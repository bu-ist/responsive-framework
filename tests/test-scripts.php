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
		wp_scripts();
		responsive_enqueue_scripts();

		$this->assertTrue( wp_script_is( 'responsive-scripts' ) );
		$this->assertTrue( wp_script_is( 'modernizr' ) );
	}

	/**
	 * Test that stylesheets are properly enqueued.
	 */
	function test_responsive_enqueue_styles() {
		wp_scripts();
		responsive_enqueue_styles();

		$this->assertTrue( wp_style_is( 'responsive-framework' ) );
		$this->assertTrue( wp_style_is( 'responsive-framework-ie' ) );
		$this->assertSame( '(lt IE 9) & (!IEMobile 7)', wp_styles()->get_data( 'responsive-framework-ie', 'conditional' ) );
	}
}
