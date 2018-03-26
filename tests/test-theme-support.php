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
	 * Test our theme is actually active.
	 */
	function test_current_theme() {
		$this->assertEquals( 'responsive-framework', get_stylesheet() );
	}

	/**
	 * Theme support for core features.
	 */
	function test_theme_support() {
		responsive_setup_theme_support();

		$this->assertTrue( current_theme_supports( 'menus' ) );

		$this->assertTrue( current_theme_supports( 'post-thumbnails' ) );
		$this->assertTrue( current_theme_supports( 'bu-branding' ) );
		$this->assertTrue( current_theme_supports( 'bu-profiles-post_type' ) );
	}

	/**
	 * Page post type support.
	 */
	function test_page_support() {
		responsive_init();
		$this->assertTrue( post_type_supports( 'page', 'bu-dynamic-footbars' ) );
	}
}
