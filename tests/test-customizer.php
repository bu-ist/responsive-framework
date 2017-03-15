<?php
/**
 * Test Customizer related functions.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Customizer
 *
 * @group branding
 */
class Tests_Responsive_Framework_Customizer extends WP_UnitTestCase {
	/**
	 * Setup parent class.
	 */
	function setUp() {
		parent::setUp();
	}

	/**
	 * Test default responsive layout.
	 */
	function test_responsive_layout() {
		$this->assertEquals( 'default', responsive_layout() );
		update_option( 'burf_setting_layout', 'side-nav' );
		$this->assertEquals( 'side-nav', responsive_layout() );
		update_option( 'burf_setting_layout', 'default' );
	}

	/**
	 * Test default responsive layout options.
	 */
	function test_responsive_layout_options() {
		$layout_options = array(
			'default' => 'Default',
			'top-nav'  => 'Top Navigation Bar',
			'side-nav' => 'Side Navigation Bar',
			'no-nav'   => 'No Navigation Bar',
		);

		$this->assertEquals( $layout_options, responsive_layout_options() );
	}

	/**
	 * Test default responsive font palette.
	 */
	function test_responsive_get_font_palette() {
		$this->assertEquals( 'f1', responsive_get_font_palette() );
		update_option( 'burf_setting_fonts', 'f2' );
		$this->assertEquals( 'f2', responsive_get_font_palette() );
		update_option( 'burf_setting_fonts', 'f1' );
	}

	/**
	 * Test the default font palettes.
	 */
	function test_responsive_font_options() {
		$font_options = array(
			'f1' => 'Capita,Benton',
			'f2' => 'Benton,Benton',
			'f3' => 'Benton,Capita',
			'f4' => 'Pressura,Benton',
			'f5' => 'Stag,Benton',
		);

		$this->assertEquals( $font_options, responsive_font_options() );
	}

	/**
	 * Test the customizer style cache flush.
	 */
	function test_responsive_flush_customizer_styles_cache() {
		update_option( 'burf_customizer_styles', 'hey this is a test option' );
		responsive_flush_customizer_styles_cache();
		$this->assertEmpty( responsive_flush_customizer_styles_cache() );
	}

	/**
	 * Test default color region sections.
	 */
	function test_responsive_customizer_color_region_groups() {
		$color_region_groups = array(
			'navbar'       => array(
				'label' => 'Navigation Bar',
				'layout_excludes' => array( 'no-nav' ),
			),
			'content-area' => array(
				'label' => 'Content Area',
			),
			'sidebar'      => array(
				'label' => 'Sidebar',
			),
			'footbar'      => array(
				'label' => 'Footbar',
			),
		);

		$this->assertEquals( $color_region_groups, responsive_customizer_color_region_groups() );
	}

	/**
	 * Test default optional color regions.
	 */
	function test_responsive_get_optional_color_regions() {
		$this->assertEquals( array( 'sidebar-bg' ), responsive_get_optional_color_regions() );
	}

	/**
	 * Test color scheme sanitization.
	 */
	function test_responsive_sanitize_color_scheme() {
		$this->assertEquals( 'default', responsive_sanitize_color_scheme( 'default' ) );
		$this->assertEquals( 'slacker', responsive_sanitize_color_scheme( 'slacker' ) );
		$this->assertEquals( 'default', responsive_sanitize_color_scheme( 'non-existant-scheme' ) );
	}

	/**
	 * Test default color scheme choices.
	 */
	function test_responsive_get_color_scheme_choices() {
		$this->assertEquals( responsive_get_color_scheme_choices(), array(
			'default' => 'Default',
			'slacker' => 'Slacker',
			'extra-spectral' => 'Extra Spectral',
			'rayleigh-scattering' => 'Rayleigh Scattering',
			'vinca-minor' => 'Vinca Minor',
		) );
	}

	/**
	 * Test correct color scheme is returned.
	 */
	function test_responsive_get_color_scheme() {
		$this->assertEquals( 'Default', responsive_get_color_scheme()['label'] );
		$this->assertEquals( 'Vinca Minor', responsive_get_color_scheme( 'vinca-minor' )['label'] );
	}

	/**
	 * Theme and framework version constants.
	 */
	function test_responsive_get_custom_colors() {
		$test_values = array( 'primaryNav-bg' => '#c2185b', 'primaryNav-border' => '#cd4279' );

		$this->assertEquals( array(), responsive_get_custom_colors() );

		update_option( 'burf_setting_custom_colors', $test_values );

		$this->assertEquals( $test_values, responsive_get_custom_colors() );
	}
}
