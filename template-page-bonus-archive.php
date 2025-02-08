<?php

/**
 * Template Name: Bonus Archive
 */
get_header();
$free = array(
	'post_type' => 'pmpro_lesson',
	'posts_per_page' => -1,
	'suppress_filters' => false,
	'tax_query' => array(
	'relation' => 'AND',
		array(
			'taxonomy' => 'lesson-category',
			'field' => 'slug',
			'terms' => ['free']
		),
		array(
			'taxonomy' => 'lesson-category',
			'field' => 'slug',
			'terms' => ['bonus']
		)
	),
);


$bonus = array(
	'post_type' => 'pmpro_lesson',
	'posts_per_page' => -1,
	'suppress_filters' => false,
	'tax_query' => array(
	'relation' => 'AND',
		array(
			'taxonomy' => 'lesson-category',
			'field' => 'slug',
			'terms' => ['bonus'],
		),
		array(
			'taxonomy' => 'lesson-category',
			'field' => 'slug',
			'terms' => ['free'],
			'operator' => 'NOT IN',

		)
	),
);
$bonus = new WP_Query($bonus);

$free = new WP_Query($free);

?>
<div class="container light no-padding ">
	<div class="grid ">
		<section>
			<?= byniko\the_page_title(); ?>
			<div class="hide-overflow">
			<?php the_content(); ?>
			</div>

			<section id="free-bonus-courses" class="courses-grid grid-450 ">
				<?php if($free->have_posts()): while($free->have_posts()): $free->the_post(); ?>
					<?php get_template_part('template-parts/content', 'pmpro_bonus-lesson', array('post' => $post)); ?>
				<?php endwhile; endif; ?>
			</section>
			
			<section id="restricted-bonus-courses" class="courses-grid grid-450">
				<?php if($bonus->have_posts()): while($bonus->have_posts()): $bonus->the_post(); ?>
					<?php get_template_part('template-parts/content', 'pmpro_bonus-lesson', array('post' => $post)); ?>
				<?php endwhile; endif; ?>
			</section>
		</section>

		<!-- <aside> -->
			<?php //get_sidebar(); ?>
		<!-- </aside> -->
	</div>

</div>

<?php
get_footer();
