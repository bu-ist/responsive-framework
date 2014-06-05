<?php

require_once("responsive-functions.php");

function bu_responsive_init() {


	if(function_exists('bu_register_banner_position')) {
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
	
	
	
	/* - - - - - - - - - - - - - - - - -
		Admin CSS
	- - - - - - - - - - - - - - - - - */
	function custom_admin_styles() {
	    wp_register_style( 'admin-stylesheet', get_bloginfo('stylesheet_directory') . '/admin/admin.css', '');
		wp_enqueue_style('admin-stylesheet');
	}
	
	add_action( 'admin_enqueue_scripts', 'custom_admin_styles' );
	add_action( 'customize_controls_enqueue_scripts', 'custom_admin_styles' );
	
}

add_action('init', 'bu_responsive_init');


/* Allowed templates */
if(class_exists('AllowedTemplates')) {
	if(!isset($banner_templates)) $banner_templates = new AllowedTemplates();
	$banner_templates->register(array('single.php', 'default', 'calendar.php', 'news.php', 'blank.php', 'window-width-blank.php', 'page-no-title.php', 'profiles.php' ));
}


/* - - - - - - - - - - - - - - - - -
	Theme Capabilities  
- - - - - - - - - - - - - - - - - */
function bu_responsive_setup() {
	add_theme_support( 'menus' );
	add_theme_support('post-thumbnails');
	add_post_type_support('page', 'excerpt');
	
}

add_action( 'after_setup_theme', 'bu_responsive_setup' );

/* - - - - - - - - - - - - - - - - -
	Menus & Locations
- - - - - - - - - - - - - - - - - */
register_nav_menu( 'primary', 'Primary Menu' );



/* - - - - - - - - - - - - - - - - -
	Register All Scripts and Styles
- - - - - - - - - - - - - - - - - */
function bu_responsive_register_scripts(){
	wp_register_style('responsi styles', get_bloginfo('stylesheet_directory') . "/style.css");
	wp_register_script('responsi script', get_bloginfo('stylesheet_directory') . "/js/script.js");
}
add_action( 'init', 'bu_responsive_register_scripts' );


/* - - - - - - - - - - - - - - - - -
	Enque Header Scripts and Styles
- - - - - - - - - - - - - - - - - */
function bu_responsive_enqueue_header_scripts() {
	wp_enqueue_style('responsi styles');
}
add_action( 'wp_enqueue_scripts', 'bu_responsive_enqueue_header_scripts' );


/* - - - - - - - - - - - - - - - - -
	Enqueue Footer Scripts
- - - - - - - - - - - - - - - - - */
function bu_responsive_footer_scripts() {
	wp_enqueue_script('responsive script');
}
add_action('wp_footer', 'bu_responsive_footer_scripts');


/* - - - - - - - - - - - - - - - - -
	Sidebars 
- - - - - - - - - - - - - - - - - */
add_action('init', 'bu_responsive_register_sidebars');

function bu_responsive_register_sidebars(){
	if ( function_exists('register_sidebar') )
		register_sidebar(array(
			'name'          => 'Right Content Area',
			'id'            => 'right-content-area',
			'description'   => 'Description',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' 	=> '</div>',
			'before_title' 	=> '<h3>',
			'after_title'	 => '</h3>',
	));
	
	

/* - - - - - - - - - - - - - - - - -
	Widget Counts 
	// from http://wordpress.org/support/topic/how-to-first-and-last-css-classes-for-sidebar-widgets
- - - - - - - - - - - - - - - - - */

function widget_first_last_classes($params) {

	global $my_widget_num; // Global a counter array
	$this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
	$arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets	

	if(!$my_widget_num) {// If the counter array doesn't exist, create it
		$my_widget_num = array();
	}

	if(!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) { // Check if the current sidebar has no widgets
		return $params; // No widgets in this sidebar... bail early.
	}

	if(isset($my_widget_num[$this_id])) { // See if the counter array has an entry for this sidebar
		$my_widget_num[$this_id] ++;
	} else { // If not, create it starting with 1
		$my_widget_num[$this_id] = 1;
	}

	$class = 'class="widget-' . $my_widget_num[$this_id] . ' '; // Add a widget number class for additional styling options

	if($my_widget_num[$this_id] == 1) { // If this is the first widget
		$class .= 'widget-first ';
	} elseif($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) { // If this is the last widget
		$class .= 'widget-last ';
	}

	$params[0]['before_widget'] = preg_replace('/class=\"/', "$class", $params[0]['before_widget'], 1);

	return $params;

}
add_filter('dynamic_sidebar_params','widget_first_last_classes');
	
	
}



/* - - - - - - - - - - - - - - - - -
	Theme Customizer
- - - - - - - - - - - - - - - - - */
require_once("admin/theme-customizer.php");






?>
