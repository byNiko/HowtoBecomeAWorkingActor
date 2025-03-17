<?php

namespace byniko;

function get_testimonials($args) {
	$defaults = array(
		'post_type' => 'testimonial',
		'post_status' => 'publish',
		'orderby' => 'rand',
		'order' => 'ASC',
		'suppress_filters' => false,
	);
	$args = wp_parse_args($args, $defaults);
	$query = new \WP_Query($args);
	return $query->posts;
}


function show_hero() {
	global $post;

	$show_on = array(
		is_front_page(),
		// is_page('about-jim'),
		// is_page('<ha></ha>waii-retreat'),
		get_field('hero_section_show_hero_section', $post)
	);
	return in_array(true, $show_on);
}

function get_hero_background_settings() {
	global $post;
	$arr = array(
		'bg_image' => wp_get_attachment_url(get_field('hero_section_background_image', $post), 'full'),
		'title' => get_field('hero_section_main_title', $post),
		'subtitle' => get_field('hero_section_subtitle', $post),
		'bg_overlay' => get_field('hero_section_image_overlay', $post),
		'text_side' => get_field('hero_section_text_side', $post),
		'bg_position' => get_field('hero_section_image_position', $post),
		'link' => get_field('hero_section_link'),
		'hero_image' => get_field('hero_section_hero_image', $post) ? wp_get_attachment_url(get_field('hero_section_hero_image', $post)) : false,
		'hero_image_link' => get_field('hero_section_hero_image_link', $post),

	);
	return $arr;
}

/**
 * Retrieves the price of a course based on the specified membership level.
 *
 * This function uses the Paid Memberships Pro (PMPro) plugin to fetch the cost
 * of a membership level. It also filters the cost text to remove the word "now."
 * from the beginning of the cost string.
 *
 * @param array|null $atts Optional. An associative array of attributes. Default is null.
 *                         - 'level' (string): The membership level ID. Default is '2'.
 *
 * @return string|null The formatted cost of the membership level, or null if the level is not found.
 */
function get_courses_price($atts = null) {
	if (function_exists('pmpro_getLevel')) {
		$default = array(
			'level' => '2',
		);
		$a = shortcode_atts($default, $atts);

		// filter cost text removing "now." from the beginning
		add_filter('pmpro_level_cost_text', function ($text, $level) {
			$text = str_replace('now.', '', $text);
			return $text;
		}, 10, 2);


		$level = pmpro_getLevel($a['level']);
		// var_dump($level);
		if ($level) {
			return pmpro_getLevelCost($level, false, true);
		}
	}
}

function get_questionnaire_modal_trigger($class = 'button secondary', $CTA = 'Fill out the Questionnaire!') {
	return "<button class='$class' data-micromodal-trigger='modal-questionairre'>$CTA</button>";
}
function get_questionnaire_modal() {
	$form = FrmFormsController::get_form_shortcode(array('id' => 2, 'title' => true, 'description' => true));
	return makeModal('questionairre', $form);
}
function the_questionnaire_modal_trigger() {
	echo get_questionnaire_modal_trigger();
}

function get_page_by_title($page_title, $output = OBJECT, $post_type = 'page') {
	$args  = array(
		'title'                  => $page_title,
		'post_type'              => $post_type,
		'post_status'            => get_post_stati(),
		'posts_per_page'         => 1,
		'update_post_term_cache' => false,
		'update_post_meta_cache' => false,
		'no_found_rows'          => true,
		'orderby'                => 'post_date ID',
		'order'                  => 'ASC',
	);
	$query = new \WP_Query($args);
	$pages = $query->posts;

	if (empty($pages)) {
		return null;
	}

	return get_post($pages[0], $output);
}

function get_correct_nav_menu() {
	return (is_user_logged_in()) ? 11 : 7;
}

function order_terms_with_posts($post_type, $taxonomy) {
	$terms = get_terms($taxonomy);
	$all_posts = [];
	foreach ($terms as $term) {
		$args = array(
			'taxonomy' => $taxonomy,
			'term' => $term->slug,
			'posts_per_page' => -1,
			'post_type' => $post_type,
			'post_status' => 'publish',
		);
		$all_posts[$term->name] = get_posts($args);
	}
	return $all_posts;
}

function get_post_edit_link($post_id) {
	if (current_user_can('edit_posts')): ?>
		<footer class="edit-footer">
			<a href="<?= get_edit_post_link($post_id); ?>" class="fz-sm">Edit <?= get_post_type($post_id); ?></a>
		</footer>
	<?php endif;
}


function has_membership_level($role) {
	if (function_exists('pmpro_hasMembershipLevel')) {
		return pmpro_hasMembershipLevel($role);
	} else
		return false;
}


function get_acf_link($link_arr, $class = "button primary") {
	$link_url = $link_arr['url'];
	$link_title = $link_arr['title'];
	$link_target = $link_arr['target'] ?: '_self';
	return "<a href='$link_url' class='$class' target='$link_target'>$link_title</a>";
}



function pmpro_courses_get_next_prev_lessons($course_id) {
	global $post;

	// Fetch all lessons associated with the course in the correct order.
	$lessons = pmpro_courses_get_lessons($course_id);

	// Check if lessons are available.
	if (empty($lessons)) {
		return;
	}

	// Build an array of lesson IDs.
	$lesson_ids = wp_list_pluck($lessons, 'ID');

	// Find the current lesson's position.
	$current_index = array_search($post->ID, $lesson_ids);

	// Determine previous and next lesson IDs.
	$previous_id = $current_index > 0 ? $lesson_ids[$current_index - 1] : false;
	$next_id     = $current_index < count($lesson_ids) - 1 ? $lesson_ids[$current_index + 1] : false;

	// Only display navigation if there's a previous or next lesson.
	if (! $previous_id && ! $next_id) {
		return array();
	}

	return array(
		'prev_id' => $previous_id,
		'next_id' => $next_id,
	);
}



