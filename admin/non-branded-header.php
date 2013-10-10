<?php

define('FLEXI_MAX_HEADER_WIDTH', 600);
define('FLEXI_HEADER_HEIGHT', 84);
define('FLEXI_MAX_HEADER_WIDTH_M', 300);

function flexi_nonbranded_admin_menu()
{
	if (!bu_flexi_is_official_site())
	{
		$page = add_theme_page(
			'Header',
			'Header',
			'switch_themes',
			'custom-header',
			'flexi_nonbranded_admin_page');

		add_action("load-$page", 'flexi_nonbranded_load_scripts');
		add_action("load-$page", 'flexi_nonbranded_load_styles');
		add_action("admin_print_scripts-$page", 'flexi_nonbranded_print_scripts');

		if (isset($_POST['flexi-nonce']) && wp_verify_nonce($_POST['flexi-nonce'], 'flexi-non-branded-header'))
		{
			flexi_nonbranded_handle_input();
		}
	}
}
add_action('admin_menu', 'flexi_nonbranded_admin_menu');

function flexi_nonbranded_print_scripts()
{
	printf('<script type="text/javascript">site_url = %s; mobile_support = %s;</script>',
		json_encode(get_bloginfo('url')),
		is_plugin_active('bu-mobile/bu-mobile.php') ? 'true' : 'false'
	);
}

function flexi_nonbranded_handle_input()
{
	$error = '';
	$msg = 0;
	
	switch($_POST['input_type'])
	{
		case 'text':
			if (!trim($_POST['text-header']))
			{
				$error = 'Please provide a title.';
				break;
			}
			
			if (!trim($_POST['text-color']) || !preg_match('/^#[0-9A-F]{3,3}([0-9A-F]{3,3})?$/i', trim($_POST['text-color'])))
			{
				$error = 'Please select a text color.';
				break;
			}
			
			$header = array(
				'type' => 'text',
				'text' => stripslashes($_POST['text-header']),
				'text-color' => $_POST['text-color'],
			);
			bu_flexi_set_custom_header($header);
			bu_flexi_set_custom_header($header, true);
			$msg = 1;
			break;
		
		case 'image':
			// Standard header
			$header = array(
				'type' => 'image',
				'alt' => stripslashes($_POST['alt-text'])
			);
			
			if ($_FILES['custom-logo']['error'] == UPLOAD_ERR_NO_FILE)
			{
				$current = bu_flexi_custom_header();
				if ($current['type'] == 'image')
				{
					$header['filename'] = $current['filename'];
				}
				else
				{
					$error = 'Please upload a logo.';
					break;
				}
			}
			else
			{
				$upload = flexi_nonbranded_handle_upload($_FILES['custom-logo']);
				if ($upload['error'])
				{
					$error = $upload['error'];
					break;
				}
				$header['filename'] = $upload['filename'];
			}
			
			// Mobile header
			$header_m = false;
			if (is_plugin_active('bu-mobile/bu-mobile.php'))
			{
				$header_m = array(
					'type' => 'image',
					'alt' => stripslashes($_POST['alt-text-m'])
				);
				
				if ($_FILES['custom-logo-m']['error'] == UPLOAD_ERR_NO_FILE)
				{
					$current = bu_flexi_custom_header(true);
					if ($current['type'] == 'image')
					{
						$header_m['filename'] = $current['filename'];
					}
					else
					{
						$error = 'Please upload a mobile logo.';
						break;
					}
				}
				else
				{
					$upload = flexi_nonbranded_handle_upload($_FILES['custom-logo-m'], false, true);
					if ($upload['error'])
					{
						$error = $upload['error'];
						break;
					}
					$header_m['filename'] = $upload['filename'];
				}
			}

			bu_flexi_set_custom_header($header);
			if ($header_m)
			{
				bu_flexi_set_custom_header($header_m, true);
			}
			
			$msg = 2;
			
			break;
	}
	
	$url = 'themes.php?page=custom-header';
	if ($error)
	{
		$url .= '&error=' . urlencode($error);
	}
	
	if ($msg)
	{
		$url .= '&msg=' . $msg;
	}
	
	if (function_exists('invalidate_blog_cache'))
	{
		invalidate_blog_cache();
	}
	
	wp_redirect(admin_url($url));
}

