<?php
/*
Template Name: No Sidebars
*/

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php responsive_content_banner( 'pageWidth' ); ?>

		<?php get_template_part( 'template-parts/content', 'page' ); ?>

	<?php endwhile; ?>

<?php get_footer();