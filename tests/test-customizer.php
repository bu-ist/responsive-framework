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

		// Test the fallback font value if none set in Options table.
		add_filter(
			'responsive_font_fallback',
			function( $fallback_font ) {
				$fallback_font = 'new_font';
				return $fallback_font;
			}
		);

		$this->assertEquals( 'new_font', responsive_get_font_palette() );
	}

	/**
	 * Test default responsive color palette.
	 */
	public function test_responsive_get_color_palette() {
		$this->assertEquals( 'default', responsive_get_color_palette() );
		update_option( 'burf_setting_colors', 'slacker' );
		$this->assertEquals( 'slacker', responsive_get_color_palette() );
		update_option( 'burf_setting_colors', 'default' );
	}

	/**
	 * Test the default color palettes.
	 */
	public function test_responsive_color_options() {
		$color_options = array(
			'default'             => 'Default',
			'slacker'             => 'Slacker',
			'extra-spectral'      => 'Extra Spectral',
			'rayleigh-scattering' => 'Rayleigh Scattering',
			'vinca-minor'         => 'Vinca Minor',
			'eiffel'              => 'Eiffel',
			'comm_ave'            => 'Comm Ave',
		);

		$this->assertEquals( $color_options, responsive_color_options() );
	}

	/**
	 * Test the default color palettes, but filtered.
	 */
	public function test_responsive_color_options_filtered() {

		// Add filter to change the default color family values.
		add_filter(
			'responsive_color_options',
			function( $color ) {
				// Remove the slacker option for testing.
				unset( $color['slacker'] );
				// Add a new color for testing.
				$color['new_color'] = 'New Testing Color';
				return $color;
			}
		);

		// Define the expected result of this filter.
		$expected = array(
			'default'             => 'Default',
			'extra-spectral'      => 'Extra Spectral',
			'rayleigh-scattering' => 'Rayleigh Scattering',
			'vinca-minor'         => 'Vinca Minor',
			'eiffel'              => 'Eiffel',
			'comm_ave'            => 'Comm Ave',
			'new_color'           => 'New Testing Color',
		);

		$this->assertEquals( $expected, responsive_color_options() );

		// Test the fallback color value if none set in Options table.
		add_filter(
			'responsive_color_fallback',
		function( $fallback_color ) {
				$fallback_color = 'new_color';
				return $fallback_color;
			}
		);

		$this->assertEquals( 'new_color', responsive_get_color_palette() );
	}

	/**
	 * Test the customizer style cache flush.
	 */
	public function test_responsive_flush_customizer_styles_cache() {
		update_option( 'burf_customizer_styles', 'hey this is a test option' );
		responsive_flush_customizer_styles_cache();
		$this->assertEmpty( responsive_flush_customizer_styles_cache() );
	}
}
