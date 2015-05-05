<?php
/**
 * Migration procedure for Flexi -> Responsive Framework.
 *
 * This logic is run on the first load post-theme switch.
 *
 * Punchlist:
 * [ ] Additional page templates (blank, no title)
 * [ ] Alternate footbar map (once it's created)
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

	$time_end = microtime( true );
	$num_queries_end = $wpdb->num_queries;
	$time_elapsed = $time_end - $time_start;
	$num_queries = $num_queries_end - $num_queries_start;

	error_log( sprintf( '[%s] Completed in %s seconds. Queries made: %d', __FUNCTION__, $time_elapsed, $num_queries ) );
	if ( $errors ) {
		error_log( sprintf( '[%s] %d errors encountered during migration: %s', __FUNCTION__, count( $errors ), var_export( $errors, true ) ) );
	}
}
