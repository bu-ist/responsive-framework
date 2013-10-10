<?php

/**
 * General Notes and Information
 *
 * --
 *
 */

if ( ! defined( 'BU_NAVIGATION_SUPPORTED_DEPTH' ) ) define('BU_NAVIGATION_SUPPORTED_DEPTH', 2);
if ( ! defined( 'BU_SUPPORTS_UTILITY_NAV' ) ) define('BU_SUPPORTS_UTILITY_NAV', true);

//In order for the comment functionality to be enabled an option named _bu_supports_comments needs to be set to 1.
if ( ! defined( 'BU_SUPPORTS_COMMENTS' ) ) define('BU_SUPPORTS_COMMENTS', true);
if ( ! defined( 'BU_SUPPORTS_SEO' ) ) define('BU_SUPPORTS_SEO', true);
if ( ! defined( 'BU_SUPPORTS_ANNOUNCEMENT' ) ) define('BU_SUPPORTS_ANNOUNCEMENT', true);

if ( ! defined( 'BU_FLEXI_CONTENT_IMAGE_WIDTH' ) ) define('BU_FLEXI_CONTENT_IMAGE_WIDTH', 550);
if ( ! defined( 'BU_FLEXI_MED_IMAGE_WIDTH' ) ) define('BU_FLEXI_MED_IMAGE_WIDTH', 837);
if ( ! defined( 'BU_FLEXI_MAX_IMAGE_WIDTH' ) ) define('BU_FLEXI_MAX_IMAGE_WIDTH', 1000);

if ( ! defined( 'BU_FLEXI_LOGOTYPE' ) ) define('BU_FLEXI_LOGOTYPE', 'default');
if ( ! defined( 'BU_FLEXI_SIGNATURE' ) ) define('BU_FLEXI_SIGNATURE', 'default');
if ( ! defined( 'BU_FLEXI_NON_ENTITY' ) ) define('BU_FLEXI_NON_ENTITY', 'default');

// support display options for Flexi Basic but not for child themes
if ( ! defined('BU_FLEXI_DISPLAY_OPTIONS') ) {
	
	$wp_version = get_bloginfo('version'); // get_current_theme deprecated in 3.4+
	
	if (version_compare($wp_version, '3.4', '<')) {
		if (get_current_theme() === 'Flexi Basic') {
			define('BU_FLEXI_DISPLAY_OPTIONS', true);
		}
	} else {
		$theme = wp_get_theme();
		if ($theme->name === 'Flexi Basic') {
			define('BU_FLEXI_DISPLAY_OPTIONS', true);
		}
	}
}

define('BU_MOBILE_TOP_SIDEBAR', false);

/**
 * Include the flexi library. If using flexi outside of the BU CMS,
 * the flexi library needs to be copied into the theme directory.
 *
 */

if(defined('BU_INCLUDES_PATH')) {
	require_once(BU_INCLUDES_PATH . '/flexi/flexi-functions.php');
	require_once(BU_INCLUDES_PATH . '/flexi/announcements.php');
	require_once(BU_INCLUDES_PATH . '/flexi/branding.php');
	require_once(BU_INCLUDES_PATH . '/flexi/bu-calendar-widget-formats.php');
	require_once(BU_INCLUDES_PATH . '/flexi/bu-posts-widget-formats.php');
	require_once(BU_INCLUDES_PATH . '/flexi/bu-search.php' );
	require_once(BU_INCLUDES_PATH . '/flexi/calendar.php');
	require_once(BU_INCLUDES_PATH . '/flexi/comments.php');
	require_once(BU_INCLUDES_PATH . '/flexi/course-feed-templates.php');
	require_once(BU_INCLUDES_PATH . '/flexi/glossary.php');
	require_once(BU_INCLUDES_PATH . '/flexi/layout.php');
	require_once(BU_INCLUDES_PATH . '/flexi/profiles.php');
	require_once(BU_INCLUDES_PATH . '/flexi/non-branded.php');
} else {
	require_once('flexi/flexi-functions.php');
	require_once('flexi/announcements.php');
	require_once('flexi/branding.php');
	require_once('flexi/bu-calendar-widget-formats.php');
	require_once('flexi/bu-posts-widget-formats.php');
	require_once('flexi/bu-search.php');
	require_once('flexi/calendar.php');
	require_once('flexi/comments.php');
	require_once('flexi/course-feed-templates.php');
	require_once('flexi/glossary.php');
	require_once('flexi/layout.php');
	require_once('flexi/profiles.php');
	require_once('flexi/non-branded.php');
}

require_once('admin/admin.php');
require_once('admin/branding.php');
require_once('admin/non-branded-header.php');

if(bu_flexi_supports_announcements()) {
	if(defined('BU_INCLUDES_PATH')) {
		require_once(BU_INCLUDES_PATH . '/flexi/admin/announcement-metabox.php');
	} else {
		require_once('flexi/admin/announcement-metabox.php');
	}
}

// define('BU_FLEXI_DEBUG', true);

