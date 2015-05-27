<?php
/**
 * Theme Settings API
 */

/**
 * Enable Customizer for all Responsive Framework sites.
 *
 * The BU UI Modifications plugin currently hides the Customizer by default
 * as most existing themes don't benefit from it given the limited capabilities
 * that Site Admin have.
 */
function responsive_enable_customizer() {
	if ( class_exists( 'BuInterfaceModifications' ) ) {
		remove_action( 'admin_menu', array( 'BuInterfaceModifications', 'hide_customizer' ) );
	}
}

add_action( 'init', 'responsive_enable_customizer', 12 );

/**
 * Returns layout slug for currently active theme layout.
 *
 * Child themes can force a specific layout option by defining the BU_RESPONSIVE_LAYOUT
 * constant using one of the layout slugs (e.g. topNav, sideNav, etc.).
 *
 * @see  responsive_layout_options()
 */
function responsive_layout() {
	if ( defined( 'BU_RESPONSIVE_LAYOUT' ) && array_key_exists( BU_RESPONSIVE_LAYOUT, responsive_layout_options() ) ) {
		return BU_RESPONSIVE_LAYOUT;
	}
	return get_option( 'burf_setting_layout', 'default' );
}

/**
 * Returns layout options available via Customizer.
 */
function responsive_layout_options() {
	return apply_filters( 'responsive_layout_options', array(
		'default' => 'Default',
		'topNav'  => 'Top Navigation Bar',
		'sideNav' => 'Side Navigation Bar',
		'noNav'   => 'No Navigation Bar',
		) );
}

/**
 * Returns the site's current font palette.
 */
function responsive_get_font_palette() {
	if ( defined( 'BU_RESPONSIVE_FONT_PALETTE' ) && array_key_exists( BU_RESPONSIVE_FONT_PALETTE, responsive_font_options() ) ) {
		return BU_RESPONSIVE_FONT_PALETTE;
	}

	return get_option( 'burf_setting_fonts', 'f1' );
}

/**
 * Returns font palette options available via Customizer.
 */
function responsive_font_options() {
	return array(
		'f1' => 'Capita,Benton',
		'f2' => 'Benton,Benton',
		'f3' => 'Benton,Capita',
		'f4' => 'Pressura,Benton',
		'f5' => 'Stag,Benton',
		);
}

/**
 * Returns any content entered into the Footer > Additional Info textarea.
 */
function responsive_get_customizer_footer_info() {
	$defaults = array(
		'text'  => '',
		'autop' => false,
		);
	$footer = get_option( 'burf_setting_footer', $defaults );

	if ( $footer['autop'] ) {
		return wpautop( $footer['text'] );
	} else {
		return $footer['text'];
	}
}

/**
 * Prints out additional footer info content.
 */
function responsive_customizer_footer_info( $args = array() ) {
	$defaults = array(
		'before' => '<div class="siteFooter-info">',
		'after'  => '</div>',
		'echo'   => true,
		);
	$args = wp_parse_args( $args, $defaults );
	$output = '';

	$footer_info = responsive_get_customizer_footer_info();
	if ( $footer_info ) {
		$output = $args['before'] . $footer_info . $args['after'];
	}

	if ( $args['echo'] ) {
		echo $output;
	} else {
		return $output;
	}
}

/**
 * Returns whether or not the additional info textarea has any content.
 */
function responsive_customizer_has_footer_info() {
	$footer_info = responsive_get_customizer_footer_info();
	return ! empty( $footer_info );
}

/**
 * Customizer color groups.
 */
function responsive_customizer_color_groups() {
	return array(
		'navbar'       => 'Navigation Bar',
		'content'      => 'Content Area',
		'sidebar'      => 'Sidebar Area',
		'footbar'      => 'Footbar Area'
		);
}

/**
 * Register customizer color regions.
 */
