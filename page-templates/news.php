<?php
/**
 * Template Name: News
 *
 * @package Responsive_Framework
 */

// Setup for secondary query that lists posts based on the page's metadata.
include BU_NEWS_POST_LISTS_PATH . '/news-page-template.php';

if ( class_exists( 'BU_News_Page_Template' ) ) {
	BU_News_Page_Template::init();
}

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

		<?php
			wp_link_pages( array(
				'before' => sprintf( '<div class="page-link">%s', esc_html__( 'Pages:', 'responsive-framework' ) ),
				'after' => '</div>',
			) );
		?>

		<?php if ( class_exists( 'BU_News_Page_Template' ) ) : ?>

			<?php $news_query = BU_News_Page_Template::query_posts(); ?>

				<?php if ( $news_query->have_posts() ) : ?>
				<section class="news-posts">

				<?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
					<?php get_template_part( 'template-parts/news', 'archive' ); ?>
				<?php endwhile; ?>

				<?php responsive_posts_navigation( null, $news_query ); ?>

				</section>

			<?php else : ?>

				<h2><?php esc_html_e( 'No Posts Found', 'responsive-framework' ); ?></h2>
				<p><?php esc_html_e( 'This site does not currently have any posts. Please check back later.', 'responsive-framework' ); ?></p>

			<?php endif; ?>

		<?php endif; ?>

		<?php wp_reset_postdata(); ?>

		<?php edit_post_link( __( 'Edit Page', 'responsive-framework' ), '<span class="edit-link">', '</span><span class="post-edit-hint"></span>' ); ?>

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
get_sidebar( 'posts' );
get_footer();
