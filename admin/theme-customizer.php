<?php
/**
 * This hides the Font / Color / Background Customizer panels and associated styles.
 *
 * @package Responsive_Framework\Customizer
 */

require_once __DIR__ . '/customizer-controls.php';

/**
 * Enqueue scripts and styles for customizer preview.
 */
function responsive_customizer_scripts() {
	wp_enqueue_style( 'responsi-admin', get_template_directory_uri() . '/admin/admin.css', array(), RESPONSIVE_FRAMEWORK_VERSION );
	wp_enqueue_script( 'responsi-customizer', get_template_directory_uri() . '/admin/theme-customizer.js', array( 'jquery', 'customize-controls', 'iris', 'underscore', 'wp-util' ), RESPONSIVE_FRAMEWORK_VERSION, true );
}
add_action( 'customize_controls_enqueue_scripts', 'responsive_customizer_scripts' );

/**
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 */
function responsive_framework_customizer_preview_scripts() {
	wp_enqueue_script( 'responsi-customize-preview', get_template_directory_uri() . '/admin/customize-preview.js', array( 'customize-preview' ), RESPONSIVE_FRAMEWORK_VERSION, true );
}
add_action( 'customize_preview_init', 'responsive_framework_customizer_preview_scripts' );

/**
 * Register customizer sections & controls.
 *
 * @param WP_Customize_Manager $wp_customize Current WP_Customize_Manager instance.
 */