function responsive_customizer_color_regions() {
	$schemes = responsive_get_color_schemes();
	return array(
		'navbar-bg' => array(
				'label'       => 'Background Color',
				'group'       => 'navbar',
			),
		'navbar-primary-link' => array(
				'label'       => 'Main Nav Color',
				'group'       => 'navbar',
			),
		'navbar-primary-hover' => array(
				'label'       => 'Main Nav Hover Color',
				'group'       => 'navbar',
			),
		'navbar-utility-link' => array(
				'label'       => 'Utility Nav Color',
				'group'       => 'navbar',
			),
		'navbar-utility-link-hover' => array(
				'label'       => 'Utility Nav Hover Color',
				'group'       => 'navbar',
			),
		'navbar-primary-border' => array(
				'label'       => 'Border Color',
				'group'       => 'navbar',
			),
		'content-heading' => array(
				'label'       => 'Heading Color',
				'group'       => 'content',
			),
		'content-text' => array(
				'label'       => 'Text Color',
				'group'       => 'content',
			),
		'content-link' => array(
				'label'       => 'Link Color',
				'group'       => 'content',
			),
		'content-link-hover' => array(
				'label'       => 'Link Hover Color',
				'group'       => 'content',
			),
		'sidebar-bg' => array(
				'label'       => 'Background Color',
				'group'       => 'sidebar',
				'optional'    => true,
			),
		'sidebar-heading' => array(
				'label'       => 'Heading Color',
				'group'       => 'sidebar',
			),
		'sidebar-heading-border' => array(
				'label'       => 'Heading Border Color',
				'group'       => 'sidebar',
			),
		'sidebar-text' => array(
				'label'       => 'Text Color',
				'group'       => 'sidebar',
			),
		'sidebar-link' => array(
				'label'       => 'Link Color',
				'group'       => 'sidebar',
			),
		'sidebar-link-hover' => array(
				'label'       => 'Link Hover Color',
				'group'       => 'sidebar',
			),
		'footbar-bg' => array(
				'label'       => 'Background Color',
				'group'       => 'footbar',
			),
		'footbar-topBorder' => array(
				'label'       => 'Top Border Color',
				'group'       => 'footbar',
			),
		'footbar-heading' => array(
				'label'       => 'Heading Color',
				'group'       => 'footbar',
			),
		'footbar-heading-border' => array(
				'label'       => 'Heading Border Color',
				'group'       => 'footbar',
			),
		'footbar-text' => array(
				'label'       => 'Text Color',
				'group'       => 'footbar',
			),
		'footbar-link' => array(
				'label'       => 'Link Color',
				'group'       => 'footbar',
			),
		'footbar-link-hover' => array(
				'label'       => 'Link Hover Color',
				'group'       => 'footbar',
			),
	);
}

/**
 * Register color schemes for Responsive Framework.
 *
 * @return array An associative array of color scheme options.
 */
function responsive_get_color_schemes() {
	return array(
		'default' => array(
			'label'  => 'Default',
			'colors' => array(
				'#000000', // Navigation Bar - Background Color
				'#ffffff', // Navigation Bar - Main Nav Color
				'#aaaaaa', // Navigation Bar - Main Nav Hover Color
				'#aaaaaa', // Navigation Bar - Utility Nav Color (sideNav only)
				'#ffffff', // Navigation Bar - Utility Nav Hover Color (sideNav only)
				'#333333', // Navigation Bar - Border Color (sideNav only)
				'#000000', // Content Area - Heading Color
				'#555555', // Content Area - Text Color
				'#0f69d7', // Content Area - Link Color
				'#0f69d7', // Content Area - Link Hover Color
				'#ffffff', // Sidebar - Background Color
				'#000000', // Sidebar - Heading Color
				'#000000', // Sidebar - Heading Border Color
				'#555555', // Sidebar - Text Color
				'#0f69d7', // Sidebar - Link Color
				'#0f69d7', // Sidebar - Link Hover Color
				'#f5f5f5', // Footbar - Background Color
				'#cccccc', // Footbar - Top Border Color
				'#000000', // Footbar - Heading Color
				'#000000', // Footbar - Heading Border Color
				'#555555', // Footbar - Text Color
				'#0f69d7', // Footbar - Link Color
				'#0f69d7', // Footbar - Link Hover Color
			),
		),
		'slacker' => array(
			'label'  => 'Slacker',
			'colors' => array(
				'#24243a', // Navigation Bar - Background Color
				'#ffffff', // Navigation Bar - Main Nav Color
				'#9f9fec', // Navigation Bar - Main Nav Hover Color
				'#7c7c9d', // Navigation Bar - Utility Nav Color (sideNav only)
				'#9f9fec', // Navigation Bar - Utility Nav Hover Color (sideNav only)
				'#3c3c50', // Navigation Bar - Border Color (sideNav only)
				'#24243a', // Content Area - Heading Color
				'#24243a', // Content Area - Text Color
				'#dd982b', // Content Area - Link Color
				'#000000', // Content Area - Link Hover Color
				'#52527e', // Sidebar - Background Color
				'#ffffff', // Sidebar - Heading Color
				'#6a6a9d', // Sidebar - Heading Border Color
				'#ffffff', // Sidebar - Text Color
				'#ecb438', // Sidebar - Link Color
				'#ffffff', // Sidebar - Link Hover Color
				'#1a1a22', // Footbar - Background Color
				'#1a1a22', // Footbar - Top Border Color
				'#ffffff', // Footbar - Heading Color
				'#323242', // Footbar - Heading Border Color
				'#8080a2', // Footbar - Text Color
				'#ecb438', // Footbar - Link Color
				'#ffffff', // Footbar - Link Hover Color
			),
		),
	);
}

/**
 * Sanitization callback for color schemes.
 *
 * @param string $value Color scheme name value.
 * @return string Color scheme name.
 */
