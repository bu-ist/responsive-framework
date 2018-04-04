<?php
/**
 * Test default constants defined in the framework.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Default_Constants
 *
 * @group default-constants
 */
class Tests_Responsive_Framework_Default_Constants extends WP_UnitTestCase {

	/**
	 * Theme and framework version constants.
	 */
	function test_default_theme_version_constants() {
		$this->assertTrue( defined( 'RESPONSIVE_FRAMEWORK_VERSION' ) );
	}

	/**
	 * Comment support constants.
	 */
	function test_default_comment_support_constants() {
		responsive_setup_constants();

		$this->assertTrue( defined( 'BU_SUPPORTS_COMMENTS' ) );
		$this->assertTrue( BU_SUPPORTS_COMMENTS );
	}

	/**
	 * BU SEO support constants.
	 */
	function test_default_seo_support_constants() {
		responsive_setup_constants();

		$this->assertTrue( defined( 'BU_SUPPORTS_SEO' ) );
		$this->assertTrue( BU_SUPPORTS_SEO );
	}

	/**
	 * BU footer editor constants.
	 */
	function test_default_footer_editor_constants() {
		responsive_setup_constants();

		$this->assertTrue( defined( 'BU_DISABLE_FOOTER_EDITOR' ) );
		$this->assertTrue( BU_DISABLE_FOOTER_EDITOR );
	}

	/**
	 * BU Navigation depth constants.
	 */
	function test_default_navigation_depth() {
		responsive_setup_constants();

		$this->assertTrue( defined( 'BU_NAVIGATION_SUPPORTED_DEPTH' ) );
		$this->assertEquals( 1, BU_NAVIGATION_SUPPORTED_DEPTH );
	}
}
