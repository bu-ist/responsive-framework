<?php



/**
 * @todo check to see if more than one layout is available based on the theme.
 * Is the theme's functions.php executed before plugins are loaded?
 * ** No, plugins are loaded first. -BG **
 */

function bu_flexi_admin() {
	if(!defined('BU_FLEXI_LAYOUT')) {
		$hook = add_theme_page('Flexi Framework Layout', 'Edit Layout', 'bu_edit_options', 'edit-flexi-layout', 'bu_flexi_layout_admin_page');
		add_action('admin_print_scripts-' . $hook, 'bu_flexi_scripts');
		add_action('admin_print_styles-' . $hook, 'bu_flexi_styles');
	}
	
	// allow themes to specify support, so custom themes don't get useless options page
	if (defined('BU_FLEXI_DISPLAY_OPTIONS') && BU_FLEXI_DISPLAY_OPTIONS) {
		add_theme_page('Flexi Framework Display Options', 'Display Options', 'bu_edit_options', 'flexi-display-options', 'bu_flexi_display_options_admin_page');
	}
}

add_action('admin_menu', 'bu_flexi_admin');

function bu_flexi_scripts() {
	wp_enqueue_script('flexi-layout', get_bloginfo('template_directory') . '/admin/interface/js/layout.js', array('jquery'));
}

function bu_flexi_styles() {
	wp_enqueue_style('flexi-layout', get_bloginfo('template_directory') . '/admin/interface/css/layout.css');
}

/**
 * Build admin page for the layout editor.
 *
 */


function bu_flexi_layout_admin_page() {
	global $current_site;

	$current_layout = bu_flexi_get_layout();
	$current_footbar_layouts = bu_flexi_get_footbar_layouts();
	$main_footbar = $current_footbar_layouts['footbar'];
	$enable_footbars = bu_flexi_supports_dynamic_footbars();
	$purge_cache = false;

	$messages = array();
	$messages[0] = 'The layout has not been changed.';
	$messages[1] = 'Layout has been updated.';

	$width = ( isset($_POST['width'] ) ) ? strip_tags($_POST['width']) : null;
	$sidebar = ( isset($_POST['sidebar'] ) ) ? strip_tags($_POST['sidebar']) : null;
	$footbars = ( isset($_POST['footbar'] ) ) ?  array_map( 'strip_tags', $_POST['footbar'] ) : null;

	// Check boxes
	if( isset( $_POST['submit'] ) ) {
		$enable_multi_footbars = ( isset($_POST['enable_multi_footbars'] ) ) ? true : false;

		if( $enable_multi_footbars != $enable_footbars ) {
			$enable_footbars = $enable_multi_footbars;
			$multi_footbar_changed = update_option( 'bu_flexi_framework_dynamic_footbars', $enable_multi_footbars );;
			$purge_cache = true;
		}
	}

	if(!empty($width) || !empty($sidebar)) {
		if($width == 'micro') {
			$layout = $width . '_1col';
		} else {
			$layout = $width . '_' . $sidebar;
		}
		$updated_layout = update_option('bu_flexi_framework_layout', $layout);
		if($updated_layout) {
			$purge_cache = true;
			$current_layout = $layout;
			$message_id = 1;
		}
	}

	if(!empty($footbars)) {
		$footbar_updated = update_option('bu_flexi_framework_footbars', $footbars);
		if( $footbar_updated ) {
			$purge_cache = true;
			$message_id = 1;
			$current_footbar_layouts = $footbars;
		}
		$main_footbar = $current_footbar_layouts['footbar'];
	}

	if($updated_layout === false && $footbar_updated === false && $milti_footbar_changed === false) $message_id = 0;
	if($purge_cache && function_exists('invalidate_blog_cache')) invalidate_blog_cache();

	$matches = array();
	preg_match('/(.*?)_(.*)/', $current_layout, $matches);


	$current_width = $matches[1];
	$current_sidebar = $matches[2];

	include('interface/edit-layout.php');
}

