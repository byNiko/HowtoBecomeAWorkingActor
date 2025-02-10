<?php
add_filter('byniko_lessons_sidebar', 'byniko_pmpro_courses_the_content_lessons', 10, 1);
function byniko_pmpro_courses_the_content_lessons() {
	// $temp_content = '';
	global $post;
	// if (is_singular('pmpro_course')) {
	// 	$course_id = $post->ID;
	// }
	if (is_singular('pmpro_lesson')) {
		$course_id = wp_get_post_parent_id($post->ID);
		// Get the course ID from the global post.
	}
	if (empty($course_id) && ! empty($post) && isset($post->ID)) {
		$course_id = $post->ID;
	}

	// Return if empty.
	if (empty($course_id)) {
		return;
	}

	ob_start();

	// Get the lessons assigned to this course.
	$lessons = pmpro_courses_get_lessons($course_id);

	// Return if there are no lessons for this course.
	if (empty($lessons)) {
		return;
	}

	// Check whether the current user has access to these lessons.
	if (current_user_can('manage_options')) {
		$hasaccess = true;
	} else {
		$hasaccess = pmpro_has_membership_access($course_id, get_current_user_id());
	}

	// Set the right class for the lessons list div based on access.
	if (! empty($hasaccess)) {
		$pmpro_courses_lesson_access_class = 'pmpro-courses-has-access';
	} else {
		$pmpro_courses_lesson_access_class = 'pmpro-courses-no-access';
	}

	// Build the HTML to output a list of lessons.
?>
	<div class="inner-lessons-list">
		<div class="pmpro_courses pmpro_courses-lessons <?php echo esc_attr($pmpro_courses_lesson_access_class); ?>">
			<h3 class="pmpro_courses-title"><?php esc_html_e('Lessons', 'pmpro-courses'); ?></h3>
			<ol class="pmpro_courses-list">
				<?php
				foreach ($lessons as $lesson) { ?>
					<li id="pmpro_courses-lesson-<?php echo intval($lesson->ID); ?>" class="pmpro_courses-list-item">
						<?php
						// Only add link to single lesson page if current user has access.
						if (! empty($hasaccess)) { ?>
							<a class="pmpro_courses-list-item-link" href="<?php echo esc_url(get_permalink($lesson->ID)); ?>">
							<?php
						}
							?>
							<div class="pmpro_courses-list-item-title fz-sm">
								<?php echo esc_html($lesson->post_title); ?>
							</div>
							<?php
							if (is_user_logged_in() && ! empty($hasaccess)) {
								// Get the status of this lesson.
								$lesson_status = pmpro_courses_get_user_lesson_status($lesson->ID, $course_id, get_current_user_id());
								//var_dump($lesson_status);
								if (! empty($lesson_status)) {
									if ($lesson_status === 'complete') {
										echo '<span class="pmpro_courses-lesson-status pmpro_courses-lesson-status-complete"><i class="dashicons dashicons-yes"></i><span class="pmpro_courses-lesson-status-label">' . esc_html('Complete', 'pmpro-courses') . '</span></span>';
									} else {
										echo '<span class="pmpro_courses-lesson-status pmpro_courses-lesson-status-incomplete"><i class="dashicons dashicons-marker"></i><span class="pmpro_courses-lesson-status-label">' . esc_html('Complete', 'pmpro-courses') . '</span></span>';
									}
								}
							}
							?>
							<?php
							// Only add link to single lesson page if current user has access.
							if (! empty($hasaccess)) { ?>
							</a>
						<?php
							}
						?>
					</li>
				<?php
				}
				?>
			</ol> <!-- end pmpro_courses-list -->
		</div> <!-- end pmpro_courses -->
	</div>
<?php

	$temp_content = ob_get_contents();
	ob_end_clean();
	return $temp_content;
	// }
}


/** real lessons updates here **/



// remove default pmpro filter for lesson content
remove_filter('the_content', 'pmpro_courses_the_content_lesson', 10);
remove_filter('the_content', 'pmpro_courses_add_lessons_to_course', 10);

add_filter('the_content', 'byniko_pmpro_courses_the_content_lesson', 10, 1);

function byniko_pmpro_courses_the_content_lesson($content) {
	global $post;
	$after_the_content = '';
	if (is_singular('pmpro_lesson')) {
		$course_id = wp_get_post_parent_id($post->ID);
		// Show a link to mark the lesson complete or incomplete.	
		$complete_button = pmpro_courses_complete_button($post->ID, $course_id);
		if (! empty($complete_button)) {
			$after_the_content .= '<div class="pmpro_courses_lesson-status">';
			$after_the_content .= $complete_button;
			$after_the_content .= '</div>';
		}

		if (! empty($course_id)) {
			$after_the_content .= sprintf(
				/* translators: %s: link to the course for this lesson. */
				'<div class="pmpro_courses_lesson-back-to-course">' . esc_html__('Course: %s', 'pmpro-courses') . '</div>',
				'<a href="' . get_permalink($course_id) . '" title="' . get_the_title($course_id) . '">' . get_the_title($course_id) . '</a>'
			);
		}
	}
	return $content . $after_the_content;
}



// add_filter('byniko_lessons_sidebar','byniko_lessons_sidebar_function', 10, 1);
function byniko_lessons_sidebar_function($post) {
	// echo "woke";
}
