<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package byniko
 */

get_header();
?>
<?php if (have_posts()) : ?>
	<div class="container light no-padding ">
		<header class="page-header">
			<?php the_archive_title('<h1 class="page-title">', '</h1>'); ?>
		</header><!-- .page-header -->
		<div class="grid has-sidebar">
			<section>
				<?php
				while (have_posts()) :
					the_post();

					$test = new Testimonial($post);
					/*
	 * Include the Post-Type-specific template for the content.
	 * If you want to override this in a child theme, then include a file
	 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
	 */
					get_template_part('/template-parts/content', get_post_type(),  array('test' => $test));

				endwhile;
				?>
			</section>
			<?php get_sidebar(); ?>
		</div>
	</div>

<?php
endif;
get_footer();
