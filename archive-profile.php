<?php
/**
 * Template used to display Profile archive.
 *
 * @package Responsive_Framework\BU_Profiles
 */

get_header(); ?>

	<?php
	/**
	 * Fires immediately before the opening article tag.
	 *
	 * @since 2.3.3
	 */
	do_action( 'r_before_opening_article' );
	?>

	<article class="content-area profiles-archive">

		<?php
		/**
		 * Fires immediately before the_content().
		 *
		 * @since 2.3.3
		 */
		do_action( 'r_after_opening_article' );
		?>

		<?php if ( have_posts() ) : ?>

			<ul class="profile-listing profile-format-basic">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/profile', 'archive' ); ?>
				<?php endwhile; ?>
			</ul>

			<?php responsive_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/no-content', 'profiles' ); ?>

		<?php endif; ?>

		<?php
		/**
		 * Fires immediately before closing article tag.
		 *
		 * @since 2.3.3
		 */
		do_action( 'r_before_closing_article' );
		?>

	</article>

	<?php
	/**
	 * Fires immediately after closing article tag.
	 *
	 * @since 2.3.3
	 */
	do_action( 'r_after_closing_article' );
	?>

<?php get_sidebar( 'profiles' ); ?>

<?php get_footer();
