<?php
/**
 * BU Post List plugin support functions & templates.
 *
 * @package Responsive_Framework\BU_Post_List
 */

/**
 * Remove/add display formats for the BU Posts widget.
 *
 * @param array $formats Default formats for the widget.
 *
 * @return array $formats Adjusted formats for the widget.
 */
function responsive_posts_widget_formats( $formats ) {
	unset( $formats['date_title_excerpt'] );

	$formats['title_only'] = array(
		'label'               => __( 'title only (no thumbnail)', 'responsive-framework' ),
		'callback'            => 'responsive_posts_widget_format_display',
		'requires_commenting' => false,
		'supports_thumbnail'  => false,
	);

	$formats['title_date'] = array(
		'label'               => __( 'title, date', 'responsive-framework' ),
		'callback'            => 'responsive_posts_widget_format_display',
		'supports_thumbnail'  => true,
		'requires_commenting' => false,
	);

	$formats['title_excerpt'] = array(
		'label'               => __( 'title, excerpt', 'responsive-framework' ),
		'callback'            => 'responsive_posts_widget_format_display',
		'supports_thumbnail'  => true,
		'requires_commenting' => false,
	);

	$formats['title_date_excerpt'] = array(
		'label'               => __( 'title, date, excerpt', 'responsive-framework' ),
		'callback'            => 'responsive_posts_widget_format_display',
		'supports_thumbnail'  => true,
		'requires_commenting' => false,
	);

	$formats['title_author_excerpt'] = array(
		'label'               => __( 'title, author, excerpt', 'responsive-framework' ),
		'callback'            => 'responsive_posts_widget_format_display',
		'supports_thumbnail'  => true,
		'requires_commenting' => false,
	);

	$formats['title_date_comments_excerpt'] = array(
		'label'               => __( 'title, date, comments, excerpt', 'responsive-framework' ),
		'callback'            => 'responsive_posts_widget_format_display',
		'supports_thumbnail'  => true,
		'requires_commenting' => true,
	);

	$formats['title_author_comments_excerpt'] = array(
		'label'               => __( 'title, author, comments, excerpt', 'responsive-framework' ),
		'callback'            => 'responsive_posts_widget_format_display',
		'supports_thumbnail'  => true,
		'requires_commenting' => true,
	);

	return $formats;
}
add_filter( 'bu_posts_widget_formats', 'responsive_posts_widget_formats', 1, 1 );

/**
 * One BU Post Lists widget format callback to rule them all.
 *
 * @param string $post Post being displayed.
 * @param array  $args {
 *     Arguments to configure how a post displays in a BU Posts widget.
 *
 *     @type  boolean $show_thumbnail Show or hide post thumbnails.
 *     @type  string  $current_format Selected format for current widget.
 * }
 *
 * @return string $output HTML output for the current post.
 */
function responsive_posts_widget_format_display( $post, $args ) {
	global $post;

	$output = '<article class="post widget-post">';

		// Thumbnail.
	if ( $args['show_thumbnail'] && function_exists( 'bu_get_thumbnail_src' ) ) {

		$thumbclass = 'widget-post-thumbnail';

		// Thumbnail dimensions change for formats with less content.
		if ( 'title_date' === $args['current_format'] ) {
			$max_width = $max_height = 60;
			$use_thumb = true;
			$thumbclass = 'widget-post-thumbnail-title-date';
		} else {
			$max_width = $max_height = 340;
			$use_thumb = false;
		}

		$output .= bu_get_thumbnail_src(
			$post->ID,
			array(
				'maxwidth'  => $max_width,
				'maxheight' => $max_height,
				'classes'   => $thumbclass,
				'use_thumb' => $use_thumb,
			)
		);
	}

	// Title.
	$output .= sprintf( '<h4 class="post-headline widget-post-headline"><a href="%s" rel="bookmark">%s</a></h4>', get_permalink(), get_the_title() );

	// Meta.
	switch ( $args['current_format'] ) {
		case 'title_date':
		case 'title_date_excerpt':
			$output .= sprintf( '<p class="meta widget-post-meta"><span class="published widget-post-published">%s</span></p>', BU_PostList::post_date( 'F j, Y' ) );
			break;
		case 'title_author_excerpt':
			/* translators: %s: author's name. */
			$output .= sprintf( '<p class="meta widget-post-meta"><span class="author widget-post-author">%s</span></p>', sprintf( __( 'by %s', 'responsive-framework' ), get_the_author() ) );
			break;
		case 'title_date_comments_excerpt':
			$output .= sprintf( '<p class="meta widget-post-meta"><span class="published widget-post-published">%s</span>  <span class="comment-counter widget-post-comment-counter"> <a href="%s" rel="nofollow"><strong>%s</strong> comments</a></span></p>', BU_PostList::post_date( 'F j, Y' ), get_comments_link(), get_comments_number() );
			break;
		case 'title_author_comments_excerpt':
			$output .= sprintf(
				'<p class="meta widget-post-meta"><span class="author widget-post-author">%s</span>  <span class="comment-counter widget-post-comment-counter">
					<a href="%s" rel="nofollow">%s</a></span></p>',
				/* translators: %s: author's name. */
				sprintf( __( 'by %s', 'responsive-framework' ), get_the_author() ),
				get_comments_link(),
				/* translators: %s: number of comments. */
				sprintf( _nx( '<strong>%1$d</strong> comment', '<strong>%1$d</strong> comments', get_comments_number(), 'number of comments', 'responsive-framework' ) ), get_comments_number()
			);
			break;
	}

	// Excerpt.
	$show_excerpt = ( false !== strpos( $args['current_format'], 'excerpt' ) );
	if ( $show_excerpt && BU_PostList::get_post_excerpt( 12 ) ) {
		$output .= sprintf( '<p class="excerpt widget-post-excerpt">%s</p>', BU_PostList::get_post_excerpt( 12 ) );
	}

	$output .= '</article>';

	return $output;
}

/**
 * Checks all of the News template display options to determine whether or not we have meta to display.
 *
 * @param array $settings BU_News_Page_Template settings array.
 *
 * @return boolean Whether to show news meta.
 */
function responsive_post_lists_show_news_meta( $settings = array() ) {
	if ( empty( $settings ) ) {
		$settings = BU_News_Page_Template::$display_content;
	}

	return ( 'yes' === $settings['disp_date'] ||
			'yes' === $settings['disp_comments'] ||
			'yes' === $settings['disp_author'] ||
			'yes' === $settings['disp_cat'] ||
			'yes' === $settings['disp_author'] ||
			'yes' === $settings['disp_tags'] );
}
