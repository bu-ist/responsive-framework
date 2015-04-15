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
 *
 * @return [type] [description]
 */
function responsive_customizer_color_regions() {
	$schemes = responsive_get_color_schemes();
	return apply_filters( 'responsive_framework_color_regions', array(
		'color0' => array(
				'label'       => 'Color Region 0',
				'description' => '',
				'default'     => $schemes['default']['colors'][0],
			),
		'color1' => array(
				'label'       => 'Color Region 1',
				'description' => '',
				'default'     => $schemes['default']['colors'][1],
			),
		'color2' => array(
				'label'       => 'Color Region 2',
				'description' => '',
				'default'     => $schemes['default']['colors'][2],
			),
		'color3' => array(
				'label'       => 'Color Region 3',
				'description' => '',
				'default'     => $schemes['default']['colors'][3],
			),
		'color4' => array(
				'label'       => 'Color Region 4',
				'description' => '',
				'default'     => $schemes['default']['colors'][4],
			),
		'color5' => array(
				'label'       => 'Color Region 5',
				'description' => '',
				'default'     => $schemes['default']['colors'][5],
			),
		'color6' => array(
				'label'       => 'Color Region 6',
				'description' => '',
				'default'     => $schemes['default']['colors'][6],
			),
		'color7' => array(
				'label'       => 'Color Region 7',
				'description' => '',
				'default'     => $schemes['default']['colors'][7],
			),
		'color8' => array(
				'label'       => 'Color Region 8',
				'description' => '',
				'default'     => $schemes['default']['colors'][8],
			),
		'color9' => array(
				'label'       => 'Color Region 9',
				'description' => '',
				'default'     => $schemes['default']['colors'][9],
			),
		'color10' => array(
				'label'       => 'Color Region 10',
				'description' => '',
				'default'     => $schemes['default']['colors'][10],
			),
		'color11' => array(
				'label'       => 'Color Region 11',
				'description' => '',
				'default'     => $schemes['default']['colors'][11],
			),
		'color12' => array(
				'label'       => 'Color Region 12',
				'description' => '',
				'default'     => $schemes['default']['colors'][12],
			),
		'color13' => array(
				'label'       => 'Color Region 13',
				'description' => '',
				'default'     => $schemes['default']['colors'][13],
			),
		'color14' => array(
				'label'       => 'Color Region 14',
				'description' => '',
				'default'     => $schemes['default']['colors'][14],
			),
		'color15' => array(
				'label'       => 'Color Region 15',
				'description' => '',
				'default'     => $schemes['default']['colors'][15],
			),
		'color16' => array(
				'label'       => 'Color Region 16',
				'description' => '',
				'default'     => $schemes['default']['colors'][16],
			),
		'color17' => array(
				'label'       => 'Color Region 17',
				'description' => '',
				'default'     => $schemes['default']['colors'][17],
			),
		'color18' => array(
				'label'       => 'Color Region 18',
				'description' => '',
				'default'     => $schemes['default']['colors'][18],
			),
	), $schemes );
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
				'#7a7a7a',    // 0 - Utility Nav Link Text Color
				'#ffffff',    // 1 - Button text colors (masthead, but it's overwritten)
				'#000000',    // 2 - Utility Nav Link Focus / Text Headings
				'#000000',    // 3 - Body, Primary Nav wrapper
				'#333333',    // 4 - Sidenav Border Colors
				'#000000',    // 5 - Widget Title / Widget Title Links
				'#0f69d7',    // 6 - Primary Link Text
				'#000000',    // 7 - Border colors (masthead, footer)
				'#f5f5f5',    // 8 - Footbar background color
				'#000000',    // 9 - Footbar widget text
				'#cccccc',    // 10 - Input border colors
				'#0f69d7',    // 11 - Footbar widget link text
				'#aaaaaa',    // 12 - Primary nav link text active / hover
				'#ffffff',    // 13 - Primary nav link text, Search toggle
				'#f5f5f5',    // 14 - Comment respond background
				'#cccccc',    // 15 - Footbar UL / LI border colors
				'#aaaaaa',    // 16 - Sidenav Utility Nav A text
				'#ffffff',    // 17 - Sidenav Utility Nav A text (hover)
				'#ffffff',    // 18 - More Button Colors (redudnant with color1)
			),
		),
		'one' => array(
			'label'  => 'One',
			'colors' => array(
				'#9f9f9f',
				'#ffffff',
				'#000000',
				'#2c3e50',
				'#091928',
				'#2c3e50',
				'#1477da',
				'#e7b032',
				'#fefaf1',
				'#2c3e50',
				'#f2e5c8',
				'#1477da',
				'#e7b032',
				'#ffffff',
				'#fefaf1',
				'#f2e5c8',
				'#9f9f9f',
				'#ffffff',
				'#ffffff',
			),
		),
		'two' => array(
			'label'  => 'Two',
			'colors' => array(
				'#9f9f9f',
				'#ffffff',
				'#000000',
				'#ead333',
				'#f9e138',
				'#0d6167',
				'#000000',
				'#ead333',
				'#2d3435',
				'#ffffff',
				'#e1e9ec',
				'#9db2b5',
				'#756a1c',
				'#000000',
				'#e9f0f3',
				'#000000',
				'#9f9f9f',
				'#756a1c',
				'#000000',
			),
		),
		'three' => array(
			'label'  => 'Three',
			'colors' => array(
				'#9f9f9f',
				'#ffffff',
				'#000000',
				'#5aa7a5',
				'#63b6b4',
				'#566970',
				'#59986c',
				'#5aa7a5',
				'#edf7fa',
				'#000000',
				'#5aa7a5',
				'#59986c',
				'#000000',
				'#ffffff',
				'#edf7fa',
				'#dee7ea',
				'#566970',
				'#000000',
				'#ffffff',
			),
		),
		'four' => array(
			'label'  => 'Four',
			'colors' => array(
				'#9f9f9f',
				'#ffffff',
				'#000000',
				'#cc0000',
				'#a40000',
				'#000000',
				'#3385c8',
				'#cccccc',
				'#eeeeee',
				'#000000',
				'#cccccc',
				'#cc0000',
				'#000000',
				'#ffffff',
				'#eeeeee',
				'#eeeeee',
				'#bbbbbb',
				'#ffffff',
				'#ffffff',
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
function responsive_get_color_scheme() {
	$color_scheme_option = get_option( 'burf_color_scheme', 'default' );
	$color_schemes       = responsive_get_color_schemes();

	if ( array_key_exists( $color_scheme_option, $color_schemes ) ) {
		return $color_schemes[ $color_scheme_option ]['colors'];
	}

	return $color_schemes['default']['colors'];
}

/**
 * Get list of CSS selectors filled out with the given color scheme.
 *
 * @return string         Color scheme CSS rules.
 */
function responsive_get_color_scheme_css() {

	// Get custom selected colors
	$color_regions = responsive_customizer_color_regions();
	$custom_colors = array();
	$custom_colors_option = get_option( 'burf_custom_colors', array() );
	foreach ( $color_regions as $name => $color ) {
		if ( array_key_exists( $name, $custom_colors_option ) ) {
			$custom_colors[ $name ] = $custom_colors_option[ $name ];
		} else {
			$custom_colors[ $name ] = $color['default'];
		}
	}

	// Get colors from current scheme
	$color_scheme = responsive_get_color_scheme();
	$region_names = array_keys( responsive_customizer_color_regions() );
	$colors = array_combine( $region_names, $color_scheme );

	// Merge, giving preference to custom colors
	$colors = wp_parse_args( $custom_colors, $colors );

	// Default color scheme without custom colors. Bail.
	$color_schemes = responsive_get_color_schemes();
	if ( array_values( $colors ) == $color_schemes['default']['colors'] ) {
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

	return <<<CSS
.utilityNav a {
	color:{$colors['color0']};
}

.utilityNav a:hover, .utilityNav a:focus {
	color:{$colors['color2']};
}

.l-sideNav .utilityNav a {
	color:{$colors['color16']};
}

.l-sideNav .utilityNav a:hover, .l-sideNav .utilityNav a:focus {
	color:{$colors['color17']};
}


/* COLOR 1: White */
.masthead,
.button, button,
html input[type="button"],
input[type="reset"],
input[type="submit"],
.news-posts .paging-navigation a,
.wrapper .navigation .nav-links a,
.archive .paging-navigation a,
.single .archiveLink,
.single .archiveLink:visited,
.single-calendar .archiveLink,
.single-calendar .archiveLink:visited  {
	color: {$colors['color1']};
}

/* COLOR 2: Black */
.masthead .brand a,
.masthead .brand a:hover,
.masthead .brand a:focus,
.masthead .brand a:visited,
h1 small,
h2 small,
h3 small,
h4 small,
h5 small,
h6 small,
.single-profile .profile-info .label {
	color:{$colors['color2']};
}

/* COLOR 3 */
body, .primaryNav, .l-sideNav .wrapper  {
	background: {$colors['color3']};
}

@media (min-width: 768px) {
	.primaryNav-menu ul {
		background: {$colors['color3']};
	}
}

/* COLOR 4 */
.l-sideNav .primaryNav-menu a {
	border-color:{$colors['color4']};
}

/* COLOR 5 */
h1, h2, h3, h4, h5, h6,
.widgetTitle, .widgetTitle a,
#contentnav li a, .widget_nav_menu li a,
#contentnav li a:hover, #contentnav li a:focus,
.widget_nav_menu li a:hover, .widget_nav_menu li a:focus,
#contentnav .current_page_item a,
.widget_nav_menu .current_page_item a,
#contentnav .current_page_item li a,
.widget_nav_menu .current_page_item li a {
	color: {$colors['color5']};
}

/* COLOR 6: Blue */
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
.monthCalendar td a:focus,
.bu_collapsible:hover:after,
.bu_collapsible:focus:after,
.bu_collapsible_open .bu_collapsible:hover:after,
.bu_collapsible_open .bu_collapsible:focus:after,
.profile-listing a .profile-name {
	color: {$colors['color6']};
}

/* COLOR 7: Gold */
.masthead,
.footbar,
.primaryNav-menu a,
.utilityNav,
.widgetTitle {
	border-color: {$colors['color7']};
}

@media (min-width: 768px) {
	.l-sideNav #quicksearch {
		border-color: {$colors['color7']};
	}
}

.message,
.single article[role=main] .meta,
.singleEvent .dateSummary,
.single-profile .profile-info,
.single article[role=main] .meta {
	border-left-color: {$colors['color7']};
}

input[type="text"]:focus,
input[type="password"]:focus,
input[type="email"]:focus,
input[type="url"]:focus,
input[type="date"]:focus,
input[type="month"]:focus,
input[type="time"]:focus,
input[type="datetime"]:focus,
input[type="datetime-local"]:focus,
input[type="week"]:focus,
input[type="number"]:focus,
input[type="search"]:focus,
input[type="tel"]:focus,
input[type="color"]:focus,
select:focus,
textarea:focus {
	border-color: {$colors['color7']};
	outline: 1px auto {$colors['color7']};
}

input[type="file"]:focus,
input[type="radio"]:focus,
input[type="checkbox"]:focus {
	outline: 1px auto {$colors['color7']};
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
.button-selected,
a.button-primary,
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
	background-color: {$colors['color7']};
	color: {$colors['color18']};
}

/* COLOR 8: Tan */
.footbar,
.footbar .footbar-container,
#quicksearch,
.message,
.single article[role=main] .meta,
.singleEvent .dateSummary,
.single-profile .profile-info {
	background-color: {$colors['color8']};
}

/* COLOR 9 */
.footbar .widget, .footbar .widgetTitle, .footbar .widgetTitle a {
	color:{$colors['color9']};
}

/* COLOR 10: Tanner */
input[type="text"],
input[type="password"],
input[type="email"],
input[type="url"],
input[type="date"],
input[type="month"],
input[type="time"],
input[type="datetime"],
input[type="datetime-local"],
input[type="week"],
input[type="number"],
input[type="search"],
input[type="tel"],
input[type="color"],
select,
textarea,
.comments-list article,
.comment-respond,
#contentnav ul,
.widget_nav_menu ul,
#contentnav li,
.widget_nav_menu li,
.widget-bu-calendar .default li,
.widget-bu-calendar .full-date li,
.news-posts .post,
.archive .content-container article,
.news-posts .paging-navigation,
.archive .paging-navigation,
.single article[role=main] .meta {
	border-color: {$colors['color10']};
}

/* COLOR 11 */
.footbar .widget a,
.footbar .widget a:hover,
.footbar .widget a:focus,
.footbar #contentnav li a, .footbar .widget_nav_menu li a,
.footbar #contentnav li a:hover, .footbar #contentnav li a:focus {
	color:{$colors['color11']};
}

/* color 12 */
.primaryNav-menu a:hover,
.primaryNav-menu a:focus,
.primaryNav-menu li a.active,
.primaryNav-menu li a.active_section,
.primaryNav-menu li li a:hover, .primaryNav-menu li li a:focus,
.l-noNav .searchToggle:hover, .searchToggle:hover {
	color:{$colors['color12']};
}

/* color 13 */
.primaryNav-menu a,
.primaryNav-menu li li a,
.searchToggle, .l-noNav .searchToggle:hover {
	color:{$colors['color13']};
}

/* color 14 */
.comment-respond {
	background: {$colors['color14']};
}

/* color 15 */
.footbar #contentnav ul,
.footbar .widget_nav_menu ul,
.footbar #contentnav li,
.footbar .widget_nav_menu li {
	border-color:{$colors['color15']};
}
CSS;

}
