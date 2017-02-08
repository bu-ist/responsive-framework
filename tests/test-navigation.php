<?php
/**
 * Test default constants defined in the framework.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Navigation
 *
 * @group navigation
 */
class Tests_Responsive_Framework_Navigation extends WP_UnitTestCase {
	/**
	 * Setup parent class.
	 */
	function setUp() {
		parent::setUp();
	}

	/**
	 * Default nav menu locations.
	 */
	function test_nav_menus() {
		$nav_menus = get_registered_nav_menus();

		$this->assertTrue( isset( $nav_menus['footer'] ) );
		$this->assertEquals( 'Footer Links', $nav_menus['footer'] );

		$this->assertTrue( isset( $nav_menus['social'] ) );
		$this->assertEquals( 'Social Links', $nav_menus['social'] );

		$this->assertTrue( isset( $nav_menus['utility'] ) );
		$this->assertEquals( 'Utility Navigation', $nav_menus['utility'] );
	}
}
