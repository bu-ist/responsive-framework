<?php
/*
Template Name: No Sidebars
*/

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php if ( function_exists( 'bu_content_banner' ) ) {
			echo do_shortcode( bu_content_banner( $post->ID, $args = array(
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

<?php get_footer(); ?>
