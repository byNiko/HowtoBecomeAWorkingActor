<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package byniko
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header d-none">
		
	</header><!-- .entry-header -->

	<div class="entry-content">
	<?php the_title( '<h4 class="entry-title">', '</h4>' );	?>
		<?= byniko_membership\bonus_lesson_content($post); ?>
		<?php // the_content(); ?>
	</div><!-- .entry-content -->

	

	<footer class="entry-footer">
	
		<?php //byniko_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
