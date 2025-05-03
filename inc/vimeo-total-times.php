<?php

/**
 * Plugin Name: Vimeo Video Length Tracker
 * Description: Calculates and tracks total Vimeo video duration from ACF fields.
 * Version: 1.0
 * Author: Your Name
 */

defined('ABSPATH') || exit;

const VVLT_POST_TYPE        = 'pmpro_lesson'; // Replace with your post type
const VVLT_ACF_FIELD        = 'lesson_video_url'; // Replace with your ACF field name
const VVLT_POST_META_KEY    = '_vvlt_duration';
const VVLT_OPTION_KEY       = 'vvlt_total_duration';
const VVLT_TOKEN_OPTION_KEY = 'vvlt_vimeo_access_token';

// -------------------- Admin Settings Page --------------------

add_action('admin_menu', function () {
	add_options_page(
		'Video Totals and API',
		'Video Totals and API',
		'manage_options',
		'vvlt-vimeo-settings',
		'vvlt_render_settings_page'
	);
});

add_action('admin_init', function () {
	register_setting('vvlt_settings', VVLT_TOKEN_OPTION_KEY, [
		'type' => 'string',
		'sanitize_callback' => 'sanitize_text_field',
	]);

	add_settings_section(
		'vvlt_api_section',
		'Vimeo API Token',
		null,
		'vvlt-vimeo-settings'
	);

	add_settings_field(
		VVLT_TOKEN_OPTION_KEY,
		'Access Token',
		'vvlt_render_token_field',
		'vvlt-vimeo-settings',
		'vvlt_api_section'
	);
});

function vvlt_render_token_field() {
	$token = get_option(VVLT_TOKEN_OPTION_KEY, '');
	$masked = $token ? str_repeat('*', strlen($token) - 4) . substr($token, -4) : '';
	echo '<input type="text" name="' . VVLT_TOKEN_OPTION_KEY . '" value="" class="regular-text" placeholder="' . esc_attr($masked) . '" />';
	echo '<p class="description">Enter a new token to replace the existing one. Leave blank to keep the current token.</p>';
}

function vvlt_render_settings_page() {
?>
	<div class="wrap">
		<h2>Recalculate Video Durations</h2>
		<p>This will fetch fresh durations from Vimeo for all published videos and update the total.</p>
		<form method="post">
			<?php submit_button('Recalculate Now', 'secondary', 'vvlt_recalculate'); ?>
		</form>

		<hr>
		<h1>Vimeo API Settings</h1>

		<form method="post" action="options.php">
			<?php
			settings_fields('vvlt_settings');
			do_settings_sections('vvlt-vimeo-settings');
			submit_button('Save API Token');
			?>
		</form>
	</div>
<?php
}

add_action('admin_init', function () {
	if (current_user_can('manage_options') && isset($_POST['vvlt_recalculate'])) {
		vvlt_recalculate_all_durations();
		add_action('admin_notices', function () {
			echo '<div class="notice notice-success is-dismissible"><p>Total video duration recalculated.</p></div>';
		});
	}
});

// -------------------- Vimeo Duration Logic --------------------

function vvlt_get_vimeo_access_token() {
	$token = get_option(VVLT_TOKEN_OPTION_KEY, '');
	if (!$token) {
		error_log('[VVLT] Vimeo access token is missing.');
	}
	return $token;
}

function vvlt_extract_vimeo_id($url) {
	preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $url, $matches);
	return $matches[1] ?? false;
}

