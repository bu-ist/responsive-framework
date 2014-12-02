<?php
/**
 * Conditionally defines a few functions that are coming in WP 4.1.
 */


if ( ! function_exists( 'the_archive_title' ) ) :

/**
 * Display the archive title based on the queried object.
 *
 * @since 4.1.0
 *
 * @see get_the_archive_title()
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function the_archive_title( $before = '', $after = '' ) {
	$title = get_the_archive_title();

	if ( ! empty( $title ) ) {
		echo $before . $title . $after;
	}
}

endif;


if ( ! function_exists( 'get_the_archive_title' ) ) :

/**
 * Retrieve the archive title based on the queried object.
 *
 * @since 4.1.0
 *
 * @return string Archive title.
 */
function get_the_archive_title() {
	if ( is_category() ) {
		$title = sprintf( __( 'Category: %s' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( __( 'Tag: %s' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		// NOTE: This is done in WP::register_globals (wp-includes/class-wp.php) in more
		// recent versions of WP, but is needed in 3.6.1 for the author title to work.
		$GLOBALS['authordata'] = get_userdata( $GLOBALS['wp_query']->post->post_author );
		$title = sprintf( __( 'Author: %s' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( __( 'Year: %s' ), get_the_date( _x( 'Y', 'yearly archives date format' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( __( 'Month: %s' ), get_the_date( _x( 'F Y', 'monthly archives date format' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( __( 'Day: %s' ), get_the_date( _x( 'F j, Y', 'daily archives date format' ) ) );
	} elseif ( is_tax( 'post_format', 'post-format-aside' ) ) {
		$title = _x( 'Asides', 'post format archive title' );
	} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
		$title = _x( 'Galleries', 'post format archive title' );
	} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
		$title = _x( 'Images', 'post format archive title' );
	} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
		$title = _x( 'Videos', 'post format archive title' );
	} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
		$title = _x( 'Quotes', 'post format archive title' );
	} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
		$title = _x( 'Links', 'post format archive title' );
	} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
		$title = _x( 'Statuses', 'post format archive title' );
	} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
		$title = _x( 'Audio', 'post format archive title' );
	} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
		$title = _x( 'Chats', 'post format archive title' );
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( __( 'Archives: %s' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( __( '%1$s: %2$s' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = __( 'Archives' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @since 4.1.0
	 *
	 * @param string $title Archive title to be displayed.
	 */
	return apply_filters( 'get_the_archive_title', $title );
}

endif;

if ( ! function_exists( 'the_archive_description' ) ) :

/**
 * Display category, tag, or term description.
 *
 * @since 4.1.0
 *
 * @see get_the_archive_description()
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_archive_description( $before = '', $after = '' ) {
	$description = get_the_archive_description();

	if ( ! empty( $description ) ) {
		echo $before . $description . $after;
	}
}

endif;

if ( ! function_exists( 'get_the_archive_description' ) ) :

/**
 * Retrieve category, tag, or term description.
 *
 * @since 4.1.0
 *
 * @return string Archive description.
 */
function get_the_archive_description() {

	/**
	 * Filter the archive description.
	 *
	 * @since 4.1.0
	 *
	 * @see term_description()
	 *
	 * @param string $description Archive description to be displayed.
	 */
	return apply_filters( 'get_the_archive_description', term_description() );
}

endif;
