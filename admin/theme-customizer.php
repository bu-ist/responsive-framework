<?php

// Child themes don't support Customizer.
if ( is_child_theme() ) {
	return;
}

require_once __DIR__ . '/customizer-controls.php';

/**
 * Enqueue scripts and styles for customizer preview.
 */
function responsive_customizer_scripts() {
	wp_enqueue_style( 'responsi-admin', get_template_directory_uri() . '/admin/admin.css', array(), RESPONSIVE_FRAMEWORK_VERSION );
	wp_enqueue_script( 'responsi-customizer', get_template_directory_uri() . '/admin/theme-customizer.js', array( 'jquery' ), RESPONSIVE_FRAMEWORK_VERSION );
}

add_action( 'customize_controls_enqueue_scripts', 'responsive_customizer_scripts' );

/**
 * Register customizer sections & controls.
 */
function responsive_customize_register( $wp_customize ) {

	// Layout
	$wp_customize->add_section( 'burf_section_layout', array(
		'title'    => __( 'Layout Options', 'burf' ),
		'priority' => 30,
	) );

	$wp_customize->add_setting( 'burf_setting_layout', array(
		'default'    => '',
		'capability' => 'edit_theme_options',
		'type'       => 'option',
	) );

	// Hide the layout options if the current theme is forcing a specific layout.
	if ( ! defined( 'BU_RESPONSIVE_LAYOUT' ) ) {
		$wp_customize->add_control( new BURF_Customize_Radio( $wp_customize, 'burf_section_layout', array(
			'section'        => 'burf_section_layout',
			'settings'       => 'burf_setting_layout',
			'type'           => 'radio',
			'choices'        => responsive_layout_options(),
		) ) );
	}

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
	$wp_customize->add_section( 'burf_section_colors', array(
		'title'    => __( 'Text Color Options', 'burf' ),
		'priority' => 32,
	) );

	$wp_customize->add_setting( 'burf_setting_colors', array(
		'default'    => '',
		'capability' => 'edit_theme_options',
		'type'       => 'option',
	) );

	$wp_customize->add_control( new BURF_Customize_Colors( $wp_customize, 'burf_section_colors', array(
		'label'       => 'Color Picker Setting',
		'section'     => 'burf_section_colors',
		'settings'    => 'burf_setting_colors',
		'type'        => 'radio',
		'choices' => array(
			'option1' => '#000000,#606060,#cc0000,#4a97a7',
			'option2' => '#000000,#414141,#0095e2,#f59a23',
			'option3' => '#4699d3,#000000,#e98900,#4699d3',
			'option4' => '#a6330a,#261514,#f77300,#aaaaaa',
			'option5' => '#cc0000,#685f5f,#cc0000,#685f5f',
			'option6' => '#ffffff,#909090,#0095e2,#f59a23',
		)
	) ) );

	// Background
	$wp_customize->add_section( 'burf_section_background', array(
		'title'    => __( 'Background Options', 'burf' ),
		'priority' => 33,
	) );

	$wp_customize->add_setting( 'burf_setting_background_color', array(
		'default'        => '',
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
	) );

	$wp_customize->add_control( new BURF_Customize_Background_Color( $wp_customize, 'burf_section_background_colors', array(
		'label'    => 'Background Setting',
		'section'  => 'burf_section_background',
		'settings' => 'burf_setting_background_color',
		'type'     => 'radio',
	) ) );

	$wp_customize->add_setting( 'burf_setting_background_image', array(
		'default'    => '',
		'capability' => 'edit_theme_options',
		'type'       => 'option',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'background', array(
		'label'      => __( 'Upload an image', 'burf' ),
		'section'    => 'burf_section_background',
		'settings'   => 'burf_setting_background_image',
	) ) );

	$wp_customize->add_setting( 'burf_setting_background_repeat', array(
		'default'        => '',
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
	) );

	$wp_customize->add_setting( 'burf_setting_background_position', array(
		'default'        => '',
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
	) );

	$wp_customize->add_setting( 'burf_setting_background_attachment', array(
		'default'        => '',
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
	) );

	$wp_customize->add_control( new BURF_Customize_Radio( $wp_customize, 'burf_background_repeat', array(
		'label'         => __( 'Background Repeat', 'burf' ),
		'section'       => 'burf_section_background',
		'settings'      => 'burf_setting_background_repeat',
		'choices' => array(
			'no-repeat' => 'None',
			'repeat'    => 'Tile',
			'repeat-x'  => 'Repeat Horizonally',
			'repeat-y'  => 'Repeat Vertically',
		)
	) ) );

	$wp_customize->add_control( new BURF_Customize_Radio( $wp_customize, 'burf_background_position', array(
		'label'      => __( 'Background Position', 'burf' ),
		'section'    => 'burf_section_background',
		'settings'   => 'burf_setting_background_position',
		'choices' => array(
			'left'   => 'Left',
			'right'  => 'Right',
			'center' => 'Center',
		)
	) ) );

	/* Control: Background Image Option: Attachment */
	$wp_customize->add_control( new BURF_Customize_Radio( $wp_customize, 'burf_background_attachment', array(
		'label'      => __( 'Background Attachment', 'burf' ),
		'section'    => 'burf_section_background',
		'settings'   => 'burf_setting_background_attachment',
		'choices' => array(
			'fixed'  => 'Fixed',
			'scroll' => 'Scroll',
		)
	) ) );

	// Footer
	$wp_customize->add_section( 'burf_section_footer', array(
		'title' => __( 'Footer Options', 'burf' ),
		'priority' => 34,
	) );

	// Contact Info
	$wp_customize->add_setting( 'burf_setting_footer_contact', array(
		'default'    => '',
		'capability' => 'edit_theme_options',
		'type'       => 'option',
	) );

	$wp_customize->add_control( new BURF_Customize_Textarea( $wp_customize, 'burf_section_footer', array(
		'label'    => 'Contact Information',
		'section'  => 'burf_section_footer',
		'settings' => 'burf_setting_footer_contact',
		'type'     => 'textarea',
	) ) );
}

