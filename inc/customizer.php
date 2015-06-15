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

function responsive_customizer_color_region_groups() {
	return array(
		'navbar'       => array(
			'label' => 'Navigation Bar',
			'layout_excludes' => array( 'noNav' ),
			),
		'content-area' => array(
			'label' => 'Content Area',
			),
		'sidebar'      => array(
			'label' => 'Sidebar',
			),
		'footbar'      => array(
			'label' => 'Footbar',
			),
		);
}

/**
 * Register customizer color regions.
 */
function responsive_customizer_color_regions() {
	$scheme = responsive_get_color_scheme();
	return array(
		
		// navigation bar
		'primaryNav-bg' => array(
				'label'       => 'Background Color',
				'group'       => 'navbar',
				'default'     => $scheme['colors'][0],
			),
		'primaryNav-border' => array(
				'label'       => 'Border Color',
				'group'       => 'navbar',
				'default'     => $scheme['colors'][1],
			),
		'primaryNav-link' => array(
				'label'       => 'Primary Nav Links',
				'group'       => 'navbar',
				'default'     => $scheme['colors'][2],
			),
		'utilityNav-link' => array(
				'label'       => 'Utility Nav Links',
				'group'       => 'navbar',
				'default'     => $scheme['colors'][3],
			),
		'primaryNav-hover' => array(
				'label'       => 'Primary Nav Links Hover',
				'group'       => 'navbar',
				'default'     => $scheme['colors'][4],
			),
		
		// content area
		'content-heading' => array(
				'label'       => 'Headings',
				'group'       => 'content-area',
				'default'     => $scheme['colors'][5],
			),
		'content-base' => array(
				'label'       => 'Text Color',
				'group'       => 'content-area',
				'default'     => $scheme['colors'][6],
			),
		'content-link' => array(
				'label'       => 'Link Color',
				'group'       => 'content-area',
				'default'     => $scheme['colors'][7],
			),
		'content-link-hover' => array(
				'label'       => 'Link Hover',
				'group'       => 'content-area',
				'default'     => $scheme['colors'][8],
			),
		'button-color' => array(
				'label'       => 'Button Background',
				'group'       => 'content-area',
				'default'     => $scheme['colors'][9],
			),
		'button-text-color' => array(
				'label'       => 'Button Text Color',
				'group'       => 'content-area',
				'default'     => $scheme['colors'][10],
			),
		
		// sidebar
		'sidebar-bg' => array(
				'label'       => 'Widget Background',
				'group'       => 'sidebar',
				'optional'    => true,
				'default'     => $scheme['colors'][11],
			),
		'sidebar-widgetTitle' => array(
				'label'       => 'Widget Title',
				'group'       => 'sidebar',
				'default'     => $scheme['colors'][12],
			),
		'sidebar-widgetTitle-border' => array(
				'label'       => 'Widget Title Border',
				'group'       => 'sidebar',
				'default'     => $scheme['colors'][13],
			),
		'sidebar-link' => array(
				'label'       => 'Link Color',
				'group'       => 'sidebar',
				'default'     => $scheme['colors'][14],
			),
		'sidebar-link-hover' => array(
				'label'       => 'Link Hover',
				'group'       => 'sidebar',
				'default'     => $scheme['colors'][15],
			),
		'sidebar-base' => array(
				'label'       => 'Text Color',
				'group'       => 'sidebar',
				'default'     => $scheme['colors'][16],
			),
		
		// footbar
		'footbar-bg' => array(
				'label'       => 'Background',
				'group'       => 'footbar',
				'default'     => $scheme['colors'][17],
			),
		'footbar-topBorder' => array(
				'label'       => 'Top Border',
				'group'       => 'footbar',
				'default'     => $scheme['colors'][18],
			),
		'footbar-widgetTitle' => array(
				'label'       => 'Widget Title',
				'group'       => 'footbar',
				'default'     => $scheme['colors'][19],
			),
		'footbar-widgetTitle-border' => array(
				'label'       => 'Widget Title Border',
				'group'       => 'footbar',
				'default'     => $scheme['colors'][20],
			),
		'footbar-link' => array(
				'label'       => 'Link Color',
				'group'       => 'footbar',
				'default'     => $scheme['colors'][21],
			),
		'footbar-link-hover' => array(
				'label'       => 'Link Hover',
				'group'       => 'footbar',
				'default'     => $scheme['colors'][22],
			),
		'footbar-base' => array(
				'label'       => 'Text Color',
				'group'       => 'footbar',
				'default'     => $scheme['colors'][23],
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
				// navigation
				'#000000', // background
				'#333333', // border color
				'#ffffff', // primary nav links
				'#aaaaaa', // utility nav links
				'#aaaaaa', // primary links hover
				
				// content area
				'#000000', // headings
				'#555555', // text color
				'#0f69d7', // link color
				'#0f69d7', // link hovers
				'#0f69d7', // button color
				'#ffffff', // button text color
				
				// sidebar
				'#ffffff', // widget bg
				'#000000', // widget title
				'#000000', // widget title border
				'#0f69d7', // links
				'#0f69d7', // link hovers
				'#555555', // text color
				
				// footbar
				'#f5f5f5', // background
				'#cccccc', // top border
				'#000000', // widget title
				'#000000', // widget title border
				'#0f69d7', // link colors
				'#0f69d7', // link hover colors
				'#555555', // text color
			),
			'active' => array(
				'sidebar-bg' => false
			),
		),
		'slacker' => array(
			'label'  => 'Slacker',
			'colors' => array(
				// navigation
				'#24243a', // background
				'#3c3c50', // border color
				'#ffffff', // primary nav links
				'#7c7c9d', // utility nav links
				'#9f9fec', // primary links hover
				
				// content area
				'#24243a', // headings
				'#24243a', // text color
				'#dd982b', // link color
				'#000000', // link hovers
				'#4fc3a0', // button color
				'#ffffff', // button text color
				
				// sidebar
				'#52527e', // widget bg
				'#ffffff', // widget title
				'#6a6a9d', // widget title border
				'#ecb438', // links
				'#ffffff', // link hovers
				'#ffffff', // text color
				
				// footbar
				'#1a1a22', // background
				'#1a1a22', // top border
				'#ffffff', // widget title
				'#323242', // widget title border
				'#ecb438', // link colors
				'#ffffff', // link hover colors
				'#8080a2', // text color
			),
			'active' => array(
				'sidebar-bg' => true
			),
		),
	);
}

