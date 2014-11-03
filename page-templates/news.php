<?php
/*
Template Name: News
*/

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php responsive_content_banner( 'page-width' ); ?>

		<?php get_template_part( 'template-parts/content', 'single' ); ?>

	<?php endwhile; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
