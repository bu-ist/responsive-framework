<?php
/**
 * BU Profiles enhancements.
 *
 * @package Responsive_Framework
 */

namespace BU\Themes\Responsive_Framework\Profiles;

/**
 * Setup an image size for BU Profiles display.
 */
function after_setup_theme() {
	/**
	 * Filters the default BU Profile thumbnail width.
	 *
	 * @since 2.0.0
	 *
	 * @param int Default gallery image width, 420.
	 */
	$width = (int) apply_filters( 'responsive_profile_width', 300 );

	/**
	 * Filters the default gallery thumbnail height.
	 *
	 * @since 2.0.0
	 *
	 * @param int Default gallery image height, 420.
	 */
	$height = (int) apply_filters( 'responsive_profile_height', 300 );

	/**
	 * Filters the default BU Profiles image crop properties.
	 *
	 * Default is to crop from the center, top.
	 *
	 * @since 2.0.0
	 *
	 * @param array Default crop position.
	 */
	$crop = apply_filters( 'responsive_profile_image_crop', array( 'center', 'top' ) );

	add_image_size( 'responsive_profile', $width, $height, $crop );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\after_setup_theme' );