/**
 * Return a list of optional color regions.
 */
function responsive_get_optional_color_regions() {
	$regions = responsive_customizer_color_regions();
	return array_keys( wp_filter_object_list( $regions, array( 'optional' => true ) ) );
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
 * Return the active state of optional color regions.
 *
 * @return array A list of color region keys with current state.
 */
function responsive_get_active_custom_colors() {
	// Get defaults from currently active scheme
	$scheme = responsive_get_color_scheme();

	// Merge with current values
	$active_regions = get_option( 'burf_custom_colors_active', array() );
	return array_merge( $scheme['active'], $active_regions );
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
function responsive_framework_get_color_regions_css( $colors, $context = 'default' ) {

		$sidebar_widget_styles =<<<CSS
/* sidebar widget background color
----------------------------------------------------------------- */

.sidebar .widget {
	background: {$colors['sidebar-bg']};
	padding:24px;
}
CSS;

	// Underscore template gets special logic
	if ( 'template' === $context ) {
		$sidebar_widget_styles =<<<CSS
<# if ( data.active['sidebar-bg'] ) { #>
{$sidebar_widget_styles}
<# } #>
CSS;
	} else {
		// Check currently active colors
		$active_regions = responsive_get_active_custom_colors();
		if ( ! $active_regions['sidebar-bg'] ) {
			$sidebar_widget_styles = '';
		}
	}

	return <<<CSS
/* navigation bar and links
----------------------------------------------------------------- */

/* navbar bg color */
.l-sideNav .wrapper,
.primaryNav,
.primaryNav-menu ul {
	background: {$colors['primaryNav-bg']};
}

/* main nav and nav border color */
.primaryNav-menu a,
.l-sideNav .primaryNav-menu a {
	color: {$colors['primaryNav-link']};
	border-color: {$colors['primaryNav-border']};
}

/* utility nav color */
.l-sideNav .utilityNav a {
	color: {$colors['utilityNav-link']};
}

/* main nav and utility nav hover color */
.primaryNav-menu a:hover,
.l-sideNav .utilityNav a:hover,
.primaryNav-menu li a.active,
.primaryNav-menu li a.active_section,
.primaryNav-menu li li a:hover,
.primaryNav-menu li li a:focus {
	color: {$colors['primaryNav-hover']};
}

/* content area
----------------------------------------------------------------- */

/* heading color */
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

/* text color */
body {
	color: {$colors['content-base']};
}

/* link color */
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

/* link hover color */
.wrapper a:hover,
.widget a:hover,
.event-list .event-link a:hover,
.monthCalendar td a:hover, {
	color: {$colors['content-link-hover']};
}

/* buttons */
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
	background: {$colors['button-color']};
	color: {$colors['button-text-color']};
}


{$sidebar_widget_styles}

/* sidebar area
----------------------------------------------------------------- */

/* widget border color */
.sidebar .widgetTitle,
.sidebar #contentnav ul,
.sidebar .widget_nav_menu ul,
.sidebar #contentnav li,
.sidebar .widget_nav_menu li,
.monthCalendar,
.monthCalendar th,
.monthCalendar td {
	border-color: {$colors['sidebar-widgetTitle-border']};
}

.sidebar .widgetTitle {
	color: {$colors['sidebar-widgetTitle']};
}

/* text color */
.sidebar .widget,
.monthCalendar th,
.monthCalendar caption {
	color: {$colors['sidebar-base']};
}

/* link color */
.sidebar .widget a,
.sidebar #contentnav li a,
.sidebar .widget_nav_menu li a {
	color: {$colors['sidebar-link']};
}

/* link hover color */
.sidebar .widget a:hover,
.sidebar #contentnav li a:hover,
.sidebar .widget_nav_menu li a:hover {
	color: {$colors['sidebar-link-hover']};
}

/* footbar area
----------------------------------------------------------------- */

/* background color */
.footbar,
.footbar .footbar-container,
.bannerContainer-windowWidth {
	background: {$colors['footbar-bg']};
}

/* top border color */
.footbar {
	border-color: {$colors['footbar-topBorder']};
}

/* widget title color */
.footbar .widgetTitle,
.footbar h3.widgetTitle a,
.widget-bu-calendar .default a .date,
.widget-bu-calendar .graphic .day {
	color: {$colors['footbar-widgetTitle']};
}

/* border color */
.footbar .widgetTitle,
.footbar #contentnav ul,
.footbar .widget_nav_menu ul,
.footbar #contentnav li,
.footbar .widget_nav_menu li {
	border-color: {$colors['footbar-widgetTitle-border']};
}

/* link color */
.footbar .widget a,
.footbar #contentnav li a,
.footbar .widget_nav_menu li a,
.widget-bu-calendar .graphic .month {
	color: {$colors['footbar-link']};
}

/* link hover color */
.footbar .widget a:hover,
.footbar #contentnav li a:hover,
.footbar .widget_nav_menu li a:hover {
	color: {$colors['footbar-link-hover']};
}

/* text color */
.footbar .widget {
	color: {$colors['footbar-base']};
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

/* calendar table */
.monthCalendar thead,
.monthCalendar th,
.monthCalendar .out,
.monthCalendar .today {
	background: rgba(0,0,0,0.15);
}

CSS;

}
