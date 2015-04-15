<?php
/**
 * This hides the Font / Color / Background Customizer panels and associated styles.
 */

require_once __DIR__ . '/customizer-controls.php';

/**
 * Enqueue scripts and styles for customizer preview.
 */
function responsive_customizer_scripts() {
	wp_enqueue_style( 'responsi-admin', get_template_directory_uri() . "/admin/admin.css", array(), RESPONSIVE_FRAMEWORK_VERSION );
	wp_enqueue_script( 'responsi-customizer', get_template_directory_uri() . "/admin/theme-customizer.js", array( 'jquery', 'customize-controls', 'iris', 'underscore', 'wp-util' ), RESPONSIVE_FRAMEWORK_VERSION, true );
	wp_localize_script( 'responsi-customizer', 'responsiveColor', array( 'schemes' => responsive_get_color_schemes(), 'regions' => responsive_customizer_color_regions() ) );
}

add_action( 'customize_controls_enqueue_scripts', 'responsive_customizer_scripts' );

/**
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 */
function responsive_framework_customizer_preview_scripts() {
	wp_enqueue_script( 'responsi-customize-preview', get_template_directory_uri() . "/admin/customize-preview.js", array( 'customize-preview' ), RESPONSIVE_FRAMEWORK_VERSION, true );
}

add_action( 'customize_preview_init', 'responsive_framework_customizer_preview_scripts' );

/**
 * Register customizer sections & controls.
 */
function responsive_customize_register( $wp_customize ) {

	// Layout
	if ( ! defined( 'BU_RESPONSIVE_LAYOUT' ) ) {
		$wp_customize->add_section( 'burf_section_layout', array(
			'title'    => __( 'Layout Options', 'burf' ),
			'priority' => 30,
		) );

		$wp_customize->add_setting( 'burf_setting_layout', array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		) );

		$wp_customize->add_control( new BURF_Customize_Radio( $wp_customize, 'burf_section_layout', array(
			'section'        => 'burf_section_layout',
			'settings'       => 'burf_setting_layout',
			'type'           => 'radio',
			'choices'        => responsive_layout_options(),
		) ) );
	}

	// Fonts and colors are only useful for Framework
	if ( ! is_child_theme() && ! defined( 'RESPONSIVE_CUSTOMIZER_DISABLE' ) ) {

		// Fonts
		$wp_customize->add_section( 'burf_section_fonts', array(
			'title'    => __( 'Font Options', 'burf' ),
			'priority' => 31,
		) );

		$wp_customize->add_setting( 'burf_setting_fonts', array(
			'default'        => '',
			'capability'     => 'edit_theme_options',
			'type'           => 'option',
		) );

		$wp_customize->add_control( new BURF_Customize_Radio( $wp_customize, 'burf_section_fonts', array(
			'label'    => 'Font Picker Setting',
			'section'  => 'burf_section_fonts',
			'settings' => 'burf_setting_fonts',
			'type'     => 'radio',
			'choices'  => responsive_font_options(),
		) ) );

		// Colors
		$wp_customize->add_setting( 'burf_color_scheme', array(
			'default'           => 'default',
			'sanitize_callback' => 'responsive_sanitize_color_scheme',
			'transport'         => 'postMessage',
			'type'              => 'option'
		) );

		$wp_customize->add_control( 'burf_color_scheme', array(
			'label'    => 'Base Color Scheme',
			'section'  => 'colors',
			'type'     => 'select',
			'choices'  => responsive_get_color_scheme_choices(),
			'priority' => 1,
		) );

		// Add color picker for each customizable colo region
		foreach ( responsive_customizer_color_regions() as $option => $colors ) {

			// Add custom header and sidebar text color setting and control.
			$wp_customize->add_setting( "burf_custom_colors[$option]", array(
				'default'           => $colors['default'],
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
				'type'              => 'option'
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "burf_custom_colors[$option]", array(
				'label'       => $colors['label'],
				'description' => $colors['description'],
				'section'     => 'colors',
			) ) );
		}
	}

	// Footer
	$menu_url = admin_url( 'nav-menus.php?action=locations' );
	$wp_customize->add_section( 'burf_section_footer', array(
		'title'       => __( 'Footer', 'burf' ),
		'description' => "Footer links can be managed using the <a href=\"$menu_url\">Footer and Social Links Custom Menu locations</a>.",
		'priority'    => 34,
	) );

	// Additiona Info (free-form textarea)
	$wp_customize->add_setting( 'burf_setting_footer[text]', array(
		'default'    => '',
		'capability' => 'edit_theme_options',
		'type'       => 'option',
	) );

	$wp_customize->add_setting( 'burf_setting_footer[autop]', array(
		'default'    => '',
		'capability' => 'edit_theme_options',
		'type'       => 'option',
	) );

	// Core <textarea> type added in WP 4.0
	$footer_info_args = array(
		'label'    => 'Additional Information',
		'section'  => 'burf_section_footer',
		'settings' => 'burf_setting_footer[text]',
		'type'     => 'textarea',
	);
	if ( version_compare( $GLOBALS['wp_version'], '4.0', '<' ) ) {
		$wp_customize->add_control( new BURF_Customize_Textarea( $wp_customize, 'burf_section_footer_info', $footer_info_args ) );
	} else {
		$wp_customize->add_control( 'burf_section_footer_info', $footer_info_args );
	}

	$wp_customize->add_control( 'burf_section_footer_autop', array(
		'label'    => 'Automatically add paragraphs',
		'section'  => 'burf_section_footer',
		'settings' => 'burf_setting_footer[autop]',
		'type'     => 'checkbox',
	) );
}

add_action( 'customize_register', 'responsive_customize_register' );

/**
 * Output an Underscore template for generating CSS for the color scheme.
 *
 * The template generates the css dynamically for instant display in the Customizer
 * preview.
 */
function responsive_framework_color_scheme_template() {
	$colors = array();
	foreach ( responsive_customizer_color_regions() as $slug => $color ) {
		$colors[ $slug ] = "{{ data.$slug }}";
	}
	?>
	<script type="text/html" id="tmpl-responsive-framework-color-scheme">
		<?php echo responsive_framework_get_color_regions_css( $colors ); ?>
	</script>
	<?php
}

add_action( 'customize_controls_print_footer_scripts', 'responsive_framework_color_scheme_template' );

/**
 * Appends inline styles based on Customizer configuration.
 *
 * @todo  performance testing
 */
function responsive_customizer_styles() {

	// Child themes can't set colors / fonts via Customizer, so bail.
	if ( is_child_theme() ) {
		return;
	}

	$styles = '';

	// $font_palette = responsive_get_font_palette();
	// if ( $font_palette ) {
	// 	$fonts_css = file_get_contents( get_template_directory() . "/css/$font_palette.css" );
	// 	if ( $fonts_css ) {
	// 		$styles .= $fonts_css . PHP_EOL;
	// 	}
	// }

	$colors_css = responsive_get_color_scheme_css();
	if ( $colors_css ) {
		$styles .= $colors_css . PHP_EOL;
	}

	if ( ! empty( $styles ) ) {
		printf( '<style type="text/css" id="responsi-customizer-styles">%s</style>', $styles );
	}
}

if ( ! defined( 'RESPONSIVE_CUSTOMIZER_DISABLE' ) ) {
	add_action( 'wp_enqueue_scripts', 'responsive_customizer_styles' );
}
