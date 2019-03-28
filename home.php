<?php
/**
 * Template file used to render the Blog Posts Index, whether on the site front page or on a static page.
 *
 * @package Responsive_Framework
 */

get_header();

?>

<?php
/**
 * Fires immediately before the opening article tag.
 *
 * @since 2.3.3
 */
do_action( 'r_before_opening_article' );
?>

<article class="content-area">

	<?php
	/**
	 * Fires immediately after opening article tag.
	 *
	 * @since 2.3.3
	 */
	do_action( 'r_after_opening_article' );
	?>

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php r_get_template_part( get_post_type(), 'home' ); ?>

		<?php endwhile; ?>

		<?php responsive_posts_navigation(); ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/no-content', 'home' ); ?>

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

<?php
get_sidebar( 'posts' );
get_footer();
