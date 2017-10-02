<?php
/**
 * Test theme activation functionality.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Activation
 *
 * @group sidebars
 */
class Tests_Responsive_Framework_Activation extends WP_UnitTestCase {

	/**
	 * Test that BU Mobile is deactivated correctly when the theme is activated.
	 */
	function test_bu_mobile_is_disabled() {
		update_option(
			'active_plugins',
			array(
				'bu-mobile/bu-mobile.php',
			)
		);

		responsive_disable_bu_mobile_plugin();

		$this->assertSame( array(), get_option( 'active_plugins' ) );
	}
}
