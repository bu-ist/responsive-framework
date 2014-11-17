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
		'choices' => array(
			'f1'   => 'Capita,Benton',
			'f2'   => 'Benton,Benton',
			'f3'   => 'Benton,Capita',
			'f4'   => 'Pressura,Benton',
			'f5'   => 'Stag,Benton',
		),
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

	// Social Links
	$wp_customize->add_setting( 'burf_setting_footer_social_fb', array(
		'default'    => '',
		'capability' => 'edit_theme_options',
		'type'       => 'option',
	) );

	$wp_customize->add_setting( 'burf_setting_footer_social_tw', array(
		'default'    => '',
		'capability' => 'edit_theme_options',
		'type'       => 'option',
	) );

	$wp_customize->add_setting( 'burf_setting_footer_social_ig', array(
		'default'    => '',
		'capability' => 'edit_theme_options',
		'type'       => 'option',
	) );

	$wp_customize->add_setting( 'burf_setting_footer_social_yt', array(
		'default'    => '',
		'capability' => 'edit_theme_options',
		'type'       => 'option',
	) );

	$wp_customize->add_setting( 'burf_setting_footer_social_li', array(
		'default'    => '',
		'capability' => 'edit_theme_options',
		'type'       => 'option',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'burf_section_footer_social_links_fb', array(
		'label'    => 'Facebook Link',
		'section'  => 'burf_section_footer',
		'settings' => 'burf_setting_footer_social_fb',
		'type'     => 'text',
	) ) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'burf_section_footer_social_links_tw', array(
		'label'    => 'Twitter Link',
		'section'  => 'burf_section_footer',
		'settings' => 'burf_setting_footer_social_tw',
		'type'     => 'text',
	) ) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'burf_section_footer_social_links_ig', array(
		'label'    => 'Instagram Link',
		'section'  => 'burf_section_footer',
		'settings' => 'burf_setting_footer_social_ig',
		'type'     => 'text',
	) ) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'burf_section_footer_social_links_yt', array(
		'label'    => 'YouTube Link',
		'section'  => 'burf_section_footer',
		'settings' => 'burf_setting_footer_social_yt',
		'type'     => 'text',
	) ) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'burf_section_footer_social_links_li', array(
		'label'    => 'LinkedIn Link',
		'section'  => 'burf_section_footer',
		'settings' => 'burf_setting_footer_social_li',
		'type'     => 'text',
	) ) );
}

add_action( 'customize_register', 'responsive_customize_register' );

function burf_customize_css() {
	$colors = explode( ',', get_option( 'burf_setting_colors' ) );
	$bg_color = get_option( 'burf_setting_background_color' );
	$bg_image = get_option( 'burf_setting_background_image' );
	$bg_repeat = get_option( 'burf_setting_background_repeat' );
	$bg_position = get_option( 'burf_setting_background_position' );
	$bg_attachment = get_option( 'burf_setting_background_attachment' );
	?>
	<style type="text/css">
		 /* heading colors */
		 h1,h2,h3,h4,h5,h6,
		 .sidebar h1,
		 .sidebar h1 a {
			color: <?php echo $colors[0]; ?>
		 }

		 /* accent text colors */
		 strong,
		 .sidebar h3,
		 .sidebar h3 a,
		 .sidebar a .day,
		 .footbar h3,
		 .footbar h3 a,
		 ul > li:before,
		 ol > li:before { color: <?php echo $colors[3]; ?> }

		 .default .date { background-color: <?php echo $colors[3]; ?> }

		 /* general text colors */
		 body, p, li,
		 .sidebar a,
		 .footbar a { color: <?php echo $colors[1]; ?> }

		 /* anchor colors */
		 a, .comment-counter a strong { color: <?php echo $colors[2]; ?> }

		 /* page background color */
		 .contentWrapper {
			background-color: <?php echo $bg_color; ?>;
			background-image: url(<?php echo $bg_image; ?>);
			background-repeat: <?php echo $bg_repeat; ?>;
			background-position: top <?php echo $bg_position; ?>;
			background-attachment: <?php echo $bg_attachment; ?>;
		 }
	</style>
	<?php
}

// add_action( 'wp_head', 'burf_customize_css' );
