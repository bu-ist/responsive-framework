<?php
/**
 * Template partial used to display content for single profiles.
 */

$has_details = bu_profile_has_details();

if ( function_exists( 'bu_thumbnail' ) ) {
	$thumb_args = array( 'maxwidth' => 150, 'maxheight' => 150 );
	$profile_thumb = bu_get_thumbnail_src( get_the_ID(), $thumb_args );
} else {
	$profile_thumb = false;
}
?>

<article role="main" <?php post_class(); ?>>

	<h1><?php bu_profile_detail( 'first_name' ); ?> <?php bu_profile_detail( 'last_name' ); ?></h1>

	<?php if ( $profile_thumb ) : ?>
	<div class="profile-thumb"><?php echo $profile_thumb; ?></div>
	<?php endif; ?>

	<?php if ( $has_details ) : ?>
	<div class="profile-info">
		<dl>
		<?php bu_profile_detail( 'title', array( 'before' => '<dt>Title</dt><dd>', 'after' => '</dd>', 'post_id' => get_the_ID(), 'format' => 'multi-line' ) ); ?>
		<?php bu_profile_detail( 'office', array( 'before' => '<dt>Office</dt><dd>', 'after' => '</dd>', 'post_id' => get_the_ID(), 'format' => 'multi-line' ) ); ?>
		<?php bu_profile_detail( 'email', array( 'before' => '<dt>Email</dt><dd>', 'after' => '</dd>', 'post_id' => get_the_ID(), 'format' => 'email' ) ); ?>
		<?php bu_profile_detail( 'phone', array( 'before' => '<dt>Phone</dt><dd>', 'after' => '</dd>', 'post_id' => get_the_ID() ) ); ?>
		<?php bu_profile_detail( 'education', array( 'before' => '<dt>Education</dt><dd>', 'after' => '</dd>', 'post_id' => get_the_ID(), 'format' => 'multi-line' ) ); ?>
		</dl>
	</div><!--/.profile-info-->

	<?php endif; ?>

	<?php if ( get_the_content() !== '' ) : ?>
	<div class="profile-bio">
		<?php the_content(); ?>
	</div><!--/.profile-bio-->
	<?php endif; ?>

	<?php the_taxonomies( array( 'before' => '<div class="profile-tax"><dl>', 'sep' => '', 'after' => '</dl></div><!--/.profiles-tax-->', 'template' => '<dt>%s</dt><dd>%l</dd>' ) ); ?>

	<?php edit_post_link( 'Edit', '<p class="edit-link">', '</p>' ); ?>

	<?php responsive_profiles_archive_link() ; ?>

	<?php responsive_comments(); ?>

</article>
