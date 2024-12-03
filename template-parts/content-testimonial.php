<?php

/**
 * Template part for displaying testimonials
 *
 * @package byniko
 */
$test = $args['test'];

if (!isset($args['test']) && current_user_can('edit_posts')) :
	echo "No testimonials passed.<br/>";
	// var_dump($args['test']);
else:

?>
	<div class="testimonial source--<?= $test->get_source(); ?>">
		<div class="testimonial--inner">
			<?php if($test->get_image()):?>
			<figure class="testimonial-image">
				<?= $test->get_image(); ?>
				<figcaption>
					<p class="testimonial-caption-1"><?= $test->get_image_caption_1(); ?></p>
					<p class="testimonial-caption-2"><?= $test->get_image_caption_2(); ?></p>
				</figcaption>
			</figure>
			<?php endif; ?>
			<blockquote class="testimonial-content">
				<q class="testimonial-quote"><?= $test->get_quote(); ?></q>
				<div class="testimonial-citation">
					<cite class="testimonial-citation-name"><?= $test->get_citation_1(); ?></cite>
					<cite class="testimonial-citation-title"><?= $test->get_citation_2(); ?></cite>
				</div>
				<?= byniko\get_post_edit_link($test->ID); ?>
			</blockquote>
			
		</div>
	</div>

<?php endif; ?>