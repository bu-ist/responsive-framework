<?php

define('LOGO_GENERATOR_PLUGIN_VER', 1);
define('LOGO_GENERATOR_PLUGIN_TMP_DIR', '/afs/bu.edu/cwis/web/c/m/cms/tmp');
define('LOGO_GENERATOR_PLUGIN_TMP_DIR_URL', 'http://www.bu.edu/cms/tmp');

function branding_admin_menu()
{
	if (bu_flexi_is_official_site())
	{
		$page = add_theme_page(
			'Branding',
			'Branding',
			'manage_sites',
			'branding',
			'branding_admin_page');

		add_action("load-$page", 'branding_load_scripts');
		add_action("load-$page", 'branding_load_styles');

		if (wp_verify_nonce($_POST['branding-nonce'], 'branding-submit'))
		{
			branding_handle_input();
		}
	}
}
add_action('admin_menu', 'branding_admin_menu');

function branding_handle_input()
{
	$branding = html_entity_decode($_POST['branding'], ENT_QUOTES);
	$sitename = html_entity_decode(get_option('blogname'), ENT_QUOTES);
	$line1 = $line2 = '';
	
	switch($branding)
	{
		case 'logotype':
		case 'signature':
			$line1 = $sitename;
			break;

		case 'logotype-stacked':
			$line1 = stripslashes($_POST['parent-entity']);
			$line2 = $sitename;
			break;

		case 'non-entity':
			$line1 = stripslashes($_POST['sponsoring-entity']);
			$line2 = $sitename;
			break;
	}

	branding_make_logos($line1, $line2);
	update_option('_bu_branding', $branding);

	if (function_exists('invalidate_blog_cache'))
	{
		invalidate_blog_cache();
	}

	wp_redirect(admin_url('themes.php?page=branding&msg=1'));
}

function branding_load_scripts()
{
	wp_enqueue_script(
			'branding-admin',
			get_bloginfo('template_directory') . '/admin/interface/js/branding.js',
			array('jquery'),
			LOGO_GENERATOR_PLUGIN_VER,
			true
		);
}

function branding_load_styles()
{
	wp_enqueue_style(
			'branding-admin',
			get_bloginfo('template_directory') . '/admin/interface/css/branding.css',
			array(),
			LOGO_GENERATOR_PLUGIN_VER,
			'all'
		);
}

/**
 * Draw admin page.
 */
function branding_admin_page()
{
	$check_signature = $check_stacked = $check_non_entity = $check_logotype = '';
	$msg = '';

	if ($_GET['msg'] == 1)
	{
		$msg = '<div class="updated below-h2">Branding options have been updated and logos have been regenerated.</div>';
	}
	
	switch(get_option('_bu_branding'))
	{
		case 'logotype':
			$check_logotype = 'checked="checked"';
			break;

		case 'signature':
			$check_signature = 'checked="checked"';
			break;

		case 'logotype-stacked':
			$check_stacked = 'checked="checked"';
			break;
		
		case 'non-entity':
			$check_non_entity = 'checked="checked"';
			break;
	}
	
	require dirname(__FILE__) . '/interface/branding.php';
}

/**
 * Make logos.
 */
function branding_make_logos($line1, $line2)
{
	$wud = wp_upload_dir();
	$save_to = $wud['basedir'];
	
	require_once (BU_INCLUDES_PATH . '/flexi-logo-maker/flexi-logo-maker.php');
	BU_Flexi_Logo_Maker::create_all(compact('line1', 'line2', 'save_to'));
}

?>
