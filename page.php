<?php
/**
 * Template file used to render a static page.
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php if ( function_exists( 'bu_content_banner' ) ) {
			echo do_shortcode( bu_content_banner( get_the_ID(), array(
				'before'   => '<div class="banner-container page-width">',
				'after'    => '</div>',
				'class'    => 'banner',
				//'maxwidth' => 900,
				'position' => 'page-width',
				'echo'     => false,
			) ) );
		} ?>

		<?php get_template_part( 'template-parts/content', 'page' ); ?>

	<?php endwhile; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
