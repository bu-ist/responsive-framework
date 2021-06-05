<?php
/**
 * Upgrade function tests that depend on constants.
 *
 * Tests involving constants are intentionally separate because each test needs
 * to be run in an isolated process, drastically slowing down each test method.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Upgrade_Constants
 *
 * @group upgrades
 */
class Tests_Responsive_Framework_Upgrade_Constants extends WP_UnitTestCase {

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
	 * Test Responsive 2.0 upgrade routine when a layout is saved and a constant
	 * is set with a value that is an allowed layout and different than the saved
	 * value.
	 */
	function test_responsive_upgrade_2_0_layout_valid_constant_overwrites_no_value() {
		define( 'BU_RESPONSIVE_LAYOUT', 'side-nav' );

		responsive_upgrade_2_0( false );

		$this->assertSame( 'side-nav', get_option( 'burf_setting_layout' ) );
	}

	/**
	 * Test Responsive 2.0 upgrade routine when a layout is saved and a constant
	 * is set with a value that is an allowed layout and different than the saved
	 * value.
	 */
	function test_responsive_upgrade_2_0_layout_valid_constant_overwrites_value() {
		define( 'BU_RESPONSIVE_LAYOUT', 'side-nav' );
		update_option( 'burf_setting_layout', 'default' );

		responsive_upgrade_2_0( false );

		$this->assertSame( 'side-nav', get_option( 'burf_setting_layout' ) );
	}
}
