<?php
/**
 * Template partial used to display content for BU Posts List "News" template.
 */

// Setup for secondary query that lists posts based on the page's metadata.
include BU_NEWS_POST_LISTS_PATH . '/news-page-template.php';
BU_News_Page_Template::init();
$bu_news_display_options = BU_News_Page_Template::$display_content;

?>

<article role="main" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php responsive_content_banner( 'contentWidth' ); ?>

	<h1><?php the_title(); ?></h1>

	<?php the_content(); ?>

	<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:' ), 'after' => '</div>' ) ); ?>

	<?php edit_post_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>

	<?php $news_query = BU_News_Page_Template::query_posts(); ?>
	<?php if ( $news_query->have_posts() ) : ?>
	<section class="news-posts">

		<?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<?php BU_News_Page_Template::show_thumbnail( '<div class="thumb">', '</div>' ); ?>

			<h2>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			</h2>

			<?php
				$show_meta = responsive_post_lists_show_news_meta( $bu_news_display_options );
				if ( $show_meta ) {

					echo '<div class="meta">';
					BU_News_Page_Template::show_author( '<span class="author"><em>By</em> ', '</span>' );
					BU_News_Page_Template::show_date( '<span class="date">', '</span>' );
					BU_News_Page_Template::show_categories( '<span class="category"><em>in</em> ', '</span>' );
					BU_News_Page_Template::show_comments( '<span class="comment-counter">', '</span>' );
					echo '</div>';
				}

				BU_News_Page_Template::show_content( '', '', 'More' );

				if ( $show_meta ) {
					echo '<p class="meta tag-list">';
					BU_News_Page_Template::show_tags( ' <span class="tags"><em>Tagged:</em> ', '</span>' );
					echo '</p>';
				}
			?>
		</article>

		<?php endwhile; ?>

		<?php responsive_posts_navigation( null, $news_query ); ?>

	</section>

	<?php else : ?>

		<h1>No Posts Found</h1>
		<p>This site does not currently have any posts. Please check back later.</p>

	<?php endif; ?>

	<?php wp_reset_postdata(); ?>

</article>
