<?php
/**
 * Template file used to render a single post.
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php responsive_content_banner( 'pageWidth' ); ?>

		<?php get_template_part( 'template-parts/content', 'single' ); ?>

	<?php endwhile; ?>

<?php get_sidebar( 'posts' ); ?>
<?php get_footer();
