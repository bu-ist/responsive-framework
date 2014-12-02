<?php
/**
 * Responsive Framework functions and theme setup
 */

/**
 * Framework version.
 */
define( 'RESPONSIVE_FRAMEWORK_VERSION', '1.0.0' );

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

	// Add support for the custom post type version of profile plugin.
	add_theme_support( 'bu-profiles-post_type' );

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
			'name'          => 'Footer Content Area',
			'id'            => 'footbar',
			'description'   => 'Add widgets here to appear in your footer.',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgetTitle">',
			'after_title'   => '</h3>',
		) );

}

add_action( 'widgets_init', 'responsive_sidebars' );

/**
 * Enqueue front-end scripts & styles.
 */
function responsive_enqueue_scripts() {
	$postfix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	// Branding fonts
	wp_enqueue_style( 'responsive-branding-fonts', '//cloud.typography.com/6127692/660644/css/fonts.css', array(), null );

	// Main script file (script.js) will load from child theme directory.
	wp_enqueue_script( 'responsive-scripts', get_stylesheet_directory_uri() . "/js/script$postfix.js", array( 'jquery' ), RESPONSIVE_THEME_VERSION, true );

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
 * Theme Customizer.
 */
require __DIR__ . '/admin/theme-customizer.php';

/**
 * BU branding support.
 */
require __DIR__ . '/inc/branding.php';

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
 * WP 4.1 Polyfills.
 * TODO: Remove post-4.1. upgrade.
 */
require __DIR__ . '/inc/polyfill.php';

/**
 * Plugin support - BU Post Lists.
 *
 * @link http://bifrost.bu.edu/svn/repos/wordpress/plugins/bu-post-lists
 */
require __DIR__ . '/inc/post-lists.php';

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
