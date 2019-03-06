<?php
/**
 * Template file used to render a Search Results Index page.
 *
 * @package Responsive_Framework
 */

get_header(); ?>

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

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php r_get_template_part( get_post_type(), 'search' ); ?>

			<?php endwhile; ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/no-content', 'search' ); ?>

		<?php endif; ?>

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

<?php get_footer();
