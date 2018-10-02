<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Responsive_Framework
 */

$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

/**
 * Make sure that WordPress has access to the theme when we run our tests.
 */
function _register_theme() {
	$theme_dir = dirname( dirname( __FILE__ ) );
	$current_theme = basename( $theme_dir );

	register_theme_directory( dirname( $theme_dir ) );

	add_filter( 'pre_option_template', function() use ( $current_theme ) {
		return $current_theme;
	});
	add_filter( 'pre_option_stylesheet', function() use ( $current_theme ) {
		return $current_theme;
	});

	/**
	 * Before WordPress version 4.7, the theme's functions.php file needs to be included manually.
	 * This only needs to be done when running as multisite.
	 */
	if ( ! function_exists( 'responsive_init' ) && ! is_multisite() ) {
		global $wp_version;

		if ( 1 > version_compare( '4.7', $wp_version ) ) {
			require_once( dirname( dirname( __FILE__ ) ) . '/functions.php' );
		}
	}
}
tests_add_filter( 'muplugins_loaded', '_register_theme' );

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';
