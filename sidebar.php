<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package byniko
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area">
	<div class="sidebar-container centered">
		<?php the_questionnaire_modal_trigger();?>
	</div>
	<div class="sidebar-container">
		<?php require ( get_template_directory() . '/template-parts/front-page/testimonials-data.php'); ?> 
		<?php 
		$testimonial_data = $testimonials[0];
		?>
		<div class="testimonial">
			<div class="testimonial--inner">
					<figure class="testimonial-image">
						<img src="<?= $testimonial_data['image']['src']; ?>" alt="<?= $testimonial_data['image']['alt']; ?>">
						<figcaption>
							<p class="testimonial-caption-1"><?= $testimonial_data['image']['caption1']; ?></p>
							<p class="testimonial-caption-2"><?= $testimonial_data['image']['caption2']; ?></p>
						</figcaption>
					</figure>
					<blockquote class="testimonial-content">
						<q class="testimonial-quote"><?= $testimonial_data['quote']; ?></q>
						<div class="testimonial-citation">
							<cite class="testimonial-citation-name"><?= $testimonial_data['citation1']; ?></cite>
							<cite class="testimonial-citation-title"><?= $testimonial_data['citation2']; ?></cite>
						</div>
					</blockquote>
				</div>
				</div>
	</div>
	<?php //dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
