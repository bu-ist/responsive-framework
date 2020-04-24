<?php
/**
 * Responsive Framework functions and theme setup.
 *
 * @package Responsive_Framework
 */

/**
 * Framework version.
 */
define( 'RESPONSIVE_FRAMEWORK_VERSION', '2.3.10' );

/**
 * Modernizr version.
 *
 * This is automatically updated when Modernizr is upgraded using `grunt upgrade_modernizer`.
 * Used to version Modernizr assets.
 */
if ( ! defined( 'RESPONSIVE_MODERNIZR_VERSION' ) ) {
	define( 'RESPONSIVE_MODERNIZR_VERSION', '3.7.1' );
}

/**
 * Get the version of the current theme.
 *
 * When a child theme is active, the RESPONSIVE_CHILD_THEME_VERSION will be
 * returned (if set in the child theme).
 *
 * When the RESPONSIVE_CHILD_THEME_VERSION constant is not set, the default
 * RESPONSIVE_FRAMEWORK_VERSION version will be returned.
 *
 * @return string Active Responsi theme version.
 */
function get_responsive_theme_version() {
	if ( defined( 'RESPONSIVE_CHILD_THEME_VERSION' ) && ! empty( RESPONSIVE_CHILD_THEME_VERSION ) ) {
		return RESPONSIVE_CHILD_THEME_VERSION;
	}

	return RESPONSIVE_FRAMEWORK_VERSION;
}

/**
 * `lightGallery` version.
 *
 * This is automatically updated when `lightGallery` is upgraded using `grunt update_lightgallery`.
 *
 * Used to version `lightGallery` assets.
 */
define( 'RESPONSIVE_LIGHTGALLERY_VERSION', '1.6.14' );

/**
 * `lg-thumbnail` version.
 *
 * This is automatically updated when `lg-thumbnail` is upgraded using `grunt update_lightgallery`.
 *
 * Used to version `lg-thumbnail` assets.
 */
define( 'RESPONSIVE_LG_THUMBNAIL_VERSION', '1.1.0' );

/**
 * Fires the before_responsive_setup action hook before any theme setup occurs.
 */
function responsive_setup_before() {
	/**
	 * Fires immediately before any theme setup occurs.
	 *
	 * @since 2.0.0
	 */
	do_action( 'before_responsive_setup' );
}
add_action( 'after_setup_theme', 'responsive_setup_before', 9 );

/**
 * Fires the after_responsive_setup action hook after theme setup occurs.
 */
function responsive_setup_after() {
	/**
	 * Fires immediately after theme setup occurs.
	 *
	 * @since 2.0.0
	 */
	do_action( 'after_responsive_setup' );
}
add_action( 'after_setup_theme', 'responsive_setup_after', 11 );

/**
 * Add default support for the following features:
 *
 * - Menus
 * - HTML5 comment forms.
 * - HTML5 comment lists.
 * - HTML5 galleries.
 * - HTML5 captions.
 * - Post thumbnails
 * - BU Branding
 * - BU Profiles
 */
function responsive_setup_theme_support() {
	add_theme_support( 'menus' );
	add_theme_support(
		'html5',
		array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'bu-branding' );
	add_theme_support( 'bu-profiles-post_type' );
}
add_action( 'after_setup_theme', 'responsive_setup_theme_support' );

/**
 * Ensure all needed constants are defined.
 */
function responsive_setup_constants() {
	/**
	 * By default, comments are disabled for BU sites.
	 *
	 * Any site that wishes to support comments must enable them by setting the `_bu_supports_comments` option to '1'.
	 *
	 * @see https://github.com/bu-ist/bu-comments
	 */
	if ( ! defined( 'BU_SUPPORTS_COMMENTS' ) ) {
		define( 'BU_SUPPORTS_COMMENTS', true );
	}

	// BU Post Details SEO support.
	if ( ! defined( 'BU_SUPPORTS_SEO' ) ) {
		define( 'BU_SUPPORTS_SEO', true );
	}

	// Disable BU Links Footer editor under Appearance menu.
	if ( ! defined( 'BU_DISABLE_FOOTER_EDITOR' ) ) {
		define( 'BU_DISABLE_FOOTER_EDITOR', true );
	}

	// Only support one level of dropdowns by default.
	if ( ! defined( 'BU_NAVIGATION_SUPPORTED_DEPTH' ) ) {
		define( 'BU_NAVIGATION_SUPPORTED_DEPTH', 1 );
	}
}
add_action( 'after_setup_theme', 'responsive_setup_constants' );

