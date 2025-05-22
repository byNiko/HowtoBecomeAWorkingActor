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
<?php
while (have_posts()) :
	the_post();
	echo "<div class='container light no-padding'>";
	get_template_part('template-parts/content', 'page');
	echo "</div>";

	// If comments are open or we have at least one comment, load up the comment template.
	if (comments_open() || get_comments_number()) :
		echo "<div class='container light no-padding'>";
		comments_template();
		echo "</div>";
	endif;

endwhile; // End of the loop.
?>

<?php
if (function_exists('pmpro_is_checkout') && pmpro_is_checkout()) {
	$categorized = byniko\order_terms_with_posts('faq', 'faq-category');
?>
	<div class="container light">
		<div class="grid-50">
			<h2 class="display-md">FAQ</h2>
			<div class=" faq-container">
				<?php
				foreach ($categorized as $category => $posts): ?>
					<div class="faq__category ">
						<header class="faq__category-header">
							<h4 class="faq__category-title"><?= $category; ?></h4>
						</header>
						<div class="faq__questions grid-300">
							<?php
							foreach ($posts as $post):
								setup_postdata($post);
							?>
								<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									<header class="faq__entry-header">
										<?php the_title(); ?>
									</header>
									<?php the_content(); ?>
									<?= byniko\get_post_edit_link($post->ID); ?>
								</article>
							<?php endforeach; ?>
							<?php wp_reset_postdata(); ?>
						</div>
					</div>
				<?php endforeach; ?>
		</div>
	</div>
	</div>
<?php
}
?>

<?php
// get_sidebar();
get_footer();
