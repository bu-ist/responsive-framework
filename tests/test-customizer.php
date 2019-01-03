<?php
/**
 * Test Customizer related functions.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Customizer
 *
 * @group customizer
 */
class Tests_Responsive_Framework_Customizer extends WP_UnitTestCase {

	/**
	 * Test default responsive font palette.
	 */
	public function test_responsive_get_font_palette() {
		$this->assertEquals( 'f1', responsive_get_font_palette() );
		update_option( 'burf_setting_fonts', 'f2' );
		$this->assertEquals( 'f2', responsive_get_font_palette() );
		update_option( 'burf_setting_fonts', 'f1' );
	}

	/**
	 * Test the default font palettes.
	 */
	public function test_responsive_font_options() {
		$font_options = array(
			'f1' => '<span class="f1-font-title">Benton Bold</span><span class="f1-font-body">Benton Sans Regular is the font your body copy will appear in.</span>',
			'f2' => '<span class="f2-font-title">Capita Bold</span><span class="f2-font-body">Benton Sans Regular is the font your body copy will appear in.</span>',
			'f3' => '<span class="f3-font-title">Benton Light</span><span class="f3-font-body">Capita Regular is the font your body copy will appear in.</span>',
			'f4' => '<span class="f4-font-title">Tiempos Bold</span><span class="f4-font-body">Tiempos Regular is the font your body copy will appear in.</span>',
			'f5' => '<span class="f5-font-title">Pressura Heading</span><span class="f5-font-body">Benton Sans Regular is the font your body copy will appear in.</span>',
		);

		$this->assertEquals( $font_options, responsive_font_options() );
	}

	/**
	 * Test the default font palettes, but filtered.
	 */
	public function test_responsive_font_options_filtered() {

		// Add filter to change the default font family values.
		add_filter(
			'responsive_font_options',
			function( $fonts ) {
				// Remove the first option for testing.
				unset( $fonts['f1'] );
				// Add a new font for testing.
				$fonts['new_font'] = '<span class="new_font-font-title">New Font</span><span class="new_font-font-body">New Font is the font your body copy will appear in.</span>';
				return $fonts;
			}
		);

		// Define the expected result of this filter.
		$expected = array(
			'f2'       => '<span class="f2-font-title">Capita Bold</span><span class="f2-font-body">Benton Sans Regular is the font your body copy will appear in.</span>',
			'f3'       => '<span class="f3-font-title">Benton Light</span><span class="f3-font-body">Capita Regular is the font your body copy will appear in.</span>',
			'f4'       => '<span class="f4-font-title">Tiempos Bold</span><span class="f4-font-body">Tiempos Regular is the font your body copy will appear in.</span>',
			'f5'       => '<span class="f5-font-title">Pressura Heading</span><span class="f5-font-body">Benton Sans Regular is the font your body copy will appear in.</span>',
			'new_font' => '<span class="new_font-font-title">New Font</span><span class="new_font-font-body">New Font is the font your body copy will appear in.</span>',
		);

		$this->assertEquals( $expected, responsive_font_options() );

	}

	/**
	 * Test the customizer style cache flush.
	 */
	public function test_responsive_flush_customizer_styles_cache() {
		update_option( 'burf_customizer_styles', 'hey this is a test option' );
		responsive_flush_customizer_styles_cache();
		$this->assertEmpty( responsive_flush_customizer_styles_cache() );
	}

	/**
	 * Test default color region sections.
	 */
	public function test_responsive_customizer_color_region_groups() {
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
	public function test_responsive_get_optional_color_regions() {
		$this->assertEquals( array( 'sidebar-bg' ), responsive_get_optional_color_regions() );
	}

	/**
	 * Test color scheme sanitization.
	 */
	public function test_responsive_sanitize_color_scheme() {
		$this->assertEquals( 'default', responsive_sanitize_color_scheme( 'default' ) );
		$this->assertEquals( 'slacker', responsive_sanitize_color_scheme( 'slacker' ) );
		$this->assertEquals( 'default', responsive_sanitize_color_scheme( 'non-existant-scheme' ) );
	}

	/**
	 * Test default color scheme choices.
	 */
	public function test_responsive_get_color_scheme_choices() {
		$this->assertEquals( responsive_get_color_scheme_choices(), array(
			'default' => 'Default',
			'slacker' => 'Slacker',
			'extra-spectral' => 'Extra Spectral',
			'rayleigh-scattering' => 'Rayleigh Scattering',
			'vinca-minor' => 'Vinca Minor',
			'eiffel' => 'Eiffel',
			'comm_ave' => 'Comm Ave',
		) );
	}

	/**
	 * Test correct color scheme is returned.
	 */
	public function test_responsive_get_color_scheme() {
		$this->assertEquals( 'Default', responsive_get_color_scheme()['label'] );
		$this->assertEquals( 'Vinca Minor', responsive_get_color_scheme( 'vinca-minor' )['label'] );
	}

	/**
	 * Theme and framework version constants.
	 */
	public function test_responsive_get_custom_colors() {
		$test_values = array( 'primaryNav-bg' => '#c2185b', 'primaryNav-border' => '#cd4279' );

		$this->assertEquals( array(), responsive_get_custom_colors() );

		update_option( 'burf_setting_custom_colors', $test_values );

		$this->assertEquals( $test_values, responsive_get_custom_colors() );
	}
}
