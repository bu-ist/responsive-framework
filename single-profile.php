<?php
/**
 * Template file used to render a single profile.
 *
 * @package Responsive_Framework\BU_Profiles
 */

$has_details = bu_profile_has_details();

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

			<?php if ( $has_details ) : ?>
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

			<?php edit_post_link( __( 'Edit', 'responsive-framework' ), '<p class="edit-link">', '</p>' ); ?>

			<?php responsive_profiles_archive_link(); ?>

			<?php responsive_comments(); ?>

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
