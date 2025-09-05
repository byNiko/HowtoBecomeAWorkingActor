<?php

/**
 * The template for the homepage */

get_header();
?>
<section class="" id="the-truth">
	<?php get_template_part('template-parts/front-page/hard-truth'); ?>
</section>
<section>
	<?php get_template_part('template-parts/front-page/student-types'); ?>
</section>
<section>
	<?php get_template_part('template-parts/front-page/stats'); ?>
</section>
<section>
	<?php get_template_part('template-parts/front-page/about-jim'); ?>
</section>
<section id="courses-intro">
	<?php get_template_part('template-parts/front-page/courses-intro'); ?>
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
	<?php get_template_part('template-parts/front-page/capture'); ?>
</section>

<?php
get_footer();
