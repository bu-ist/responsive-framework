<?php
/*
Template Name: Homepage
*/

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php responsive_content_banner( 'contentWidth' ); ?>

		<?php get_template_part( 'template-parts/content', 'page' ); ?>

	<?php endwhile; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
