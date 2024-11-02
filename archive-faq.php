<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package byniko
 */

get_header();
// $all_posts = $wp_query->posts;
// put all posts in an array by category
$categorized = byniko\order_terms_with_posts('faq', 'faq-category');

?>
<?php if (have_posts()) : ?>

	<div class="container light no-padding ">
		<header class="page-header">
			<?php the_archive_title('<h1 class="page-title">', '</h1>'); ?>
		</header><!-- .page-header -->
		<div class="grid has-sidebar">
			<section>
				<?php foreach ($categorized as $category => $posts): ?>
					<div class="faq__category">
						<header class="faq__category-header">
							<h2 class="faq__category-title"><?= $category; ?></h2>
						</header>
						<div class="faq__questions">
						<?php foreach ($posts as $post): ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<header class="faq__entry-header">
									<?php the_title(); ?>
								</header>
								<?php the_content(); ?>
								<?= byniko\get_post_edit_link($post->ID); ?>
							</article>
						<?php endforeach; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</section>
			<aside>
				<?php get_sidebar(); ?>
			</aside>
		</div>

	</div>

<?php
endif;
get_footer();
