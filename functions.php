<?php
/**
 * Responsive Framework functions and theme setup.
 *
 * @package Responsive_Framework
 */

/**
 * Framework version.
 */
define( 'RESPONSIVE_FRAMEWORK_VERSION', '2.0.0-dev' );

/**
 * Theme version.
 *
 * Child themes should define this constant.
 * Used to version theme assets (style.css, production.js, etc.).
 */
if ( ! defined( 'RESPONSIVE_THEME_VERSION' ) ) {
	define( 'RESPONSIVE_THEME_VERSION', RESPONSIVE_FRAMEWORK_VERSION );
}

/**
 * Modernizr version.
 *
 * This is automatically updated when Modernizr is upgraded using `grunt upgrade_modernizer`.
 * Used to version Modernizr assets.
 */
define( 'RESPONSIVE_MODERNIZR_VERSION', '3.5.0' );

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
			add_theme_support( 'post-thumbnails' );

			// Add support for branding plugin.
			add_theme_support( 'bu-branding' );

			// Add support for the custom post type version of profile plugin.
			add_theme_support( 'bu-profiles-post_type' );

			// Default flexi multi-line style doesn't need the extra <p> tags.
			remove_filter( 'bu_profile_detail_multi_line', 'wpautop' );
			add_filter( 'bu_profile_detail_multi_line', 'nl2br' );

			/*
			 * By default, comments are disabled for BU sites.
			 *
			 * Any site that wishes to support comments  must enable them by setting the `_bu_supports_comments` option to '1'.
			 *
			 * @see http://bifrost.bu.edu/svn/repos/wordpress/plugins/bu-comments
			 */
		if ( ! defined( 'BU_SUPPORTS_COMMENTS' ) ) {
			define( 'BU_SUPPORTS_COMMENTS', true );
		}

			// BU Post Details SEO support.
		if ( ! defined( 'BU_SUPPORTS_SEO' ) ) {
			define( 'BU_SUPPORTS_SEO', true );
		}

			// Disable BU Links Footer editor under Appearance menu.
			define( 'BU_DISABLE_FOOTER_EDITOR', true );

			// Only support one level of dropdowns by default.
			define( 'BU_NAVIGATION_SUPPORTED_DEPTH', 1 );

			// Custom menu locations.
			register_nav_menus( array(
				'footer'  => 'Footer Links',
				'social'  => 'Social Links',
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
					'hint'  => 'Banner will appear above the content and sidebars and should be 1130 pixels wide.',
				) );
				bu_register_banner_position( 'content-width', array(
					'label'   => 'Content width',
					'hint'    => 'Banner will appear above the title in the content area and should be 760 pixels wide.',
					'default' => true,
				) );
		}

			// Register supported templates for Content Banner and BU Profile plugins.
			// @TODO: Need to require from BU_INCLUDES.
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
	// Add support for dynamic footbars (e.g. alternate footbar).
	add_post_type_support( 'page', 'bu-dynamic-footbars' );

	// Make sure images are set to 'no link' by default.
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
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
	) );

	register_sidebar( array(
			'name'          => 'Posts Content Area',
			'id'            => 'posts',
			'description'   => 'Add widgets here for display on posts and archives. Only the first 2 widgets will appear.',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
	) );

	if ( defined( 'BU_PROFILES_PLUGIN_ACTIVE' ) ) {
		register_sidebar( array(
				'name'          => 'Profiles Content Area',
				'id'            => 'profiles',
				'description'   => 'Add widgets here for display on profile pages and archives. Only the first 2 widgets will appear.',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
		) );
	}

	register_sidebar( array(
			'name'          => 'Footbar',
			'id'            => 'footbar',
			'description'   => 'Add widgets here to appear in your footer.',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
	) );

	// Alternate footbar registration.
	if ( responsive_theme_supports_dynamic_footbars() || is_customize_preview() ) {
		register_sidebar( array(
				'name'          => 'Alternate Footbar',
				'id'            => 'alternate-footbar',
				'description'   => 'Add widgets here to appear in your footer.',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
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
	wp_enqueue_script( 'responsive-scripts', get_stylesheet_directory_uri() . "/js/script$postfix.js", apply_filters( 'r_script_dependencies', array( 'jquery' ) ), RESPONSIVE_THEME_VERSION, apply_filters( 'r_script_location', true ) );

	/**
	 * Filters whether Modernizr should be enqueued by the framework.
	 *
	 * False can be returned by child themes or plugins to load a custom Modernizr build.
	 *
	 * @since 2.0.0
	 *
	 * @param bool Default is to enqueue Modernizr.
	 */
	$enqueue_modernizr = apply_filters( 'r_enqueue_modernizr', true );

	if ( (bool) $enqueue_modernizr ) {
		wp_enqueue_script( 'modernizr', get_template_directory_uri() . "/js/vendor/modernizr$postfix.js", array(), RESPONSIVE_MODERNIZR_VERSION );
	}

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
 *
 * @param string        $old_name The old theme name.
 * @param bool|WP_Theme $old_theme false if the old theme does not exist, WP_Theme instance of the old theme if it does.
 */
function responsive_maybe_migrate_theme( $old_name, $old_theme = false ) {
	// Theme migrations require Site Manager > 4.0.
	if ( ! defined( 'BU_SITE_MANAGER_VERSION' ) || version_compare( BU_SITE_MANAGER_VERSION, '4.0', '<' ) ) {
		return;
	}

	if ( ! $old_theme ) {
		return;
	}

	$new_theme = wp_get_theme();

	if ( 'flexi-framework' === $old_theme->get_template() ) {
		require __DIR__ . '/inc/migration-helpers.php';
		error_log( sprintf( '[%s] Migrating from %s to %s...', __FUNCTION__, $old_theme->get_template(), $new_theme->get_template() ) );
		responsive_flexi_migration();
	}
}

add_action( 'after_switch_theme', 'responsive_maybe_migrate_theme', 1, 2 );

/**
 * Reset title tag for navigation.
 *
 * @param array   $attr BU Navigation item arguments. See bu_navigation_format_page().
 * @param WP_Post $page Post object currently being filtered.
 *
 * @return array Adjusted bu_navigation_filter_anchor_attrs filter attributes.
 */
function responsive_change_title_tag( $attr, $page ) {
	unset( $attr['title'] );
	$attr['title'] = 'Navigate to: ' . $page->navigation_label;
	return $attr;
}
add_filter( 'bu_navigation_filter_anchor_attrs', 'responsive_change_title_tag', 10, 2 );

/**
 * Checks if the current content is considered narrow.
 *
 * By default, this function returns true for the following:
 *
 * - Single profiles
 * - Single posts
 * - Single calendar events
 * - Profile archives
 * - Post archives
 *
 * @return bool Whether this is narrow content.
 */
function r_is_narrow_template() {
	$is_narrow_template = false;

	$sidebar_position = (string) get_option( 'burf_setting_sidebar_location', 'right' );

	if ( 'bottom' === $sidebar_position ) {
		$is_narrow_template = true;
	}

	// Check for single calendar events. These are always narrow.
	if ( ! $is_narrow_template && ! empty( $_GET['eid'] ) ) {
		$is_narrow_template = true;
	}

	$narrow_enabled = (bool) get_option( 'burf_setting_posts_sidebar_bottom', false );

	if ( ! $is_narrow_template && ! $narrow_enabled ) {
		return false;
	}

	/**
	 * Filters whether the blog page (post type archive) should be considered narrow.
	 *
	 * @since 2.0.0
	 *
	 * @param bool true Default for checking is_home() conditional.
	 */
	$blog_page_narrow = (bool) apply_filters( 'r_narrow_blog_page', true );

	if ( ! $is_narrow_template && $blog_page_narrow && is_home() ) {
		$is_narrow_template = true;
	}

	$single_post_types = array(
		'profile',
		'post',
	);

	/**
	 * Filters post types to consider narrow when is_singular() is true.
	 *
	 * @since 2.0.0
	 *
	 * @param array $narrow_single_post_types List of post types.
	 */
	$single_post_types = apply_filters( 'r_narrow_single_templates', $single_post_types );

	if ( ! $is_narrow_template && ! empty( $single_post_types ) && is_singular( (array) $single_post_types ) ) {
		$is_narrow_template = true;
	}

	$archive_post_types = array(
		'profile',
		'post',
	);

	/**
	 * Filters post types to consider narrow when is_post_type_archive() is true.
	 *
	 * @since 2.0.0
	 *
	 * @param array $archive_post_types List of post types.
	 */
	$archive_post_types = apply_filters( 'r_narrow_archive_templates', $archive_post_types );

	if ( ! $is_narrow_template && ! empty( $archive_post_types ) && is_post_type_archive( (array) $archive_post_types ) ) {
		$is_narrow_template = true;
	}

	$page_templates = array(
		'page-templates/news.php',
		'profiles.php',
	);

	/**
	 * Filters page templates to consider narrow when is_page_template() is true.
	 *
	 * @since 2.0.0
	 *
	 * @param array $page_templates List of page templates.
	 */
	$page_templates = apply_filters( 'r_narrow_page_templates', $page_templates );

	if ( ! $is_narrow_template && ! empty( $page_templates ) && is_page_template( (array) $page_templates ) ) {
		$is_narrow_template = true;
	}

	/**
	 * Filters the final result of checking for a narrow template.
	 *
	 * @since 2.0.0
	 *
	 * @param bool $is_narrow_template Whether this is a narrow template.
	 */
	$is_narrow_template = apply_filters( 'r_is_narrow_template', $is_narrow_template );

	return $is_narrow_template;
}

/**
 * Displays the classes for the main content container.
 *
 * @since 2.0.0
 *
 * @param string|array $class One or more classes to add to the class list.
 */
function r_content_container_class( $class = '' ) {
	$classes = array();

	if ( r_is_narrow_template() ) {
		$classes[] = 'content-container-narrow';
	} else {
		$classes[] = 'content-container';
	}

	if ( $class ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class );
		}
		$classes = array_merge( $classes, array_map( 'esc_attr', $class ) );
	} else {
		// Ensure that we always coerce class to being an array.
		$class = array();
	}

	/**
	 * Filters the list of CSS classes for the content container.
	 *
	 * @since 2.0.0
	 *
	 * @param array $classes An array of post classes.
	 * @param array $class   An array of additional classes added to the post.
	 */
	$classes = apply_filters( 'r_content_container_class', $classes, $class );

	if ( empty( $classes ) ) {
		return;
	}

	// Separates classes with a single space, collates classes for content container element.
	echo 'class="' . join( ' ', array_map( 'esc_attr', array_unique( $classes ) ) ) . '"';
}

/**
 * Admin.
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
 * WordPress galleries code.
 */
require __DIR__ . '/inc/class-responsive-galleries.php';

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
