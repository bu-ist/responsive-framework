<?php
/**
 * Core filters
 */

/**
 * Adds custom classes to body class.
 */
function responsive_body_class( $classes = '' ) {
	$font_palette = get_option( 'burf_setting_fonts' );
	$layout_setting = responsive_layout();

	if ( $font_palette ) {
		$classes[] = $font_palette;
	}

	if ( $layout_setting ) {
		$classes[] = "l-$layout_setting";
	}

	return $classes;
}

add_filter( 'body_class', 'responsive_body_class' );

/**
 * Removes "uncategorized" and "private" from categories.
 *
 * @todo Review.
 */
function responsive_category_filter( $thelist, $separator = ' ' ) {
	if ( ! defined( 'WP_ADMIN' ) ) {
		// Category IDs to exclude
		$exclude = array( 1, 5 );

		$exclude2 = array();
		foreach ( $exclude as $c ) {
			$exclude2[] = get_cat_name( $c );
		}

		$cats = explode( $separator, $thelist );
		$newlist = array();
		foreach ( $cats as $cat ) {
			$catname = trim( strip_tags( $cat ) );
			if ( ! in_array( $catname, $exclude2 ) ) {
				$newlist[] = $cat;
			}
		}
		return implode( $separator, $newlist );
	} else {
		return $thelist;
	}
}

add_filter( 'the_category', 'responsive_category_filter', 10, 2 );

/**
 * Filter shortcode attributes for [caption] to fix padding.
 */
function responsive_caption_attributes( $attrs ) {
	if ( ! empty( $attrs['width'] ) ) {
		$attrs['width'] += 10;
	}
	return $attrs;
}

add_filter( 'shortcode_atts_caption', 'responsive_caption_attributes' );

/**
 * Widget Counts.
 *
 * @todo  Review.
 *
 * @link http://wordpress.org/support/topic/how-to-first-and-last-css-classes-for-sidebar-widgets
 */
function responsive_widget_counts( $params ) {

	global $my_widget_num; // Global a counter array
	$this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
	$arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets

	if ( ! $my_widget_num ) {// If the counter array doesn't exist, create it
		$my_widget_num = array();
	}

	if ( ! isset( $arr_registered_widgets[ $this_id ] ) || ! is_array( $arr_registered_widgets[ $this_id ] ) ) { // Check if the current sidebar has no widgets
		return $params; // No widgets in this sidebar... bail early.
	}

	if ( isset( $my_widget_num[ $this_id ] ) ) { // See if the counter array has an entry for this sidebar
		$my_widget_num[ $this_id ] ++;
	} else { // If not, create it starting with 1
		$my_widget_num[ $this_id ] = 1;
	}

	$class = 'class="widget-' . $my_widget_num[ $this_id ] . ' '; // Add a widget number class for additional styling options

	if ( 1 == $my_widget_num[ $this_id ] ) { // If this is the first widget
		$class .= 'widget-first ';
	} elseif ( $my_widget_num[ $this_id ] == count( $arr_registered_widgets[ $this_id ] ) ) { // If this is the last widget
		$class .= 'widget-last ';
	}

	$params[0]['before_widget'] = preg_replace( '/class=\"/', "$class", $params[0]['before_widget'], 1 );

	return $params;
}

add_filter( 'dynamic_sidebar_params', 'responsive_widget_counts' );
