<?php
/**
 * BU Post List plugin support functions & templates.
 *
 * @package Responsive_Framework\BU_Post_List
 */

if ( ! function_exists( 'responsive_posts_widget_formats' ) ) :

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
		'label'               => 'title only (no thumbnail)',
		'callback'            => 'responsive_posts_widget_format_display',
		'requires_commenting' => false,
		'supports_thumbnail'  => false,
			);

			$formats['title_date'] = array(
			'label'               => 'title, date',
			'callback'            => 'responsive_posts_widget_format_display',
			'supports_thumbnail'  => true,
			'requires_commenting' => false,
			);

			$formats['title_excerpt'] = array(
			'label'               => 'title, excerpt',
			'callback'            => 'responsive_posts_widget_format_display',
			'supports_thumbnail'  => true,
			'requires_commenting' => false,
			);

			$formats['title_date_excerpt'] = array(
			'label'               => 'title, date, excerpt',
			'callback'            => 'responsive_posts_widget_format_display',
			'supports_thumbnail'  => true,
			'requires_commenting' => false,
			);

			$formats['title_author_excerpt'] = array(
			'label'               => 'title, author, excerpt',
			'callback'            => 'responsive_posts_widget_format_display',
			'supports_thumbnail'  => true,
			'requires_commenting' => false,
			);

			$formats['title_date_comments_excerpt'] = array(
			'label'               => 'title, date, comments, excerpt',
			'callback'            => 'responsive_posts_widget_format_display',
			'supports_thumbnail'  => true,
			'requires_commenting' => true,
			);

			$formats['title_author_comments_excerpt'] = array(
			'label'               => 'title, author, comments, excerpt',
			'callback'            => 'responsive_posts_widget_format_display',
			'supports_thumbnail'  => true,
			'requires_commenting' => true,
			);

			return $formats;
	}

endif;

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

		// Thumbnail dimensions change for formats with less content.
		if ( 'title_date' === $args['current_format'] ) {
			$max_width = $max_height = 88;
			$use_thumb = true;
		} else {
			$max_width = $max_height = 260;
			$use_thumb = false;
		}

		$output .= bu_get_thumbnail_src( $post->ID, array(
				'maxwidth'  => $max_width,
				'maxheight' => $max_height,
				'classes'   => 'thumb',
				'use_thumb' => $use_thumb,
				)
		);
	}

	// Title.
	$output .= sprintf( '<h1 class="post-headline widget-headline"><a href="%s" rel="bookmark">%s</a></h1>', get_permalink(), get_the_title() );

	// Meta.
	switch ( $args['current_format'] ) {
		case 'title_date':
		case 'title_date_excerpt':
			$output .= sprintf( '<p class="meta widget-meta"><span class="published widget-published">%s</span></p>', BU_PostList::post_date( 'F j, Y' ) );
			break;
		case 'title_author_excerpt':
			$output .= sprintf( '<p class="meta widget-meta"><span class="author widget-author">by %s</span></p>', get_the_author() );
			break;
		case 'title_date_comments_excerpt':
			$output .= sprintf( '<p class="meta widget-meta"><span class="published widget-published">%s</span>  <span class="comment-counter widget-comment-counter"> <a href="%s" rel="nofollow"><strong>%s</strong> comments</a></span></p>', BU_PostList::post_date( 'F j, Y' ), get_comments_link(), get_comments_number( $post->ID ) );
			break;
		case 'title_author_comments_excerpt':
			$output .= sprintf( '<p class="meta widget-meta"><span class="author widget-author">by %s</span>  <span class="comment-counter widget-comment-counter">
					<a href="%s" rel="nofollow"><strong>%s</strong> comments</a></span></p>', get_the_author(), get_comments_link(), get_comments_number( $post->ID ) );
			break;
	}

	// Excerpt.
	$show_excerpt = ( false !== strpos( $args['current_format'], 'excerpt' ) );
	if ( $show_excerpt && BU_PostList::get_post_excerpt( 12 ) ) {
		$output .= sprintf( '<p class="excerpt widget-excerpt">%s</p>', BU_PostList::get_post_excerpt( 12 ) );
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
