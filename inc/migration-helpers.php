<?php
/**
 * Migration procedure for Flexi -> Responsive Framework.
 *
 * This logic is run on the first load post-theme switch.
 *
 * @package Responsive_Framework
 */

/**
 * Migrate a Flexi site to Responsive Foundation.
 */
function responsive_flexi_migration() {
	global $wpdb;

	// Bail early if Site Manager migration helpers are unavailable.
	if ( ! function_exists( 'bu_migrate_sidebars' ) ) {
		error_log( sprintf( '[%s] Could not migrate templates - Site Manager helper functions are not defined.', __FUNCTION__ ) );
		return;
	}

	// Check for existing migration lock.
	if ( get_transient( 'responsive_flexi_migration_locked' ) ) {
		return;
	}

	// Set lock to prevent multiple migrations.
	set_transient( 'responsive_flexi_migration_locked', 1, 10 * MINUTE_IN_SECONDS );

	// Ensure larger sites have enough resources to finish this operation.
	ini_set( 'memory_limit', WP_MAX_MEMORY_LIMIT );
	ignore_user_abort( true );
	set_time_limit( 300 );

	$errors = array();

	$time_start = microtime( true );
	$num_queries_start = $wpdb->num_queries;

	// Contact Forms.
	$result = responsive_migrate_contact_form();
	if ( is_wp_error( $result ) ) {
		$errors[] = $result;
	}

	// Temporarily register Flexi alternate footbar for migration purposes.
	register_sidebar( array(
		'name' => 'Alternate Footbar',
		'id'   => 'alternate-footbar',
	) );

	// Rename sidebars.
	$sidebar_map = apply_filters( __FUNCTION__ . '_sidebar_map', array(
		'sidebar-2'       => 'sidebar',
		'sidebar-profile' => 'profiles',
	) );
	$result = bu_migrate_sidebars( $sidebar_map );
	if ( is_wp_error( $result ) ) {
		$errors[] = $result;
	}

	// Rename page templates.
	$template_map = apply_filters( __FUNCTION__ . '_page_template_map', array(
		'calendar.php'           => 'page-templates/calendar.php',
		'news.php'               => 'page-templates/news.php',

		// Okay mappings ... Flexi hid title for these templates as well.
		'blank.php'              => 'page-templates/no-sidebars.php',
		'window-width-blank.php' => 'page-templates/no-sidebars.php',

		// No good mapping.
		'page-no-title.php'      => 'default',
		'contact-us.php'         => 'default',
		'glossary.php'           => 'default',
	) );
	$result = bu_migrate_page_templates( $template_map );
	if ( is_wp_error( $result ) ) {
		$errors[] = $result;
	}

	// Migrate banner positions.
	$banner_position_map = apply_filters( __FUNCTION__ . '_banner_position_map', array(
		'contentWidth' => 'content-width',
		'pageWidth'    => 'page-width',
		'windowWidth'  => 'window-width',
	) );
	$result = bu_migrate_banner_positions( $banner_position_map );
	if ( is_wp_error( $result ) ) {
		$errors[] = $result;
	}

	// Migrate utility links.
	$result = bu_migrate_link_lists( 'utility', 'Utility Menu', 'utility' );
	if ( is_wp_error( $result ) ) {
		$errors[] = $result;
	}

	// Migrate footer links.
	$result = bu_migrate_link_lists( 'footer', 'Footer Menu', 'footer' );
	if ( is_wp_error( $result ) ) {
		$errors[] = $result;
	}

	// Display options.
	$result = responsive_migrate_post_display_options();
	if ( is_wp_error( $result ) ) {
		$errors[] = $result;
	}

	// Migrate dynamic footbar settings.
	$result = responsive_migrate_flexi_footbars();
	if ( is_wp_error( $result ) ) {
		$errors[] = $result;
	}

	// Swap out Sharedaddy for BU Sharing.
	$active_plugins = get_option( 'active_plugins' );
	$sharing_plugin_index = array_search( 'sharedaddy/sharedaddy.php', $active_plugins );
	if ( $sharing_plugin_index > 0 ) {
		error_log( sprintf( '[%s] Sharedaddy detected! Swapping Sharedaddy for BU Sharing...', __FUNCTION__ ) );
		$active_plugins[ $sharing_plugin_index ] = 'bu-sharing/bu-sharing.php';
		$result = update_option( 'active_plugins', $active_plugins );
		if ( ! $result ) {
			error_log( sprintf( '[%] Error activating BU Sharing!', __FUNCTION__ ) );
		}
	}

	// Add theme groups.
	$theme_groups = get_option( 'theme_groups', array() );
	if ( ! in_array( 'Responsive Framework', $theme_groups ) ) {
		$theme_groups[] = 'Responsive Framework';
		update_option( 'theme_groups', $theme_groups );
	}

	// Set BU Nav Dropdown Defaults (Only want max 1).
	if ( get_option( 'bu_navigation_primarynav_depth' ) > BU_NAVIGATION_SUPPORTED_DEPTH ) {
		update_option( 'bu_navigation_primarynav_depth', BU_NAVIGATION_SUPPORTED_DEPTH );
	}

	$time_end = microtime( true );
	$num_queries_end = $wpdb->num_queries;
	$time_elapsed = $time_end - $time_start;
	$num_queries = $num_queries_end - $num_queries_start;

	error_log( sprintf( '[%s] Completed in %s seconds. Queries made: %d', __FUNCTION__, $time_elapsed, $num_queries ) );
	if ( $errors ) {
		error_log( sprintf( '[%s] %d errors encountered during migration:', __FUNCTION__, count( $errors ) ) );
		foreach ( $errors as $error ) {
			error_log( $error->get_error_message() );
		}
	}

	// Release migration lock.
	delete_transient( 'responsive_flexi_migration_locked' );
}

