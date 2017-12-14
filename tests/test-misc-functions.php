<?php
/**
 * Test miscellaneous functions.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Miscellaneous_Functions
 *
 * @group narrow-templates
 */
class Tests_Responsive_Framework_Miscellaneous_Functions extends WP_UnitTestCase {
	/**
	 * Test the default image link type is set to none.
	 */
	function test_responsive_update_image_default_link_type() {
		update_option( 'image_default_link_type', 'file' );
		$this->assertEquals( 'file', get_option( 'image_default_link_type' ) );

		responsive_update_image_default_link_type();
		$this->assertEquals( 'none', get_option( 'image_default_link_type' ) );
	}
}
