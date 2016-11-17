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
	$sidebar_location = defined( 'BU_RESPONSIVE_SIDEBAR_POSITION' ) ? BU_RESPONSIVE_SIDEBAR_POSITION : get_option( 'burf_setting_sidebar_location' );
	$posts_sidebar_bottom = defined( 'BU_RESPONSIVE_POSTS_SIDEBAR_SHOW_BOTTOM' ) ? BU_RESPONSIVE_POSTS_SIDEBAR_SHOW_BOTTOM : get_option( 'burf_setting_posts_sidebar_bottom' );

	if ( $font_palette ) {
		$classes[] = $font_palette;
	}

	if ( $layout_setting ) {
		$classes[] = "l-$layout_setting";
	}

	/* If "Keep posts sidebar on bottom" is on, don't add classes to those pages */
	if ( $sidebar_location ) {
		if( true == $posts_sidebar_bottom ){
			if( is_page() && ! is_page_template( 'page-templates/news.php' ) && ! is_page_template( 'page-templates/profiles.php' ) ){
				$classes[] = "sidebarLocation-$sidebar_location";
			}
		}else {
			$classes[] = "sidebarLocation-$sidebar_location";
		}
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
 * Removes "Uncategorized" from category listings.
 *
 * Child themes can add extra categories for exclusion by way of the `responsive_category_lists_exclusions`
 * filter.
 */
function responsive_filter_category_lists( $thelist, $separator = null ) {
	if ( is_admin() || is_null( $separator ) ) {
		return $thelist;
	}

	$category_links = explode( $separator, $thelist );

	$categories_to_exclude = apply_filters( 'responsive_category_lists_exclusions', array( 'Uncategorized' ) );
	foreach ( $categories_to_exclude as &$cat ) {
		$cat = preg_quote( $cat, '!' );
	}

	$exclude_pattern = sprintf(  '!<\s*a[^>]*>%s<\s*/a[^>]*>!im', implode( '|', $categories_to_exclude ) );
	$category_links = preg_grep( $exclude_pattern, $category_links, PREG_GREP_INVERT );

	$thelist = implode( $separator, $category_links );

	return $thelist;
}

add_filter( 'the_category', 'responsive_filter_category_lists', 10, 2 );

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
 * Append classes indicating current widget index to widget containers.
 *
 * The dynamic_sidebars filter is called prior to displaying each widget. We
 * use a static variable to keep track of how many times it's called for each
 * sidebar, and use it to add a class that includes the current index.
 *
 * Note that this currently fails with BU Text and BU Link widgets due to the
 * custom per-post configuration.
 */
function responsive_widget_counts( $params ) {
	static $widget_counter = array();

	$current_sidebar = $params[0]['id'];
	$sidebars = wp_get_sidebars_widgets();

	// Bail if current sidebar doesn't exist or has no widgets
	if ( ! array_key_exists( $current_sidebar, $sidebars ) || empty( $sidebars[ $current_sidebar ] ) ) {
		return $params;
	}

	// Initialize or increment our static widget counter by one for this widget
	if ( array_key_exists( $current_sidebar, $widget_counter ) ) {
		$widget_counter[ $current_sidebar ] ++;
	} else {
		$widget_counter[ $current_sidebar ] = 1;
	}

	// Build the class attribute for this widget
	$class = 'widget-' . $widget_counter[ $current_sidebar ];

	// Supplement the class defined in the sidebar's before_widget argument
	$params[0]['before_widget'] = preg_replace( '/(class="widget.*?)(")/', '$1 '. $class . '$2', $params[0]['before_widget'] );

	return $params;
}

add_filter( 'dynamic_sidebar_params', 'responsive_widget_counts', 1, 1 );

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

// Adds support for shortcodes to core text widget
add_filter( 'widget_text', 'do_shortcode' );

/**
 * Set the default "Link To" value for image attachments to "None".
 *
 * The actual default is "File", which is confusing for many users,
 * especially when images are sized appropriately. It also presents
 * usability issues on mobile, where it's easy to accidentally navigate
 * to the image while scrolling.
 *
 * There is core consensus that "None" should be the default.
 * @see  https://core.trac.wordpress.org/ticket/31467
 */
function responsive_image_default_link_type() {
	update_option( 'image_default_link_type', 'none' );
}

add_filter( 'admin_init', 'responsive_image_default_link_type' );


/**
 * Hides the H1 for homepage if option is set.
 *
 * @param string $title Post title.
 * @param int $post_id Post ID to filter title for.
 *
 * @return string New title to use.
 */
function responsive_maybe_hide_homepage_h1( $title, $post_id ) {
	$hide_front_h1 = get_option( 'burf_setting_hide_front_h1' );

	if ( true === (boolean) $hide_front_h1 && is_front_page() && (int) get_option( 'page_on_front' ) === $post_id ) {
		return '';
	}

	return $title;
}
add_filter( 'the_title', 'responsive_maybe_hide_homepage_h1', 10, 2 );


/**
 * Customizes oEmbed output
 * -- Adds a wrapper div around youtube/vimeo videos
 */
function responsive_oembed_output( $html, $url ) {
	$providers = array(
		array( 'youtube', 'Youtube',
			array( '#http://((m|www)\.)?youtube\.com/watch.*#i', '#https://((m|www)\.)?youtube\.com/watch.*#i', '#http://((m|www)\.)?youtube\.com/playlist.*#i', '#https://((m|www)\.)?youtube\.com/playlist.*#i', '#http://youtu\.be/.*#i', '#https://youtu\.be/.*#i')
		),
		array( 'vimeo', 'Vimeo',
			array( '#https?://(.+\.)?vimeo\.com/.*#i' )
		)
	);

	foreach ( $providers as $provider ) {
		$slug = $provider[0];
		$name = $provider[1];
		$patterns = $provider[2];

		foreach ( $patterns as $pattern ) {
			if ( preg_match( $pattern, $url ) ) {
				return( sprintf( '<div class="responsiveVideo responsive-%s">%s</div>', $slug, $html ) );
			}
		}
	}
	return $html;
}
add_filter( 'embed_oembed_html', 'responsive_oembed_output', 10, 2 );