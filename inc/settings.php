<?php
/**
 * Theme Settings API
 */

/**
 * Returns layout slug for currently active theme layout.
 *
 * @see  responsive_layout_options()
 */
function responsive_layout() {
	return get_option( 'burf_setting_layout', 'default' );
}

/**
 * Returns layout options available via Customizer.
 */
function responsive_layout_options() {
	return array(
		'default' => 'Default',
		'topNav'  => 'Top Navigation Bar',
		'sideNav' => 'Side Navigation Bar',
		'noNav'   => 'No Navigation Bar',
		);
}