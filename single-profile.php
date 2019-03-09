<?php
/**
 * Template file used to render a single profile.
 *
 * @package Responsive_Framework\BU_Profiles
 */

/**
 * Adds a profile image above the title.
 *
 * @since 2.2.1
 */
function responsive_single_profile_img() {

	// Sets profile thumbnail to false by default.
	$profile_thumb = false;

	// If BU Thumbnail exists, attempt to retrieve the image HTML.
	if ( function_exists( 'bu_thumbnail' ) ) {
		$thumb_args    = array(
			'maxwidth'  => 300,
			'maxheight' => 300,
			'size'      => 'responsive_profile_large',
		);
		$profile_thumb = bu_get_thumbnail_src( get_the_ID(), $thumb_args );
	}

	// Output the thumbnail if found.
	if ( $profile_thumb ) :
		?>
		<figure class="profile-photo profile-single-photo">
			<?php echo wp_kses_post( $profile_thumb ); ?>
		</figure>
		<?php
	endif;
}
add_action( 'r_after_opening_article', 'responsive_single_profile_img', 9 );

/**
 * Adds a profile title (a.k.a. job/position) below the title.
 *
 * @since 2.2.1
 *
 * @link https://github.com/bu-ist/bu-profiles/blob/develop/bu-profile-template-tags.php#L3-L28
 */
function responsive_single_profile_subheader() {

	// Define arguments to pass to `bu_profile_detail()`.
	$detail_args = array(
		'before' => '<h2 class="profile-single-title">',
		'after'  => '</h2>',
	);

	// Output the profile title (job/position) in heading tags if exists.
	bu_profile_detail( 'title', $detail_args );
}
add_action( 'r_after_opening_article', 'responsive_single_profile_subheader', 11 );

/**
 * Begin templating.
 */
get_header(); ?>

	<?php if ( have_posts() ) : the_post(); ?>

		<?php
		/**
		 * Fires immediately before the opening article tag.
		 *
		 * @since 2.2.1
		 */
		do_action( 'r_before_opening_article' );
		?>

		<article <?php post_class( 'content-area' ); ?>>

			<?php
			/**
			 * Fires immediately after opening article tag.
			 *
			 * @since 2.2.1
			 */
			do_action( 'r_after_opening_article' );
			?>

			<?php if ( bu_profile_has_details() ) : ?>
				<aside role="complementary" class="profile-single-details">
					<ul class="profile-details-list">
						<?php

						bu_profile_detail( 'title', array(
							'before' => sprintf( '<li class="profile-details-item profile-details-title"><span class="label profile-details-label">%s </span>', esc_html__( 'Title', 'responsive-framework' ) ),
							'after' => '</li>',
							'post_id' => get_the_ID(),
							'format' => 'multi-line',
						) );

						bu_profile_detail( 'office', array(
							'before' => sprintf( '<li class="profile-details-item profile-details-office"><span class="label profile-details-label">%s </span>', esc_html__( 'Office', 'responsive-framework' ) ),
							'after' => '</li>',
							'post_id' => get_the_ID(),
							'format' => 'multi-line',
						) );

						bu_profile_detail( 'email', array(
							'before' => sprintf( '<li class="profile-details-item profile-details-email"><span class="label profile-details-label">%s </span>', esc_html__( 'Email', 'responsive-framework' ) ),
							'after' => '</li>',
							'post_id' => get_the_ID(),
							'format' => 'email',
						) );

						bu_profile_detail( 'phone', array(
							'before' => sprintf( '<li class="profile-details-item profile-details-phone"><span class="label profile-details-label">%s </span>', esc_html__( 'Phone', 'responsive-framework' ) ),
							'after' => '</li>',
							'post_id' => get_the_ID(),
						) );

						bu_profile_detail( 'education', array(
							'before' => sprintf( '<li class="profile-details-item profile-details-education"><span class="label profile-details-label">%s </span>', esc_html__( 'Education', 'responsive-framework' ) ),
							'after' => '</li>',
							'post_id' => get_the_ID(),
							'format' => 'multi-line',
						) );

						?>
					</ul>
				</aside><!--/.profile-info-->

			<?php endif; ?>

			<?php if ( get_the_content() !== '' ) : ?>
				<div class="profile-single-bio">
					<?php the_content(); ?>
				</div><!--/.profile-bio-->
			<?php endif; ?>

			<?php responsive_share_tools(); ?>

			<?php the_taxonomies( array( 'before' => '<div class="profile-tax"><dl>', 'sep' => '', 'after' => '</dl></div><!--/.profiles-tax-->', 'template' => '<dt>%s</dt><dd>%l</dd>' ) ); ?>

			<?php responsive_profiles_archive_link(); ?>

			<?php responsive_comments(); ?>

			<?php edit_post_link( __( 'Edit Profile', 'responsive-framework' ), '<span class="edit-link">', '</span><span class="post-edit-hint"></span>' ); ?>

			<?php
			/**
			 * Fires immediately before closing article tag.
			 *
			 * @since 2.2.1
			 */
			do_action( 'r_before_closing_article' );
			?>

		</article>

		<?php
		/**
		 * Fires immediately after closing article tag.
		 *
		 * @since 2.2.1
		 */
		do_action( 'r_after_closing_article' );
		?>

	<?php endif; ?>

<?php get_sidebar( 'profiles' ); ?>
<?php get_footer();