function responsive_customize_register( $wp_customize ) {

	// Navigation Style.
	if ( ! defined( 'BU_RESPONSIVE_LAYOUT' ) ) {
		$wp_customize->add_section(
			'burf_navigation_style',
			array(
				'title'    => __( 'Navigation Style', 'responsive-framework' ),
				'priority' => 30,
			)
		);

		$wp_customize->add_setting(
			'burf_setting_layout',
			array(
				'default'    => responsive_get_layout_default(),
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			)
		);

		$wp_customize->add_control(
			new BURF_Customize_Radio(
				$wp_customize,
				'burf_setting_layout',
				array(
					'section'  => 'burf_navigation_style',
					'settings' => 'burf_setting_layout',
					'type'     => 'radio',
					'choices'  => responsive_layout_options(),
				)
			)
		);
	}

	// Fonts and colors are only useful for Framework.
	if ( ! is_child_theme() && ! defined( 'RESPONSIVE_CUSTOMIZER_DISABLE' ) ) {

		// Fonts.
		$wp_customize->add_section(
			'burf_section_fonts',
			array(
				'title'    => __( 'Fonts', 'responsive-framework' ),
				'priority' => 31,
			)
		);

		$wp_customize->add_setting(
			'burf_setting_fonts',
			array(
				'default'    => 'f1',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			)
		);

		$wp_customize->add_control(
			new BURF_Customize_Radio(
				$wp_customize,
				'burf_setting_fonts',
				array(
					'section'  => 'burf_section_fonts',
					'settings' => 'burf_setting_fonts',
					'type'     => 'radio',
					'choices'  => responsive_font_options(),
				)
			)
		);

		// Colors.
		$wp_customize->remove_section( 'colors' );

		$wp_customize->add_section(
			'burf_section_colors',
			array(
				'title'    => __( 'Colors', 'responsive-framework' ),
				'priority' => 33,
			)
		);

		$wp_customize->add_setting(
			'burf_setting_colors',
			array(
				'default'    => 'default',
				'capability' => 'edit_theme_options',
				'type'       => 'option',
			)
		);

		$wp_customize->add_control(
			new BURF_Customize_Radio(
				$wp_customize,
				'burf_setting_colors',
				array(
					'section'  => 'burf_section_colors',
					'settings' => 'burf_setting_colors',
					'type'     => 'radio',
					'choices'  => responsive_color_options(),
				)
			)
		);
	}

	// Content Options.
	$wp_customize->add_section(
		'burf_section_content_options',
		array(
			'title'    => __( 'Content Options', 'responsive-framework' ),
			'priority' => 39,
		)
	);

	$wp_customize->add_setting(
		'burf_setting_post_display_options',
		array(
			'default'    => array( 'categories', 'tags' ),
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		)
	);

	$wp_customize->add_control(
		new BURF_Customize_Checkbox_Group(
			$wp_customize,
			'burf_setting_post_display_options',
			array(
				'label'       => __( 'Post Display Options', 'responsive-framework' ),
				'section'     => 'burf_section_content_options',
				'description' => __( 'Change visibility of post meta fields. Note that the "News" page template has its own display options.', 'responsive-framework' ),
				'choices'     => array(
					'categories' => __( 'Categories', 'responsive-framework' ),
					'tags'       => __( 'Tags', 'responsive-framework' ),
					'author'     => __( 'Author', 'responsive-framework' ),
				),
			)
		)
	);

	// Sidebar Options.
	$wp_customize->add_setting(
		'burf_setting_sidebar_options',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		)
	);

	$sidebar_description = '';

	if ( defined( 'BU_RESPONSIVE_SIDEBAR_POSITION' ) || defined( 'BU_RESPONSIVE_POSTS_SIDEBAR_SHOW_BOTTOM' ) ) {
		$sidebar_description .= sprintf( '<h3>%s</h3>', esc_html__( 'Options set by the theme:', 'responsive-framework' ) );
	}

	if ( defined( 'BU_RESPONSIVE_SIDEBAR_POSITION' ) ) {
		$sidebar_description .= sprintf( '<p><strong>%s</strong>: %s</p>', esc_html__( 'Main sidebar position ', 'responsive-framework' ), BU_RESPONSIVE_SIDEBAR_POSITION );
	}
	if ( defined( 'BU_RESPONSIVE_POSTS_SIDEBAR_SHOW_BOTTOM' ) ) {
		$sidebar_description .= sprintf( '<p><strong>%s</strong>: %s</p>', esc_html__( 'Keep posts and profiles sidebar on the bottom?', 'responsive-framework' ), ( ( BU_RESPONSIVE_POSTS_SIDEBAR_SHOW_BOTTOM ) ? 'true' : 'false' ) );
	}

	$wp_customize->add_control(
		new BURF_Customize_Checkbox_Group(
			$wp_customize,
			'burf_setting_sidebar_options',
			array(
				'label'       => __( 'Sidebar Options', 'responsive-framework' ),
				'section'     => 'burf_section_content_options',
				'description' => $sidebar_description,
				'choices'     => array(
					'dynamic_footbars' => 'Enable alternate footbar?',
				),
			)
		)
	);

	// Footer.
	$menu_url = admin_url( 'customize.php?autofocus[section]=menu_locations' );
	$wp_customize->add_section(
		'burf_section_footer',
		array(
			'title'       => __( 'Footer', 'responsive-framework' ),
			/* translators: %s: menu url */
			'description' => sprintf( __( 'Footer links can be managed using the <a href="%s">Footer and Social Links Custom Menu locations</a>.', 'responsive-framework' ), esc_url( $menu_url ) ),
			'priority'    => 34,
		)
	);

	// Additional Info (free-form textarea).
	$wp_customize->add_setting(
		'burf_setting_footer[text]',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		)
	);

	$wp_customize->add_setting(
		'burf_setting_footer[autop]',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		)
	);

	// Core <textarea> type added in WP 4.0.
	$footer_info_args = array(
		'label'       => __( 'Custom HTML', 'responsive-framework' ),
		'section'     => 'burf_section_footer',
		'settings'    => 'burf_setting_footer[text]',
		'type'        => 'textarea',
		'description' => __( 'May be used to enter an address or contact information.', 'responsive-framework' ),
	);
	if ( version_compare( $GLOBALS['wp_version'], '4.0', '<' ) ) {
		$wp_customize->add_control( new BURF_Customize_Textarea( $wp_customize, 'burf_section_footer_info', $footer_info_args ) );
	} else {
		$wp_customize->add_control( 'burf_section_footer_info', $footer_info_args );
	}

	$wp_customize->add_control(
		'burf_section_footer_autop',
		array(
			'label'    => __( 'Automatically add paragraphs', 'responsive-framework' ),
			'section'  => 'burf_section_footer',
			'settings' => 'burf_setting_footer[autop]',
			'type'     => 'checkbox',
		)
	);

	// Front Page H1 Display.
	$wp_customize->add_setting(
		'burf_setting_hide_front_h1',
		array(
			'default'    => '',
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		)
	);

	$wp_customize->add_control(
		new BURF_Customize_Checkbox_Group(
			$wp_customize,
			'burf_setting_hide_front_h1',
			array(
				'label'   => __( 'Static page options', 'responsive-framework' ),
				'section' => 'static_front_page',
				'choices' => array(
					'true' => __( 'Hide the homepage title', 'responsive-framework' ),
				),
			)
		)
	);

	// Main Sidebar Location.
	if ( ! defined( 'BU_RESPONSIVE_SIDEBAR_POSITION' ) ) {
		$wp_customize->add_setting(
			'burf_setting_sidebar_location',
			array(
				'default' => 'right',
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			'burf_setting_sidebar_location',
			array(
				'label'       => __( 'Main Sidebar Position', 'responsive-framework' ),
				'section'     => 'burf_section_content_options',
				'description' => __( 'Changes the position of the main sidebar.', 'responsive-framework' ),
				'type'        => 'radio',
				'choices'     => array(
					'bottom' => 'Bottom',
					'left'   => 'Left',
					'right'  => 'Right',
				),
			)
		);
	}

	// Posts Sidebar Location.
	if ( ! defined( 'BU_RESPONSIVE_POSTS_SIDEBAR_SHOW_BOTTOM' ) ) {
		$wp_customize->add_setting(
			'burf_setting_posts_sidebar_bottom',
			array(
				'type' => 'option',
			)
		);

		$wp_customize->add_control(
			'burf_setting_posts_sidebar_bottom',
			array(
				'label'   => __( 'Keep the posts sidebar on bottom', 'responsive-framework' ),
				'section' => 'burf_section_content_options',
				'type'    => 'checkbox',
			)
		);
	}
}
add_action( 'customize_register', 'responsive_customize_register' );

/**
 * Appends inline styles based on Customizer configuration.
 */
function responsive_customizer_styles() {

	// Child themes can't set colors / fonts via Customizer, so bail.
	if ( is_child_theme() ) {
		return;
	}

	// Inline styles are cached in a site option for production.
	$use_cache = true;

	// Bypass cached styles during Customizer previews.
	if ( is_customize_preview() ) {
		$use_cache = false;
	}

	echo responsive_get_customizer_styles(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

if ( ! defined( 'RESPONSIVE_CUSTOMIZER_DISABLE' ) ) {
	/**
	 * Because the styles generated in the Customizer are not enqueued, there is no way to specify dependencies.
	 * The wp_head hook prints all enqueued styles and scripts at priorities 8 and 9, respectively.
	 * By using priority 10 here, we can guarantee that the Customizer generate styles are output after the default
	 * stylesheet is printed.
	 */
	add_action( 'wp_head', 'responsive_customizer_styles', 10 );
}
