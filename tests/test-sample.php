<?php
/**
 * Class SampleTest
 *
 * @package Responsive_Framework
 */

/**
 * Sample test case.
 */
class Responsive_Framework_Core_Support_Tests extends WP_UnitTestCase {

	function setUp() {
		parent::setUp();
	}

	/**
	 * A single example test.
	 */
	function test_current_theme() {
		$current_theme = wp_get_theme();
		$this->assertEquals( 'Responsive Framework', $current_theme->get( 'Name' ) );
	}

	function test_theme_support() {
//		$this->assertTrue( current_theme_supports( 'html5' ) );
		$this->assertTrue( current_theme_supports( 'menus' ) );
		$this->assertTrue( current_theme_supports( 'bu-branding' ) );
		$this->assertTrue( current_theme_supports( 'bu-profiles-post_type' ) );
	}

	function test_dynamic_foot_bars() {
		$this->assertEquals( array(
			'footbar'           => 'Footbar',
			'alternate-footbar' => 'Alternate Footbar',
		), responsive_get_dynamic_footbars() );
	}
}