function vvlt_get_vimeo_duration($url, $post_id = null) {
	$token = vvlt_get_vimeo_access_token();
	if (!$token) return false;

	$id = vvlt_extract_vimeo_id($url);
	if (!$id) return false;

	$response = wp_remote_get("https://api.vimeo.com/videos/$id", [
		'headers' => [
			'Authorization' => 'Bearer ' . $token,
			'Accept'        => 'application/vnd.vimeo.*+json;version=3.4',
		],
	]);

	if (is_wp_error($response)) {
		error_log('[VVLT] Vimeo API error (network issue): ' . $response->get_error_message());
		return false;
	}

	$code = wp_remote_retrieve_response_code($response);
	if ($code !== 200) {
		$title = $post_id ? get_the_title($post_id) : 'Unknown';
		error_log("[VVLT] Vimeo API returned HTTP $code for post ID $post_id ($title), URL: $url");
		if ($post_id) {
			$errors = get_transient('vvlt_error_log') ?: [];
			$errors[] = [
				'post_id' => $post_id,
				'title'   => get_the_title($post_id),
				'code'    => $code,
				'url'     => $url,
			];
			set_transient('vvlt_error_log', $errors, 300); // show for 5 mins
		}
		return false;
	}

	$body = json_decode(wp_remote_retrieve_body($response), true);
	return isset($body['duration']) ? (int)$body['duration'] : false;
}

function vvlt_recalculate_all_durations() {
	$posts = get_posts([
		'post_type'      => VVLT_POST_TYPE,
		'post_status'    => 'publish',
		'posts_per_page' => -1,
	]);

	$total = 0;

	foreach ($posts as $post) {
		$url = get_field(VVLT_ACF_FIELD, $post->ID);
		if (!$url) continue;

		$duration = vvlt_get_vimeo_duration($url, $post->ID);
		if (!$duration) continue;

		update_post_meta($post->ID, VVLT_POST_META_KEY, $duration);
		$total += $duration;
	}

	update_option(VVLT_OPTION_KEY, $total);
}

// -------------------- Update on Save/Delete --------------------

add_action('save_post_' . VVLT_POST_TYPE, 'vvlt_handle_video_post_save', 20);
function vvlt_handle_video_post_save($post_id) {
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

	$url = get_field(VVLT_ACF_FIELD, $post_id);
	if (!$url) return;

	$new_duration = vvlt_get_vimeo_duration($url, $post_id);
	$old_duration = (int) get_post_meta($post_id, VVLT_POST_META_KEY, true);

	if (!$new_duration) {
		set_transient("vvlt_duration_error_{$post_id}", true, 60); // lasts 1 minute
		$fails = get_transient("vvlt_failed_posts") ?: [];
		if (!in_array($post_id, $fails)) {
			$fails[] = $post_id;
			set_transient("vvlt_failed_posts", $fails, 300); // 5 min
		}

		set_transient("vvlt_global_duration_error", true, 300);
		return;
	}
	if ($new_duration && $new_duration !== $old_duration) {
		update_post_meta($post_id, VVLT_POST_META_KEY, $new_duration);
		$total = (int) get_option(VVLT_OPTION_KEY, 0);
		$total = $total - $old_duration + $new_duration;
		update_option(VVLT_OPTION_KEY, $total);
	}
}

add_action('before_delete_post', function ($post_id) {
	if (get_post_type($post_id) !== VVLT_POST_TYPE) return;

	$duration = (int) get_post_meta($post_id, VVLT_POST_META_KEY, true);
	$total = (int) get_option(VVLT_OPTION_KEY, 0);
	update_option(VVLT_OPTION_KEY, max(0, $total - $duration));
});

// -------------------- Shortcode --------------------

add_shortcode('lessons_total_hours', function () {
	$total_seconds = (int) get_option(VVLT_OPTION_KEY, 0);
	return floor($total_seconds / 3600); // hours, rounded down
});


add_action('admin_notices', function () {
	$errors = get_transient('vvlt_error_log');
	if (!$errors || !is_array($errors)) return;

	echo '<div class="notice notice-error"><p><strong>Vimeo Duration Fetch Failed for:</strong></p><ul>';
	foreach ($errors as $error) {
		$link = get_edit_post_link($error['post_id']);
		echo '<li>';
		if ($link) {
			echo '<a href="' . esc_url($link) . '">' . esc_html($error['title']) . '</a>';
		} else {
			echo esc_html($error['title']);
		}
		echo ' — HTTP ' . esc_html($error['code']) . ', URL: ' . esc_html($error['url']);
		echo '</li>';
	}
	echo '</ul></div>';

	// Optionally clear it after display
	delete_transient('vvlt_error_log');
});