/**
 * Migrate Flexi post meta display options
 *
 * @param bool $verbose Whether to display error log messages.
 *
 * @return bool|WP_Error        true on success, or a WP_Error instance describing failures.
 */
function responsive_migrate_post_display_options( $verbose = true ) {
	$flexi_display_options = get_option( 'flexi_display' );
	if ( $flexi_display_options ) {
		$responsi_display_options = array();
		$option_map = array(
			'cat'    => 'categories',
			'tag'    => 'tags',
			'author' => 'author',
		);

		foreach ( $option_map as $from => $to ) {
			if ( $flexi_display_options[ $from ] ) {
				$responsi_display_options[] = $to;
			}
		}
		$responsi_display_options = implode( ',', $responsi_display_options );

		if ( $verbose ) {
			error_log( sprintf( '[%s] Migrating display options: %s', __FUNCTION__, $responsi_display_options ) );
		}

		$result = update_option( 'burf_setting_post_display_options', $responsi_display_options );

		if ( ! $result ) {
			return new WP_Error( 'flexi_display_options_updates_failed', 'Could not migrate post display options' );
		}
	}

	return true;
}

/**
 * Attempt to migrate dynamic footbar settings from Flexi.
 *
 * @param bool $verbose Whether to display error log messages.
 *
 * @return bool|WP_Error true on success, or a WP_Error instance describing failures.
 */
function responsive_migrate_flexi_footbars( $verbose = true ) {
	global $wpdb;

	$errors = array();

	// Whether or not the current site has alternate / dynamic footbars enabled.
	$flexi_supports_dynamic_footbars = (bool) get_option( 'bu_flexi_framework_dynamic_footbars' );
	if ( true === $flexi_supports_dynamic_footbars ) {
		update_option( 'burf_setting_sidebar_options', 'dynamic_footbars' );
	}

	// Migrate post-specific dynamic footbar selections.
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT post_id, meta_value FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value != ''", '_bu_flexi_framework_footbar' ) );

	if ( empty( $results ) ) {
		return;
	}

	if ( $verbose ) {
		error_log( sprintf( '[%s] Migrating %d Flexi footbars...', __FUNCTION__, count( $results ) ) );
	}

	foreach ( $results as $result ) {
		$success = update_post_meta( $result->post_id, '_bu_footbar_id', $result->meta_value );
		if ( ! $success ) {
			$errors[] = $result;
		}
	}

	if ( ! empty( $errors ) ) {
		return new WP_Error( 'flexi_footbar_updates_failed', 'Could not migrate all Flexi footbar post settings.', $errors );
	}

	return true;
}

/**
 * Migrate contact form.
 *
 * - Create a new Gravity Form using the default template.
 * - If a Contact page exists, update it to use the [gravityform] shortcode.
 * - If `_preferred_contact_users` are set, update the form notifications to use those e-mail addresses.
 *
 * @return bool|WP_Error        true on success, or a WP_Error instance describing failures.
 */
function responsive_migrate_contact_form() {
	global $wpdb;

	if ( class_exists( 'GFForms' ) && class_exists( 'GFAPI' ) ) {

		$results = $wpdb->get_col( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_wp_page_template' AND meta_value = 'contact-us.php'" );

		if ( empty( $results ) ) {
			return;
		} elseif ( count( $results ) > 1 ) {
			error_log( sprintf( '[%s] There are multiple contact forms on this site... Migrating post ID %s.', __FUNCTION__, reset( $results ) ) );
		}

		$contact_id = reset( $results );

		error_log( sprintf( '[%s] Creating contact form...', __FUNCTION__ ) );

		// Install GF tables if they don't already exist.
		GFForms::setup();

		// Import template form.
		$contact_form = json_decode( file_get_contents( get_template_directory() . '/inc/contact-form.json' ), true );
		$form_id = GFAPI::add_form( $contact_form );
		if ( is_wp_error( $form_id ) ) {
			return $form_id;
		}

		// Migrate contact form page.
		$contact_page = get_post( $contact_id );
		if ( $contact_page ) {
			error_log( sprintf( '[%s] Updating contact page: %d', __FUNCTION__, $contact_id ) );

			$contact_page_updates = array(
				'ID'            => $contact_id,
				'post_content'  => sprintf( '[gravityform id="%d" title="false" description="false"]', $form_id ),
				'page_template' => 'default',
				);
			$result = wp_update_post( $contact_page_updates, true );
			if ( is_wp_error( $result ) ) {
				return $result;
			}
		}

		// Attempt to migrate contact e-mails from previous form.
		$contact_emails = get_option( '_preferred_contact_users' );
		if ( ! empty( $contact_emails ) ) {
			$contact_emails = implode( ',', $contact_emails );

			error_log( sprintf( '[%s] Migrating contact form notification emails: %s', __FUNCTION__, $contact_emails ) );

			$form = GFAPI::get_form( $form_id );
			$key = key( $form['notifications'] );
			$form['notifications'][ $key ]['to'] = $contact_emails;

			$result = GFAPI::update_form( $form );
			if ( is_wp_error( $result ) ) {
				return $result;
			}
		}

		return true;
	}
}
