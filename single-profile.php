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
		if ( function_exists( 'bu_thumbnail' ) ) {
			$thumb_args = array(
				'maxwidth'  => 300,
				'maxheight' => 300,
				'size'      => 'responsive_profile_large',
			);
			$profile_thumb = bu_get_thumbnail_src( get_the_ID(), $thumb_args );
		} else {
			$profile_thumb = false;
		}
		?>

		<article <?php post_class( 'content-area' ); ?>>
			<?php if ( $profile_thumb ) : ?>
				<figure class="profile-photo profile-single-photo"><?php echo wp_kses_post( $profile_thumb ); ?></figure>
			<?php endif; ?>

			<?php responsive_the_title(); ?>
			<h2 class="profile-single-title"><?php bu_profile_detail( 'title' ); ?></h2>

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

		</article>

	<?php endif; ?>

<?php get_sidebar( 'profiles' ); ?>
<?php get_footer();