function responsive_sanitize_color_scheme( $value ) {
	$color_schemes = responsive_get_color_scheme_choices();

	if ( ! array_key_exists( $value, $color_schemes ) ) {
		$value = 'default';
	}

	return $value;
}

/**
 * Get list of available color schemes.
 *
 * @return array Associative array of schemes, "slug" => "Label"
 */
function responsive_get_color_scheme_choices() {
	$schemes = responsive_get_color_schemes();
	$choices = array();
	foreach ( $schemes as $slug => $scheme ) {
		$schemes[ $slug ] = $scheme['label'];
	}

	return $schemes;
}

/**
 * Get the current color scheme.
 *
 * @return array An associative array of either the current or default color scheme values.
 */
function responsive_get_color_scheme( $scheme = null ) {
	// Load the current color scheme if none was passed
	if ( ! is_scalar( $scheme ) ) {
		$scheme = get_option( 'burf_color_scheme', 'default' );
	}

	// Return requested theme if found
	$schemes = responsive_get_color_schemes();
	if ( array_key_exists( $scheme, $schemes ) ) {
		return $schemes[ $scheme ];
	}

	// Return default otherwise
	return $schemes['default'];
}

/**
 * Return the HEX color values for the given color scheme.
 *
 * If no $scheme is passed, the currently active scheme is used.
 *
 * @param  string $scheme A color scheme to retrieve colors for. Optional.
 * @return array          Color scheme colors, indexed by region name.
 */
function responsive_get_color_scheme_colors( $scheme = null ) {
	$scheme = responsive_get_color_scheme( $scheme );

	// Combine region names and color values into associative array
	$region_names = array_keys( responsive_customizer_color_regions() );
	$colors = array_combine( $region_names, $scheme['colors'] );
	return $colors;
}

/**
 * Return custom color values set through Customizer.
 *
 * @return array Custom colors, indexed by region name.
 */
function responsive_get_custom_colors() {
	return get_option( 'burf_custom_colors', array() );
}

/**
 * Get list of CSS selectors filled out with the given color scheme.
 *
 * @return string         Color scheme CSS rules.
 */
function responsive_get_color_scheme_css() {

	// Get colors from current scheme
	$scheme_colors = responsive_get_color_scheme_colors();

	// Get custom selected colors
	$custom_colors = responsive_get_custom_colors();

	// Merge, giving preference to custom colors
	$colors = array_merge( $scheme_colors, $custom_colors );

	// Default color scheme without custom colors. Bail.
	if ( $colors == responsive_get_color_scheme_colors( 'default' ) ) {
		return '';
	}

	return responsive_framework_get_color_regions_css( $colors );
}

/**
 * Generates CSS snippet for customizer color scheme.
 *
 * @param  array $colors Hex color values, keyed on region slugs.
 * @return string        Color scheme CSS rules.
 */
