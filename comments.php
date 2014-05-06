<?php ?>

<aside class="comments">
	<?php if ( post_password_required() ) : ?>
    <p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.' ); ?></p>
</aside>

<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>

<?php
	// You can start editing here -- including this comment!
?>

<?php if ( have_comments() ) : ?>
            <h2><?php
			printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number() ),
			number_format_i18n( get_comments_number() ), get_the_title() );
			?></h2>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
    <ul class="navigation">
        <li class="older">
            <?php previous_comments_link( __( 'Older Comments' ) ); ?>
        </li> 
        <li class="newer">
			<?php next_comments_link( __( 'Newer Comments' ) ); ?>
        </li>
    </ul>
<?php endif; // check for comment navigation ?>

<ol class="commentlist">
    <?php wp_list_comments( array( 'callback' => 'post_comments' ) ); ?>
</ol>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>			
    <ul class="navigation">
        <li class="older">
            <?php previous_comments_link( __( 'Older Comments' ) ); ?>
        </li> 
        <li class="newer">
			<?php next_comments_link( __( 'Newer Comments' ) ); ?>
        </li>
    </ul>
<?php endif; // check for comment navigation ?>

<?php else : // or, if we don't have comments:

	/* If there are no comments and comments are closed,
	 * let's leave a little note, shall we?
	 */
	if ( ! comments_open() ) :
?>
	<p class="nocomments"><?php _e( 'Comments are closed.' ); ?></p>
<?php endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>

<?php comment_form(); ?>

</div><!-- #comments -->
