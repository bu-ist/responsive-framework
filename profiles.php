<?php
/**
 * Template Name: Profiles
 *
 * @package Responsive_Framework\BU_Profiles
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php
		/**
		 * Fires immediately before the opening article tag.
		 *
		 * @since 2.2.1
		 */
		do_action( 'r_before_opening_article' );
		?>

		<article id="post-<?php the_ID(); ?>" class="content-area">

			<?php
			/**
			 * Fires immediately after opening article tag.
			 *
			 * @since 2.2.1
			 */
			do_action( 'r_after_opening_article' );
			?>

			<?php the_content( '<p class="serif">' . esc_html__( 'Read the rest of this profile &raquo;', 'responsive-framework' ) . '</p>' ); ?>

			<?php if ( defined( 'BU_PROFILES_PLUGIN_ACTIVE' ) && BU_PROFILES_PLUGIN_ACTIVE ) : ?>
			<?php $format = bu_profile_get_format_for_post(); ?>
			<?php $query = bu_profile_get_query();?>
			<?php bu_profile_get_template_part( $format, $query ); ?>
			<?php endif; ?>

			<?php responsive_comments(); ?>

			<?php edit_post_link( __( 'Edit Page', 'responsive-framework' ), '<span class="edit-link">', '</span><span class="post-edit-hint"></span>' ); ?>

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

	<?php endwhile; ?>

<?php get_sidebar( 'profiles' ); ?>
<?php get_footer();
