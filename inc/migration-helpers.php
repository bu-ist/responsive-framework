<?php
/**
 * Migration procedure for Flexi -> Responsive Framework.
 *
 * This logic is run on the first load post-theme switch.
 *
 * Punchlist:
 * [ ] Additional page templates (blank, no title)
 * [ ] Contact form migration
 */
function responsive_flexi_migration() {

	// Ensure larger sites have enough resources to finish this operation
	ini_set( 'memory_limit', WP_MAX_MEMORY_LIMIT );
	ignore_user_abort( true );
	set_time_limit( 300 );

	global $wpdb;
	$errors = array();

	if ( ! function_exists( 'bu_migrate_sidebars' ) ) {
		error_log( sprintf( '[%s] Could not migrate templates - Site Manager helper functions are not defined.', __FUNCTION__ ) );
		return;
	}

	$time_start = microtime( true );
	$num_queries_start = $wpdb->num_queries;

	// Temporarily register Flexi alternate footbar for migration purposes
	register_sidebar( array(
		'name' => 'Alternate Footbar',
		'id'   => 'alternate-footbar',
	) );

	// Rename sidebars
	$sidebar_map = apply_filters( __FUNCTION__ . '_sidebar_map', array(
		'sidebar-2'       => 'sidebar',
		'sidebar-profile' => 'profiles',
		) );
	$result = bu_migrate_sidebars( $sidebar_map );
	if ( is_wp_error( $result ) ) {
		$errors[] = $result;
	}

	// Rename page templates
	$template_map = apply_filters( __FUNCTION__ . '_page_template_map', array(
		'calendar.php'        => 'page-templates/calendar.php',
		'news.php'            => 'page-templates/news.php',
		'profiles.php'        => 'page-templates/profiles.php',
		) );
	$result = bu_migrate_page_templates( $template_map );
	if ( is_wp_error( $result ) ) {
		$errors[] = $result;
	}

	// Migrate banner positions
	$banner_position_map = apply_filters( __FUNCTION__ . '_banner_position_map', array(
		'content-width' => 'contentWidth',
		'page-width'    => 'pageWidth',
		'window-width'  => 'windowWidth',
		) );
	$result = bu_migrate_banner_positions( $banner_position_map );
	if ( is_wp_error( $result ) ) {
		$errors[] = $result;
	}

	// Migrate utility links
	$result = bu_migrate_link_lists( 'utility', 'Utility Menu', 'utility' );
	if ( is_wp_error( $result ) ) {
		$errors[] = $result;
	}

	// Migrate footer links
	$result = bu_migrate_link_lists( 'footer', 'Footer Menu', 'footer' );
	if ( is_wp_error( $result ) ) {
		$errors[] = $result;
	}

	// Display options
	$result = responsive_migrate_post_display_options();
	if ( is_wp_error( $result ) ) {
		$errors[] = $result;
	}

	// Migrate dynamic footbar settings
	$result = responsive_migrate_flexi_footbars();
	if ( is_wp_error( $result ) ) {
		$errors[] = $result;
	}

	$time_end = microtime( true );
	$num_queries_end = $wpdb->num_queries;
	$time_elapsed = $time_end - $time_start;
	$num_queries = $num_queries_end - $num_queries_start;

	error_log( sprintf( '[%s] Completed in %s seconds. Queries made: %d', __FUNCTION__, $time_elapsed, $num_queries ) );
	if ( $errors ) {
		error_log( sprintf( '[%s] %d errors encountered during migration: %s', __FUNCTION__, count( $errors ), var_export( $errors, true ) ) );
	}
}

/**
 * Migrate Flexi post meta display options
 *
 * @return bool|WP_Error        true on success, or a WP_Error instance describing failures.
 */
function responsive_migrate_post_display_options() {
	$flexi_display_options = get_option( 'flexi_display' );
	if ( $flexi_display_options ) {
		$responsi_display = array();
		$option_map = array(
			'cat'    => 'categories',
			'tag'    => 'tags',
			'author' => 'author'
			);
		foreach ( $option_map as $from => $to ) {
			if ( $flexi_display_options[ $from ] ) {
				$responsi_display_options[] = $to;
			}
		}
		$responsi_display_options = implode( ',', $responsi_display_options );
		error_log( sprintf( '[%s] Migrating display options: %s', __FUNCTION__, $responsi_display_options ) );

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
 * @return bool|WP_Error        true on success, or a WP_Error instance describing failures.
 */
function responsive_migrate_flexi_footbars() {
	global $wpdb;

	$errors = array();

	// Whether or not the current site has alternate / dynamic footbars enabled
	$flexi_supports_dynamic_footbars = get_option( 'bu_flexi_framework_dynamic_footbars' );
	if ( 1 == $flexi_supports_dynamic_footbars ) {
		update_option( 'burf_setting_sidebar_options', 'dynamic_footbars' );
	}

	// Migrate post-specific dynamic footbar selections
	$footbar_query = sprintf( 'SELECT post_id, meta_value FROM %s WHERE meta_key = "_bu_flexi_framework_footbar" AND meta_value != ""',
		$wpdb->postmeta );
	$results = $wpdb->get_results( $footbar_query );

	if ( empty( $results ) ) {
		return;
	}

	error_log( sprintf( '[%s] Migrating %d Flexi footbars...', __FUNCTION__, count( $results ) ) );

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
