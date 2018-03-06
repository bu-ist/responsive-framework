<?php
/**
 * Test scripts and styles.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Scripts_Styles
 *
 * @group scripts-styles
 */
class Tests_Responsive_Framework_Scripts_Styles extends WP_UnitTestCase {

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
	 * Test that stylesheets not named responsive-framework are not wrapped in conditionals.
	 */
	function test_responsive_style_loader_tag_not_responsi() {
		$expected = '<link rel="stylesheet" id="not-responsi"  href="https://www.bu.edu/styles/not-responsi.css" type="text/css" media="all" />';

		$this->assertSame( $expected, responsive_style_loader_tag( $expected, 'not-responsi' ) );
	}

	/**
	 * Test that the Responsive Framework stylesheet is properly wrapped in conditionals to target all browsers and
	 * IE greater than IE 8.
	 */
	function test_responsive_style_loader_tag_responsi() {
		$original = '<link rel="stylesheet" id="responsive-framework"  href="https://www.bu.edu/styles/responsive-framework.css" type="text/css" media="all" />';
		$expected = '<!--[if gt IE 8]><!-->
<link rel="stylesheet" id="responsive-framework"  href="https://www.bu.edu/styles/responsive-framework.css" type="text/css" media="all" /><![endif]-->
';

		$this->assertSame( $expected, responsive_style_loader_tag( $original, 'responsive-framework' ) );
	}

	/**
	 * Test that scripts are properly enqueued.
	 */
	function test_responsive_enqueue_scripts() {
		global $wp_version;

		if ( version_compare( '4.7', $wp_version ) > 0 && version_compare( phpversion(), '7.1' ) >= 0 ) {
			$this->markTestSkipped( 'This test causes errors in WordPress < 4.7 on PHP >= 7.1' );
		}

		$this->assertFalse( wp_script_is( 'responsive-scripts' ) );
		$this->assertFalse( wp_script_is( 'modernizr' ) );

		responsive_enqueue_scripts();

		$this->assertTrue( wp_script_is( 'responsive-scripts' ) );
		$this->assertTrue( wp_script_is( 'modernizr' ) );
	}

	/**
	 * Test that the framework JavaScript still loads when Modernizr is disabled.
	 */
	function test_responsive_enqueue_scripts_no_modernizr() {
		global $wp_version;

		if ( version_compare( '4.7', $wp_version ) > 0 && version_compare( phpversion(), '7.1' ) >= 0 ) {
			$this->markTestSkipped( 'This test causes errors in WordPress < 4.7 on PHP >= 7.1' );
		}

		$this->assertFalse( wp_script_is( 'responsive-scripts' ) );
		$this->assertFalse( wp_script_is( 'modernizr' ) );

		add_filter( 'r_enqueue_modernizr', '__return_false' );

		responsive_enqueue_scripts();

		$this->assertTrue( wp_script_is( 'responsive-scripts' ) );
		$this->assertFalse( wp_script_is( 'modernizr' ) );

		remove_all_filters( 'r_enqueue_modernizr' );
	}

	/**
	 * Test that stylesheets are properly enqueued.
	 */
	function test_responsive_enqueue_styles() {
		global $wp_version;

		if ( version_compare( '4.7', $wp_version ) > 0 && version_compare( phpversion(), '7.1' ) >= 0 ) {
			$this->markTestSkipped( 'This test causes errors in WordPress < 4.7 on PHP >= 7.1' );
		}

		responsive_enqueue_styles();

		$this->assertTrue( wp_style_is( 'responsive-framework' ) );
		$this->assertTrue( wp_style_is( 'responsive-framework-ie' ) );
		$this->assertSame( '(lt IE 9) & (!IEMobile 7)', wp_styles()->get_data( 'responsive-framework-ie', 'conditional' ) );
	}
}