function responsive_framework_get_color_regions_css( $colors ) {

	// Optional sidebar background
	$sidebar_widget_styles = '';
	if ( $colors['sidebar-bg'] ) {
		$sidebar_widget_styles =<<<CSS
/* Background Color */
.sidebar .widget {
	background: {$colors['sidebar-bg']};
	padding: 24px;
}
CSS;

	}

	return <<<CSS
/* Navigation Bar
----------------------------------------------------------------- */

/* Background Color */
.l-sideNav .wrapper,
.primaryNav,
.primaryNav-menu ul {
	background: {$colors['navbar-bg']};
}

/* Main Nav Color */
.primaryNav-menu a,
.l-sideNav .primaryNav-menu a {
	color: {$colors['navbar-primary-link']};
}

/* Main Nav Hover Color */
.primaryNav-menu a:hover,
.primaryNav-menu li a.active,
.primaryNav-menu li a.active_section,
.primaryNav-menu li li a:hover,
.primaryNav-menu li li a:focus {
	color: {$colors['navbar-primary-hover']};
}

/* Utility Nav Color */
.l-sideNav .utilityNav a {
	color: {$colors['navbar-utility-link']};
}

/* Utility Nav Hover Color */
.l-sideNav .utilityNav a:hover {
	color: {$colors['navbar-utility-link-hover']};
}

/* Border Color */
.primaryNav-menu a,
.l-sideNav .primaryNav-menu a {
	border-color: {$colors['navbar-primary-border']};
}

/* Content Area
----------------------------------------------------------------- */

/* Heading Color */
.wrapper h1,
.wrapper h2,
.wrapper h3,
.wrapper h4,
.wrapper h5,
.wrapper h6,
.wrapper h1 a,
.wrapper h2 a,
.wrapper h3 a,
.wrapper h4 a,
.wrapper h5 a,
.wrapper h6 a {
	color: {$colors['content-heading']};
}

/* Text Color */
body {
	color: {$colors['content-text']};
}

/* Link Color */
.wrapper a,
.wrapper a:visited,
.widget a,
.widget a:hover,
.widget a:focus,
.event-list .event-link a,
.event-list .event-link a:hover,
.event-list .event-link a:focus,
.monthCalendar td a,
.monthCalendar td a:hover,
.monthCalendar td,
.bu_collapsible:hover:after,
.bu_collapsible:focus:after,
.bu_collapsible_open .bu_collapsible:hover:after,
.bu_collapsible_open .bu_collapsible:focus:after,
.profile-listing a .profile-name {
	color: {$colors['content-link']};
}

/* Link Hover Color */
.wrapper a:hover,
.widget a:hover,
.event-list .event-link a:hover,
.monthCalendar td a:hover, {
	color: {$colors['content-link-hover']};
}

/* Sidebar Area
----------------------------------------------------------------- */

{$sidebar_widget_styles}

/* Header Color */
.sidebar .widgetTitle {
	color: {$colors['sidebar-heading']};
}

/* Header Border Color */
.sidebar .widgetTitle,
.sidebar #contentnav ul,
.sidebar .widget_nav_menu ul,
.sidebar #contentnav li,
.sidebar .widget_nav_menu li {
	border-color: {$colors['sidebar-heading-border']};
}

/* Text Color */
.sidebar .widget {
	color: {$colors['sidebar-text']};
}

/* Link Color */
.sidebar .widget a,
.sidebar #contentnav li a,
.sidebar .widget_nav_menu li a {
	color: {$colors['sidebar-link']};
}

/* Link Hover Color */
.sidebar .widget a:hover,
.sidebar #contentnav li a:hover,
.sidebar .widget_nav_menu li a:hover {
	color: {$colors['sidebar-link-hover']};
}

/* Footbar Area
----------------------------------------------------------------- */

/* Background Color */
.footbar,
.footbar .footbar-container,
.bannerContainer-windowWidth {
	background: {$colors['footbar-bg']};
}

/* Top Border Color */
.footbar {
	border-color: {$colors['footbar-topBorder']};
}

/* Heading Color */
.footbar .widgetTitle {
	color: {$colors['footbar-heading']};
}

/* Heading Border Color */
.footbar .widgetTitle,
.footbar #contentnav ul,
.footbar .widget_nav_menu ul,
.footbar #contentnav li,
.footbar .widget_nav_menu li {
	border-color: {$colors['footbar-heading-border']};
}

/* Text Color */
.footbar .widget {
	color: {$colors['footbar-text']};
}

/* Link Color */
.footbar .widget a,
.footbar #contentnav li a,
.footbar .widget_nav_menu li a {
	color: {$colors['footbar-link']};
}

/* Link Hover Color */
.footbar .widget a:hover,
.footbar #contentnav li a:hover,
.footbar .widget_nav_menu li a:hover {
	color: {$colors['footbar-link-hover']};
}

/* non-configurable styles
----------------------------------------------------------------- */

.comment-respond,
#quicksearch,
.l-sideNav #quicksearch,
.message,
.single article[role=main] .meta,
.singleEvent .dateSummary,
.single-profile .profile-info {
	background: #f5f8ff;
	border-color: #dfdfea;
}

.button, button,
html input[type="button"],
input[type="reset"],
input[type="submit"],
.news-posts .paging-navigation a,
.archive .paging-navigation a,
.single .archiveLink,
.single-calendar .archiveLink,
.button-primary,
#quicksearch .button,
#quicksearch button,
#quicksearch html input[type="button"],
html #quicksearch input[type="button"],
#quicksearch input[type="reset"],
#quicksearch input[type="submit"],
#quicksearch .news-posts .paging-navigation a,
.news-posts .paging-navigation #quicksearch a,
#quicksearch .archive .paging-navigation a,
.archive .paging-navigation #quicksearch a,
#quicksearch .single .archiveLink,
.single #quicksearch .archiveLink,
#quicksearch .single-calendar .archiveLink,
.single-calendar #quicksearch .archiveLink,
.news-posts .paging-navigation a,
.archive .paging-navigation a,
.single .archiveLink,
.single-calendar .archiveLink,
.button-selected, a.button-primary,
#quicksearch a.button,
#quicksearch .news-posts .paging-navigation a,
.news-posts .paging-navigation #quicksearch a,
#quicksearch .archive .paging-navigation a,
.archive .paging-navigation #quicksearch a,
#quicksearch .single a.archiveLink,
.single #quicksearch a.archiveLink,
#quicksearch .single-calendar a.archiveLink,
.single-calendar #quicksearch a.archiveLink,
.news-posts .paging-navigation a,
.archive .paging-navigation a,
.single a.archiveLink,
.single-calendar a.archiveLink,
a.button-selected {
	background: #4fc3a0;
	color: #fff;
}

CSS;

}
