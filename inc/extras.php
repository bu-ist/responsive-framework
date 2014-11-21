<?php
/**
 * Core filters
 */

/**
 * Adds custom classes to body class.
 */
function responsive_body_class( $classes = '' ) {
	global $wp_query;

	$font_palette = get_option( 'burf_setting_fonts' );
	$layout_setting = responsive_layout();

	if ( $font_palette ) {
		$classes[] = $font_palette;
	}

	if ( $layout_setting ) {
		$classes[] = "l-$layout_setting";
	}

	// Cleans up page template releated body classes
	if ( is_page() ) {
		$page_id = $wp_query->get_queried_object_id();

		// Find classes added by core and remove
		$core_classes = preg_grep( '/page-template-.*?/', $classes );
		$classes = array_diff( $classes, $core_classes );

		if ( is_page_template() ) {
			$template = get_page_template_slug( $page_id );
			$template = str_replace( 'page-templates', '', $template );
			$template = str_replace( '.', '-', $template );
			$template = str_replace( '-php', '', $template );

			$classes[] = 'page-template-' . sanitize_html_class( $template );
		} else {
			$classes[] = 'page-template-default';
		}
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

/**
 * Limit widget counts for certain sidebars.
 *
 * By default this is applied to the 'posts' and 'profiles' sidebars.
 * Child themes can tie in to this logic by using the `responsive_limit_sidebars_widgets` filter.
 */
function responsive_limit_sidebars_widgets( $sidebars_widgets ) {

	if ( ! is_admin() ) {
		$sidebars_to_limit = apply_filters( 'responsive_limit_sidebars_widgets', array(
			'posts'    => 2,
			'profiles' => 2,
			) );

		foreach ( $sidebars_to_limit as $sidebar => $max_widget_count ) {

			// Ignore unreasonable values
			if ( $max_widget_count < 1 || $max_widget_count > 10 ) {
				continue;
			}

			// Make sure the sidebar we're being asked to limit is registered
			if ( ! array_key_exists( $sidebar, $sidebars_widgets ) ) {
				continue;
			}

			// Make sure the sidebar currently exceeds our limit
			if ( count( $sidebars_widgets[ $sidebar ] ) < $max_widget_count ) {
				continue;
			}

			// Truncate extra widgets for the given sidebar
			$sidebars_widgets[ $sidebar ] = array_slice( $sidebars_widgets[ $sidebar ], 0, $max_widget_count );
		}
	}

	return $sidebars_widgets;
}

add_filter( 'sidebars_widgets', 'responsive_limit_sidebars_widgets', 10, 1 );
