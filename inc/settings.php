<?php
/**
 * Theme Settings API
 */

/**
 * Returns layout slug for currently active theme layout.
 *
 * Possible values:
 * 	- l-branding (default)
 * 	- l-navbar
 * 	- l-nonav
 * 	- l-sidebar
 */
function responsive_layout() {
	$layout = get_option( 'burf_setting_layout', 'l-branding' );
	return $layout;
}