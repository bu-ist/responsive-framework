<?php
/**
 * Theme feature support for core features.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Core_Feature_Support
 *
 * @group core-features
 */
class Tests_Responsive_Framework_Core_Feature_Support extends WP_UnitTestCase {
	/**
	 * Setup parent class.
	 */
	function setUp() {
		parent::setUp();
	}

	/**
	 * Test our theme is actually active.
	 */
	function test_current_theme() {
		$this->assertEquals( 'responsive-framework', get_stylesheet() );
	}

	/**
	 * Theme support for core features.
	 */
	function test_theme_support() {
		$this->assertTrue( current_theme_supports( 'menus' ) );

		$this->assertTrue( current_theme_supports( 'post-thumbnails' ) );
		$this->assertTrue( current_theme_supports( 'bu-branding' ) );
		$this->assertTrue( current_theme_supports( 'bu-profiles-post_type' ) );

		$this->assertTrue( current_theme_supports( 'html5' ) );
		$this->assertTrue( current_theme_supports( 'html5', 'comment-list' ) );
		$this->assertTrue( current_theme_supports( 'html5', 'comment-form' ) );
		$this->assertTrue( current_theme_supports( 'html5', 'gallery' ) );
		$this->assertTrue( current_theme_supports( 'html5', 'caption' ) );
	}
}
