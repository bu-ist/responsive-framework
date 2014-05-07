<?php

/* - - - - - - - - - - - - - - - - -
	Theme Capabilities  
- - - - - - - - - - - - - - - - - */
function bu_responsi_setup() {
	add_theme_support( 'menus' );
	add_theme_support('post-thumbnails');
	add_post_type_support('page', 'excerpt');
	
}

add_action( 'after_setup_theme', 'bu_responsi_setup' );



/* - - - - - - - - - - - - - - - - -
	Register All Scripts and Styles
- - - - - - - - - - - - - - - - - */
function bu_responsi_register_scripts(){
	wp_register_style('responsi styles', get_bloginfo('stylesheet_directory') . "/style.css");
	wp_register_script('responsi script', get_bloginfo('stylesheet_directory') . "/js/script.js");
}
add_action( 'init', 'bu_responsi_register_scripts' );

/* - - - - - - - - - - - - - - - - -
	Enque Header Scripts and Styles
- - - - - - - - - - - - - - - - - */
function bu_responsi_enqueue_header_scripts() {
	wp_enqueue_style('responsi styles');
}
add_action( 'wp_enqueue_scripts', 'bu_responsi_enqueue_header_scripts' );

/* - - - - - - - - - - - - - - - - -
	Enqueue Footer Scripts
- - - - - - - - - - - - - - - - - */
function bu_responsi_footer_scripts() {
	wp_enqueue_script('responsi script');
}
add_action('wp_footer', 'bu_responsi_footer_scripts');


/* - - - - - - - - - - - - - - - - -
	Sidebars 
- - - - - - - - - - - - - - - - - */
add_action('init', 'bu_responsi_register_sidebars');

function bu_responsi_register_sidebars(){
	if ( function_exists('register_sidebar') )
		register_sidebar(array(
			'before_widget' => '<aside>',
			'after_widget' => '</aside>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
	));
}






?>