add_action('init', 'bu_flexi_register_sidebars');
add_action('bu_flexi_register_sidebars', 'bu_flexi_register_profile_sidebar');
add_action('bu_flexi_register_dynamic_footbars', 'bu_flexi_register_alternate_footbar');	
add_filter('dynamic_sidebar_params', array('BU_Flexi_Sidebar', 'sidebar_params'), 1, 1);
add_filter('sidebars_widgets', 'bu_flexi_limit_footbar_widgets', 10, 1);

/**
 * Define the default Flexi feature set
 *
 * Custom child themes can override these default features by
 * defining their own bu_flexi_setup function
 */
if( ! function_exists( 'bu_flexi_setup' ) ):

function bu_flexi_setup() {

	// Dynamic footbar meta box
	add_post_type_support( 'page', 'dynamic-footbars' );

	// Add support for the custom post type version of profile plugin
	add_theme_support( 'bu-profiles-post_type' );
	add_action( 'bu_flexi_above_profile_sidebar', 'bu_flexi_profile_sidebar_link' );

	// Default flexi multi-line style doesn't need the extra <p> tags
	remove_filter('bu_profile_detail_multi_line', 'wpautop');
	add_filter('bu_profile_detail_multi_line', 'nl2br');

	// Format definitions for news post widget, calendar and course feed plugins
	add_filter('bu_posts_widget_formats', 'bu_flexi_posts_widget_formats', 1, 1);
	add_filter('bu_calendar_widget_formats', 'bu_flexi_calendar_widget_formats', 12, 1);
	add_filter('bu_course_feeds_default_section_template', 'bu_flexi_section_template', 10, 1);
}

endif;

add_action( 'after_setup_theme', 'bu_flexi_setup' );

/* Allowed templates */
if(class_exists('AllowedTemplates')) {
	if(!isset($news_templates)) $news_templates = new AllowedTemplates();
	$news_templates->register(array('news.php'));

	if(!isset($profile_templates)) $profile_templates = new AllowedTemplates();
	$profile_templates->register(array('profiles.php'));

	if(!isset($banner_templates)) $banner_templates = new AllowedTemplates();
	$banner_templates->register(array('single.php', 'default', 'calendar.php', 'news.php', 'blank.php', 'window-width-blank.php', 'page-no-title.php', 'profiles.php' ));

	if(!isset($footbar_templates)) $footbar_templates = new AllowedTemplates();
	$footbar_templates->register(array('default', 'calendar.php', 'contact-us.php', 'news.php', 'blank.php', 'window-width-blank.php', 'page-no-title.php', 'profiles.php' ));
}


function bu_flexi_init() {

	wp_enqueue_script('jquery');

	if(function_exists('bu_register_banner_position')) {
		$page_width = bu_flexi_get_page_width();

		bu_register_banner_position('content-width', array(
				'label' => 'Content width',
				'hint' => sprintf('Banner will appear above the title in the content area and should be %d pixels wide.', BU_FLEXI_CONTENT_IMAGE_WIDTH),
				'default' => true
			));
		bu_register_banner_position('page-width', array(
			'label' => 'Page width',
			'hint' => sprintf('Banner will appear above the content and sidebars and should be %d pixels wide.', $page_width)
			));
		bu_register_banner_position('window-width', array(
			'label' => 'Full browser window width',
			'hint' => 'Banner area will appear above the content and sidebars, for use with scalable media such as Flash.'
			));
	}
	
	// allows for custom sharing display location by applying the flexi_sharing filter
	if(class_exists('Sharing_Service')) {
		add_filter('flexi_sharing', 'sharing_display');
	}
}

add_action('init', 'bu_flexi_init');


function bu_flexi_supports_utility_nav($enabled) {
	if(bu_flexi_get_size() == 'micro') return false;
	return $enabled;
}

add_filter('bu_supports_utility_nav', 'bu_flexi_supports_utility_nav', 10, 1);

function bu_flexi_register_profile_sidebar() {
	if( defined('BU_PROFILES_PLUGIN_ACTIVE') && BU_PROFILES_PLUGIN_ACTIVE ) {
		register_sidebar(array(
			'name' => 'Profile Sidebar',
			'id' => 'sidebar-profile',
			'before_widget' => '<div class="widget %2$s" id="%1$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widgettitle">',
			'after_title' => '</h2>'
		));
	}
	
}

function bu_flexi_register_alternate_footbar() {
	register_sidebar(array(
		'name' => 'Alternate Footbar',
		'id' => 'alternate-footbar',
		'description' => bu_flexi_get_footbar_description( 'alternate-footbar' ),
		'before_widget' => '<div class="widget_container"><div class="widget %2$s" id="%1$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>'
	));
}

function bu_flexi_profile_sidebar_link(){
	if( function_exists('bu_profile_archive_link')) {
		if( $link = bu_profile_archive_link(array('echo'=>false)) ) {
			echo '<p>' . $link . '</p>';
		}	
	}
}

?>
