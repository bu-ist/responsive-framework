<?php
/**
 * Template file used to render a static page.
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php responsive_content_banner( 'pageWidth' ); ?>

		<?php get_template_part( 'template-parts/content', 'page' ); ?>

	<?php endwhile; ?>

<?php get_sidebar(); ?>
<?php get_footer();
