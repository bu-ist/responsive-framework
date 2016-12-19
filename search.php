<?php
/**
 * Template file used to render a Search Results Index page.
 *
 * @package Responsive_Framework
 */

get_header(); ?>

	<article role="main" <?php post_class(); ?>>

		<?php if ( have_posts() ) : ?>

			<h1><?php printf( 'Search Results for: %s', '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'search' ); ?>

			<?php endwhile; ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

	</article>

<?php get_footer();