add_action( 'customize_register', 'responsive_customize_register' );

function responsive_customize_colors_css() {
	$colors = explode( ',', get_option( 'burf_setting_colors' ) );
	$bg_color = get_option( 'burf_setting_background_color' );
	$bg_image = get_option( 'burf_setting_background_image' );
	$bg_repeat = get_option( 'burf_setting_background_repeat' );
	$bg_position = get_option( 'burf_setting_background_position' );
	$bg_attachment = get_option( 'burf_setting_background_attachment' );

	$css = <<<CSS
/* heading colors */
h1, h2, h3, h4, h5, h6,
.sidebar h1,
.sidebar h1 a {
	color: $colors[0]
}

/* accent text colors */
strong,
.sidebar h3,
.sidebar h3 a,
.sidebar a .day,
.footbar h3,
.footbar h3 a,
ul > li:before,
ol > li:before { color: $colors[3] }

.default .date { background-color: $colors[3] }

/* general text colors */
body, p, li,
.sidebar a,
.footbar a { color: $colors[1] }

/* anchor colors */
a, .comment-counter a strong { color: $colors[2] }


CSS;

	// Background image / color
	if ( $bg_image && $bg_color ) {
		$css .= <<<CSS
/* page background */
.contentWrapper {
	background-color: $bg_color;
	background-image: url($bg_image);
	background-repeat: $bg_repeat;
	background-position: top $bg_position;
	background-attachment: $bg_attachment;
}
CSS;
	} else if ( $bg_image ) {
		$css .= <<<CSS
/* page background */
.contentWrapper {
	background-image: url($bg_image);
	background-repeat: $bg_repeat;
	background-position: top $bg_position;
	background-attachment: $bg_attachment;
}
CSS;
	} else if ( $bg_color ) {
		$css .= <<<CSS
/* page background */
.contentWrapper {
	background-color: $bg_color;
}
CSS;
	}

	return $css;
}


/**
 * Appends inline styles based on Customizer configuration.
 *
 * @todo  performance testing
 */
function responsive_customize_fonts() {
	echo '<style type="text/css">';

	$font_palette = responsive_get_font_palette();
	if ( $font_palette ) {
		$fonts_css = file_get_contents( get_template_directory() . "/css/$font_palette.css" );
		if ( $fonts_css ) {
			echo esc_html( $fonts_css );
		}
	}

	$colors_css = responsive_customize_colors_css();
	if ( $colors_css ) {
		echo esc_html( $colors_css );
	}

	echo '</style>';
}

// add_action( 'wp_head', 'responsive_customize_fonts' );