/**
 * Register navigation menu locations.
 */
function responsive_setup_nav_menus() {
	// Custom menu locations.
	register_nav_menus(
		array(
			'footer'  => __( 'Footer Links', 'responsive-framework' ),
			'social'  => __( 'Social Links', 'responsive-framework' ),
			'utility' => __( 'Utility Navigation', 'responsive-framework' ),
			'short'   => __( 'Short Navigation', 'responsive-framework' ),
		)
	);

	// When BU Navigation is not active, register a default primary navigation menu location.
	if ( ! function_exists( 'bu_navigation_display_primary' ) ) {
		register_nav_menu( 'responsive-primary', __( 'Primary Navigation', 'responsive-framework' ) );
	}
}
add_action( 'after_setup_theme', 'responsive_setup_nav_menus' );

/**
 * Setup miscellaneous filters.
 *
 * @codeCoverageIgnore
 */
function responsive_setup_misc_filters() {
	// Default flexi multi-line style doesn't need the extra <p> tags.
	remove_filter( 'bu_profile_detail_multi_line', 'wpautop' );
	add_filter( 'bu_profile_detail_multi_line', 'nl2br' );
}
add_action( 'after_setup_theme', 'responsive_setup_misc_filters' );

/**
 * Register News Post List templates.
 *
 * @codeCoverageIgnore
 */
function responsive_setup_news_templates() {
	// Register supported news templates for the BU Post Lists plugin.
	if ( ! class_exists( 'AllowedTemplates' ) ) {
		return;
	}

	global $news_templates;

	if ( ! isset( $news_templates ) ) {
		$news_templates = new AllowedTemplates();
	}

	/**
	 * Filters page templates that allow news posts to be listed.
	 *
	 * @since 2.0.0
	 *
	 * @param array Page templates.
	 */
	$theme_news_templates = apply_filters(
		'responsive_news_templates',
		array(
			'page-templates/news.php',
		)
	);

	$news_templates->register( $theme_news_templates );
}
add_action( 'after_setup_theme', 'responsive_setup_news_templates' );

/**
 * Add support to pages for Dynamic footbars (e.g. alternate footbars).
 */
function responsive_init() {
	add_post_type_support( 'page', 'bu-dynamic-footbars' );
}
add_action( 'init', 'responsive_init' );

/**
 * Register widget areas.
 */
