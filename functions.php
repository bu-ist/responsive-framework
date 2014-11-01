<?php

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

/* Theme Capabilities */
function bu_responsive_setup() {
	add_theme_support( 'menus' );
	add_theme_support( 'post-thumbnails' );

	// Specific sites must enable comments by setting the _bu_supports_comments option to 1
	add_theme_support( 'bu_comments' );

	add_post_type_support( 'page', 'excerpt' );
}

add_action( 'after_setup_theme', 'bu_responsive_setup' );

function bu_responsive_init() {

	if ( ! defined( 'BU_SUPPORTS_SEO' ) ) {
		define( 'BU_SUPPORTS_SEO', true );
	}

	/* Menus & Locations */
	register_nav_menus( array(
			'primary' => 'Primary Menu',
			'utility' => 'Utility Navigation',
		) );
}

add_action( 'init', 'bu_responsive_init' );

/* Banner Positions */
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

/* Allowed templates */
if ( class_exists( 'AllowedTemplates' ) ) {
	if ( ! isset( $banner_templates ) ) {
		$banner_templates = new AllowedTemplates();
	}

	$banner_templates->register( array( 'single.php', 'default', 'calendar.php', 'news.php', 'blank.php', 'window-width-blank.php', 'page-no-title.php', 'profiles.php', 'page-nosidebars.php' ) );

	if ( ! isset( $profile_templates ) ) {
		$profile_templates = new AllowedTemplates();
	}

	$profile_templates->register( array( 'profiles.php' ) );
}

/* - - - - - - - - - - - - - - - - -
  Register All Scripts and Styles
  - - - - - - - - - - - - - - - - - */

function bu_responsive_register_scripts() {
	global $wp_styles;

	$postfix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	// Main stylesheets (style.css, ie.css) will load from child theme directory.
	wp_register_style( 'responsi', get_stylesheet_directory_uri() . "/style$postfix.css", array(), RESPONSIVE_THEME_VERSION );
	wp_register_style( 'responsi-ie', get_stylesheet_directory_uri() . "/ie$postfix.css", array(), RESPONSIVE_THEME_VERSION );
	wp_register_style( 'responsi-fonts', '//cloud.typography.com/6127692/660644/css/fonts.css', array(), null );

	// Main script file (script.js) will load from child theme directory.
	wp_register_script( 'responsi', get_stylesheet_directory_uri() . "/js/script$postfix.js", array( 'jquery' ), RESPONSIVE_THEME_VERSION );

	// Vendor scripts will load from parent theme directory.
	wp_register_script( 'responsi-modernizer', get_template_directory_uri() . "/js/vendor/modernizer$postfix.js", array(), '2.8.3' );

	// Wraps IE stylesheet in conditional comments.
	$wp_styles->add_data( 'responsi-ie', 'conditional', '(lt IE 9) & (!IEMobile 7)' );
}

add_action( 'init', 'bu_responsive_register_scripts' );

/* - - - - - - - - - - - - - - - - -
  Enque Header Scripts and Styles
  - - - - - - - - - - - - - - - - - */

function bu_responsive_enqueue_header_scripts() {
	wp_enqueue_style( 'responsi-fonts' );
	wp_enqueue_style( 'responsi' );
	wp_enqueue_style( 'responsi-ie' );
	wp_enqueue_script( 'responsi-modernizer' );
}

add_action( 'wp_enqueue_scripts', 'bu_responsive_enqueue_header_scripts' );


/* - - - - - - - - - - - - - - - - -
  Enqueue Footer Scripts
  - - - - - - - - - - - - - - - - - */

function bu_responsive_footer_scripts() {
	wp_enqueue_script( 'responsi' );
}

add_action( 'wp_footer', 'bu_responsive_footer_scripts' );

/* - - - - - - - - - - - - - - - - -
  Sidebars
  - - - - - - - - - - - - - - - - - */

function bu_responsive_register_sidebars() {
	if ( function_exists( 'register_sidebar' ) ) {
		register_sidebar( array(
				'name' => 'Right Content Area',
				'id' => 'right-content-area',
				'description' => 'Description',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3>',
				'after_title' => '</h3>',
			) );

		register_sidebar( array(
				'name' => 'Bottom Content Area',
				'id' => 'bottom-content-area',
				'description' => 'Description',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3>',
				'after_title' => '</h3>',
			) );
	}
}

add_action( 'init', 'bu_responsive_register_sidebars' );

/* - - - - - - - - - - - - - - - - -
  Removes "uncategorized" and "private" from categories
  - - - - - - - - - - - - - - - - - */

function the_category_filter( $thelist, $separator = ' ' ) {
	if ( ! defined( 'WP_ADMIN' ) ) {
		//Category IDs to exclude
		$exclude = array( 1, 5 );

		$exclude2 = array();
		foreach ( $exclude as $c ) {
			$exclude2[] = get_cat_name( $c );
		}

		$cats = explode( $separator, $thelist );
		$newlist = array();
		foreach ( $cats as $cat ) {
			$catname = trim( strip_tags( $cat ) );
			if ( ! in_array( $catname, $exclude2 ) )
				$newlist[] = $cat;
		}
		return implode( $separator, $newlist );
	} else {
		return $thelist;
	}
}

add_filter( 'the_category', 'the_category_filter', 10, 2 );

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
 * Plugin support - BU Post Lists.
 *
 * @link http://bifrost.bu.edu/svn/repos/wordpress/plugins/bu-post-lists
 */
require __DIR__ . '/inc/post-lists.php';

/**
 * Plugin support - BU Profiles
 *
 * @link http://bifrost.bu.edu/svn/repos/wordpress/plugins/bu-profiles
 */
require __DIR__ . '/inc/profiles.php';

/**
 * Shortcodes for content editors.
 */
require __DIR__ . '/inc/shortcodes.php';

/**
 * Reusable template tags to keep templates logic-free.
 */
require __DIR__ . '/inc/template-tags.php';
