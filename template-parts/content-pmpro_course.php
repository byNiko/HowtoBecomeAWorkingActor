<?php

/**
 * Template part for displaying courses and lessons 
 * from paid membership pro plugin
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package byniko
 */
$course = new Course($post->ID);
?>
<div class="container light no-padding">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php the_title('<h1 class="entry-title display-md">', '</h1>'); ?>
		</header><!-- .entry-header -->

		<?php // byniko_post_thumbnail(); 
		?>
		<div class="grid has-sidebar sidebar">
			<div class=" main">
				<div class="lesson-content">
					<?php
					$video_args = array(
						'video_url' => get_field('welcome_video_link', $post->ID),
						// 'video_url' => get_field('sample_video_link', $post->ID),
					);
					if ($video_args && ($video_args['video_url'])) {
					$v = new ResponsiveVideo($video_args);
					echo $v->get_responsive_video();
					}
					?>

					<div class="entry-content mt-5">
						<?php
						// echo '<p>' . $post->post_content . '</p>';
						$extended = get_extended($post->post_content);

						// echo $extended['extended'];
						echo apply_filters('the_content', $extended['extended']);
						// echo apply_filters('the_content', get_the_content());
						// echo $extended['main'];
						if (!is_singular('pmpro_course')):
							echo "<div class='text-right'>";
							echo "<a href='" . get_permalink() . "' class='button tertiary '>Head to " . get_the_title() . " &rarr;</a>";
							echo "</div>";
							echo "<hr>";
						endif;
						?>
					</div>
				</div>
			</div>
			<aside class="sidebar lessons-list" data-equal-height-target=".lesson-content" style="height:0; overflow:hidden;">
				<?php echo apply_filters('byniko_lessons_sidebar', null); ?>
			</aside>

		</div>
	</article>
</div><!-- .entry-content -->

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