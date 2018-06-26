<?php
/**
 * Template file used to render the Blog Posts Index, whether on the site front page or on a static page.
 *
 * @package Responsive_Framework
 */

get_header();

$page_for_posts = get_option( 'page_for_posts', 0 );
?>

<article class="content-area">
	<?php if ( ! is_front_page() && is_home() && ! empty( $page_for_posts ) ) : ?>
		<h1 <?php r_page_title_class( '', true ); ?>><?php echo get_the_title( $page_for_posts ); ?></h1>
	<?php endif; ?>

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php r_get_template_part( get_post_type(), 'home' ); ?>

		<?php endwhile; ?>

		<?php responsive_posts_navigation(); ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/no-content', 'home' ); ?>

	<?php endif; ?>

</article>

<?php
get_sidebar( 'posts' );
get_footer();