function responsive_sidebars() {
	register_sidebar(
		array(
			'name'          => __( 'Main Sidebar', 'responsive-framework' ),
			'id'            => 'sidebar',
			'description'   => __( 'Add widgets here to appear in your sidebar.', 'responsive-framework' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Posts Content Area', 'responsive-framework' ),
			'id'            => 'posts',
			'description'   => __( 'Add widgets here for display on posts and archives. Only the first 2 widgets will appear.', 'responsive-framework' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	if ( defined( 'BU_PROFILES_PLUGIN_ACTIVE' ) ) {
		register_sidebar(
			array(
				'name'          => __( 'Profiles Content Area', 'responsive-framework' ),
				'id'            => 'profiles',
				'description'   => __( 'Add widgets here for display on profile pages and archives. Only the first 2 widgets will appear.', 'responsive-framework' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	register_sidebar(
		array(
			'name'          => __( 'Footbar', 'responsive-framework' ),
			'id'            => 'footbar',
			'description'   => __( 'Add widgets here to appear in your footer.', 'responsive-framework' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	// Alternate footbar registration.
	if ( responsive_theme_supports_dynamic_footbars() || is_customize_preview() ) {
		register_sidebar(
			array(
				'name'          => __( 'Alternate Footbar', 'responsive-framework' ),
				'id'            => 'alternate-footbar',
				'description'   => __( 'Add widgets here to appear in your footer.', 'responsive-framework' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

}
add_action( 'widgets_init', 'responsive_sidebars' );

/**
 * Display the bottom sidebar.
 */
function responsive_bottom_sidebar_display() {
	get_sidebar( 'bottom' );
}
add_action( 'r_after_closing_container_inner', 'responsive_bottom_sidebar_display' );

/**
 * Enqueue front-end scripts & styles.
 */
function responsive_enqueue_scripts() {

	$dependencies = array(
		'jquery',
	);

	/**
	 * Filters whether Modernizr should be enqueued by the framework.
	 *
	 * False can be returned by child themes or plugins to load a custom Modernizr build.
	 *
	 * @since 2.0.0
	 *
	 * @param bool Default is to enqueue Modernizr.
	 */
	$enqueue_modernizr = (bool) apply_filters( 'r_enqueue_modernizr', true );

	if ( $enqueue_modernizr ) {
		$dependencies[] = 'modernizr';

		/**
		 * Filters whether the Modernizr should be loaded in the footer.
		 *
		 * Default is false (no).
		 *
		 * @link https://github.com/Modernizr/Modernizr/issues/878#issuecomment-41448059
		 *
		 * @since 2.0.0
		 *
		 * @param bool Whether to load the script in the footer.
		 */
		$modernizr_in_footer = (bool) apply_filters( 'r_modernizr_in_footer', false );

		wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/vendor/modernizr.js', array(), RESPONSIVE_MODERNIZR_VERSION, $modernizr_in_footer );
	}

	/**
	 * Filter the responsive-scripts script dependencies.
	 *
	 * @since 2.0.0
	 *
	 * @param array Framework script dependencies.
	 */
	$dependencies = apply_filters( 'r_script_dependencies', $dependencies );

	/**
	 * Filters whether the main framework JavaScript file should be loaded in the footer.
	 *
	 * Default is true (yes).
	 *
	 * @since 2.0.0
	 *
	 * @param bool Whether to load the script in the footer.
	 */
	$script_in_footer = (bool) apply_filters( 'r_script_in_footer', true );

	// Main script file (script.js) will load from child theme directory.
	wp_enqueue_script( 'responsive-scripts', get_stylesheet_directory_uri() . '/js/script.js', $dependencies, get_responsive_theme_version(), $script_in_footer );

	// Enqueue core script responsible for inline comment replies if the current site / post supports it.
	if ( is_singular() && responsive_has_comment_support() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'responsive_enqueue_scripts' );

/**
 * Enqueue CSS files for the theme.
 */
function responsive_enqueue_styles() {
	$postfix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_style( 'responsive-framework', get_stylesheet_directory_uri() . "/style$postfix.css", array(), get_responsive_theme_version(), 'all' );

	wp_enqueue_style( 'responsive-framework-ie', get_stylesheet_directory_uri() . "/ie$postfix.css", array(), get_responsive_theme_version(), 'all' );
	wp_style_add_data( 'responsive-framework-ie', 'conditional', '(lt IE 9) & (!IEMobile 7)' );
}
add_action( 'wp_enqueue_scripts', 'responsive_enqueue_styles' );

/**
 * Add the correct IE conditional to the main theme stylesheet.
 *
 * WordPress supports adding IE conditionals as data attributes for enqueued styles.
 * It does not, however, allow you to specify a conditional that targets certain versions
 * of IE, AND other browsers (<!--[if gt IE 8]><!--> in our case). The extra comment tag
 * allows the stylesheet to be loaded by non-IE browsers.
 *
 * By using this filter, we can enqueue the theme's stylesheet and still load it to our needs.
 *
 * @param string $html   The link tag for the enqueued style.
 * @param string $handle The style's registered handle.
 *
 * @return string Unaltered HTML if not the Responsive Framework stylesheet,
 *                link tag wrapped in the correct IE conditional if it is.
 */
function responsive_style_loader_tag( $html, $handle ) {
	if ( 'responsive-framework' !== $handle ) {
		return $html;
	}

	$new_html  = "<!--[if gt IE 8]><!-->\n";
	$new_html .= $html;
	$new_html .= "<![endif]-->\n";

	return $new_html;
}
add_filter( 'style_loader_tag', 'responsive_style_loader_tag', 10, 2 );

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
	/* translators: %s: navigation label navigating to. */
	$attr['title'] = sprintf( esc_html__( 'Navigate to: %s', 'responsive-framework' ), esc_html( $page->navigation_label ) );
	return $attr;
}
add_filter( 'bu_navigation_filter_anchor_attrs', 'responsive_change_title_tag', 10, 2 );

/**
 * Checks if the current content is considered narrow.
 *
 * By default, this function returns true for the following:
 *
 * - Single profiles.
 * - Single posts.
 * - Single calendar events.
 * - Profile archives.
 * - Post archives.
 *
 * @return bool Whether this is narrow content.
 */
function r_is_narrow_template() {
	$is_narrow_template = false;

	if ( defined( 'BU_RESPONSIVE_POSTS_SIDEBAR_SHOW_BOTTOM' ) ) {
		if ( ! BU_RESPONSIVE_POSTS_SIDEBAR_SHOW_BOTTOM ) {
			return false;
		} else {
			$narrow_enabled = true;
		}
	} else {
		$narrow_enabled = (bool) get_option( 'burf_setting_posts_sidebar_bottom' );
	}

	if ( defined( 'BU_RESPONSIVE_SIDEBAR_POSITION' ) ) {
		$sidebar_position = BU_RESPONSIVE_SIDEBAR_POSITION;
	} else {
		$sidebar_position = (string) get_option( 'burf_setting_sidebar_location', 'right' );
	}

	if ( 'bottom' === $sidebar_position ) {
		$is_narrow_template = true;
	}

	// Check for single calendar events. These are always narrow.
	if ( ! $is_narrow_template && ! empty( $_GET['eid'] ) ) {
		$is_narrow_template = true;
	}

	if ( ( ! $is_narrow_template && ! $narrow_enabled ) ) {
		return false;
	}

	/**
	 * Filters whether the blog page (post type archive) should be considered narrow.
	 *
	 * Default is true, or yes.
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
 * Displays the classes for the HTML tag.
 *
 * @since 2.3.61
 *
 * @param string|array $class One or more classes to add to the class list.
 * @param boolean      $attribute Output classes with 'class' attribute.
 */
function responsive_html_class( $class = '', $attribute = true ) {
	$classes = array();

	$class   = r_prepare_passed_classes( $class );
	$classes = array_merge( $classes, array_map( 'esc_attr', $class ) );

	/**
	 * Filters the list of CSS classes for the HTML tag.
	 *
	 * @since 2.3.61
	 *
	 * @param array $classes HTML element classes.
	 * @param array $class   Additional classes added to the HTML element.
	 */
	$classes = apply_filters( 'r_html_class', $classes, $class );

	if ( empty( $classes ) ) {
		return;
	}

	if ( true === $attribute ) {
		// Separates classes with a single space, collates classes for the HTML element.
		echo 'class="' . join( ' ', array_map( 'esc_attr', array_unique( $classes ) ) ) . '"';
	} else {
		// Separates classes with a single space, collates classes for the HTML element
		// without the class attribute name.
		echo join( ' ', array_map( 'esc_attr', array_unique( $classes ) ) ) . ' ';
	}
}

/**
 * Displays the classes for the inner content container.
 *
 * @since 2.0.0
 *
 * @param string|array $class One or more classes to add to the class list.
 */
function r_container_inner_class( $class = '' ) {
	$classes = array();

	if ( r_is_narrow_template() ) {
		$classes[] = 'content-container-narrow';
	} else {
		$classes[] = 'content-container';
	}

	$class   = r_prepare_passed_classes( $class );
	$classes = array_merge( $classes, array_map( 'esc_attr', $class ) );

	/**
	 * Filters the list of CSS classes for the inner content container.
	 *
	 * @since 2.0.0
	 *
	 * @param array $classes Inner content container classes.
	 * @param array $class   Additional classes added to the inner content container.
	 */
	$classes = apply_filters( 'r_container_inner_class', $classes, $class );

	if ( empty( $classes ) ) {
		return;
	}

	// Separates classes with a single space, collates classes for the inner content container element.
	echo 'class="' . join( ' ', array_map( 'esc_attr', array_unique( $classes ) ) ) . '"';
}

/**
 * Displays the classes for the outer content container.
 *
 * @since 2.0.0
 *
 * @param string|array $class One or more classes to add to the class list.
 */
function r_container_outer_class( $class = '' ) {
	$classes = array(
		'content',
	);

	$class   = r_prepare_passed_classes( $class );
	$classes = array_merge( $classes, array_map( 'esc_attr', $class ) );

	/**
	 * Filters the list of CSS classes for the outer content container.
	 *
	 * @since 2.0.0
	 *
	 * @param array $classes Outer content container classes.
	 * @param array $class   Additional classes added to the outer content container.
	 */
	$classes = apply_filters( 'r_container_outer_class', $classes, $class );

	if ( empty( $classes ) ) {
		return;
	}

	// Separates classes with a single space, collates classes for the outer content container element.
	echo 'class="' . join( ' ', array_map( 'esc_attr', array_unique( $classes ) ) ) . '"';
}

/**
 * Returns or displays the classes for the page title.
 *
 * @since 2.1.1
 *
 * @param string|array $class One or more classes to add to the class list.
 * @param bool         $display Return or Echo classes. Set to true to echo.
 *
 * @return none | string $page_title_class The class attribute and list of classes.
 */
function r_page_title_class( $class = '', $display = false ) {

	if ( is_page_template( 'single-profile.php' ) ) {
		$classes[] = 'profile-single-name page-title';
	} else {
		$classes[] = 'page-title';
	}

	$class   = r_prepare_passed_classes( $class );
	$classes = array_merge( $classes, array_map( 'esc_attr', $class ) );

	/**
	 * Filters the list of CSS classes for the page title.
	 *
	 * @since 2.1.1
	 *
	 * @param array $classes Page title classes.
	 * @param array $class   Additional classes added to the page title.
	 */
	$classes = apply_filters( 'r_page_title_class', $classes, $class );

	if ( empty( $classes ) ) {
		return;
	}

	// Separates classes with a single space, collates classes for the page title element.
	$page_title_class = 'class="' . join( ' ', array_map( 'esc_attr', array_unique( $classes ) ) ) . '"';

	if ( $display ) {
		echo $page_title_class; // WPCS: XSS OK.
	} else {
		return $page_title_class;
	}
}

/**
 * Ensure the class argument for class attribute functions is always an array.
 *
 * @param string|array $class Element classes.
 *
 * @return array Element classes.
 */
function r_prepare_passed_classes( $class ) {
	if ( $class ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class );
		}
	} else {
		$class = array();
	}

	return $class;
}

/**
 * In BU Core, there is a filter on sanitize_html_class that strips underscores from HTML classes.
 *
 * This was added to preserve a legacy behavior that was changed in WordPress r17614.
 *
 * @since 2.0.0
 */
remove_filter( 'sanitize_html_class', 'bu_sanitize_html_class', 10 );

/**
 * Enqueue gallery scripts and styles.
 */
function r_enqueue_fancy_gallery() {
	wp_enqueue_script( 'responsive-framework-gallery' );
	wp_enqueue_style( 'lightgallery' );
}

/**
 * Remove the news template when BU_News_Page_Template does not exist.
 *
 * @param string[]     $templates Array of page templates. Keys are filenames,
 *                                values are translated names.
 * @param WP_Theme     $theme     the theme object.
 * @param WP_Post|null $post      The post being edited, provided for context, or null.
 *
 * @return array Page templates.
 */
function r_remove_news_template( $templates, $theme, $post ) {
	if ( isset( $templates['page-templates/news.php'] ) && ! class_exists( 'BU_News_Page_Template' ) ) {
		$template = get_page_template_slug( $post );

		if ( 'page-templates/news.php' !== $template ) {
			unset( $templates['page-templates/news.php'] );
		}
	}

	return $templates;
}

/**
 * Add Copyright for print purposes to footer.
 */
function responsive_branding_copyright() {
	?>
		<div class="bu_copyright u-visually-hidden">&copy; <?php date( 'Y' ); ?> Boston&nbsp;University. All&nbsp;rights&nbsp;reserved. www.bu.edu</div>
	<?php
}

add_action( 'r_after_footer_menus', 'responsive_branding_copyright' );

// add_filter( 'theme_page_templates', 'r_remove_news_template', 10, 3 );
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
 * Theme activation.
 */
require __DIR__ . '/inc/activation.php';

/**
 * BU branding support.
 */
require __DIR__ . '/inc/branding.php';

/**
 * BU Banners support.
 */
require __DIR__ . '/inc/bu-banners.php';

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
require __DIR__ . '/inc/bu-template-tags.php'; // BU enhancements to template-tags.
require __DIR__ . '/inc/template-tags.php';

/**
 * Templating hooks to offer flexibility in templating, adding content, etc.
 */
require __DIR__ . '/inc/template-hooks.php';

/**
 * Upgrade routines for schema changes across versions.
 */
require __DIR__ . '/inc/upgrade.php';

/**
 * WordPress galleries code.
 */
require __DIR__ . '/inc/galleries.php';

/**
 * Plugin Support - BU Profiles
 */
require __DIR__ . '/inc/profiles.php';

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
