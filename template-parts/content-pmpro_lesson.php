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

$is_bonus = $lesson->is_bonus_lesson();
$is_restricted = $lesson->is_restricted_bonus_lesson();
$member_has_access = $lesson->member_has_access_to_bonus_lesson(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="container light">
		<header class="entry-header">
			<?php the_title('<h1 class="lesson-title entry-title">', '</h1>'); ?>
		</header>
		<div class="grid has-sidebar sidebar ">
			<div class="main">
				<div class="lesson-content">
					<?php
					echo $lesson->get_main_video();
					?>
					<div class="entry-content">
					<?php \byniko\pmpro_the_courses_lesson_nav($course_id); ?>
						<div class="container--tabs">
							<section class="">
								<ul class="nav nav-tabs">
									<li class="active">
										<a href="#lesson-content">Lesson Content</a>
									</li>
									<?php
									if (comments_open() || get_comments_number()) :
									?>
										<li class="">
											<a href="#discussion">Discussion</a>
										</li>
									<?php endif; ?>
								</ul>
								<div class="tab-content">
									<div id="lesson-content" class="tab-pane active">
										<span class="glyphicon glyphicon-leaf glyphicon--home--feature two columns text-center"></span>

										<div class="lesson-description">
											<?php echo apply_filters('the_content', $lesson->post_content); ?>
										</div>

									</div>
									<div id="discussion" class="tab-pane">
										<span class="glyphicon glyphicon-fire glyphicon--home--feature two columns text-center"></span>
										<span class="col-md-10">
											<?php
											// If comments are open or we have at least one comment, load up the comment template.
											if (comments_open() || get_comments_number()) :
											?>
												<div id="discussion" class="tab-content-item">
													<div class="lesson-discussion">
														<?php
														comments_template();
														?>
													</div>
												</div>
											<?php endif; ?>
										</span>
									</div>
								</div>
							</section>
						</div>
					</div><!-- .entry-content -->
				</div>
			</div>
			<aside class=" sidebar lessons-list " data-equal-height-target=".lesson-content" style="height:0; overflow:hidden;">
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