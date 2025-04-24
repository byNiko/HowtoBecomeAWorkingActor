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
	<div class="container light no-padding">
		<header class="page-header">
			<?php the_archive_title('<h1 class="page-title">', '</h1>'); ?>
		</header><!-- .page-header -->
		<div class="grid">
			<section class='grid grid__3-md'>
				<?php
				$count = 0;
				while (have_posts()) :
					the_post();
					$count++;
					if ($count === 4):
						echo '</section>';
						echo "<div class='py-10 text-center'>";
						the_questionnaire_modal_trigger('button secondary', 'Begin Now!');
						echo '</div>';
						echo '<section class="grid grid__3-md">';
					endif;

					$test = new Testimonial($post);
					get_template_part('/template-parts/content', get_post_type(),  array('test' => $test));

				endwhile;
				?>

			</section>
			<div class="py-10 text-center">
				<?php the_questionnaire_modal_trigger('button secondary', 'Begin Now!'); ?>
			</div>

		</div>
	</div>

<?php
endif;
get_footer();
