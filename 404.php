<?php
/**
 * Template file used to render a Server 404 error page.
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

<article class="error-404 not-found content-area">

	<?php
	/**
	 * Fires immediately after opening article tag.
	 *
	 * @since 2.2.1
	 */
	do_action( 'r_after_opening_article' );
	?>

	<p><?php esc_html_e( 'Looks like that page might not be here anymore. Want to give search a try?', 'responsive-framework' ); ?></p>

	<?php responsive_search_form(); ?>

	<?php
	/**
	 * Fires immediately before closing article tag.
	 *
	 * @since 2.2.1
	 */
	do_action( 'r_before_closing_article' );
	?>

</article><!-- .error-404 -->

<?php
/**
 * Fires immediately after closing article tag.
 *
 * @since 2.2.1
 */
do_action( 'r_after_closing_article' );
?>

<?php get_footer();
