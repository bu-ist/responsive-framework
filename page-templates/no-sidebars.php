<?php
/**
 * Template Name: No Sidebars
 *
 * @package Responsive_Framework
 */

get_header();
?>

	<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'content-area' ); ?>>

			<?php responsive_the_title(); ?>

			<?php the_content(); ?>

			<?php responsive_share_tools(); ?>

			<?php
				wp_link_pages( array(
					'before' => sprintf( '<div class="page-link">%s', esc_html__( 'Pages:', 'responsive-framework' ) ),
					'after' => '</div>',
				) );
			?>

			<?php responsive_comments(); ?>

			<?php edit_post_link( __( 'Edit Page', 'responsive-framework' ), '', '<span class="post-edit-hint"></span>' ); ?>

		</article>

	<?php endwhile; ?>

<?php
get_footer();
