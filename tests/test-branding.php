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
	function test_default_theme_version_constants() {
		$this->expectOutputString( locate_template( array(
			'template-parts/branding.php',
		), true ) );

		responsive_branding();
	}
}
