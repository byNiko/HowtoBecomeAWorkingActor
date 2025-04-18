<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package byniko
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<div class="comments-notice">
	<p>All comments are reviewed before being published.</p>
	<p>Please keep the conversation kind and respectful—let’s create a positive space for everyone to share their thoughts. </p>
</div>

<div id="comments" class="comments-area">
	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h2 class="comments-title">
			<?php
			$byniko_comment_count = get_comments_number();
			if ( '1' === $byniko_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'byniko' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
				printf( 
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $byniko_comment_count, 'comments title', 'byniko' ) ),
					number_format_i18n( $byniko_comment_count ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			$args = array(
				'walker'            => null,
				'max_depth'         => '',
				'style'             => 'ul',
				'callback'          => '',
				'end-callback'      => null,
				'type'              => 'all',
				'page'              => '',
				'per_page'          => '',
				'avatar_size'       => 32,
				'reverse_top_level' => null,
				'reverse_children'  => '',
				'format'            => 'html5', // or 'xhtml' if no 'HTML5' theme support
				'short_ping'        => false,   // @since 3.6
				'echo'              => true     // boolean, default is true
				);
			wp_list_comments($args);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'byniko' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	comment_form();
	?>

</div><!-- #comments -->
