<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package byniko
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */


/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/pmprpo_templates/lesson_template_functions.php';
require get_template_directory() . '/inc/pmprpo_templates/course_template_functions.php';

function byniko_body_classes($classes) {
	// Adds a class of hfeed to non-singular pages.
	if (! is_singular()) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if (! is_active_sidebar('sidebar-1')) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter('body_class', 'byniko_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function byniko_pingback_header() {
	if (is_singular() && pings_open()) {
		printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
	}
}
add_action('wp_head', 'byniko_pingback_header');

function my_plugin_body_class($classes) {
	global $post;
	if (isset($post->post_name)) {
		$classes[] = 'page--' . $post->post_name;
	}
	return $classes;
}

add_filter('body_class', 'my_plugin_body_class');


function makeModal($id, $content, $title = null) {

	$modal_id = 'modal-' . $id;
	$modal_trigger = 'trigger-' . $id;
	return "<div class='modal micromodal-slide' id='$modal_id' aria-hidden='true'>
		<div class='modal__overlay' tabindex='-1' data-micromodal-close>
			<div class='modal__container' role='dialog' aria-modal='true' aria-labelledby='$modal_id-title'>
				<header class='modal__header' tabindex='0'>
					<h2 class='modal__title' id='$modal_id-title'>
					$title
					</h2>
					<button class='modal__close' aria-label='Close modal' data-micromodal-close></button>
				</header>
				<main class='modal__content' id='$modal_id-content'>
					$content
				</main>
				<!-- <footer class='modal__footer'>
					<button class='modal__btn modal__btn-primary'>Continue</button>
					<button class='modal__btn' data-micromodal-close aria-label='Close this dialog window'>Close</button>
				</footer> -->
			</div>
		</div>
	</div>";
}


function byniko_loginout_menu_link($items, $args) {
	if ($args->menu === 11 || $args->menu === 7) {
		if (is_user_logged_in()) {
			$items .= '<li class="right"><a href="' . wp_logout_url('/') . '">' . __("Log Out") . '</a></li>';
		} else {
			$items .= '<li class="right"><a href="' . wp_login_url() . '">' . __("Log In") . '</a></li>';
		}
	}
	return $items;
}
add_filter('wp_nav_menu_items', 'byniko_loginout_menu_link', 10, 2);

// Simply remove anything that looks like an archive title prefix ("Archive:", "Foo:", "Bar:").
add_filter('get_the_archive_title', function ($title) {
	return preg_replace('/^\w+: /', '', $title);
});


// Add Shortcode
function shortcode_lesson_count() {
	$args = array(
		'status' => 'publish',
		'post_type' => 'pmpro_lesson',
		'posts_per_page' => -1,
	);
	$lessons = get_posts($args);
	$lesson_count = count($lessons);
	return $lesson_count;
}
add_shortcode('lesson_count', 'shortcode_lesson_count');
