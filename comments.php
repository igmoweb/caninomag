<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
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

<div class="row">
	<div id="comments" class="comments-area large-12 column">
		<?php if ( have_comments() ) : ?>
			<h2 class="comments-title">
				<?php
				printf( _nx( 'Un comentario', '%1$s comentarios', get_comments_number(), 'comments title' ),
					number_format_i18n( get_comments_number() ), get_the_title() );
				?>
			</h2>
			
			<ol class="comment-list">
				<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 56,
				) );
				?>
			</ol><!-- .comment-list -->

			<?php canino_comment_nav(); ?>

		<?php endif; // have_comments() ?>

		<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
			?>
			<p class="no-comments"><?php _e( 'Comments are closed.', 'twentyfifteen' ); ?></p>
		<?php endif; ?>

		<?php comment_form(); ?>

	</div><!-- .comments-area -->
</div>