function flexi_nonbranded_handle_upload($upload, $preview = false, $mobile = false)
{
	$error = $filename = null;
	
	if ($upload['error'])
	{
		$error = 'File upload failed.';
		return compact('error', 'filename');
	}

	// Validate dimensions.
	$dims = getimagesize($upload['tmp_name']);
	$width = $dims[0];
	$height = $dims[1];

	if ($mobile)
	{
		// Mobile: capped width
		if ($width != FLEXI_MAX_HEADER_WIDTH_M && $width != (FLEXI_MAX_HEADER_WIDTH_M * 2))
		{
			$error = sprintf('Mobile logo image must be %dpx or %dpx wide.', FLEXI_MAX_HEADER_WIDTH_M, FLEXI_MAX_HEADER_WIDTH_M * 2);
			return compact('error', 'filename');
		}
	}
	else
	{
		// Standard: fixed height, capped width.
		if ($width > FLEXI_MAX_HEADER_WIDTH || $height != FLEXI_HEADER_HEIGHT)
		{
			$error = sprintf('Image must have a height of %dpx and a width of no more than %dpx',
					FLEXI_HEADER_HEIGHT, FLEXI_MAX_HEADER_WIDTH);
			return compact('error', 'filename');
		}
	}

	$extension = strtolower(preg_replace('@^.*?\.(.*)@', '\1', $upload['name']));
	if (!in_array($extension, array('png', 'gif', 'jpg', 'jpeg')))
	{
		$error = 'Wrong file type, please upload one of: PNG, GIF, JPG';
		return compact('error', 'filename');
	}

	$filename = 'titlebar';
	if ($preview)
	{
		$filename .= '_preview';
	}
	if ($mobile)
	{
		$filename .= '_m';
	}

	$filename .= '.' . $extension;
	$destination = bu_static_content_dir() . '/' . $filename;
	move_uploaded_file($upload['tmp_name'], $destination);	
	return compact('error', 'filename');
}

function flexi_nonbranded_load_scripts()
{
	wp_enqueue_script(
			'branding-admin',
			get_bloginfo('template_directory') . '/admin/interface/js/non-branded-header.js',
			array('jquery'),
			LOGO_GENERATOR_PLUGIN_VER,
			true
		);
	wp_enqueue_script(
			'branding-asynch-uploader',
			get_bloginfo('template_directory') . '/admin/interface/js/ajax-file-uploader/ajaxfileupload.js',
			array('jquery'),
			LOGO_GENERATOR_PLUGIN_VER,
			true
		);
	
	wp_enqueue_script('thickbox');
	wp_enqueue_script('farbtastic');
}

function flexi_nonbranded_load_styles()
{
	wp_enqueue_style(
			'branding-admin',
			get_bloginfo('template_directory') . '/admin/interface/css/branding.css',
			array(),
			LOGO_GENERATOR_PLUGIN_VER,
			'all'
		);
	wp_enqueue_style('farbtastic');
	wp_enqueue_style('thickbox');
}

/**
 * Draw admin page.
 */
function flexi_nonbranded_admin_page()
{
	$wud = wp_upload_dir();
	$header = bu_flexi_custom_header();
	$msg = '';

	if ($_GET['msg'] == 1)
	{
		$msg = '<div class="updated below-h2">Header text has been updated.</div>';
	}
	
	if ($_GET['msg'] == 2)
	{
		$msg = '<div class="updated below-h2">Header image has been updated.</div>';
	}

	switch ($header['type'])
	{
		case 'image':
			$alt_text = $header['alt'];
			$image_src = $wud['baseurl'] . '/' . $header['filename'];
			$image_checked = 'checked="checked"';
			$text_color = '#c00';
			$text = '';
			break;

		case 'text':
			$text = $header['text'];
			$text_color = $header['text-color'];
			$text_checked = 'checked="checked"';
			break;
	}
	
	$header_m = bu_flexi_custom_header(true);
	if ($header_m['type'] == 'image')
	{
		$image_src_m = $wud['baseurl'] . '/' . $header_m['filename'];
		$alt_text_m = $header_m['alt'];
	}
	
	$support_mobile = is_plugin_active('bu-mobile/bu-mobile.php');
	
	require dirname(__FILE__) . '/interface/nonbranded-header.php';
}

function flexi_nonbranded_asynch_upload()
{
	$mobile = (isset($_GET['mobile']) && $_GET['mobile']);
	$upload = $mobile ? $_FILES['custom-logo-m'] : $_FILES['custom-logo'];

	$preview = true;
	$handled = flexi_nonbranded_handle_upload($upload, $preview, $mobile);
	
	$response = new stdClass;
	
	if ($handled['error'])
	{
		$response->status = 0;
		$response->error = $handled['error'];
	}
	else
	{
		$response->status = 1;
		$response->filename = $handled['filename'];
	}
	
	echo json_encode($response);
	die;
}
add_action('wp_ajax_flexi-header-preview', 'flexi_nonbranded_asynch_upload');