/**
 * Options page for display. Currently just post-related options.
 */
function bu_flexi_display_options_admin_page() {
	
	$display_default = array(
		'cat' => 1,
		'tag' => 1,
		'author' => 0
	);
	
	$display_opts = get_option('flexi_display', $display_default);
	$msg = '';
	
	if (isset($_POST['flexi_display_options_nonce']) && 
			wp_verify_nonce($_POST['flexi_display_options_nonce'], 'flexi_display_options_nonce')) {
			
		if ( isset($_POST['flexi_display']) && is_array($_POST['flexi_display']) ) {
			$new_opts = $_POST['flexi_display'];
		} else {
			$new_opts = array();
		}

		// fill in any unchecked values with 0
		$new_opts = array_merge(array('cat' => 0, 'tag' => 0, 'author' => 0), $new_opts);

		$new_opts = array_map('intval', $new_opts);
		update_option('flexi_display', $new_opts);
		$display_opts = $new_opts;

		$msg = 'Display options updated.';
		
	}
	
	include 'interface/display-options.php';
	
}

function bu_is_production() {
	global $current_site;
	return in_array($current_site->domain, array('www.bu.edu', 'www.bumc.bu.edu'));
}


/**
 * Per page widget layout selection
 */

/**
 * Display registered footbar areas
 */
function bu_flexi_display_footbar_form( $post) {
	$dynamic_footbars = bu_flexi_get_dynamic_footbar_ids();
	$footbars = bu_flexi_get_footbars($dynamic_footbars);

	if( !empty( $footbars ) ) {
		$selected = bu_flexi_get_footbar_for_post($post->ID);
		include 'interface/footbar-form.php';
	}
}

function bu_flexi_footbar_metabox( $post_type, $post ) {
	global $footbar_templates;
	
	if( bu_flexi_supports_dynamic_footbars() && post_type_supports( $post_type, 'dynamic-footbars') ) {

		// Honor allowed templates for pages
		if( $post_type == 'page' ) {
			$page_template = get_post_meta( $post->ID, '_wp_page_template', true );
			if( ! $page_template ) $page_template = 'default';

			if( isset($footbar_templates) && ! $footbar_templates->is_registered($page_template) )
				return;	
		}
		
		add_meta_box( 'flexi-footbar', 'Footbar Display', 'bu_flexi_display_footbar_form', $post_type, 'side', 'core' );
	}
}

add_action( 'add_meta_boxes', 'bu_flexi_footbar_metabox', 10, 2 );

function bu_flexi_save_footbar_layout( $post_id, $post ) {
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		return;

	if( isset( $_POST['footbar_layout'] ) ) {

		$layout_choice = $_POST['footbar_layout'];
		$allowed_footbars = bu_flexi_get_dynamic_footbar_ids();
		
		if( $layout_choice == 'none' || in_array($layout_choice, $allowed_footbars ) )
			update_post_meta( $post_id, '_bu_flexi_framework_footbar', $layout_choice );
	}
}

add_action( 'save_post', 'bu_flexi_save_footbar_layout', 10, 2 );


/**
 * registering widget location needs to essentially wrap the capabilities of creating a widget area @see register_sidebar()
 */



/**
 * Switch to a sprite for layouts?
 */

/**
 * allow child themes to add footbars
 */



/** How do I handle race conditions?
 *
 *  idea #1: validate using ajax call to retrieve widget count.   if above threshold, throw dialog which sets hidden input to true.   (an agreement of sort.)
 *      if the count does not match and the user agreed throw error and don't save layout
 *
 *  How to handle multiple widget bars?
 *
 *
 *
 */



/**
 * Disable widgets that exceed the number of widgets designed to fit the horizontal column
 */


function bu_disable_widgets($max_count) {

}



function bu_widget_count($widget_area) {

}


?>
