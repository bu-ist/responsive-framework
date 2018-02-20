<?php
/**
 * Template Name: News
 *
 * @package Responsive_Framework
 */

// Setup for secondary query that lists posts based on the page's metadata.
include BU_NEWS_POST_LISTS_PATH . '/news-page-template.php';
BU_News_Page_Template::init();

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'content-area' ); ?>>

	<?php the_title( '<h1>', '</h1>' ); ?>

	<?php the_content(); ?>

	<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:' ), 'after' => '</div>' ) ); ?>

	<?php edit_post_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>

	<?php $news_query = BU_News_Page_Template::query_posts(); ?>

		<?php if ( $news_query->have_posts() ) : ?>
		<section class="news-posts">

		<?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
			<?php get_template_part( 'template-parts/news', 'archive' ); ?>
		<?php endwhile; ?>

		<?php responsive_posts_navigation( null, $news_query ); ?>

		</section>

	<?php else : ?>

		<h1>No Posts Found</h1>
		<p>This site does not currently have any posts. Please check back later.</p>

	<?php endif; ?>

		<?php wp_reset_postdata(); ?>

	</article>

<?php endwhile; ?>

<?php get_sidebar( 'posts' ); ?>
<?php get_footer();
