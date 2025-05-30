<?php

// add_filter('wp_nav_menu_objects', 'f25_add_dynamic_submenu_items', 10, 2);
function f25_add_dynamic_submenu_items($items, $args) {
	// Only modify the menu on the frontend and for a specific menu location
	if (is_admin() || $args->theme_location !== 'menu-1') {
		return $items;
	}

	// Find the parent menu item
	$parent_id = 0;
	foreach ($items as $item) {
		if ($item->title === 'My Courses') {
			$parent_id = $item->ID;
			$item->classes[] = 'menu-item-has-children';

			$my_courses = my_pmpro_get_user_courses();
			if (!empty($my_courses)) {

				foreach ($my_courses as $c) :
					// var_dump($c->post_title);
					if ($c->post_title === "The Mental Game") continue;
					if ($c->post_title === "The Business") continue;
					if ($c->post_title === "The Craft") continue;
					$id = $c->ID;
					// Create a fake menu item object
					$new_item = new stdClass();
					$new_item->current = false;
					$new_item->ID = wp_rand(100000, 999999); // Must be unique
					$new_item->title = $c->post_title;
					$new_item->url = get_permalink($id);
					$new_item->menu_item_parent = $parent_id;
					$new_item->type = '';
					$new_item->object = '';
					$new_item->object_id = '';
					$new_item->db_id = 0;
					$new_item->classes = ['menu-item', 'menu-item-type-custom'];
					$new_item->menu_order = count($items) + 1;

					$items[] = $new_item;
				endforeach;
			}
		}
	}

	return $items;
}



/**
 * Get all courses a given user has access to.
 *
 * @param int $user_id The ID of the user.
 * @return array An array of WP_Post objects (courses).
 */
function my_pmpro_get_user_courses($user_id = null) {
	if (!function_exists('pmpro_has_membership_access')) {
		return array();
	}
	if (!$user_id) {
		$user_id = get_current_user_id();
	}

	$accessible_courses = array();

	// Get all courses
	$args = array(
		'post_type'      => 'pmpro_course', // The custom post type for courses
		'post_status'    => 'publish',
		'posts_per_page' => -1, // Get all courses
	);
	$courses = new WP_Query($args);

	if ($courses->have_posts()) {
		while ($courses->have_posts()) {
			$courses->the_post();
			$course_id = get_the_ID();

			// Check if the current user has access to this specific course
			if (pmpro_has_membership_access($course_id, $user_id)) {
				$accessible_courses[] = get_post($course_id); // Add the WP_Post object
			}
		}
		wp_reset_postdata(); // Always reset post data after a custom query
	}

	return $accessible_courses;
}
