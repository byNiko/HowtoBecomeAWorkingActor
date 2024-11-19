<?php
/**
 * Template part for displaying courses and lessons 
 * from paid membership pro plugin
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package byniko
 */
// require (get_template_directory() . '/parts/svg-icons.php');
$course = new Course($post->ID);
?>
<div class="container light no-padding">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title display-md">', '</h1>' ); ?>
		</header><!-- .entry-header -->

		<?php // byniko_post_thumbnail(); ?>

		<div class="entry-content">

			<div class="grid has-sidebar sidebar">
				
				<div class="course-description main">
				<?php 
						$video_args = array(
							'video_url' => get_field('welcome_video_link',$post->ID),
							'video_url' => get_field('sample_video_link',$post->ID),
						);
						$v = new ResponsiveVideo($video_args);
						echo $v->get_responsive_video();
						?>
					<div class="content mt-5">
						<?php
						echo '<p>'. $post->post_excerpt . '</p>';
						the_content();
						?> 
					</div>
				</div>
				<aside class=" sidebar lessons-list">
				<?php echo apply_filters('byniko_lessons_sidebar', null); ?>
				</aside>

			</div>
		</div><!-- .entry-content -->

		<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'byniko' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
		<?php endif; ?>
	</article><!-- #post-<?php the_ID(); ?> -->
</div>