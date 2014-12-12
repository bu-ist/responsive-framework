<?php
/**
 * Template file used to render the Blog Posts Index, whether on the site front page or on a static page.
 */

get_header(); ?>

	<?php if ( have_posts() ) : ?>

		<h1>Latest Posts</h1>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'template-parts/content' ); ?>

	<?php endwhile; ?>

	<?php responsive_paging_nav(); ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/content', 'none' ); ?>

	<?php endif; ?>

<?php get_sidebar( 'posts' ); ?>
<?php get_footer(); ?>