<?php
/**
 * Test Responsive version related functions that depend on constants.
 *
 * Tests involving constants are intentionally separate because each test needs
 * to be run in an isolated process, drastically slowing down each test method.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Version_Constants
 *
 * @group versions
 */
class Tests_Responsive_Framework_Version_Constants extends WP_UnitTestCase {

	/**
	 * Do not preserve global state between test methods.
	 *
	 * @var bool
	 */
	protected $preserveGlobalState = false;

	/**
	 * Run each test method in a separate, isolated process.
	 *
	 * This ensures constants are properly set and tested.
	 *
	 * @var bool
	 */
	protected $runTestInSeparateProcess = true;

	/**
	 * Test the framework version is returned when the child theme constant is not set.
	 */
	function test_get_responsive_theme_version_no_child_constant() {
		$this->assertSame( RESPONSIVE_FRAMEWORK_VERSION, get_responsive_theme_version() );
	}

	/**
	 * Test the framework version is returned when the child theme
	 * constant is defined but empty.
	 */
	function test_get_responsive_theme_version_child_constant_empty() {
		define( 'RESPONSIVE_CHILD_THEME_VERSION', '' );
		$this->assertSame( RESPONSIVE_FRAMEWORK_VERSION, get_responsive_theme_version() );
	}

	/**
	 * Test the framework version is returned when the child theme
	 * constant is defined.
	 */
	function test_get_responsive_theme_version_child_constant_valid() {
		define( 'RESPONSIVE_CHILD_THEME_VERSION', '5.1.2' );
		$this->assertSame( '5.1.2', get_responsive_theme_version() );
	}
}
