<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	if ( post_password_required() ) { ?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
}
?>

<?php if ( have_comments() ) : ?>
	<div id="comment_wrapper">
		<h3 id="comments"><?php comments_number('No Comments', 'One Comment', '% Comments' );?> <span>on <?php the_title(); ?></span></h3>
		<ul class="commentlist">
			<?php wp_list_comments(array('callback' => 'bu_flexi_comments_callback')); ?>
		</ul>
	
		<?php if($GLOBALS['wp_query']->max_num_comment_pages > 1): ?>
			<p class="navigation"><span class="previous"><?php previous_comments_link('Older') ?></span> <span class="next"><?php next_comments_link('Newer') ?></span></p>
		<?php endif; ?>
	</div><!-- /#comment_wrapper -->

<?php else: ?>
	<?php if( !comments_open() && is_single() ) : // comments are closed ?>
		<div id="comment_wrapper">
		<p class="nocomments">Comments are closed.</p>
		</div><!-- /#comment_wrapper -->
	<?php endif; ?>
<?php endif; ?>

 <?php if (comments_open()) : // this is displayed if there are no comments so far ?>
	<div id="commentform_wrapper" class="buforms">

	<h3 id="respond"><?php comment_form_title( 'Post Your Comment', 'Reply to %s' ); ?></h3>

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
		<p>You must be <a href="<?php echo wp_login_url( get_permalink() ); ?>">logged in</a> to post a comment.</p>
	<?php else : ?>
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		<fieldset>
		<?php if ( is_user_logged_in() ) : ?>
			<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>
		<?php else : ?>
			<div><label for="author">Name<?php if ($req) echo "<em class='required'>*</em>"; ?></label><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> /></div>
			<div><label for="email">Email<?php if ($req) echo "<em class='required'>*</em>"; ?></label><input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> /></div>
			<div><label for="url">Website</label><input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" /></div>
		<?php endif; ?>

			<div><label for="comment">Comment <span>(<a href="http://www.bu.edu/tech/web/departments/wordpress/management/comment-guidelines/">view guidelines</a>)</span></label><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></div>
			<div><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" /></div>
			<p class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></p>
		<?php comment_id_fields(); ?>
		<?php do_action('comment_form', $post->ID); ?>
		</fieldset>
		</form>
	<?php endif; // if registration required and not logged in ?>
	</div><!-- /#commentform_wrapper -->
		
<?php endif; ?>
