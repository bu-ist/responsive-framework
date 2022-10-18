<?php
/**
 * Logic in this file is triggered when a new site is created with this theme.
 *
 * @see  mu-plugins/site-manager
 *
 * @package Responsive_Framework
 */

/**
 * Tasks to run for setting up a responsive site.
 *
 * @param array  $site {
 *     New site configuration options.
 *
 *     @type array        $users      List of users to add, keyed by role.
 *     @type array        $branding   List of BU branding options.
 *     @type string       $theme      Theme to activate. ("stylesheet" value, or theme directory name).
 * }
 * @param int    $site_id     New site ID.
 * @param int    $admin_id    New site administrator user ID.
 * @param string $domain      New site domain.
 * @param string $path        New site path.
 * @param int    $network_id  New site network ID.
 * @param array  $meta        New site options.
 *
 * @see bu_initialize_site().
 */
function responsive_initialize_site( $site, $site_id, $admin_id, $domain, $path, $network_id, $meta ) {
	error_log( sprintf( '[%s] Running for: %s', __FUNCTION__, var_export( compact( 'site', 'site_id', 'admin_id', 'domain', 'path', 'network_id', 'meta' ), true ) ) );

	// Clean slate.
	error_log( sprintf( '[%s] Deleting default posts...', __FUNCTION__ ) );
	foreach ( get_posts( array( 'post_type' => 'any' ) ) as $post ) {
		wp_delete_post( $post->ID );
	}

	foreach ( get_bookmarks() as $bookmark ) {
		wp_delete_link( $bookmark->link_id );
	}

	// Replace templated strings in first page content.
	$site_url = site_url();
	$admin_url = admin_url();
	$welcome_text = get_site_option( 'first_page' );
	$host = parse_url( $site_url, PHP_URL_HOST );
	$post_content = str_replace( array( '%host-name%', '%site-url%', '%admin-url%' ), array( $host, $site_url, $admin_url ), $welcome_text );

	// Create home page.
	error_log( sprintf( '[%s] Creating home page...', __FUNCTION__ ) );
	$home_id = wp_insert_post( array(
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_author'  => $admin_id,
		'post_title'   => get_bloginfo( 'name' ),
		'post_content' => $post_content,
	) );

	// Set front page.
	error_log( sprintf( '[%s] Setting front page..' , __FUNCTION__ ) );
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $home_id );

	// Create news page.
	error_log( sprintf( '[%s] Creating news page...', __FUNCTION__ ) );

	$news_id = wp_insert_post( array(
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_author'  => $admin_id,
		'post_title'   => 'News',
	) );

	if ( $news_id ) {
		update_post_meta( $news_id, '_wp_page_template', 'page-templates/news.php' );
	}

	// Populate initial widgets.
	error_log( sprintf( '[%s] Populating widgets...', __FUNCTION__ ) );
	update_option( 'sidebars_widgets', array(
		'sidebar' => array(
			'bu_pages-1',   // BU Navigation - Content Navigation widget.
			'bu-posts-1',   // BU Post Lists - BU Posts widget.
			'bu-links-1',   // Link Lists - BU Links widget.
			),
		'array_version' => 3,
	));

	// Content Navigation widget settings.
	update_option( 'widget_bu_pages', array(
		'_multiwidget' => 1,
		1 => array(
			'navigation_title'      => 'section',
			'navigation_title_text' => '',
			'navigation_title_url'  => '',
			'navigation_style'      => 'section',
		),
	) );

	// BU Posts widget settings.
	update_option( 'widget_bu-posts', array(
		'_multiwidget' => 1,
		1 => array(
			'category'       => 0,
			'random'         => 0,
			'number'         => 3,
			'title'          => 'News',
			'title_link'     => get_permalink( $news_id ),
			'format'         => 'title_date_excerpt',
			'show_thumbnail' => 0,
		),
	) );

	// BU Links widget settings.
	update_option( 'widget_bu-links', array(
		'_multiwidget' => 1,
		1 => array(
			'title'      => 'Related Links',
			'post_types' => 'page',
		),
	) );

	// Create initial menu.
	error_log( sprintf( '[%s] Creating footer menu...', __FUNCTION__ ) );
	$menu_exists = wp_get_nav_menu_object( 'Footer Menu' );

	// If it doesn't exist, let's create it.
	if ( ! $menu_exists ) {
		$menu_id = wp_create_nav_menu( 'Footer Menu' );

		// Set up default menu items.
		wp_update_nav_menu_item( $menu_id, 0, array(
			'menu-item-title'  => 'Boston University',
			'menu-item-url'    => 'http://www.bu.edu',
			'menu-item-status' => 'publish',
			'menu-item-type'   => 'custom',
		) );

		wp_update_nav_menu_item( $menu_id, 0, array(
			'menu-item-title'  => 'Search',
			'menu-item-url'    => 'http://www.bu.edu/search',
			'menu-item-status' => 'publish',
			'menu-item-type'   => 'custom',
		) );

		wp_update_nav_menu_item( $menu_id, 0, array(
			'menu-item-title'  => 'Directory',
			'menu-item-url'    => 'http://www.bu.edu/directory',
			'menu-item-status' => 'publish',
			'menu-item-type'   => 'custom',
		) );

		wp_update_nav_menu_item( $menu_id, 0, array(
			'menu-item-title'  => 'BU Today',
			'menu-item-url'    => 'http://www.bu.edu/today/',
			'menu-item-status' => 'publish',
			'menu-item-type'   => 'custom',
		) );

		// Assign to our 'Footer Links' location.
		$locations = get_nav_menu_locations();
		$locations['footer'] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	// Create Gravity Form.
	if ( class_exists( 'GFForms' ) && class_exists( 'GFAPI' ) ) {
		error_log( sprintf( '[%s] Creating contact form...', __FUNCTION__ ) );

		// Install GF tables if they don't already exist.
		$current_gf_version = get_option( 'rg_form_version' );
		gf_upgrade()->upgrade( $current_gf_version, true );

		// Import template form.
		$contact_form = json_decode( file_get_contents( get_template_directory() . '/inc/contact-form.json' ), true );
		$form_id = GFAPI::add_form( $contact_form );
		if ( is_wp_error( $form_id ) ) {
			error_log( sprintf( '[%s] Error creating contact form: %s', __FUNCTION__, $form_id->get_error_message() ) );
		}
	}

	// Activate default plugins.
	error_log( sprintf( '[%s] Activating default plugins..', __FUNCTION__ ) );
	update_option( 'active_plugins', array(
		'bu-banners/bu-banners.php',
		'bu-front-end-library/bu-front-end-library.php',
		'bu-post-details/bu-post-details.php',
		'link-lists/link-lists.php',
		'bu-sharing/bu-sharing.php',
		'cmb2/init.php',
		'bu-landing-pages/bu-landing-pages.php',
		'bu-text-widget/bu-text-widget.php',
		'classic-editor/classic-editor.php',
	) );

	// Default comment depth.
	update_option( 'thread_comments_depth', 2 );

	// Default image sizes (consistent with Flexi).
	update_option( 'medium_size_w', 636 );
	update_option( 'medium_size_h', 636 );

	// Theme Groups.
	update_option( 'theme_groups', array( 'Responsive Framework' ) );
}

add_action( 'bu_initialize_site', 'responsive_initialize_site', 10, 7 );
