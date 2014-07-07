<?php

require_once("responsive-functions.php");
require_once("flexi-functions/calendar.php");

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
		Admin CSS & JS
	- - - - - - - - - - - - - - - - - */
	function custom_admin_styles() {
	    wp_register_style( 'admin-stylesheet', get_bloginfo('stylesheet_directory') . '/admin/admin.css', '');
	    wp_register_script('theme-customizer', get_bloginfo('stylesheet_directory') . "/admin/theme-customizer.js");
	    
		wp_enqueue_style('admin-stylesheet');
		wp_enqueue_script('theme-customizer');
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

/* remove extra padding for captions */
add_filter('shortcode_atts_caption', 'fixExtraCaptionPadding');

function fixExtraCaptionPadding($attrs)
{
    if (!empty($attrs['width'])) {
        $attrs['width'] += 10;
    }
    return $attrs;
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
register_nav_menus(array(
	'primary' => 'Primary Menu',
	'utility' => 'Utility Navigation'
));



/* - - - - - - - - - - - - - - - - -
	Register All Scripts and Styles
- - - - - - - - - - - - - - - - - */
function bu_responsive_register_scripts(){
	wp_register_style('responsi styles', get_bloginfo('stylesheet_directory') . "/style.css");
	wp_register_script('responsi script', get_bloginfo('stylesheet_directory') . "/js/production.js");
	wp_register_script('responsi modernizer', get_bloginfo('stylesheet_directory') . "/js/vendor/modernizer.js");
}
add_action( 'init', 'bu_responsive_register_scripts' );


/* - - - - - - - - - - - - - - - - -
	Enque Header Scripts and Styles
- - - - - - - - - - - - - - - - - */
function bu_responsive_enqueue_header_scripts() {
	wp_enqueue_style('responsi styles');
	wp_enqueue_script('responsi modernizer');
}
add_action( 'wp_enqueue_scripts', 'bu_responsive_enqueue_header_scripts' );


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

function bu_responsive_register_sidebars(){
	if ( function_exists('register_sidebar') ){
		register_sidebar(array(
			'name'          => 'Right Content Area',
			'id'            => 'right-content-area',
			'description'   => 'Description',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' 	=> '</div>',
			'before_title' 	=> '<h3>',
			'after_title'	 => '</h3>',
		));
		
		register_sidebar(array(
			'name'          => 'Bottom Content Area',
			'id'            => 'bottom-content-area',
			'description'   => 'Description',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' 	=> '</div>',
			'before_title' 	=> '<h3>',
			'after_title'	 => '</h3>',
		));
	}
}
	
	

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




/* - - - - - - - - - - - - - - - - -
	Theme Customizer
- - - - - - - - - - - - - - - - - */
require_once("admin/theme-customizer.php");


/* - - - - - - - - - - - - - - - - -
	Course Feed Template
- - - - - - - - - - - - - - - - - */

function bu_flexi_course_template($template) {
	$template = <<<TPL
<div class="cf-course">
	<h4>{{title}}</h4>
	<p class="meta">{{college}} {{department}} {{course_num}} ({{credits}} credits)</p>
	<p>{{description}}</p>

	[bu-course-feed_section]
</div>
TPL;

	return $template;
}

add_filter('bu_course_feeds_default_course_template', 'bu_flexi_course_template', 10, 1);

function bu_flexi_section_template($template) {
	$template = <<<TPL
<em>{{section_id}}, {{date_start}} to {{date_end}} {{year}}</em><br />
<table>
	<tr>
		<th>Days</th>
		<th>Start</th>
		<th>End</th>
		<th>Type</th>
		<th>Bldg</th>
		<th>Room</th>
	</tr>
	[bu-course-feed_schedule]
</table>
TPL;
	return $template;
}



function bu_flexi_schedule_template($template) {
	$template = <<<TPL
<tr>
	<td>{{days}}</td>
	<td>{{time_start}}</td>
	<td>{{time_end}}</td>
	<td>{{type}}</td>
	<td>{{building}}</td>
	<td>{{room}}</td>
</tr>
TPL;

	return $template;
}

add_filter('bu_course_feeds_default_schedule_template', 'bu_flexi_schedule_template', 10, 1);


/* - - - - - - - - - - - - - - - - -
	BU Calendar Widget Formats
- - - - - - - - - - - - - - - - - */

function bu_flexi_calendar_widget_formats($formats) {

	unset($formats['plain']);
	unset($formats['big']);

	$formats['full-date'] = array(
		'label' => 'Full Date',
		'callback' => 'bu_flexi_calendar_full_date'
	);


	$formats['graphic'] = array(
		'label' => 'Graphic',
		'callback' => 'bu_calendar_widget_format_big'
	);

	return $formats;
}

function bu_flexi_calendar_full_date($events, $base_url, $calendar_id = null) {
	 $output = '';

	if ((is_array($events)) && (count($events) > 0)) {

			foreach ($events as $e) {
					$url = sprintf('%s?eid=%s', $base_url, urlencode($e['id']));
					if (!empty($e['oid'])) $url .= '&oid=' . urlencode($e['oid']);
					if (!empty($calendar_id)) $url .= '&cid=' . urlencode($calendar_id);

					if (isset($e['subscription_name'])) $url .= '&sub=' . urlencode($e['subscription_name']);

					$output .= sprintf('<li><span class="date">%s</span> <a href="%s"><span class="title">%s</span></a></li>', date('l, F j', $e['starts']), esc_url($url), $e['summary']);
					$output .= "\n";
			}
	}

	return $output;

}

add_filter('bu_calendar_widget_formats', 'bu_flexi_calendar_widget_formats', 12, 1);


/* - - - - - - - - - - - - - - - - -
	BU Post Widget Formats
- - - - - - - - - - - - - - - - - */

function bu_flexi_posts_widget_formats($formats) {

	unset($formats['date_title_excerpt']);

	$formats['title_date'] = array(
		'label' => 'title, date',
		'callback' => 'bu_flexi_title_date_callback',
		'supports_thumbnail' => true,
		'requires_commenting' => false
	);

	$formats['title_excerpt'] = array(
		'label' => 'title, excerpt',
		'callback' => 'bu_flexi_posts_widget_default_callback',
		'supports_thumbnail' => true,
		'requires_commenting' => false
	);

	$formats['title_date_excerpt'] = array(
		'label' => 'title, date, excerpt',
		'callback' => 'bu_flexi_posts_widget_default_callback',
		'supports_thumbnail' => true,
		'requires_commenting' => false
	);

	$formats['title_author_excerpt'] = array(
		'label' => 'title, author, excerpt',
		'callback' => 'bu_flexi_posts_widget_default_callback',
		'supports_thumbnail' => true,
		'requires_commenting' => false
	);

	$formats['title_date_comments_excerpt'] = array(
		'label' => 'title, date, comments, excerpt',
		'callback' => 'bu_flexi_posts_widget_default_callback',
		'supports_thumbnail' => true,
		'requires_commenting' => true
	);

	$formats['title_author_comments_excerpt'] = array(
		'label' => 'title, author, comments, excerpt',
		'callback' => 'bu_flexi_posts_widget_default_callback',
		'supports_thumbnail' => true,
		'requires_commenting' => true
	);

	return $formats;

}

function bu_flexi_title_date_callback($post, $args) {
	global $post;

	$output = '';
	$output .= '<section class="post">';
	if($args['show_thumbnail'] && function_exists('bu_get_thumbnail_src')) {
		$output .= bu_get_thumbnail_src($post->ID, array(
							'maxwidth' => 88,
							'maxheight' => 88,
							'classes' => 'thumb',
							'use_thumb' => true)
						);
	}
	$output .= sprintf('<h1><a href="%s" rel="bookmark">%s</a></h1>', get_permalink(), get_the_title());
	$output .= sprintf('<p class="meta"><span class="published">%s</span></p>', BU_PostList::post_date('F j, Y'));
	$output .= '</div>';
	return $output;
}

function bu_flexi_posts_widget_default_callback($post, $args) {
	global $post;

	$output = '';
	$meta = '';
	$output .= '<section class="post">';
	if($args['show_thumbnail'] && function_exists('bu_get_thumbnail_src')) {
		$output .= bu_get_thumbnail_src($post->ID, array(
							'maxwidth' => 260,
							'maxheight' => 260,
							'classes' => 'thumb',
							'use_thumb' => false)
						);
	}
	$output .= sprintf('<h1 class="headline"><a href="%s" rel="bookmark">%s</a></h1>', get_permalink(), get_the_title());

	switch($args['current_format']) {
		case 'title_date_excerpt':
			$output .= sprintf('<p class="meta"><span class="published">%s</span></p>', BU_PostList::post_date('F j, Y'));
		break;
		case 'title_author_excerpt':
			$output .= sprintf('<p class="meta"><span class="author">by %s</span></p>', get_the_author());
		break;
		case 'title_date_comments_excerpt':
			$output .= sprintf('<p class="meta"><span class="published">%s</span>  <span class="comment-counter"> <a href="%s" rel="nofollow"><strong>%s</strong> comments</a></span></p>',
				BU_PostList::post_date('F j, Y'), get_comments_link(), get_comments_number($post->ID));
		break;

		case 'title_author_comments_excerpt':
			$output .= sprintf('<p class="meta"><span class="author">by %s</span>  <span class="comment-counter">
				<a href="%s" rel="nofollow"><strong>%s</strong> comments</a></span></p>', get_the_author(),
				 get_comments_link(), get_comments_number($post->ID));
		break;
	}

	$output .= sprintf('<p class="excerpt">%s</p>', BU_PostList::get_post_excerpt(12));
	$output .= '</section>';
	return $output;
}


/* - - - - - - - - - - - - - - - - -
	BU Profiles
- - - - - - - - - - - - - - - - - */

/**
 * Display profile sidebar
 * 
 * @todo determine the best actions/filters to make available to theme devs
 * @todo determine appropriate markup to house the profile archive link
 * 
 * @param type $args 
 */
function bu_flexi_profile_sidebar( $args = array() ) {

	do_action('bu_flexi_above_profile_sidebar');
	
	if( is_active_sidebar( 'sidebar-profile' ) ) {
	
		// Profile widgets
		dynamic_sidebar('sidebar-profile');
	}
}

/* - - - - - - - - - - - - - - - - -
	Body_Class (For Customizer)
- - - - - - - - - - - - - - - - - */

add_filter('body_class','browser_body_class');

function browser_body_class($classes = '') {
	$fontPalette = get_option("burf_setting_fonts");
	$layoutSetting = get_option("burf_setting_layout");
	
	if($fontPalette) $classes[] = $fontPalette;
	if($layoutSetting) $classes[] = $layoutSetting;

	return $classes;
}


?>
