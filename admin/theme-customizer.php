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
	wp_localize_script( 'responsi-customizer', 'responsiveColor', array( 'schemes' => responsive_get_color_schemes(), 'regions' => responsive_customizer_color_regions(), 'optional' => responsive_get_optional_color_regions() ) );
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
			'title'    => 'Layout',
			'priority' => 30,
		) );

		$wp_customize->add_setting( 'burf_setting_layout', array(
			'default'    => 'default',
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		) );

		$wp_customize->add_control( new BURF_Customize_Radio( $wp_customize, 'burf_setting_layout', array(
			'section'  => 'burf_section_layout',
			'settings' => 'burf_setting_layout',
			'type'     => 'radio',
			'choices'  => responsive_layout_options(),
		) ) );
	}

	// Fonts and colors are only useful for Framework
	if ( ! is_child_theme() && ! defined( 'RESPONSIVE_CUSTOMIZER_DISABLE' ) ) {

		// Fonts
		$wp_customize->add_section( 'burf_section_fonts', array(
			'title'    => 'Fonts',
			'priority' => 31,
		) );

		$wp_customize->add_setting( 'burf_setting_fonts', array(
			'default'        => 'f1',
			'capability'     => 'edit_theme_options',
			'type'           => 'option',
		) );

		$wp_customize->add_control( new BURF_Customize_Radio( $wp_customize, 'burf_setting_fonts', array(
			'section'  => 'burf_section_fonts',
			'settings' => 'burf_setting_fonts',
			'type'     => 'radio',
			'choices'  => responsive_font_options(),
		) ) );

		// Colors
		$wp_customize->remove_section( 'colors' );

		$wp_customize->add_panel( 'burf_panel_colors', array(
			'title'    => 'Colors',
			'priority' => 33,
		) );

		$wp_customize->add_section( 'burf_section_color_scheme', array(
			'title'    => 'Color Scheme',
			'panel'    => 'burf_panel_colors',
		) );

		$wp_customize->add_setting( 'burf_setting_color_scheme', array(
			'default'           => 'default',
			'sanitize_callback' => 'responsive_sanitize_color_scheme',
			'transport'         => 'postMessage',
			'type'              => 'option'
		) );

		$wp_customize->add_control( 'burf_setting_color_scheme', array(
			'label'    => 'Base Color Scheme',
			'section'  => 'burf_section_color_scheme',
			'type'     => 'select',
			'choices'  => responsive_get_color_scheme_choices(),
		) );

		// Add color picker for each customizable colo region
		$color_groups = responsive_customizer_color_region_groups();
		$regions = responsive_customizer_color_regions();
		$scheme = responsive_get_color_scheme();
		$active_settings = isset( $scheme['active'] ) ? $scheme['active'] : array();

		foreach ( $color_groups as $slug => $group ) {

			$wp_customize->add_section( "burf_section_custom_colors[$slug]", array(
				'title'           => $group['label'],
				'panel'           => 'burf_panel_colors',
				'active_callback' => function ( $control ) use ( $group ) {
					$excluded_layouts = isset( $group['layout_excludes'] ) ? $group['layout_excludes'] : array();
					if ( in_array( $control->manager->get_setting( 'burf_setting_layout' )->value(), $excluded_layouts ) ) {
						return false;
					} else {
						return true;
					}
				}
			) );

			$group_regions = wp_filter_object_list( $regions, array( 'group' => $slug ) );

			foreach ( $group_regions as $option => $colors ) {

				// Color picker
				$wp_customize->add_setting( "burf_setting_custom_colors[$option]", array(
					'default'           => $colors['default'],
					'sanitize_callback' => 'sanitize_hex_color',
					'transport'         => 'postMessage',
					'type'              => 'option',
				) );

				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "burf_setting_custom_colors[$option]", array(
					'label'       => $colors['label'],
					'description' => $colors['description'],
					'section'     => "burf_section_custom_colors[$slug]",
				) ) );

				// Disable toggle (for optional color regions)
				if ( $colors['optional'] && array_key_exists( $option, $active_settings ) ) {
					$wp_customize->add_setting( "burf_setting_active_color_regions[$option]", array(
						'default'           => $active_settings[ $option ],
						'transport'         => 'postMessage',
						'type'              => 'option',
					) );

					$wp_customize->add_control( "burf_setting_active_color_regions[$option]", array(
						'label'       => 'Use ' . $colors['label'] . '?',
						'section'     => "burf_section_custom_colors[$slug]",
						'type'        => 'checkbox',
					) );
				}
			}
		}
	}



	// Content Options
	$wp_customize->add_section( 'burf_section_content_options', array(
		'title'       => 'Content Options',
		'priority'    => 39,
	) );

	$wp_customize->add_setting( 'burf_setting_post_display_options', array(
		'default'    => array( 'categories', 'tags' ),
		'capability' => 'edit_theme_options',
		'type'       => 'option',
		) );

	$wp_customize->add_control(
		new BURF_Customize_Checkbox_Group(
			$wp_customize,
			'burf_setting_post_display_options',
			array(
				'label'       => 'Post Display Options',
				'section'     => 'burf_section_content_options',
				'description' => 'Change visibility of post meta fields. Note that the "News" page template has its own display options.',
				'choices'     => array(
					'categories' => 'Categories',
					'tags'       => 'Tags',
					'author'     => 'Author',
					)
			)
		)
	);






	// Sidebar Options
	$wp_customize->add_setting( 'burf_setting_sidebar_options', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'type'              => 'option'
	) );

	$sidebar_description = '';

	if ( defined( 'BU_RESPONSIVE_SIDEBAR_POSITION' ) || defined( 'BU_RESPONSIVE_POSTS_SIDEBAR_SHOW_BOTTOM' ) ) {
		$sidebar_description .= '<h3>Options set by the theme:</h3>';
	}

	if ( defined( 'BU_RESPONSIVE_SIDEBAR_POSITION' ) ) {
		$sidebar_description .= '<p><strong>Main sidebar position</strong>: ' . BU_RESPONSIVE_SIDEBAR_POSITION . '</p>';
	}
	if ( defined( 'BU_RESPONSIVE_POSTS_SIDEBAR_SHOW_BOTTOM' ) ) {
		$sidebar_description .= '<p><strong>Keep posts and profiles sidebar on the bottom?</strong>: ' . BU_RESPONSIVE_POSTS_SIDEBAR_SHOW_BOTTOM . '</p>';
	}

	$wp_customize->add_control(
		new BURF_Customize_Checkbox_Group(
			$wp_customize,
			'burf_setting_sidebar_options',
			array(
				'label'       => 'Sidebar Options',
				'section'     => 'burf_section_content_options',
				'description' => $sidebar_description,
				'choices'     => array(
					'dynamic_footbars' => 'Enable alternate footbar?',
				)
			)
		)
	);

	// Footer
	$menu_url = admin_url( 'nav-menus.php?action=locations' );
	$wp_customize->add_section( 'burf_section_footer', array(
		'title'       => 'Footer',
		'description' => "Footer links can be managed using the <a href=\"$menu_url\">Footer and Social Links Custom Menu locations</a>.",
		'priority'    => 34,
	) );

	// Additional Info (free-form textarea)
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


	/* Front Page H1 Display */
	$wp_customize->add_setting( 'burf_setting_hide_front_h1', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'type'              => 'option'
	) );

	$wp_customize->add_control(
		new BURF_Customize_Checkbox_Group(
			$wp_customize,
			'burf_setting_hide_front_h1',
			array(
				'label'       => 'Additional options',
				'section'     => 'static_front_page',
				'choices'     => array(
					'true' => 'Hide the homepage title',
				)
			)
		)
	);

	/* Main Sidebar Location */
	if ( ! defined( 'BU_RESPONSIVE_SIDEBAR_POSITION' ) ) {
		$wp_customize->add_setting( 'burf_setting_sidebar_location', array(
			'default'	=> 'right',
			'type'		=> 'option'
		) );

		$wp_customize->add_control( 'burf_setting_sidebar_location', array(
			'label'		=> 'Main Sidebar Position',
			'section'	=> 'burf_section_content_options',
			'description' => 'Changes the position of the main sidebar.',
			'type'		=> 'radio',
			'choices'	=> array(
				'bottom'=>	'Bottom',
				'left'	=>	'Left',
				'right'	=>	'Right'
			)
		) );
	}

	/* Posts Sidebar Location */
	if ( ! defined( 'BU_RESPONSIVE_POSTS_SIDEBAR_SHOW_BOTTOM' ) ) {
		$wp_customize->add_setting( 'burf_setting_posts_sidebar_bottom', array(
			'default' => true,
			'type'    => 'option',
		) );

		$wp_customize->add_control( 'burf_setting_posts_sidebar_bottom', array(
			'label'		=> 'Keep the posts sidebar on bottom',
			'section'	=> 'burf_section_content_options',
			'type'		=> 'checkbox'
		) );
	}
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
		$colors[ $slug ] = "{{ data['$slug'] }}";
	}
	?>
	<script type="text/html" id="tmpl-responsive-framework-color-scheme">
		<?php echo responsive_framework_get_color_regions_css( $colors, 'template' ); ?>
	</script>
	<?php
}

add_action( 'customize_controls_print_footer_scripts', 'responsive_framework_color_scheme_template' );

/**
 * Appends inline styles based on Customizer configuration.
 */
function responsive_customizer_styles() {

	// Child themes can't set colors / fonts via Customizer, so bail.
	if ( is_child_theme() ) {
		return;
	}

	// Inline styles are cached in a site option for production
	$use_cache = true;

	// Bypass cached styles during Customizer previews
	if ( is_customize_preview() ) {
		$use_cache = false;
	}

	echo responsive_get_customizer_styles( $use_cache );
}

if ( ! defined( 'RESPONSIVE_CUSTOMIZER_DISABLE' ) ) {
	add_action( 'wp_enqueue_scripts', 'responsive_customizer_styles' );
}
