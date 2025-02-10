<?php
// require(__DIR__ . '/testimonials-data.php');

?>
<div class="container light">
	<header class="d-none">
		<h2 class="display centered">Testimonials</h2>
	</header>
	<div class="main">
		<div class="testimonials">
			<?php
			// get chosen testimonial from the page's acf custom field
			$testimonials = get_field('get_testimonial');
			foreach ($testimonials as $testimonial):
				$test = new Testimonial($testimonial);
				get_template_part('/template-parts/content', 'testimonial', array('test' => $test));
			?>
			<?php endforeach; ?>
			<div class="flex-row centered">
				<a
					href="<?= get_post_type_archive_link('testimonial'); ?>"
					class="button primary ">
					More Testimonials
				</a>
			</div>
		</div>
	</div>