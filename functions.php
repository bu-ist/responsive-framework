<?php
/**
 * Responsive Framework functions and theme setup
 */

/**
 * Framework version.
 */
define( 'RESPONSIVE_FRAMEWORK_VERSION', '0.9.1' );

/**
 * Theme version.
 *
 * Child themes should define this constant.
 * Used to version theme assets (style.css, production.js, etc.).
 */
if ( ! defined( 'RESPONSIVE_THEME_VERSION' ) ) {
	define( 'RESPONSIVE_THEME_VERSION', RESPONSIVE_FRAMEWORK_VERSION );
}

if ( ! function_exists( 'responsive_setup' ) ) :

/**
 * Sets up theme defaults and registers various core and plugin features.
 *
 * Child themes can re-define this function to customize setup configuration.
 */
function responsive_setup() {

	// Expose navigation menu UI.
	add_theme_support( 'menus' );

	// Expose Featured Images for posts.
	// TODO: Investigate removing in favor of BU Thumbnail
	add_theme_support( 'post-thumbnails' );

	// Enable excerpts for pages.
	// TODO: Investigate removing in favor of BU Page Summary
	add_post_type_support( 'page', 'excerpt' );

	// Specific sites must enable comments by setting the _bu_supports_comments option to 1
	add_theme_support( 'bu_comments' );

	// Add support for the custom post type version of profile plugin
	add_theme_support( 'bu-profiles-post_type' );

	// BU Post Details SEO support.
	if ( ! defined( 'BU_SUPPORTS_SEO' ) ) {
		define( 'BU_SUPPORTS_SEO', true );
	}

	// Custom menu locations.
	register_nav_menus( array(
			'primary' => 'Primary Menu',
			'utility' => 'Utility Navigation',
		) );

	// Content banner locations.
	if ( function_exists( 'bu_register_banner_position' ) ) {
		bu_register_banner_position( 'window-width', array(
				'label' => 'Full browser window width',
				'hint'  => 'Banner area will appear above the content and sidebars, for use with scalable media such as Flash.',
			) );
		bu_register_banner_position( 'page-width', array(
				'label' => 'Page width',
				'hint'  => 'Banner will appear above the content and sidebars and should be XY pixels wide.',
			) );
		bu_register_banner_position( 'content-width', array(
				'label'   => 'Content width',
				'hint'    => 'Banner will appear above the title in the content area and should be XY pixels wide.',
				'default' => true,
			) );
	}

	// Register supported templates for Content Banner and BU Profile plugins.
	// TODO: Need to require from BU_INCLUDES
	if ( class_exists( 'AllowedTemplates' ) ) {
		global $banner_templates, $profile_templates;

		if ( ! isset( $banner_templates ) ) {
			$banner_templates = new AllowedTemplates();
		}

		$banner_templates->register( array(
			'default',
			'page-templates/calendar.php',
			'page-templates/news.php',
			'page-templates/no-sidebars.php',
			'page-templates/profiles.php',
			'single.php',
			) );

		if ( ! isset( $profile_templates ) ) {
			$profile_templates = new AllowedTemplates();
		}

		$profile_templates->register( array(
			'page-templates/profiles.php'
			) );
	}

}

endif;

add_action( 'after_setup_theme', 'responsive_setup' );

/**
 * Register widget areas.
 */
function responsive_sidebars() {
	register_sidebar( array(
			'name'          => 'Right Content Area',
			'id'            => 'right-content-area',
			'description'   => 'Description',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		) );

	register_sidebar( array(
			'name'          => 'Bottom Content Area',
			'id'            => 'bottom-content-area',
			'description'   => 'Description',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		) );
}

add_action( 'widgets_init', 'responsive_sidebars' );

/**
 * Enqueue front-end scripts & styles.
 *
 * TODO: We are loading both the ie.css and style.css for IE <= 8. Fix.
 */
function responsive_scripts() {
	global $wp_styles;

	$postfix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	// Main stylesheets (style.css, ie.css) will load from child theme directory.
	wp_enqueue_style( 'responsi', get_stylesheet_directory_uri() . "/style$postfix.css", array(), RESPONSIVE_THEME_VERSION );
	wp_enqueue_style( 'responsi-ie', get_stylesheet_directory_uri() . "/ie$postfix.css", array(), RESPONSIVE_THEME_VERSION );
	wp_enqueue_style( 'responsi-fonts', '//cloud.typography.com/6127692/660644/css/fonts.css', array(), null );

	// Main script file (script.js) will load from child theme directory.
	wp_enqueue_script( 'responsi', get_stylesheet_directory_uri() . "/js/script$postfix.js", array( 'jquery' ), RESPONSIVE_THEME_VERSION, true );

	// Vendor scripts will load from parent theme directory.
	wp_enqueue_script( 'responsi-modernizer', get_template_directory_uri() . "/js/vendor/modernizer$postfix.js", array(), '2.8.3' );

	// Wraps IE stylesheet in conditional comments.
	$wp_styles->add_data( 'responsi-ie', 'conditional', '(lt IE 9) & (!IEMobile 7)' );

}

add_action( 'wp_enqueue_scripts', 'responsive_scripts' );

/**
 * Theme Customizer.
 */
require __DIR__ . '/admin/theme-customizer.php';

/**
 * Plugin support - BU Calendar.
 *
 * @link https://github.com/bu-ist/bu-calendar
 */
require __DIR__ . '/inc/calendar.php';

/**
 * Plugin support - Course Feeds.
 *
 * @link http://bifrost.bu.edu/svn/repos/wordpress/plugins/course-feeds
 */
require __DIR__ . '/inc/course-feeds.php';

/**
 * Extra core filters.
 */
require __DIR__ . '/inc/extras.php';

/**
 * Plugin support - BU Post Lists.
 *
 * @link http://bifrost.bu.edu/svn/repos/wordpress/plugins/bu-post-lists
 */
require __DIR__ . '/inc/post-lists.php';

/**
 * Theme settings API.
 */
require __DIR__ . '/inc/settings.php';

/**
 * Shortcodes for content editors.
 */
require __DIR__ . '/inc/shortcodes.php';

/**
 * Reusable template tags to keep templates logic-free.
 */
require __DIR__ . '/inc/template-tags.php';

/**
 * Upgrade routines for schema changes across versions.
 */
require __DIR__ . '/inc/upgrade.php';
