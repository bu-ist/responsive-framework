<?php
/*
Template Name: Developer Access Grid
*/

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php responsive_content_banner( 'pageWidth' ); ?>

		<?php get_template_part( 'template-parts/content', 'developer-access-grid' ); ?>

	<?php endwhile; ?>

<?php get_footer();
