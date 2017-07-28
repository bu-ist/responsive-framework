<?php
/**
 * Template file used to render the Blog Posts Index, whether on the site front page or on a static page.
 *
 * @package Responsive_Framework
 */

get_header(); ?>

<article class="content-area">

	<h1><?php single_post_title(); ?></h1>

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content' ); ?>

		<?php endwhile; ?>

		<?php responsive_posts_navigation(); ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/content', 'none' ); ?>

	<?php endif; ?>

</article>

<?php get_sidebar( 'posts' ); ?>
<?php get_footer();
