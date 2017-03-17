<?php
/**
 * Test Sidebar configuration
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Navigation
 *
 * @group sidebars
 */
class Tests_Responsive_Framework_Sidebars extends WP_UnitTestCase {
	/**
	 * Setup parent class.
	 */
	function setUp() {
		parent::setUp();
	}

	/**
	 * Default sidebars
	 */
	function test_registered_sidebars() {
		$this->assertTrue( is_registered_sidebar( 'sidebar' ) );
		$this->assertTrue( is_registered_sidebar( 'posts' ) );
		$this->assertTrue( is_registered_sidebar( 'footbar' ) );
	}
}
