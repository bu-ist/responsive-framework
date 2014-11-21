<?php
/**
 * Upgrade routines.
 *
 * @todo Prior to 1.0.0 release, add logic to the master branch (0.1.0) to ensure DB version
 *       is set so that these routines run for existing Responsi sites.
 *
 * @since  0.9.1
 */

/**
 * Stores current theme version in database.
 *
 * Allows us to run code when the framework is updated.
 */
function responsive_framework_upgrade() {
	$db_version = get_option( '_responsive_framework_version', false );

	// Old theme version detected
	if ( $db_version ) {
		if ( version_compare( $db_version, RESPONSIVE_FRAMEWORK_VERSION, '<' ) ) {
			error_log( __FUNCTION__ . ' - Version mismatch detected. Starting upgrade...' );

			// Run version-specific upgrade routine(s)
			if ( version_compare( $db_version, '0.9.1', '<' ) ) {
				responsive_upgrade_091();
			}

			error_log( __FUNCTION__ . ' - Updating framework version in DB: ' . $db_version . ' -> ' . RESPONSIVE_FRAMEWORK_VERSION );
			update_option( '_responsive_framework_version', RESPONSIVE_FRAMEWORK_VERSION );
		}
	} else {
		// No version was previously set -- add it now.
		error_log( __FUNCTION__ . ' - Adding framework version to DB: ' . RESPONSIVE_FRAMEWORK_VERSION );
		add_option( '_responsive_framework_version', RESPONSIVE_FRAMEWORK_VERSION );
	}
}

add_action( 'init', 'responsive_framework_upgrade' );

/**
 * Upgrade for 0.9.1.
 *
 * - Page template renaming
 */
function responsive_upgrade_091() {
	global $wpdb;

	error_log( __FUNCTION__ . ' - Migrating page templates...' );
	$relocate_map = array(
		'calendar.php'        => 'page-templates/calendar.php',
		'news.php'            => 'page-templates/news.php',
		'page-nosidebars.php' => 'page-templates/no-sidebars.php',
		'profiles.php'        => 'page-templates/profiles.php',
		);
	$pt_query = sprintf( 'SELECT post_id, meta_value FROM %s WHERE meta_key = "%s" AND meta_value IN ("%s")',
		$wpdb->postmeta, '_wp_page_template', implode( '","', array_keys( $relocate_map ) ) );
	$results = $wpdb->get_results( $pt_query );

	foreach ( $results as $result ) {
		update_post_meta( $result->post_id, '_wp_page_template', $relocate_map[ $result->meta_value ] );
	}
}
