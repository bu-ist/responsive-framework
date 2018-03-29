<?php
/**
 * Template file used to render a Search Results Index page.
 *
 * @package Responsive_Framework
 */

get_header(); ?>

	<article <?php post_class( 'content-area' ); ?>>

		<?php if ( have_posts() ) : ?>

			<h1 class="page-title">
			<?php
				/* translators: %s: current search query. */
				printf( esc_html__( 'Search Results for: %s', 'responsive-framework' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
			?>
			</h1>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php r_get_template_part( get_post_type(), 'search' ); ?>

			<?php endwhile; ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/no-content', 'search' ); ?>

		<?php endif; ?>

	</article>

<?php get_footer();
