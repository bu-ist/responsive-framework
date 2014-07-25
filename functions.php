<?php

require_once("responsive-functions.php");

if(!is_child_theme()){
	require_once("admin/theme-customizer.php");
}

require_once("flexi-functions/calendar.php");
require_once("flexi-functions/formats-and-templates.php");


function bu_responsive_init() {
	
	/* Theme Capabilities */
	function bu_responsive_setup() {
	    add_theme_support('menus');
	    add_theme_support('post-thumbnails');
	    add_post_type_support('page', 'excerpt');
	}
	add_action('after_setup_theme', 'bu_responsive_setup');

	if ( ! defined( 'BU_SUPPORTS_SEO' ) ) define('BU_SUPPORTS_SEO', true);
	

	
    
	/* Menus & Locations */
	register_nav_menus(array(
	    'primary' => 'Primary Menu',
	    'utility' => 'Utility Navigation'
	));
}

add_action('init', 'bu_responsive_init');

/* Banner Positions */
if (function_exists('bu_register_banner_position')) {
    bu_register_banner_position('window-width', array(
        'label' => 'Full browser window width',
        'hint' => 'Banner area will appear above the content and sidebars, for use with scalable media such as Flash.'
    ));
    bu_register_banner_position('page-width', array(
        'label' => 'Page width',
        'hint' => 'Banner will appear above the content and sidebars and should be XY pixels wide.'
    ));
    bu_register_banner_position('content-width', array(
        'label' => 'Content width',
        'hint' => 'Banner will appear above the title in the content area and should be XY pixels wide.',
        'default' => true
    ));
}


/* Allowed templates */
if (class_exists('AllowedTemplates')) {
    if (!isset($banner_templates))
        $banner_templates = new AllowedTemplates();
    $banner_templates->register(array('single.php', 'default', 'calendar.php', 'news.php', 'blank.php', 'window-width-blank.php', 'page-no-title.php', 'profiles.php'));
    
    if(!isset($profile_templates)) $profile_templates = new AllowedTemplates();
	$profile_templates->register(array('profiles.php'));
}




function video_func( $atts ) {
      $atts = shortcode_atts( array(
 	      'vid' => '',
 	      'id' => '',
 	      'class' => ''
      ), $atts );

	  $retstr = "<div id='" . $atts['id'] . "' class='responsive-video " . $atts['class'] . "'><div>";
	  $retstr .= "<iframe width='550' height='310' frameborder='0' src='http://www.bu.edu/buniverse/interface/embed/embed.html?v=" . $atts['vid'] . "'></iframe>";
	  $retstr .= "</div></div>";

      return($retstr);
}
add_shortcode('video', 'video_func');





/* - - - - - - - - - - - - - - - - -
  Register All Scripts and Styles
  - - - - - - - - - - - - - - - - - */

function bu_responsive_register_scripts() {
    wp_register_style('responsi styles', get_bloginfo('stylesheet_directory') . "/style.css");
    wp_register_script('responsi script', get_bloginfo('stylesheet_directory') . "/js/production.js");
    wp_register_script('responsi modernizer', if_child_path() . "/js/vendor/modernizer.js");
}

add_action('init', 'bu_responsive_register_scripts');


/* - - - - - - - - - - - - - - - - -
  Enque Header Scripts and Styles
  - - - - - - - - - - - - - - - - - */

function bu_responsive_enqueue_header_scripts() {
    wp_enqueue_style('responsi styles');
    wp_enqueue_script('jquery');
    wp_enqueue_script('responsi modernizer');
}

add_action('wp_enqueue_scripts', 'bu_responsive_enqueue_header_scripts');


/* - - - - - - - - - - - - - - - - -
  Enqueue Footer Scripts
  - - - - - - - - - - - - - - - - - */

function bu_responsive_footer_scripts() {  
    wp_enqueue_script('responsi script');
}

add_action('wp_footer', 'bu_responsive_footer_scripts');



/* - - - - - - - - - - - - - - - - -
  Sidebars
  - - - - - - - - - - - - - - - - - */
add_action('init', 'bu_responsive_register_sidebars');

function bu_responsive_register_sidebars() {
    if (function_exists('register_sidebar')) {
        register_sidebar(array(
            'name' => 'Right Content Area',
            'id' => 'right-content-area',
            'description' => 'Description',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => 'Bottom Content Area',
            'id' => 'bottom-content-area',
            'description' => 'Description',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));
    }
}


/* - - - - - - - - - - - - - - - - -
  Removes "uncategorized" and "private" from categories
  - - - - - - - - - - - - - - - - - */

function the_category_filter($thelist, $separator = ' ') {
    if (!defined('WP_ADMIN')) {
        //Category IDs to exclude  
        $exclude = array(1, 5);

        $exclude2 = array();
        foreach ($exclude as $c) {
            $exclude2[] = get_cat_name($c);
        }

        $cats = explode($separator, $thelist);
        $newlist = array();
        foreach ($cats as $cat) {
            $catname = trim(strip_tags($cat));
            if (!in_array($catname, $exclude2))
                $newlist[] = $cat;
        }
        return implode($separator, $newlist);
    } else {
        return $thelist;
    }
}

add_filter('the_category', 'the_category_filter', 10, 2);
?>
