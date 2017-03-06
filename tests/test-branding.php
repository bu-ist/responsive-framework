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
		ob_start();
		get_template_part( 'template-parts/branding.php' );
		$expected_output = ob_get_clean();

		$this->expectOutputString( $expected_output );

		responsive_branding();
	}
}
