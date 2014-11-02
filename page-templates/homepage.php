<?php
/*
Template Name: Homepage
*/

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php if ( function_exists( 'bu_content_banner' ) ) {
			echo do_shortcode( bu_content_banner( $post->ID, $args = array(
				'before'   => '<div class="banner-container">',
				'after'    => '</div>',
				'class'    => 'banner',
				'position' => 'content-width',
				'echo'     => false,
			) ) );
		} ?>

		<?php get_template_part( 'template-parts/content', 'page' ); ?>

	<?php endwhile; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
