<?php

/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package byniko
 */

if (! is_active_sidebar('sidebar-1')) {
	return;
}

?>

<aside id="secondary" class="widget-area">
	<div class="sidebar-container centered">
		<?php the_questionnaire_modal_trigger('button secondary', 'Begin Now!'); ?>
	</div>
	<?php if (!is_post_type_archive('testimonial')): ?>
		<div class="sidebar-container">
			<?php
			$rand_args = array(
				'count' => 3,
			);
			$rand_testimonials = byniko\get_random_testimonials($rand_args);
			foreach($rand_testimonials as $test):
			get_template_part('/template-parts/content', 'testimonial', array('test' => $test));
			endforeach;
			?>
		</div>
	<?php endif; ?>
</aside><!-- #secondary -->