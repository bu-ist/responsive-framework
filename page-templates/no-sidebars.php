<?php
/**
 * Template Name: No Sidebars
 *
 * @package Responsive_Framework
 */

get_header();
?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php
		/**
		 * Fires immediately before the opening article tag.
		 *
		 * @since 2.2.1
		 */
		do_action( 'r_before_opening_article' );
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'content-area' ); ?>>

			<?php
			/**
			 * Fires immediately after opening article tag.
			 *
			 * @since 2.2.1
			 */
			do_action( 'r_after_opening_article' );
			?>

			<?php the_content(); ?>

			<?php responsive_share_tools(); ?>

			<?php
				wp_link_pages( array(
					'before' => sprintf( '<div class="page-link">%s', esc_html__( 'Pages:', 'responsive-framework' ) ),
					'after' => '</div>',
				) );
			?>

			<?php edit_post_link( __( 'Edit', 'responsive-framework' ), '<span class="edit-link">', '</span>' ); ?>

			<?php responsive_comments(); ?>

			<?php
			/**
			 * Fires immediately before closing article tag.
			 *
			 * @since 2.2.1
			 */
			do_action( 'r_before_closing_article' );
			?>

		</article>

		<?php
		/**
		 * Fires immediately after closing article tag.
		 *
		 * @since 2.2.1
		 */
		do_action( 'r_after_closing_article' );
		?>

	<?php endwhile; ?>

<?php
get_footer();
