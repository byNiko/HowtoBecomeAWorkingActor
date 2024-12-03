<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package byniko
 */
$lesson = new Lesson($post->ID);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php
			the_title( '<h2 class="entry-title">', '</h2>' );
			?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?= byniko_membership\bonus_lesson_content($lesson); ?>
		<?php // the_content(); ?>
	</div><!-- .entry-content -->

	

	<footer class="entry-footer">
		<?php //byniko_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
