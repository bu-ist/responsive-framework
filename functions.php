<?php
/**
 * Responsive Framework functions and theme setup
 */

/**
 * Framework version.
 */
define( 'RESPONSIVE_FRAMEWORK_VERSION', '1.5.9' );

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

	// Use HTML5 markup for WP provided components where supported.
	add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

	// Add support for branding plugin
	add_theme_support( 'bu-branding' );

	// Add support for the custom post type version of profile plugin.
	add_theme_support( 'bu-profiles-post_type' );

	// Add support for post thumbnails to deprecate BU Thumbnail in bu-post-details plugin.
	add_theme_support( 'post-thumbnails' );

	// Default flexi multi-line style doesn't need the extra <p> tags
	remove_filter( 'bu_profile_detail_multi_line', 'wpautop' );
	add_filter( 'bu_profile_detail_multi_line', 'nl2br' );

	// By default, comments are disabled for BU sites.
	// Any site that wishes to support comments  must enable them by setting the `_bu_supports_comments` option to '1'.
	// @see http://bifrost.bu.edu/svn/repos/wordpress/plugins/bu-comments
	if ( ! defined( 'BU_SUPPORTS_COMMENTS' ) ) {
		define( 'BU_SUPPORTS_COMMENTS', true );
	}

	// BU Post Details SEO support.
	if ( ! defined( 'BU_SUPPORTS_SEO' ) ) {
		define( 'BU_SUPPORTS_SEO', true );
	}

	// Disable BU Links Footer editor under Appearance menu
	define( 'BU_DISABLE_FOOTER_EDITOR', true );

	// Only support one level of dropdowns by default
	define('BU_NAVIGATION_SUPPORTED_DEPTH', 1);

	// Custom menu locations.
	register_nav_menus( array(
			'footer'  => 'Footer Links',
			'social'  => 'Social Links',
			'utility' => 'Utility Navigation',
		) );

	// Content banner locations.
	if ( function_exists( 'bu_register_banner_position' ) ) {
		bu_register_banner_position( 'windowWidth', array(
				'label' => 'Full browser window width',
				'hint'  => 'Banner area will appear above the content and sidebars, for use with scalable media such as Flash.',
			) );
		bu_register_banner_position( 'pageWidth', array(
				'label' => 'Page width',
				'hint'  => 'Banner will appear above the content and sidebars and should be 1130 pixels wide.',
			) );
		bu_register_banner_position( 'contentWidth', array(
				'label'   => 'Content width',
				'hint'    => 'Banner will appear above the title in the content area and should be 760 pixels wide.',
				'default' => true,
			) );
	}

	// Register supported templates for Content Banner and BU Profile plugins.
	// TODO: Need to require from BU_INCLUDES
	if ( class_exists( 'AllowedTemplates' ) ) {
		global $banner_templates, $profile_templates, $news_templates;

		if ( ! isset( $banner_templates ) ) {
			$banner_templates = new AllowedTemplates();
		}

		$banner_templates->register( apply_filters( 'responsive_banner_templates', array(
			'default',
			'page-templates/calendar.php',
			'page-templates/news.php',
			'page-templates/no-sidebars.php',
			'page-templates/profiles.php',
			'single.php',
			) ) );

		if ( ! isset( $profile_templates ) ) {
			$profile_templates = new AllowedTemplates();
		}

		$profile_templates->register( apply_filters( 'responsive_profile_templates', array(
			'page-templates/profiles.php'
			) ) );

		if ( ! isset( $news_templates ) ) {
			$news_templates = new AllowedTemplates();
		}

		$news_templates->register( apply_filters( 'responsive_news_templates', array(
			'page-templates/news.php'
			) ) );
	}

}

endif;

add_action( 'after_setup_theme', 'responsive_setup' );

/**
 * Theme-specific initialization logic
 */
function responsive_init() {
	// Add support for dynamic footbars (e.g. alternate footbar)
	add_post_type_support( 'page', 'bu-dynamic-footbars' );

	// Make sure images are set to 'no link' by default
	update_option( 'image_default_link_type', 'none' );
}

add_action( 'init', 'responsive_init' );

/**
 * Register widget areas.
 */
function responsive_sidebars() {
	register_sidebar( array(
			'name'          => 'Main Sidebar',
			'id'            => 'sidebar',
			'description'   => 'Add widgets here to appear in your sidebar.',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgetTitle">',
			'after_title'   => '</h3>',
		) );

	register_sidebar( array(
			'name'          => 'Posts Content Area',
			'id'            => 'posts',
			'description'   => 'Add widgets here for display on posts and archives. Only the first 2 widgets will appear.',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgetTitle">',
			'after_title'   => '</h3>',
		) );

	if ( defined( 'BU_PROFILES_PLUGIN_ACTIVE' ) ) {
		register_sidebar( array(
				'name'          => 'Profiles Content Area',
				'id'            => 'profiles',
				'description'   => 'Add widgets here for display on profile pages and archives. Only the first 2 widgets will appear.',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widgetTitle">',
				'after_title'   => '</h3>',
			) );
	}

	register_sidebar( array(
			'name'          => 'Footbar',
			'id'            => 'footbar',
			'description'   => 'Add widgets here to appear in your footer.',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgetTitle">',
			'after_title'   => '</h3>',
		) );

	// Alternate footbar registration
	if ( responsive_theme_supports_dynamic_footbars() || is_customize_preview() ) {
		register_sidebar( array(
				'name'          => 'Alternate Footbar',
				'id'            => 'alternate-footbar',
				'description'   => 'Add widgets here to appear in your footer.',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widgetTitle">',
				'after_title'   => '</h3>',
			) );
	}

}

