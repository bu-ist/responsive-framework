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

	$layout_options = apply_filters(
		'responsive_layout_options',
		array(
			'default'  => __( 'Default Navigation <span class="ui-context">A good choice for most websites</span>', 'responsive-framework' ),
			'top-nav'  => __( 'Top Navigation <span class="ui-context">Best for websites without dropdowns</span>', 'responsive-framework' ),
			'side-nav' => __( 'Side Navigation <span class="ui-context">Best for small websites with few nested pages</span>', 'responsive-framework' ),
			'mega-nav' => __( 'Mega Navigation <span class="ui-context">Best for large, complex websites</span>', 'responsive-framework' ),
			'no-nav'   => __( 'No Navigation <span class="ui-context">Best for single-page websites</span>', 'responsive-framework' ),
		)
	);

	return $layout_options;
}

/**
 * Returns the site's current font palette.
 *
 * @return string The value for the font palette to be used.
 */
function responsive_get_font_palette() {
	if ( defined( 'BU_RESPONSIVE_FONT_PALETTE' ) && array_key_exists( BU_RESPONSIVE_FONT_PALETTE, responsive_font_options() ) ) {
		return BU_RESPONSIVE_FONT_PALETTE;
	}

	/**
	 * Allow the fallback font to be filtered.
	 *
	 * @since 2.1.11
	 *
	 * @param string Fallback font value.
	 */
	$fallback_font = (string) apply_filters( 'responsive_font_fallback', 'f1' );
	$palette       = get_option( 'burf_setting_fonts' );

	// Let's make sure that we are actually getting a font that is in the list.
	if ( ! in_array( $palette, responsive_font_options(), true ) ) {
		$palette = $fallback_font;
	}

	return $palette;
}

/**
 * Returns font palette options available via Customizer.
 */
function responsive_font_options() {

	/**
	 * Allow fonts to be filtered.
	 *
	 * @since 2.1.11
	 *
	 * @param array List of font family options.
	 */
	return (array) apply_filters(
		'responsive_font_options',
		array(
			'f1' => '<span class="f1-font-title">Benton Bold</span><span class="f1-font-body">Benton Sans Regular is the font your body copy will appear in.</span>',
			'f2' => '<span class="f2-font-title">Capita Bold</span><span class="f2-font-body">Benton Sans Regular is the font your body copy will appear in.</span>',
			'f3' => '<span class="f3-font-title">Benton Light</span><span class="f3-font-body">Capita Regular is the font your body copy will appear in.</span>',
			'f4' => '<span class="f4-font-title">Tiempos Bold</span><span class="f4-font-body">Tiempos Regular is the font your body copy will appear in.</span>',
			'f5' => '<span class="f5-font-title">Pressura Heading</span><span class="f5-font-body">Benton Sans Regular is the font your body copy will appear in.</span>',
		)
	);

}

/**
 * Returns an array of color schemes
 */
function responsive_color_options() {
	return (array) apply_filters(
		'responsive_color_options',
		array(
			'default'             => 'Default',
			'slacker'             => 'Slacker',
			'extra-spectral'      => 'Extra Spectral',
			'rayleigh-scattering' => 'Rayleigh Scattering',
			'vinca-minor'         => 'Vinca Minor',
			'eiffel'              => 'Eiffel',
			'comm_ave'            => 'Comm Ave',
		)
	);
}

/**
 * Returns the site's current color palette.
 *
 * @return string The value for the color palette to be used.
 */
function responsive_get_color_palette() {
	if ( defined( 'BU_RESPONSIVE_COLOR_PALETTE' ) && array_key_exists( BU_RESPONSIVE_COLOR_PALETTE, responsive_color_options() ) ) {
		return BU_RESPONSIVE_COLOR_PALETTE;
	}

	/**
	 * Allow the fallback color to be filtered.
	 *
	 * @since 2.1.11
	 *
	 * @param string Fallback color value.
	 */
	$fallback_color = (string) apply_filters( 'responsive_color_fallback', 'default' );

	$palette = get_option( 'burf_setting_colors' );

	// Let's make sure that we are actually getting a color that is in the list.
	if ( ! in_array( $palette, responsive_color_options(), true ) ) {
		$palette = $fallback_color;
	}

	return $palette;
}

/**
 * Generate inline customizer style block.
 *
 * @param boolean $use_cache Whether to use styles cached in an option. Default is true.
 *
 * @return string $styles CSS Styles for use in the Customizer.
 */
function responsive_get_customizer_styles( $use_cache = true ) {

	$styles              = array();
	$is_script_debugging = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;

	// Check cache first if requested and SCRIPT_DEBUG is off.
	if ( $use_cache && ! $is_script_debugging ) {
		$styles = get_option( 'burf_customizer_styles' );
		if ( $styles ) {
			return $styles;
		}
	}

	// Fonts.
	$fonts_css = responsive_get_css( 'font' );
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
	$colors_css = responsive_get_css( 'color' );
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

add_action( 'customize_save_after', 'responsive_flush_customizer_styles_cache' );
add_action( 'update_option_burf_setting_color_scheme', 'responsive_flush_customizer_styles_cache' );
add_action( 'update_option_burf_setting_custom_colors', 'responsive_flush_customizer_styles_cache' );
add_action( 'update_option_burf_setting_active_color_regions', 'responsive_flush_customizer_styles_cache' );
add_action( 'update_option_burf_setting_fonts', 'responsive_flush_customizer_styles_cache' );

// Flush cached Customizer styles whenever framework has been updated.
add_action( 'update_option__responsive_framework_version', 'responsive_flush_customizer_styles_cache' );

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

	$csstidy->set_cfg( 'remove_bslash', false );
	$csstidy->set_cfg( 'compress_colors', false );
	$csstidy->set_cfg( 'compress_font-weight', false );
	$csstidy->set_cfg( 'optimise_shorthands', 0 );
	$csstidy->set_cfg( 'remove_last_;', false );
	$csstidy->set_cfg( 'case_properties', false );
	$csstidy->set_cfg( 'discard_invalid_properties', true );
	$csstidy->set_cfg( 'css_level', 'CSS3.0' );
	$csstidy->set_cfg( 'preserve_css', true );
	$csstidy->set_cfg( 'template', 'highest' );

	return $csstidy;
}

/**
 * Return font palette CSS styles.
 *
 * @param string $palette Either font or color.
 * @return string $css Contents of the CSS font palette file.
 */
function responsive_get_css( $palette ) {
	if ( ! in_array( $palette, array( 'font', 'color' ), true ) ) {
		return;
	}

	$css         = '';
	$get_palette = '';
	switch ( $palette ) {
		case 'font':
			$get_palette = responsive_get_font_palette();
			break;
		case 'color':
			$get_palette = responsive_get_color_palette();
			if ( 'default' === $get_palette ) {
				$get_palette = '';
			}
			break;
		default:
			$get_palette = '';
			break;
	}

	if ( ! empty( $get_palette ) ) {
		$request = wp_remote_get( get_template_directory_uri() . '/css/' . $get_palette . '.css' );

		if ( ! is_wp_error( $request ) && 200 === wp_remote_retrieve_response_code( $request ) ) {
			$css = wp_remote_retrieve_body( $request );
		}
	}

	return $css;
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

	$args   = wp_parse_args( $args, $defaults );
	$output = '';

	$footer_info = responsive_get_customizer_footer_info();
	if ( $footer_info ) {
		$output = $args['before'] . $footer_info . $args['after'];
	}

	if ( $args['echo'] ) {
		echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
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
