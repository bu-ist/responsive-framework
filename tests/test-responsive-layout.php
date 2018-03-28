<?php
/**
 * Test Responsive layout related functions.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Layout
 *
 * @group responsive-layout
 */
class Tests_Responsive_Layout extends WP_UnitTestCase {

	/**
	 * Test that the correct default value is returned.
	 */
	function test_responsive_get_layout_default() {
		$this->assertSame( 'default', responsive_get_layout_default() );
	}

	/**
	 * Test that the first layout in the list is used when `default` is not a
	 * valid layout (because it was removed with a filter).
	 */
	function test_responsive_get_layout_default_no_default_layout() {
		add_filter( 'responsive_layout_options', array( $this, 'filter_responsive_layout_options_remove_default' ) );
		$this->assertSame( 'top-nav', responsive_get_layout_default() );
		remove_all_filters( 'responsive_layout_options' );
	}

	/**
	 * Test that the framework's default option is returned when the default is
	 * filtered and the value is not a valid layout option.
	 */
	function test_responsive_get_layout_default_changed_default_invalid() {
		add_filter( 'responsive_layout_default', array( $this, 'filter_responsive_layout_default_invalid' ) );
		$this->assertSame( 'default', responsive_get_layout_default() );
		remove_all_filters( 'responsive_layout_default' );
	}

	/**
	 * Test that the a new filtered default is returned correctly (standard framework option).
	 */
	function test_responsive_get_layout_default_changed_default_valid_standard() {
		add_filter( 'responsive_layout_default', array( $this, 'filter_responsive_layout_default_valid_standard' ) );
		$this->assertSame( 'no-nav', responsive_get_layout_default() );
		remove_all_filters( 'responsive_layout_default' );
	}

	/**
	 * Test that the a new filtered default is returned correctly (non-standard framework option).
	 */
	function test_responsive_get_layout_default_changed_default_valid_non_standard() {
		add_filter( 'responsive_layout_options', array( $this, 'filter_responsive_layout_options_add_layout' ) );
		add_filter( 'responsive_layout_default', array( $this, 'filter_responsive_layout_default_valid_non_standard' ) );

		$this->assertSame( 'custom-layout', responsive_get_layout_default() );

		remove_all_filters( 'responsive_layout_default' );
		remove_all_filters( 'responsive_layout_options' );
	}

	/**
	 * Remove the default layout option from the list of available layouts.
	 *
	 * @param array $layouts List of layout options.
	 *
	 * @return array List of layout options.
	 */
	function filter_responsive_layout_options_remove_default( $layouts ) {
		unset( $layouts['default'] );

		return $layouts;
	}

	/**
	 * Return an invalid layout for the responsive_layout_default filter.
	 *
	 * @return string Default layout.
	 */
	function filter_responsive_layout_default_invalid() {
		return 'not-a-layout';
	}

	/**
	 * Return a valid new default layout that is standard for the framework.
	 */
	function filter_responsive_layout_default_valid_standard() {
		return 'no-nav';
	}

	/**
	 * Add a new layout option to the list of available layouts.
	 *
	 * @param array $layouts List of layout options.
	 *
	 * @return array List of layout options.
	 */
	function filter_responsive_layout_options_add_layout( $layouts ) {
		$layouts['custom-layout'] = 'Custom Layout';

		return $layouts;
	}

	/**
	 * Return a valid new default layout that is not standard for the framework.
	 */
	function filter_responsive_layout_default_valid_non_standard() {
		return 'custom-layout';
	}
}
