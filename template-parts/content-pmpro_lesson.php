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
$course = new Course($lesson->get_course_id($lesson->ID));


$video_args = array(
	'video_url' => get_field('lesson_video_url', $post->ID),
);
$v = new ResponsiveVideo($video_args);
$responsive_video = $v->get_responsive_video();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ($responsive_video): ?>
		<div class="container light no-padding">

			<header class="entry-header ">
				<?php the_title('<h1 class="display-sm entry-title">', '</h1>'); ?>
			</header>
			<div class="excerpt">
				<?php the_excerpt(); ?>
			</div>

		</div>

		<!-- .entry-header -->
		<div class="container light no-padding">
			<div class="entry-content">
				<?= $responsive_video; ?>
			</div><!-- .entry-content -->
		</div>
	<?php endif; ?>
	<div class="container light">
		<div class="row">
			<div class="grid has-sidebar sidebar ">
				<div class="course-description main">
					<header>
						<h2 class="display-sm"><?php echo $post->post_title; ?></h2>
					</header>
					<div class="content">
						<div class="lesson-content">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
				<aside class=" sidebar lessons-list ">
					<?php echo apply_filters('byniko_lessons_sidebar', null); ?>
				</aside>

			</div>
		</div>
	</div>
	<div class="container light">
		<div class="row">
			<?php

			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'byniko') . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'byniko') . '</span> <span class="nav-title">%title</span>',
				)
			);

			// If comments are open or we have at least one comment, load up the comment template.
			if (comments_open() || get_comments_number()) :
				comments_template();
			endif;
			?>
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