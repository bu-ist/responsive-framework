<?php
/**
 * Theme Settings API
 *
 * @package Responsive_Framework\Customizer
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
 * constant using one of the layout slugs (e.g. top-nav, side-nav, etc.).
 *
 * @see  responsive_layout_options()
 */
function responsive_layout() {
	$layout = responsive_get_layout_default();

	if ( defined( 'BU_RESPONSIVE_LAYOUT' ) && array_key_exists( BU_RESPONSIVE_LAYOUT, responsive_layout_options() ) ) {
		$layout = BU_RESPONSIVE_LAYOUT;
	} else {
		$saved_layout = get_option( 'burf_setting_layout', $layout );

		if ( $saved_layout !== $layout && array_key_exists( $saved_layout, responsive_layout_options() ) ) {
			$layout = $saved_layout;
		}
	}

	return $layout;
}

/**
 * Returns layout options available via Customizer.
 */
function responsive_layout_options() {
	/**
	 * Filters the available layout options.
	 *
	 * @since 1.0.3
	 *
	 * @param array List of layout options.
	 */
	$layout_options = apply_filters( 'responsive_layout_options', array(
		'default'  => __( 'Default', 'responsive-framework' ),
		'top-nav'  => __( 'Top Navigation Bar', 'responsive-framework' ),
		'side-nav' => __( 'Side Navigation Bar', 'responsive-framework' ),
		'no-nav'   => __( 'No Navigation Bar', 'responsive-framework' ),
	) );

	return $layout_options;
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
 * Generate inline customizer style block.
 *
 * @param boolean $use_cache Whether to use styles cached in an option. Default is true.
 *
 * @return string $styles CSS Styles for use in the Customizer.
 */
function responsive_get_customizer_styles( $use_cache = true ) {
	$styles = array();
	$is_script_debugging = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;

	// Check cache first if requested and SCRIPT_DEBUG is off.
	if ( $use_cache && ! $is_script_debugging ) {
		$styles = get_option( 'burf_customizer_styles' );
		if ( $styles ) {
			return $styles;
		}
	}

	// Fonts.
	$fonts_css = responsive_get_fonts_css();
	if ( $fonts_css ) {

		// Minify font styles if SCRIPT_DEBUG is off.
		if ( ! $is_script_debugging ) {
			$csstidy = responsive_css_tidy();
			$csstidy->parse( $fonts_css );
			$fonts_css = $csstidy->print->plain();
			unset( $csstidy );
		}

		$styles[] = sprintf( '<style type="text/css" id="responsive-customizer-fonts">%s</style>', $fonts_css );
	}

	// Colors.
	$colors_css = responsive_get_color_scheme_css();
	if ( $colors_css ) {

		// Minify color styles if SCRIPT_DEBUG is off.
		if ( ! $is_script_debugging ) {
			$csstidy = responsive_css_tidy();
			$csstidy->parse( $colors_css );
			$colors_css = $csstidy->print->plain();
			unset( $csstidy );
		}

		$styles[] = sprintf( '<style type="text/css" id="responsive-customizer-colors">%s</style>', $colors_css );
	}

	// Concatenate font and color styles.
	$styles = implode( PHP_EOL, $styles );

	// Only cache minified styles when script debugging is disabled.
	if ( $styles && $use_cache && ! $is_script_debugging ) {
		update_option( 'burf_customizer_styles', $styles );
	}

	return $styles;
}

/**
 * Purge customizer styles cache
 *
 * Customizer styles are purged whenever the customizer is saved, or when any relevant color or font options
 * are updated.
 */
function responsive_flush_customizer_styles_cache() {
	delete_option( 'burf_customizer_styles' );
}

add_action( 'customize_save_after',                            'responsive_flush_customizer_styles_cache' );
add_action( 'update_option_burf_setting_color_scheme',         'responsive_flush_customizer_styles_cache' );
add_action( 'update_option_burf_setting_custom_colors',        'responsive_flush_customizer_styles_cache' );
add_action( 'update_option_burf_setting_active_color_regions', 'responsive_flush_customizer_styles_cache' );
add_action( 'update_option_burf_setting_fonts',                'responsive_flush_customizer_styles_cache' );

// Flush cached Customizer styles whenever framework has been updated.
add_action( 'update_option__responsive_framework_version',     'responsive_flush_customizer_styles_cache' );

/**
 * Returns a configured csstidy instance for CSS minification.
 *
 * Configuration values are consistent with those found in the BU Custom CSS
 * plugin.
 *
 * @see https://github.com/bu-ist/bu-custom-css/blob/5c874ce87ab674301398a4945b5e789fdebb1890/bu-custom-css.php
 * @see http://manpages.ubuntu.com/manpages/raring/man1/csstidy.1.html
 */
function responsive_css_tidy() {

	// Load CSSTidy class using Composer autoloader.
	require_once get_template_directory() . '/vendor/autoload.php';

	$csstidy = new csstidy();

	$csstidy->set_cfg( 'remove_bslash',              false );
	$csstidy->set_cfg( 'compress_colors',            false );
	$csstidy->set_cfg( 'compress_font-weight',       false );
	$csstidy->set_cfg( 'optimise_shorthands',        0 );
	$csstidy->set_cfg( 'remove_last_;',              false );
	$csstidy->set_cfg( 'case_properties',            false );
	$csstidy->set_cfg( 'discard_invalid_properties', true );
	$csstidy->set_cfg( 'css_level',                  'CSS3.0' );
	$csstidy->set_cfg( 'preserve_css',               true );
	$csstidy->set_cfg( 'template',                   'highest' );

	return $csstidy;
}

/**
 * Return font palette CSS styles.
 *
 * @return string $css Contents of the CSS font palette file.
 */
function responsive_get_fonts_css() {
	$css = '';
	$palette = responsive_get_font_palette();
	if ( ! empty( $palette ) ) {
		$request = wp_remote_get( get_template_directory_uri() . "/css/$palette.css" );

		if ( ! is_wp_error( $request ) && 200 == wp_remote_retrieve_response_code( $request ) ) {
			$css = wp_remote_retrieve_body( $request );
		}
	}

	return $css;
}

/**
 * Customizer color region sections.
 */
function responsive_customizer_color_region_groups() {
	return array(
		'navbar'       => array(
			'label' => __( 'Navigation Bar', 'responsive-framework' ),
			'layout_excludes' => array( 'no-nav' ),
		),
		'content-area' => array(
			'label' => __( 'Content Area', 'responsive-framework' ),
		),
		'sidebar'      => array(
			'label' => __( 'Sidebar', 'responsive-framework' ),
		),
		'footbar'      => array(
			'label' => __( 'Footbar', 'responsive-framework' ),
		),
	);
}

/**
 * Register customizer color regions.
 */
function responsive_customizer_color_regions() {
	$scheme = responsive_get_color_scheme();
	return array(

		// navigation bar.
		'primaryNav-bg' => array(
			'label'       => __( 'Background Color', 'responsive-framework' ),
			'group'       => 'navbar',
			'default'     => $scheme['colors'][0],
		),
		'primaryNav-border' => array(
			'label'       => __( 'Border Color', 'responsive-framework' ),
			'group'       => 'navbar',
			'default'     => $scheme['colors'][1],
		),
		'primaryNav-link' => array(
			'label'       => __( 'Primary Nav Links', 'responsive-framework' ),
			'group'       => 'navbar',
			'default'     => $scheme['colors'][2],
		),
		'utilityNav-link' => array(
			'label'       => __( 'Utility Nav Links', 'responsive-framework' ),
			'group'       => 'navbar',
			'default'     => $scheme['colors'][3],
		),
		'primaryNav-hover' => array(
			'label'       => __( 'Primary Nav Links Hover', 'responsive-framework' ),
			'group'       => 'navbar',
			'default'     => $scheme['colors'][4],
		),

		// content area.
		'content-heading' => array(
			'label'       => __( 'Headings', 'responsive-framework' ),
			'group'       => 'content-area',
			'default'     => $scheme['colors'][5],
		),
		'content-base' => array(
			'label'       => __( 'Text Color', 'responsive-framework' ),
			'group'       => 'content-area',
			'default'     => $scheme['colors'][6],
		),
		'content-link' => array(
			'label'       => __( 'Link Color', 'responsive-framework' ),
			'group'       => 'content-area',
			'default'     => $scheme['colors'][7],
		),
		'content-link-hover' => array(
			'label'       => __( 'Link Hover', 'responsive-framework' ),
			'group'       => 'content-area',
			'default'     => $scheme['colors'][8],
		),
		'button-color' => array(
			'label'       => __( 'Button Background', 'responsive-framework' ),
			'group'       => 'content-area',
			'default'     => $scheme['colors'][9],
		),
		'button-text-color' => array(
			'label'       => __( 'Button Text Color', 'responsive-framework' ),
			'group'       => 'content-area',
			'default'     => $scheme['colors'][10],
		),

		// sidebar.
		'sidebar-bg' => array(
			'label'       => __( 'Widget Background', 'responsive-framework' ),
			'group'       => 'sidebar',
			'optional'    => true,
			'default'     => $scheme['colors'][11],
		),
		'sidebar-widgetTitle' => array(
			'label'       => __( 'Widget Title', 'responsive-framework' ),
			'group'       => 'sidebar',
			'default'     => $scheme['colors'][12],
		),
		'sidebar-widgetTitle-border' => array(
			'label'       => __( 'Widget Title Border', 'responsive-framework' ),
			'group'       => 'sidebar',
			'default'     => $scheme['colors'][13],
		),
		'sidebar-link' => array(
			'label'       => __( 'Link Color', 'responsive-framework' ),
			'group'       => 'sidebar',
			'default'     => $scheme['colors'][14],
		),
		'sidebar-link-hover' => array(
			'label'       => __( 'Link Hover', 'responsive-framework' ),
			'group'       => 'sidebar',
			'default'     => $scheme['colors'][15],
		),
		'sidebar-base' => array(
			'label'       => __( 'Text Color', 'responsive-framework' ),
			'group'       => 'sidebar',
			'default'     => $scheme['colors'][16],
		),

		// footbar.
		'footbar-bg' => array(
			'label'       => __( 'Background', 'responsive-framework' ),
			'group'       => 'footbar',
			'default'     => $scheme['colors'][17],
		),
		'footbar-topBorder' => array(
			'label'       => __( 'Top Border', 'responsive-framework' ),
			'group'       => 'footbar',
			'default'     => $scheme['colors'][18],
		),
		'footbar-widgetTitle' => array(
			'label'       => __( 'Widget Title', 'responsive-framework' ),
			'group'       => 'footbar',
			'default'     => $scheme['colors'][19],
		),
		'footbar-widgetTitle-border' => array(
			'label'       => __( 'Widget Title Border', 'responsive-framework' ),
			'group'       => 'footbar',
			'default'     => $scheme['colors'][20],
		),
		'footbar-link' => array(
			'label'       => __( 'Link Color', 'responsive-framework' ),
			'group'       => 'footbar',
			'default'     => $scheme['colors'][21],
		),
		'footbar-link-hover' => array(
			'label'       => __( 'Link Hover', 'responsive-framework' ),
			'group'       => 'footbar',
			'default'     => $scheme['colors'][22],
		),
		'footbar-base' => array(
			'label'       => __( 'Text Color', 'responsive-framework' ),
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
			'label'  => __( 'Default', 'responsive-framework' ),
			'colors' => array(
				// navigation.
				'#000000', // background.
				'#333333', // border color.
				'#ffffff', // primary nav links.
				'#aaaaaa', // utility nav links.
				'#aaaaaa', // primary links hover.

				// content area.
				'#000000', // headings.
				'#555555', // text color.
				'#0f69d7', // link color.
				'#0f69d7', // link hovers.
				'#0f69d7', // button color.
				'#ffffff', // button text color.

				// sidebar.
				'#ffffff', // widget bg.
				'#000000', // widget title.
				'#000000', // widget title border.
				'#0f69d7', // links.
				'#0f69d7', // link hovers.
				'#555555', // text color.

				// footbar.
				'#f5f5f5', // background.
				'#cccccc', // top border.
				'#000000', // widget title.
				'#000000', // widget title border.
				'#0f69d7', // link colors.
				'#0f69d7', // link hover colors.
				'#555555', // text color.
			),
			'active' => array(
				'sidebar-bg' => false,
			),
		),
		'slacker' => array(
			'label'  => __( 'Slacker', 'responsive-framework' ),
			'colors' => array(
				// navigation.
				'#24243a', // background.
				'#3c3c50', // border color.
				'#ffffff', // primary nav links.
				'#7c7c9d', // utility nav links.
				'#9f9fec', // primary links hover.

				// content area.
				'#24243a', // headings.
				'#24243a', // text color.
				'#A06C1A', // link color.
				'#000000', // link hovers.
				'#4fc3a0', // button color.
				'#ffffff', // button text color.

				// sidebar.
				'#494971', // widget bg.
				'#ffffff', // widget title.
				'#6a6a9d', // widget title border.
				'#ecb438', // links.
				'#ffffff', // link hovers.
				'#ffffff', // text color.

				// footbar.
				'#1a1a22', // background.
				'#1a1a22', // top border.
				'#ffffff', // widget title.
				'#323242', // widget title border.
				'#ecb438', // link colors.
				'#ffffff', // link hover colors.
				'#8080a2', // text color.
			),
			'active' => array(
				'sidebar-bg' => true,
			),
		),
		'extra-spectral' => array(
			'label'  => __( 'Extra Spectral', 'responsive-framework' ),
			'colors' => array(
				// navigation.
				'#c2185b', // background.
				'#cd4279', // border color.
				'#ffffff', // primary nav links.
				'#ff9fc5', // utility nav links.
				'#000000', // primary links hover.

				// content area.
				'#000000', // headings.
				'#000000', // text color.
				'#e82a75', // link color.
				'#000000', // link hovers.
				'#e82a75', // button color.
				'#ffffff', // button text color.

				// sidebar.
				'#7f2247', // widget bg.
				'#ffffff', // widget title.
				'#924362', // widget title border.
				'#ffffff', // links.
				'#ffffff', // link hovers.
				'#e4abc1', // text color.

				// footbar.
				'#222222', // background.
				'#222222', // top border.
				'#ffffff', // widget title.
				'#3d3d3d', // widget title border.
				'#e82a75', // link colors.
				'#ffffff', // link hover colors.
				'#bdbdbd', // text color.
			),
			'active' => array(
				'sidebar-bg' => true,
			),
		),
		'rayleigh-scattering' => array(
			'label'  => __( 'Rayleigh Scattering', 'responsive-framework' ),
			'colors' => array(
				// navigation.
				'#04a9f4', // background.
				'#31b9f6', // border color.
				'#ffffff', // primary nav links.
				'#b4ddfa', // utility nav links.
				'#000000', // primary links hover.

				// content area.
				'#222222', // headings.
				'#000000', // text color.
				'#fa5707', // link color.
				'#000000', // link hovers.
				'#fa5707', // button color.
				'#ffffff', // button text color.

				// sidebar.
				'#e1f0f5', // widget bg.
				'#000000', // widget title.
				'#cad7db', // widget title border.
				'#000000', // links.
				'#000000', // link hovers.
				'#6f7b7f', // text color.

				// footbar.
				'#222222', // background.
				'#222222', // top border.
				'#ffffff', // widget title.
				'#3d3d3d', // widget title border.
				'#fa5707', // link colors.
				'#dcdcdc', // link hover colors.
				'#dcdcdc', // text color.
			),
			'active' => array(
				'sidebar-bg' => true,
			),
		),
		'vinca-minor' => array(
			'label'  => __( 'Vinca Minor', 'responsive-framework' ),
			'colors' => array(
				// navigation.
				'#3f51b5', // background.
				'#6270c2', // border color.
				'#ffffff', // primary nav links.
				'#bec8ff', // utility nav links.
				'#000000', // primary links hover.

				// content area.
				'#000000', // headings.
				'#000000', // text color.
				'#fb8007', // link color.
				'#000000', // link hovers.
				'#6c7dff', // button color.
				'#ffffff', // button text color.

				// sidebar.
				'#ffffff', // widget bg.
				'#000000', // widget title.
				'#e8eaf6', // widget title border.
				'#fb8007', // links.
				'#989bad', // link hovers.
				'#989bad', // text color.

				// footbar.
				'#1a1d2b', // background.
				'#1a1a22', // top border.
				'#ffffff', // widget title.
				'#363845', // widget title border.
				'#fb8007', // link colors.
				'#ffffff', // link hover colors.
				'#dcdcdc', // text color.
			),
			'active' => array(
				'sidebar-bg' => false,
			),
		),
		'eiffel' => array(
			'label'  => __( 'Eiffel', 'responsive-framework' ),
			'colors' => array(
				// navigation.
				'#00343a', // background.
				'#3f6270', // border color.
				'#ffffff', // primary nav links.
				'#c9b28f', // utility nav links.
				'#c4c7c7', // primary links hover.

				// content area.
				'#c58700', // headings.
				'#2a3239', // text color.
				'#447375', // link color.
				'#005653', // link hovers.
				'#447375', // button color.
				'#ffffff', // button text color.

				// sidebar.
				'#f4f7f7', // widget bg.
				'#34595b', // widget title.
				'#e5e7e7', // widget title border.
				'#447375', // links.
				'#005653', // link hovers.
				'#2a3239', // text color.

				// footbar.
				'#f4f7f7', // background.
				'#b4b7b7', // top border.
				'#34595b', // widget title.
				'#e5e7e7', // widget title border.
				'#447375', // link colors.
				'#005653', // link hover colors.
				'#2a3239', // text color.
			),
			'active' => array(
				'sidebar-bg' => true,
			),
		),
		'comm_ave' => array(
			'label'  => __( 'Comm Ave', 'responsive-framework' ),
			'colors' => array(
				// navigation.
				'#303437', // background.
				'#535860', // border color.
				'#ffffff', // primary nav links.
				'#b2b2b2', // utility nav links.
				'#48b4f4', // primary links hover.

				// content area.
				'#48b4f4', // headings.
				'#001f2c', // text color.
				'#7ba11b', // link color.
				'#4f6d04', // link hovers.
				'#7ba11b', // button color.
				'#ffffff', // button text color.

				// sidebar.
				'#7ba11b', // widget bg.
				'#ffffff', // widget title.
				'#87b71f', // widget title border.
				'#eaedeb', // links.
				'#ffffff', // link hovers.
				'#ffffff', // text color.

				// footbar.
				'#53575b', // background.
				'#b4e145', // top border.
				'#f6f7f9', // widget title.
				'#6f7378', // widget title border.
				'#b4e145', // link colors.
				'#86b304', // link hover colors.
				'#ffffff', // text color.
			),
			'active' => array(
				'sidebar-bg' => true,
			),
		),


	);
}

/**
 * Return a list of optional color regions.
 */
function responsive_get_optional_color_regions() {
	$regions = responsive_customizer_color_regions();
	return array_keys(
		wp_filter_object_list(
			$regions, array(
				'optional' => true,
			)
		)
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

	foreach ( $schemes as $slug => $scheme ) {
		$schemes[ $slug ] = $scheme['label'];
	}

	return $schemes;
}

/**
 * Get the current color scheme.
 *
 * @param null|string $scheme Color scheme to retrieve.
 *
 * @return array An associative array representing a color scheme.
 */
function responsive_get_color_scheme( $scheme = null ) {
	// Load the current color scheme if none was passed.
	if ( ! is_scalar( $scheme ) ) {
		$scheme = get_option( 'burf_setting_color_scheme', 'default' );
	}

	// Return requested theme if found.
	$schemes = responsive_get_color_schemes();
	if ( array_key_exists( $scheme, $schemes ) ) {
		return $schemes[ $scheme ];
	}

	// Return default otherwise.
	return $schemes['default'];
}

/**
 * Return the HEX color values for the given color scheme.
 *
 * If no $scheme is passed, the currently active scheme is used.
 *
 * @param string $scheme A color scheme to retrieve colors for. Optional.
 *
 * @return array $colors Color scheme colors, indexed by region name.
 */
function responsive_get_color_scheme_colors( $scheme = null ) {
	$scheme = responsive_get_color_scheme( $scheme );

	// Combine region names and color values into associative array.
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
	return get_option( 'burf_setting_custom_colors', array() );
}

/**
 * Return the active state of optional color regions.
 *
 * @return array A list of color region keys with current state.
 */
function responsive_get_active_color_regions() {
	// Get defaults from currently active scheme.
	$scheme = responsive_get_color_scheme();

	// Merge with current values.
	$active_regions = get_option( 'burf_setting_active_color_regions', array() );
	return array_merge( $scheme['active'], $active_regions );
}

/**
 * Get list of CSS selectors filled out with the given color scheme.
 *
 * @return string         Color scheme CSS rules.
 */
function responsive_get_color_scheme_css() {

	// Get colors from current scheme.
	$scheme_colors = responsive_get_color_scheme_colors();

	// Get custom selected colors.
	$custom_colors = responsive_get_custom_colors();

	// Merge, giving preference to custom colors.
	$colors = array_merge( $scheme_colors, $custom_colors );

	// Default color scheme without custom colors. Bail.
	if ( responsive_get_color_scheme_colors( 'default' ) === $colors ) {
		return '';
	}

	return responsive_framework_get_color_regions_css( $colors );
}

/**
 * Generates CSS snippet for customizer color scheme.
 *
 * @param array  $colors  Hex color values, keyed on region slugs.
 * @param string $context Context for the styles.
 *
 * @return string        Color scheme CSS rules.
 */
function responsive_framework_get_color_regions_css( $colors, $context = 'default' ) {

		$sidebar_widget_styles = <<<CSS
/* sidebar widget background color
----------------------------------------------------------------- */

.widget {
	background: {$colors['sidebar-bg']};
	padding: 24px;
}

.footbar .widget {
	background: transparent;
	padding: 0;
}
CSS;

	// Underscore template gets special logic.
	if ( 'template' === $context ) {
		$sidebar_widget_styles = <<<CSS
<# if ( data.active['sidebar-bg'] ) { #>
{$sidebar_widget_styles}
<# } #>
CSS;
	} else {
		// Check currently active colors.
		$active_regions = responsive_get_active_color_regions();
		if ( ! $active_regions['sidebar-bg'] ) {
			$sidebar_widget_styles = '';
		}
	}

	return <<<CSS
/* navigation bar and links
----------------------------------------------------------------- */

/* navbar bg color */
.l-side-nav .wrapper,
.primary-nav,
.primary-nav-menu ul,
.l-side-nav {
	background: {$colors['primaryNav-bg']};
}

.primary-nav,
.primary-nav-menu ul,
.primary-nav-menu a,
.search-toggle::before {
	color: {$colors['primaryNav-link']};
}

/* main nav and nav border color */
.primary-nav-menu a,
.l-side-nav .primary-nav-menu a {
	border-color: {$colors['primaryNav-border']};
}

/* main nav and nav border color */
.nav-toggle span,
.nav-toggle span::before,
.nav-toggle span::after {
	background-color: {$colors['primaryNav-link']};
}

/* utility nav color */
.l-side-nav .utility-nav a {
	color: {$colors['utilityNav-link']};
}

/* main nav and utility nav hover color */
.primary-nav-menu a:hover,
.primary-nav-menu a:focus,
.l-side-nav .utility-nav a:hover,
.l-side-nav .utility-nav a:focus,
.primary-nav-menu li a.active,
.primary-nav-menu li a.active_section,
.primary-nav-menu li li a:hover,
.primary-nav-menu li li a:focus {
	color: {$colors['primaryNav-hover']};
}

/* content area
----------------------------------------------------------------- */

/* heading color */
h1,
h2,
h3,
h4,
h5,
h6 {
	color: {$colors['content-heading']};
}

/* text color */
body {
	color: {$colors['content-base']};
}

/* link color */
a,
.widget a,
.widget a:hover,
.widget a:focus,
.calendar-list-event-link,
.calendar-list-event-link:focus,
.bu_collapsible::before,
.profile-name {
	color: {$colors['content-link']};
}

/* link hover color */
a:hover,
.calendar-list-event-link:hover,
.bu_collapsible:hover::before,
.bu_collapsible:focus::before,
.month td a:hover {
	color: {$colors['content-link-hover']};
}

/* buttons */
input[type="submit"],
.button,
.button-primary,
.button-selected,
#quicksearch .button,
.paging-navigation a,
.archive-link {
	background: {$colors['button-color']};
	color: {$colors['button-text-color']};
}

input[type="submit"]:hover,
.button:hover,
.button-primary:hover,
.button-selected:hover,
#quicksearch .button:hover,
.paging-navigation a:hover,
.archive-link:hover {
	color: {$colors['button-text-color']};
}

/* blockquotes */
blockquote {
	border-color: {$colors['content-link']};
}

blockquote:before {
	color: {$colors['content-link']};
}


{$sidebar_widget_styles}

/* sidebar area
----------------------------------------------------------------- */

/* widget border color */
.widget-title,
#contentnav ul,
#contentnav li,
.widget_nav_menu ul,
.widget_nav_menu li,
.widget-calendar-event,
.month,
.widget-calendar-picker th,
.widget-calendar-picker td {
	border-color: {$colors['sidebar-widgetTitle-border']};
}

.widget-title {
	color: {$colors['sidebar-widgetTitle']};
}

/* text color */
.widget,
.widget-calendar-picker th,
.widget-calendar-picker caption {
	color: {$colors['sidebar-base']};
}

/* link color */
.widget a,
#contentnav li a,
.widget_nav_menu li a {
	color: {$colors['sidebar-link']};
}

/* link hover color */
.widget a:hover,
#contentnav li a:hover,
.widget_nav_menu li a:hover,
#contentnav li.current_page_item > a,
.widget_nav_menu li.current_page_item > a{
	color: {$colors['sidebar-link-hover']};
}

/* footbar area
----------------------------------------------------------------- */

/* background color */
.footbar,
.footbar-container,
.banner-container-window-width {
	background: {$colors['footbar-bg']};
}

/* top border color */
.footbar {
	border-color: {$colors['footbar-topBorder']};
}

/* link color */
.footbar a,
.footbar .widget a,
.footbar #contentnav li a,
.footbar .widget_nav_menu li a {
	color: {$colors['footbar-link']};
}

/* widget title color */
.footbar .widget-title,
.footbar .widget-calendar-date {
	color: {$colors['footbar-widgetTitle']};
}

/* border color */
.footbar .widget-title,
.footbar #contentnav ul,
.footbar #contentnav li,
.footbar .widget_nav_menu ul,
.footbar .widget_nav_menu li,
.footbar .widget-calendar-event {
	border-color: {$colors['footbar-widgetTitle-border']};
}

/* link hover color */
.footbar .widget a:hover,
.footbar #contentnav li a:hover,
.footbar .widget_nav_menu li a:hover {
	color: {$colors['footbar-link-hover']};
}

/* text color */
.footbar .widget,
.footbar .widget-calendar-day-graphic,
.footbar .widget-bu-posts .meta {
	color: {$colors['footbar-base']};
}

/* non-configurable styles
----------------------------------------------------------------- */

.comment-respond,
#quicksearch,
.l-side-nav #quicksearch,
.message,
.single .content-area .meta,
.single-event-schedule,
.single-profile .profile-info {
	background: #f5f8ff;
	border-color: #dfdfea;
}

/* calendar table */
.widget-calendar-picker thead,
.widget-calendar-picker th,
.widget-calendar-picker .out,
.widget-calendar-picker .today {
	background: rgba(0,0,0,0.15);
}

.utility-nav a,
a:active,
a:visited,
.widget-title a,
.widget-post-meta {
	color: inherit;
}

CSS;

}

/**
 * Returns any content entered into the Footer > Additional Info textarea.
 */
function responsive_get_customizer_footer_info() {
	$defaults = array(
		'text'  => '',
		'autop' => false,
	);
	$footer = wp_parse_args( get_option( 'burf_setting_footer', array() ), $defaults );

	if ( $footer['autop'] ) {
		return wpautop( $footer['text'] );
	} else {
		return $footer['text'];
	}
}

/**
 * Prints out additional footer info content.
 *
 * @param array $args {
 *     An array of widget display arguments.
 *
 *     @type string $before Text or markup to go before the widget.
 *     @type string $after  Text or markup to go after the widget.
 *     @type string $echo   Whether to echo or return the HTML output.
 * }
 *
 * @return string $output HTML output for footer info.
 */
function responsive_customizer_footer_info( $args = array() ) {
	$defaults = array(
		'before' => '<div class="site-footer-info">',
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
