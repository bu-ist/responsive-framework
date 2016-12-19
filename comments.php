<?php
/**
 * Default comments template.
 *
 * @package Responsive_Framework
 */

if ( post_password_required() ) {
	return;
}
?>

<section id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( esc_html( _nx( 'One comment', '%1$s comments', get_comments_number(), 'comments title', '_s' ) ), esc_html( number_format_i18n( get_comments_number() ) ) );
			?>
		</h2>

		<ol class="comments-list">
			<?php
				wp_list_comments( array(
					'style'      => 'ol',
					'short_ping' => true,
				) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through. ?>
		<nav class="comments-nav" role="navigation">
			<div class="comments-nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', '_s' ) ); ?></div>
			<div class="comments-nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', '_s' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation. ?>

	<?php endif; // have_comments(). ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="comments-closed"><?php esc_html_e( 'Comments are closed.', '_s' ); ?></p>
	<?php endif; ?>

	<?php if ( comments_open() ) : // this is displayed if there are no comments so far. ?>
	<div id="respond" class="comment-respond">

		<h3 class="comment-respond-title"><?php comment_form_title( 'Post Your Comment', 'Reply to %s' ); ?></h3>

		<?php if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) : ?>
			<p>You must be <a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>">logged in</a> to post a comment.</p>
		<?php else : ?>
			<form action="<?php echo esc_url( home_url( '/' ) ); ?>/wp-comments-post.php" method="post" id="commentform" class="comment-form">
				<fieldset>
					<?php if ( is_user_logged_in() ) : ?>
						<p>Logged in as <a href="<?php echo esc_url( get_edit_profile_url() ); ?>"><?php echo wp_kses_post( $user_identity ); ?></a>. <a href="<?php echo esc_url( wp_logout_url( get_permalink() ) ); ?>" title="Log out of this account">Log out &raquo;</a></p>
					<?php else : ?>
						<div class="form-row"><label for="author">Name<?php if ( $req ) echo '<em class="required">*</em>'; ?></label><input type="text" name="author" id="author" value="<?php echo esc_attr( $comment_author ); ?>" size="22" tabindex="1" <?php if ( $req ) echo 'aria-required="true"'; ?> /></div>
						<div class="form-row"><label for="email">Email<?php if ( $req ) echo '<em class="required">*</em>'; ?></label><input type="text" name="email" id="email" value="<?php echo esc_attr( $comment_author_email ); ?>" size="22" tabindex="2" <?php if ( $req ) echo 'aria-required="true"'; ?> /></div>
					<?php endif; ?>

					<div class="form-row"><label for="comment">Comment <span class="form-tip">(<a href="http://www.bu.edu/tech/web/departments/wordpress/management/comment-guidelines/">view guidelines</a>)</span></label><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></div>
					<div class="comment-form-submit form-row">
						<input name="submit" type="submit" id="submit" class="button" tabindex="5" value="Submit Comment" />
						<span class="cancel-comment-reply"><?php cancel_comment_reply_link( 'Cancel' ); ?></span>
					</div>

					<?php comment_id_fields(); ?>
					<?php do_action( 'comment_form' ); ?>
				</fieldset>
			</form>
		<?php endif; // if registration required and not logged in. ?>
	</div>

<?php endif; ?>

</section>
