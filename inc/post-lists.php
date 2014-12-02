<?php
/**
 * BU Post List plugin support functions & templates.
 */

if ( ! function_exists( 'responsive_posts_widget_formats' ) ) :

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
 */
function responsive_posts_widget_format_display( $post, $args ) {
	global $post;

	$output = '<article class="post">';

	// Thumbnail
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

	// Title
	$output .= sprintf( '<h1 class="headline"><a href="%s" rel="bookmark">%s</a></h1>', get_permalink(), get_the_title() );

	// Meta
	switch ( $args['current_format'] ) {
		case 'title_date':
		case 'title_date_excerpt':
			$output .= sprintf( '<p class="meta"><span class="published">%s</span></p>', BU_PostList::post_date( 'F j, Y' ) );
			break;
		case 'title_author_excerpt':
			$output .= sprintf( '<p class="meta"><span class="author">by %s</span></p>', get_the_author() );
			break;
		case 'title_date_comments_excerpt':
			$output .= sprintf( '<p class="meta"><span class="published">%s</span>  <span class="comment-counter"> <a href="%s" rel="nofollow"><strong>%s</strong> comments</a></span></p>', BU_PostList::post_date( 'F j, Y' ), get_comments_link(), get_comments_number( $post->ID ) );
			break;
		case 'title_author_comments_excerpt':
			$output .= sprintf( '<p class="meta"><span class="author">by %s</span>  <span class="comment-counter">
					<a href="%s" rel="nofollow"><strong>%s</strong> comments</a></span></p>', get_the_author(), get_comments_link(), get_comments_number( $post->ID ) );
			break;
	}

	// Excerpt
	$show_excerpt = ( false !== strpos( $args['current_format'], 'excerpt' ) );
	if ( $show_excerpt && BU_PostList::get_post_excerpt( 12 ) ) {
		$output .= sprintf( '<p class="excerpt">%s</p>', BU_PostList::get_post_excerpt( 12 ) );
	}

	$output .= '</article>';

	return $output;
}

/**
 * Checks all of the News template display options to determine
 * whether or not we have meta to display.
 */
function responsive_post_lists_show_news_meta( $settings ) {
	return ( $settings['disp_date'] === 'yes' ||
		$settings['disp_comments'] === 'yes' ||
		$settings['disp_author'] === 'yes' ||
		$settings['disp_cat'] === 'yes' ||
		$settings['disp_author'] === 'yes' ||
		$settings['disp_tags'] === 'yes' );
}
