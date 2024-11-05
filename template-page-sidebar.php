<?php
/**
 * Template Name: Page with sidebar
 */
get_header();
?>
<div class="container light no-padding ">
	<div class="grid has-sidebar">
		<section>
			<?= byniko_the_page_title();?>
			<?php the_content(); ?>
		</section>
		<aside>
			<?php get_sidebar(); ?>
		</aside>
	</div>
	
</div>

<?php
get_footer();
