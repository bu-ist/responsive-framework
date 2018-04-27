<?php
/**
 * Test Responsive Framework Profile related functions.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Profiles
 *
 * @group profiles
 */
class Tests_Responsive_Framework_Profiles extends WP_UnitTestCase {

	/**
	 * Test default responsive layout.
	 */
	function test_responsive_gallery_after_setup_theme() {
		BU\Themes\Responsive_Framework\Profiles\after_setup_theme();

		$this->assertTrue( has_image_size( 'responsive_profile' ) );
		$this->assertTrue( has_image_size( 'responsive_profile_large' ) );
	}

}
