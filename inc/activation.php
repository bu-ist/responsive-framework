<?php
/**
 * Functions related to theme activation.
 *
 * @package r-cas
 */

/**
 * Maybe trigger theme migration procedure.
 *
 * @param string        $old_name The old theme name.
 * @param bool|WP_Theme $old_theme false if the old theme does not exist, WP_Theme instance of the old theme if it does.
 */
function responsive_maybe_migrate_theme( $old_name, $old_theme = false ) {
	// Theme migrations require Site Manager > 4.0.
	if ( ! defined( 'BU_SITE_MANAGER_VERSION' ) || version_compare( BU_SITE_MANAGER_VERSION, '4.0', '<' ) ) {
		return;
	}

	if ( ! $old_theme ) {
		return;
	}

	$new_theme = wp_get_theme();

	if ( 'flexi-framework' === $old_theme->get_template() ) {
		require __DIR__ . '/migration-helpers.php';
		error_log( sprintf( '[%s] Migrating from %s to %s...', __FUNCTION__, $old_theme->get_template(), $new_theme->get_template() ) );
		responsive_flexi_migration();
	}
}
add_action( 'after_switch_theme', 'responsive_maybe_migrate_theme', 1, 2 );

/**
 * Updates the image_default_link_type option to none.
 *
 * This prevents media from linking to the attachment's page.
 */
function responsive_update_image_default_link_type() {
	update_option( 'image_default_link_type', 'none' );
}
add_action( 'after_switch_theme', 'responsive_update_image_default_link_type', 1, 2 );

/**
 * Disable BU Mobile when the theme is activated.
 *
 * BU Mobile plugin does device detection on the front end servers and adds headers to serve mobile specific pages.
 * This is not ideal for any site running this theme because this theme is responsive by default.
 */
function responsive_disable_bu_mobile_plugin() {
	deactivate_plugins( 'bu-mobile/bu-mobile.php' );
}
add_action( 'after_switch_theme', 'responsive_update_image_default_link_type', 1, 2 );
