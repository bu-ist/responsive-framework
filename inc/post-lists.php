<?php
/**
 * BU Post List plugin support functions & templates.
 */

/* - - - - - - - - - - - - - - - - -
  BU Post Widget Formats
  - - - - - - - - - - - - - - - - - */

function bu_flexi_posts_widget_formats( $formats ) {

	unset( $formats['date_title_excerpt'] );

	$formats['title_date'] = array(
		'label'               => 'title, date',
		'callback'            => 'bu_flexi_title_date_callback',
		'supports_thumbnail'  => true,
		'requires_commenting' => false,
	);

	$formats['title_excerpt'] = array(
		'label'               => 'title, excerpt',
		'callback'            => 'bu_flexi_posts_widget_default_callback',
		'supports_thumbnail'  => true,
		'requires_commenting' => false,
	);

	$formats['title_date_excerpt'] = array(
		'label'               => 'title, date, excerpt',
		'callback'            => 'bu_flexi_posts_widget_default_callback',
		'supports_thumbnail'  => true,
		'requires_commenting' => false,
	);

	$formats['title_author_excerpt'] = array(
		'label'               => 'title, author, excerpt',
		'callback'            => 'bu_flexi_posts_widget_default_callback',
		'supports_thumbnail'  => true,
		'requires_commenting' => false,
	);

	$formats['title_date_comments_excerpt'] = array(
		'label'               => 'title, date, comments, excerpt',
		'callback'            => 'bu_flexi_posts_widget_default_callback',
		'supports_thumbnail'  => true,
		'requires_commenting' => true,
	);

	$formats['title_author_comments_excerpt'] = array(
		'label'               => 'title, author, comments, excerpt',
		'callback'            => 'bu_flexi_posts_widget_default_callback',
		'supports_thumbnail'  => true,
		'requires_commenting' => true,
	);

	return $formats;
}

add_filter( 'bu_posts_widget_formats', 'bu_flexi_posts_widget_formats', 1, 1 );

function bu_flexi_title_date_callback( $post, $args ) {
	global $post;

	$output = '';
	$output .= '<article class="post">';
	if ( $args['show_thumbnail'] && function_exists( 'bu_get_thumbnail_src' ) ) {
		$output .= bu_get_thumbnail_src( $post->ID, array(
				'maxwidth'  => 88,
				'maxheight' => 88,
				'classes'   => 'thumb',
				'use_thumb' => true,
				)
		);
	}
	$output .= sprintf( '<h1><a href="%s" rel="bookmark">%s</a></h1>', get_permalink(), get_the_title() );
	$output .= sprintf( '<p class="meta"><span class="published">%s</span></p>', BU_PostList::post_date( 'F j, Y' ) );
	$output .= '</section>';
	return $output;
}

function bu_flexi_posts_widget_default_callback( $post, $args ) {
	global $post;

	$output = '';
	$meta = '';
	$output .= '<article class="post">';

	if ( $args['show_thumbnail'] && function_exists( 'bu_get_thumbnail_src' ) ) {
		$output .= bu_get_thumbnail_src( $post->ID, array(
				'maxwidth'  => 260,
				'maxheight' => 260,
				'classes'   => 'thumb',
				'use_thumb' => false,
				)
		);
	}
	$output .= sprintf( '<h1 class="headline"><a href="%s" rel="bookmark">%s</a></h1>', get_permalink(), get_the_title() );

	switch ( $args['current_format'] ) {
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

	if ( BU_PostList::get_post_excerpt( 12 ) ) {
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