/**
 * Display navigation to next/previous lesson within a single course.
 */
function pmpro_the_courses_lesson_nav($course_id) {

	$next_prev_lessons = pmpro_courses_get_next_prev_lessons($course_id);
	$previous_id = $next_prev_lessons['prev_id'] ?? null;
	$next_id     = $next_prev_lessons['next_id'] ?? null;
	// Output HTML for navigation.
	?>
	<nav class="lesson-navigation page-navigation" role="navigation">
		<span class="screen-reader-text"><?php esc_html_e('Lesson navigation', 'pmpro-courses'); ?></span>
		<div class="nav-links">
			<?php if ($previous_id) : ?>
				<div class="nav-previous">
					Previous Lesson:
					<a href="<?php echo esc_url(get_permalink($previous_id)); ?>" rel="prev">
						<?php echo esc_html(get_the_title($previous_id)); ?>
					</a>
				</div>
			<?php endif; ?>
			<?php if ($next_id) : ?>
				<div class="nav-next">
					Next Lesson:
					<a href="<?php echo esc_url(get_permalink($next_id)); ?>" rel="next">
						<?php echo esc_html(get_the_title($next_id)); ?>
					</a>
				</div>
			<?php endif; ?>
		</div><!-- .nav-links -->
	</nav><!-- .lesson-navigation -->
<?php
}

function is_bonus_course($post_id) {
	$bonus_category = 'pmpro_course_category';
	$bonus_slug = 'bonus-course';

	$is_bonus = false;

	$post_terms = get_the_terms($post_id, $bonus_category);
	if (is_array($post_terms)) :
		foreach ($post_terms as $term):
			if ($term->slug === $bonus_slug) {
				$is_bonus = true;
			}
		endforeach;
	endif;
	return $is_bonus;
}

function is_bonus_lesson($post_id) {
	echo  __FUNCTION__ . " deprecated for Lesson class <br>";
	$bonus_slug = 'bonus';

	$is_bonus = false;

	$post_terms = get_the_terms($post_id, 'lesson-category');
	if (is_array($post_terms)) :
		foreach ($post_terms as $term):
			if ($term->slug === $bonus_slug) {
				$is_bonus = true;
			}
		endforeach;
	endif;
	return $is_bonus;
}

function is_restricted_bonus_lesson($post_id) {
	echo  __FUNCTION__ . " deprecated for Lesson class <br>";
	if (!is_bonus_lesson($post_id)) return false;

	/* The line ` = true;` is initializing a variable named `` and setting its
	initial value to `true`. This variable is used to track whether a particular lesson is restricted
	or not. By default, it is set to `true`, indicating that the lesson is considered restricted unless
	determined otherwise based on certain conditions or criteria within the function. */
	$is_restricted = true;
	$free_bonus_slug = 'free';

	$post_terms = get_the_terms($post_id, 'lesson-category');
	/* 
	if the terms associated with a post (lesson) contain a specific term
	with the slug 'free' then is is NOT restricted. 
	*/
	if (is_array($post_terms)) :
		foreach ($post_terms as $term):
			if ($term->slug === $free_bonus_slug) {
				$is_restricted = false;
			}
		endforeach;
	endif;
	return $is_restricted;
}

function member_has_access_to_bonus_lesson($lesson_id) {
	echo  __FUNCTION__ . " deprecated for Lesson class <br>";
	global $current_user;

	if (!is_user_logged_in()) return false;

	if (is_restricted_bonus_lesson($lesson_id)):
		$access_levels = array('2', '3');
		return has_membership_level($access_levels);
	endif;
	return true;
}

function the_page_title() {
	global $post;
	// either slug or title - I can't remember which is $post->post_name
	$hide_title = array(
		'home'
		// 'student-questionnaire'
	);

	if (in_array($post->post_name, $hide_title)) return;
	return the_title('<header class="entry-header"><h1 class="page-title h1">', '</h1></header>');
}

function array_random($array, $amount = 1)
{
    $keys = array_rand($array, $amount);

    if ($amount == 1) {
        return $array[$keys];
    }

    $results = [];
    foreach ($keys as $key) {
        $results[] = $array[$key];
    }

    return $results;
}

function get_random_testimonials($args = array()) {
	$defaults = array(
		'count' => 1,
		'source' => 'celebrity',
	);
	$args = wp_parse_args($args, $defaults);
	$testimonial_ids_args = array(
		'post_type' => 'testimonial',
		'posts_per_page' => -1,
		'suppress_filters' => false,
		'fields' => 'ids',
		'tax_query' => array(
			array(
				'taxonomy' => 'source',
				'field' => 'slug',
				'terms' => $args['source']
			)
		)
	);
	// just getting post ids here
	$testimonial_ids = get_posts($testimonial_ids_args);
	// randomize result and make sure to get an array of ids even if count is 1
	$random_ids = array_random($testimonial_ids, $args['count']);
	$testimonials_query = 
		array(
			'post_type' => 'testimonial',
			'post__in' => $random_ids,
		);
	// get the radmom testimonials
	$testimonials_res = get_posts($testimonials_query);
	$testimonials = [];
	foreach ($testimonials_res as $test) {
		$testimonials[] = new \Testimonial($test);
	}
	return $testimonials;
}
