<?php
/**
 * Upgrade routines.
 *
 * @todo Prior to 1.0.0 release, add logic to the master branch (0.1.0) to ensure DB version
 *       is set so that these routines run for existing Responsi sites.
 *
 * @since  0.9.1
 *
 * @package Responsive_Framework\Upgrade
 */

/**
 * Stores current theme version in database.
 *
 * Allows us to run code when the framework is updated.
 */
function responsive_framework_upgrade() {
	$db_version = get_option( '_responsive_framework_version', false );

	// Old theme version detected.
	if ( $db_version ) {
		if ( version_compare( $db_version, RESPONSIVE_FRAMEWORK_VERSION, '<' ) ) {
			error_log( __FUNCTION__ . ' - Version mismatch detected. Starting upgrade...' );

			// Run version-specific upgrade routine(s).
			if ( version_compare( $db_version, '0.9.1', '<' ) ) {
				responsive_upgrade_091();
			}

			do_action( 'responsive_framework_upgrade', $db_version, RESPONSIVE_FRAMEWORK_VERSION );

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
 * - Banner position renaming
 * - Sidebar renaming
 */
function responsive_upgrade_091() {
	global $wpdb;

	// Rename page templates.
	error_log( __FUNCTION__ . ' - Migrating page templates...' );
	$template_map = apply_filters( __FUNCTION__ . '_template_map', array(
		'calendar.php'        => 'page-templates/calendar.php',
		'news.php'            => 'page-templates/news.php',
		'page-nosidebars.php' => 'page-templates/no-sidebars.php',
		'profiles.php'        => 'page-templates/profiles.php',
	) );

	$template_query = sprintf( 'SELECT post_id, meta_value FROM %s WHERE meta_key = "_wp_page_template" AND meta_value IN ("%s")',
		$wpdb->postmeta, implode( '","', array_keys( $template_map ) )
	);
	$results = $wpdb->get_results( $template_query );
	error_log( __FUNCTION__ . ' - Posts to migrate: ' . count( $results ) );

	foreach ( $results as $result ) {
		update_post_meta( $result->post_id, '_wp_page_template', $template_map[ $result->meta_value ] );
	}

	// Rename banner positions.
	error_log( __FUNCTION__ . ' - Migrating content banners...' );
	$banner_map = apply_filters( __FUNCTION__ . '_banner_map', array(
		'contentWidth' => 'content-width',
		'pageWidth'    => 'page-width',
		'windowWidth'  => 'window-width',
	) );
	$banner_query = sprintf( 'SELECT post_id, meta_value FROM %s WHERE meta_key = "_bu_banner"',
		$wpdb->postmeta
	);
	$results = $wpdb->get_results( $banner_query );

	foreach ( $results as $result ) {
		$banner = maybe_unserialize( $result->meta_value );
		if ( is_array( $banner ) ) {
			if ( array_key_exists( 'position', $banner ) && in_array( $banner['position'], array_keys( $banner_map ) ) ) {
				$banner['position'] = $banner_map[ $banner['position'] ];
				update_post_meta( $result->post_id, '_bu_banner', $banner );
			} elseif ( ! array_key_exists( 'position', $banner ) || empty( $banner['position'] ) ) {
				error_log( __FUNCTION__ . ' - Resetting empty banner position to default (content-width)' );
				// Reset to default.
				$banner['position'] = 'content-width';
				update_post_meta( $result->post_id, '_bu_banner', $banner );
			}
		}
	}

	// Rename sidebars.
	error_log( __FUNCTION__ . ' - Migrating sidebars...' );
	$sidebars_map = apply_filters( __FUNCTION__ . '_sidebars_map', array(
		'right-content-area'  => 'sidebar',
		'bottom-content-area' => 'footbar',
	) );
	$sidebars_widgets = wp_get_sidebars_widgets();
	foreach ( $sidebars_map as $from => $to ) {
		if ( array_key_exists( $from, $sidebars_widgets ) ) {
			$sidebars_widgets[ $to ] = $sidebars_widgets[ $from ];
			unset( $sidebars_widgets[ $from ] );
		}
	}
	wp_set_sidebars_widgets( $sidebars_widgets );
}
