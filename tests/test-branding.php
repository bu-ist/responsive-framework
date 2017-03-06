<?php
/**
 * Test default branding.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Branding
 *
 * @group branding
 */
class Tests_Responsive_Framework_Branding extends WP_UnitTestCase {
	/**
	 * Setup parent class.
	 */
	function setUp() {
		parent::setUp();
	}

	/**
	 * Theme and framework version constants.
	 */
	function test_responsive_branding() {
		$this->expectOutputString( locate_template( 'template-parts/branding.php', true, false ) );

		responsive_branding();
	}
}
