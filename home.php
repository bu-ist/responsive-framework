<?php
/**
 * Template file used to render the Blog Posts Index, whether on the site front page or on a static page.
 *
 * @package Responsive_Framework
 */

get_header(); ?>

<article class="content-area">

	<?php if ( ! empty( $title  ) ) : ?>

		<h1><?php echo esc_html( $title ); ?></h1>

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

<?php get_sidebar( 'posts' ); ?>
<?php get_footer();
