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
	 * Setup each test method.
	 */
	function setUp() {
		parent::setUp();

		responsive_sidebars();
	}

	/**
	 * Default sidebars.
	 */
	function test_registered_sidebars() {
		$this->assertTrue( is_registered_sidebar( 'sidebar' ) );
		$this->assertTrue( is_registered_sidebar( 'posts' ) );
		$this->assertTrue( is_registered_sidebar( 'footbar' ) );
		$this->assertFalse( is_registered_sidebar( 'alternate-footbar' ) );
		$this->assertFalse( is_registered_sidebar( 'profiles' ) );
	}

	/**
	 * Tests sidebars get registered when the related constants are defined.
	 */
	function test_sidebars_requiring_constants() {
		define( 'BU_SUPPORTS_DYNAMIC_FOOTBARS', true );
		define( 'BU_PROFILES_PLUGIN_ACTIVE', true );
		add_filter( 'responsive_theme_supports_dynamic_footbars', '__return_true' );

		responsive_sidebars();

		$this->assertTrue( is_registered_sidebar( 'alternate-footbar' ) );
		$this->assertTrue( is_registered_sidebar( 'profiles' ) );
	}
}
