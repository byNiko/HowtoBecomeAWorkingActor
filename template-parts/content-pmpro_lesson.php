<?php

/**
 * Template part for displaying courses and lessons 
 * from paid membership pro plugin
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package byniko
 */
require(get_template_directory() . '/parts/svg-icons.php');
$lesson = new Lesson($post->ID);
$course_id = $lesson->get_course_id($lesson->ID);
$course = new Course($course_id);
// $course = new Course($lesson->get_course_id($lesson->ID));


$video_args = array(
	'video_url' => get_field('lesson_video_url', $post->ID),
);
$v = new ResponsiveVideo($video_args);
$responsive_video = $v->get_responsive_video();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="container light">
		<header class="entry-header">
			<?php the_title('<h1 class="lesson-title entry-title">', '</h1>'); ?>
		</header>
		<div class="grid has-sidebar sidebar ">
			<div class="course-content main">
				<?php if ($responsive_video): ?>
					<?= $responsive_video; ?>
				<?php endif; ?>
				<div class="entry-content">
					<div class="lesson-content mt-6">
						<?php
						\byniko\pmpro_the_courses_lesson_nav($course_id);

						// If comments are open or we have at least one comment, load up the comment template.
						if (comments_open() || get_comments_number()) :
							comments_template();
						endif;
						?>
						<?php the_content(); ?>
					</div>

				</div><!-- .entry-content -->
			</div>
			<aside class=" sidebar lessons-list ">
				<?php echo apply_filters('byniko_lessons_sidebar', null); ?>
			</aside>

		</div>
	</div>


	<?php if (get_edit_post_link()) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__('Edit <span class="screen-reader-text">%s</span>', 'byniko'),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post(get_the_title())
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->

	<?php endif; ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->