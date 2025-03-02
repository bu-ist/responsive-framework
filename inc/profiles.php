<?php
/**
 * BU Profiles enhancements.
 *
 * @package Responsive_Framework
 */

namespace BU\Themes\Responsive_Framework\Profiles;

/**
 * Setup image sizes for BU Profiles display.
 */
function after_setup_theme() {
	/**
	 * Filters the default BU Profile thumbnail width.
	 *
	 * @since 2.0.0
	 *
	 * @param int Default profile thumbnail width, 300.
	 */
	$width = (int) apply_filters( 'responsive_profile_width', 300 );

	/**
	 * Filters the default profile thumbnail height.
	 *
	 * @since 2.0.0
	 *
	 * @param int Default profile thumbnail height, 300.
	 */
	$height = (int) apply_filters( 'responsive_profile_height', 300 );

	/**
	 * Filters the default BU Profiles image crop position.
	 *
	 * Default is to crop from the center, top.
	 *
	 * @since 2.0.0
	 *
	 * @param array Default profile image crop position.
	 */
	$crop = apply_filters( 'responsive_profile_image_crop', array( 'center', 'top' ) );

	add_image_size( 'responsive_profile', $width, $height, $crop );

	/**
	 * Filters the default BU Profile large thumbnail width.
	 *
	 * @since 2.0.0
	 *
	 * @param int Default profile large thumbnail width, 600.
	 */
	$width = (int) apply_filters( 'responsive_profile_large_width', 600 );

	/**
	 * Filters the default profile large thumbnail height.
	 *
	 * @since 2.0.0
	 *
	 * @param int Default profile large thumbnail height, 600.
	 */
	$height = (int) apply_filters( 'responsive_profile_large_height', 600 );

	/**
	 * Filters the default BU Profiles large image crop position.
	 *
	 * Default is to crop from the center, top.
	 *
	 * @since 2.0.0
	 *
	 * @param array Default large profile image crop position.
	 */
	$crop = apply_filters( 'responsive_profile_image_large_crop', array( 'center', 'top' ) );

	add_image_size( 'responsive_profile_large', $width, $height, $crop );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\after_setup_theme' );

if ( ! defined( 'BU_PROFILES_PLUGIN_ACTIVE' ) || ! BU_PROFILES_PLUGIN_ACTIVE ) {
	/**
	 * Removes the profile template if BU profiles is not active.
	 *
	 * @param array $page_templates list of registered page templates.
	 * @return array $page_templates list of registered page templates.
	 */
	function remove_profile_template( $page_templates ) {
		unset( $page_templates['profiles.php'] );

		return $page_templates;
	}
	add_filter( 'theme_page_templates', __NAMESPACE__ . '\remove_profile_template' );
}
