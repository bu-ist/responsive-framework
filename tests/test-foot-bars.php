<?php
/**
 * Theme feature support for core features.
 *
 * @package Responsive_Framework
 */

/**
 * Class SampleTest
 *
 * @group footbars
 */
class Tests_Responsive_Framework_Footbars extends WP_UnitTestCase {
	/**
	 * Setup parent class.
	 */
	function setUp() {
		parent::setUp();

		if ( ! function_exists( 'responsive_get_dynamic_footbars' ) ) {
			require_once( dirname( dirname( __FILE__ ) ) . '/inc/template-tags.php' );
		}
	}

	/**
	 * Default responsive footbars.
	 */
	function test_dynamic_foot_bars() {
		$this->assertEquals( array(
			'footbar'           => 'Footbar',
			'alternate-footbar' => 'Alternate Footbar',
		), responsive_get_dynamic_footbars() );
	}
}
