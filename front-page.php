<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package byniko
 */

get_header();
?>
<section class="">
	<?php get_template_part('template-parts/front-page/hard-truth');?>
</section>
<section>
	<?php get_template_part('template-parts/front-page/stats'); ?>
</section>
<section >
	<?php get_template_part('template-parts/front-page/about-jim'); ?>
</section>
<section id="courses">
	<?php get_template_part('template-parts/front-page/courses'); ?>
</section>
<section>
	<?php get_template_part('template-parts/front-page/encouragement'); ?>
</section>
<section>
	<?php get_template_part('template-parts/front-page/testimonials'); ?>
</section>
<section id="sign-up">
	<?php get_template_part('template-parts/front-page/how-this-works-steps'); ?>
</section>
<section>
	<?php get_template_part('template-parts/front-page/student-types'); ?>
</section>
<section>
	<?php get_template_part('template-parts/front-page/capture'); ?>
</section>

<?php
get_footer();
