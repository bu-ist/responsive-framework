<?php
/**
 * Test template tag functions.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Template_Tags
 *
 * @group sidebars
 */
class Tests_Responsive_Framework_Template_Tags extends WP_UnitTestCase {
	/**
	 * Setup parent class.
	 */
	function setUp() {
		parent::setUp();
	}

	/**
	 * Default site title.
	 */
	function test_responsive_get_title() {
		update_option( 'blogname', 'Responsive Framework' );

		$expected = 'Responsive Framework';

		ob_start();
		responsive_get_title();
		$actual = ob_get_clean();

		$this->assertEquals( $expected, $actual );
	}

	/**
	 * Test default comment support.
	 */
	function test_responsive_has_comment_support() {
		$this->assertTrue( responsive_has_comment_support() );
	}

	/**
	 * Test default search setting.
	 */
	function responsive_search_is_enabled() {
		$this->assertTrue( responsive_search_is_enabled() );
	}
}
