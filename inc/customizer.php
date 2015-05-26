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
 * Register customizer color regions.
 */
function responsive_customizer_color_regions() {
	$schemes = responsive_get_color_schemes();
	return array(
		'primaryNav-bg' => array(
				'label'       => 'Background Color',
				'default'     => $schemes['default']['colors'][0],
				'group'       => 'Navigation Bar',
			),
		'primaryNav-border' => array(
				'label'       => 'Border Color',
				'default'     => $schemes['default']['colors'][1],
				'group'       => 'Navigation Bar',
			),
		'primaryNav-link' => array(
				'label'       => 'Primary Nav Links',
				'default'     => $schemes['default']['colors'][2],
				'group'       => 'Navigation Bar',
			),
		'utilityNav-link' => array(
				'label'       => 'Utility Nav Links',
				'default'     => $schemes['default']['colors'][3],
				'group'       => 'Navigation Bar',
			),
		'primaryNav-hover' => array(
				'label'       => 'Primary Nav Links Hover',
				'default'     => $schemes['default']['colors'][4],
				'group'       => 'Navigation Bar',
			),
		'content-heading' => array(
				'label'       => 'Headings',
				'default'     => $schemes['default']['colors'][5],
				'group'       => 'Content Area',
			),
		'content-base' => array(
				'label'       => 'Base',
				'default'     => $schemes['default']['colors'][6],
				'group'       => 'Content Area',
			),
		'content-link' => array(
				'label'       => 'Links',
				'default'     => $schemes['default']['colors'][7],
				'group'       => 'Content Area',
			),
		'content-link-hover' => array(
				'label'       => 'Links Hover',
				'default'     => $schemes['default']['colors'][8],
				'group'       => 'Content Area',
			),
		'sidebar-bg' => array(
				'label'       => 'Widget Background',
				'default'     => $schemes['default']['colors'][9],
				'group'       => 'Sidebar',
			),
		'sidebar-widgetTitle' => array(
				'label'       => 'Widget Title',
				'default'     => $schemes['default']['colors'][10],
				'group'       => 'Sidebar',
			),
		'sidebar-widgetTitle-border' => array(
				'label'       => 'Widget Title Border',
				'default'     => $schemes['default']['colors'][11],
				'group'       => 'Sidebar',
			),
		'sidebar-link' => array(
				'label'       => 'Link',
				'default'     => $schemes['default']['colors'][12],
				'group'       => 'Sidebar',
			),
		'sidebar-link-hover' => array(
				'label'       => 'Link Hover',
				'default'     => $schemes['default']['colors'][13],
				'group'       => 'Sidebar',
			),
		'sidebar-base' => array(
				'label'       => 'Base',
				'default'     => $schemes['default']['colors'][14],
				'group'       => 'Sidebar',
			),
		'footbar-bg' => array(
				'label'       => 'Background',
				'default'     => $schemes['default']['colors'][15],
				'group'       => 'Footbar',
			),
		'footbar-topBorder' => array(
				'label'       => 'Top Border',
				'default'     => $schemes['default']['colors'][16],
				'group'       => 'Footbar',
			),
		'footbar-widgetTitle' => array(
				'label'       => 'Widget Title',
				'default'     => $schemes['default']['colors'][17],
				'group'       => 'Footbar',
			),
		'footbar-widgetTitle-border' => array(
				'label'       => 'Widget Title Border',
				'default'     => $schemes['default']['colors'][18],
				'group'       => 'Footbar',
			),
		'footbar-link' => array(
				'label'       => 'Link',
				'default'     => $schemes['default']['colors'][19],
				'group'       => 'Footbar',
			),
		'footbar-link-hover' => array(
				'label'       => 'Link Hover',
				'default'     => $schemes['default']['colors'][20],
				'group'       => 'Footbar',
			),
		'footbar-base' => array(
				'label'       => 'Base',
				'default'     => $schemes['default']['colors'][21],
				'group'       => 'Footbar',
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
				'#000000',
				'#333333',
				'#ffffff',
				'#aaaaaa',
				'#aaaaaa',
				'#000000',
				'#555555',
				'#0f69d7',
				'#0f69d7',
				'',
				'#000000',
				'#000000',
				'#0f69d7',
				'#0f69d7',
				'#555555',
				'#f5f5f5',
				'#cccccc',
				'#000000',
				'#000000',
				'#0f69d7',
				'#0f69d7',
				'#555555',
			),
		),
		'slacker' => array(
			'label'  => 'Slacker',
			'colors' => array(
				'#24243a',
				'#3c3c50',
				'#ffffff',
				'#7c7c9d',
				'#9f9fec',
				'#24243a',
				'#24243a',
				'#dd982b',
				'#000000',
				'#52527e',
				'#ffffff',
				'#6a6a9d',
				'#ecb438',
				'#ffffff',
				'#ffffff',
				'#1a1a22',
				'#1a1a22',
				'#ffffff',
				'#323242',
				'#ecb438',
				'#ffffff',
				'#8080a2',
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

	$sidebar_widget_styles = '';
	if ( $colors['sidebar-bg'] ) {
		$sidebar_widget_styles =<<<CSS
/* sidebar widget background color
----------------------------------------------------------------- */

.sidebar .widget {
	background: {$colors['sidebar-bg']};
	padding:24px;
}
CSS;

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

{$sidebar_widget_styles}

/* sidebar area
----------------------------------------------------------------- */

/* widget border color */
.sidebar .widgetTitle,
.sidebar #contentnav ul,
.sidebar .widget_nav_menu ul,
.sidebar #contentnav li,
.sidebar .widget_nav_menu li {
	border-color: {$colors['sidebar-widgetTitle-border']};
}

.sidebar .widgetTitle {
	color: {$colors['sidebar-widgetTitle']};
}

/* text color */
.sidebar .widget {
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
.footbar .widgetTitle {
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
.footbar .widget_nav_menu li a {
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