add_action( 'widgets_init', 'responsive_sidebars' );

/**
 * Enqueue front-end scripts & styles.
 */
function responsive_enqueue_scripts() {
	$postfix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	// Main script file (script.js) will load from child theme directory.
	wp_enqueue_script( 'responsive-scripts', get_stylesheet_directory_uri() . "/js/script$postfix.js", apply_filters( 'r_script_dependencies', array( 'jquery' ) ), RESPONSIVE_THEME_VERSION, true );

	// Vendor scripts will load from parent theme directory.
	wp_enqueue_script( 'responsive-modernizer', get_template_directory_uri() . "/js/vendor/modernizer$postfix.js", array(), '2.8.3' );

	// Enqueue core script responsible for inline comment replies if the current site / post supports it.
	if ( is_singular() && responsive_has_comment_support() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'responsive_enqueue_scripts' );

/**
 * Print main theme stylesheet with IE fallback.
 *
 * Works for both parent and child themes.
 */
function responsive_styles() {
	$suffix    = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	$style_css = add_query_arg( 'ver', RESPONSIVE_THEME_VERSION, get_stylesheet_directory_uri() . "/style$suffix.css" );
	$ie_css    = add_query_arg( 'ver', RESPONSIVE_THEME_VERSION, get_stylesheet_directory_uri() . "/ie$suffix.css" );
?>
	<!--[if gt IE 8]><!-->
	<link rel="stylesheet" id="responsi-css"  href="<?php echo esc_url( $style_css ); ?>" type="text/css" media="all" />
	<!--<![endif]-->
	<!--[if (lt IE 9) & (!IEMobile 7)]>
	<link rel="stylesheet" id="responsi-ie-css"   href="<?php echo esc_url( $ie_css ); ?>" type="text/css" media="all" />
	<![endif]-->
<?php
}

/**
 * Maybe trigger theme migration procedure.
 */
function responsive_maybe_migrate_theme( $old_name, $old_theme = false ) {
	// Theme migrations require Site Manager > 4.0
	if ( ! defined( 'BU_SITE_MANAGER_VERSION' ) || version_compare( BU_SITE_MANAGER_VERSION, '4.0', '<' ) ) {
		return;
	}

	if ( ! $old_theme ) {
		return;
	}

	$new_theme = wp_get_theme();

	if ( 'flexi-framework' == $old_theme->get_template() ) {
		require __DIR__ . '/inc/migration-helpers.php';
		error_log( sprintf( '[%s] Migrating from %s to %s...', __FUNCTION__, $old_theme->get_template(), $new_theme->get_template() ) );
		responsive_flexi_migration();
	}
}

add_action( 'after_switch_theme', 'responsive_maybe_migrate_theme', 1, 2 );

/**
 * Reset title tag for navigation
 */
function responsive_change_title_tag($attr, $page) {
	unset( $attr['title'] );
	$attr['title'] = 'Navigate to: ' . $page->navigation_label;
	return $attr;
}
add_filter( 'bu_navigation_filter_anchor_attrs', 'responsive_change_title_tag', 10, 2 );



/**
 * Custom GF Events for Summer Term
 * Move events to st_functions.php for prod
 */
add_filter( 'gform_notification_events', 'add_event' );
function add_event( $notification_events ) {
    $notification_events['payment_updated'] = __( 'Payment Updated', 'gravityforms' );
    return $notification_events;
}
include 'st_functions.php';
include 'rise_program_functions.php';
include 'hsh_program_functions.php';

/**
 * Admin
 */
if ( is_admin() ) {
	require __DIR__ . '/admin/admin.php';
}

/**
 * Theme Customizer.
 */
require __DIR__ . '/admin/theme-customizer.php';

/**
 * BU branding support.
 */
require __DIR__ . '/inc/branding.php';

/**
 * BUniverse support.
 */
require __DIR__ . '/inc/buniverse.php';

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
 * Customizer settings API.
 */
require __DIR__ . '/inc/customizer.php';

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
 * Plugin support - BU Sharing.
 *
 * @link http://github.com/bu-ist/bu-sharing
 */
require __DIR__ . '/inc/sharing.php';

/**
 * Plugin support - BU CMS/Search Form
 *
 * @link http://github.com/bu-ist/bu-cms
 */
require __DIR__ . '/inc/search-form.php';

/**
 * Reusable template tags to keep templates logic-free.
 */
require __DIR__ . '/inc/template-tags.php';

/**
 * Upgrade routines for schema changes across versions.
 */
require __DIR__ . '/inc/upgrade.php';

/**
 * WP-CLI commands.
 */
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require __DIR__ . '/inc/wp-cli.php';
}

/**
 * Deprecated functions for backwards compatibility.
 */
require __DIR__ . '/inc/deprecated.php';
