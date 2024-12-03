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

	<header class="page-header">
		<?php
		the_archive_title('<h1 class="page-title">', '</h1>');
		the_archive_description('<div class="archive-description">', '</div>');
		?>
	</header><!-- .page-header -->

<?php
	/* Start the Loop */
	$bonus_courses = array();
	while (have_posts()) :

		the_post();
		// if (!byniko\is_bonus_course(get_the_ID())) :
		get_template_part('template-parts/content', get_post_type());
	// endif;

	endwhile;
	// endwhile;

	the_posts_navigation();

else :

	get_template_part('template-parts/content', 'none');

endif;
?>
<?php
if (!is_post_type_archive('pmpro_course')):
	get_sidebar();
endif;
get_footer();
