<?php
/**
 * Test container class template functions.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Container_Class_Functions
 *
 * @group sidebars
 */
class Tests_Responsive_Framework_Container_Class_Functions extends WP_UnitTestCase {

	/**
	 * Test inner content container class function with no args.
	 */
	function test_r_container_inner_class_no_args() {
		$this->expectOutputString( 'class="content-container"' );
		r_container_inner_class();
	}

	/**
	 * Test inner content container class function with no args when on a narrow template.
	 */
	function test_r_container_inner_class_no_args_narrow_template() {
		update_option( 'burf_setting_sidebar_location', 'bottom' );
		$this->expectOutputString( 'class="content-container-narrow"' );
		r_container_inner_class();
		update_option( 'burf_setting_sidebar_location', 'right' );
	}

	/**
	 * Test inner content container class function with string arg.
	 */
	function test_r_container_inner_class_string_arg() {
		$this->expectOutputString( 'class="content-container test class"' );
		r_container_inner_class( 'test class' );
	}

	/**
	 * Test inner content container class function with array arg.
	 */
	function test_r_container_inner_class_array_arg() {
		$this->expectOutputString( 'class="content-container test class"' );
		r_container_inner_class( array( 'test', 'class' ) );
	}

	/**
	 * Test inner content container class function with bad characters.
	 */
	function test_r_container_inner_class_bad_characters() {
		$this->expectOutputString( 'class="content-container te&quot;st c&amp;lass"' );
		r_container_inner_class( array( 'te"st', 'c&lass' ) );
	}

	/**
	 * Test inner content container class function with no classes.
	 */
	function test_r_container_inner_class_no_classes() {
		$this->expectOutputString( '' );

		add_filter( 'r_container_inner_class', '__return_empty_array' );
		r_container_inner_class( array( 'test', 'class' ) );
		remove_all_filters( 'r_container_inner_class' );
	}

	/**
	 * Test outer content container class function with no args.
	 */
	function test_r_container_outer_class_no_args() {
		$this->expectOutputString( 'class="container"' );
		r_container_outer_class();
	}

	/**
	 * Test outer content container class function with string arg.
	 */
	function test_r_container_outer_class_string_arg() {
		$this->expectOutputString( 'class="container test class"' );
		r_container_outer_class( 'test class' );
	}

	/**
	 * Test outer content container class function with array arg.
	 */
	function test_r_container_outer_class_array_arg() {
		$this->expectOutputString( 'class="container test class"' );
		r_container_outer_class( array( 'test', 'class' ) );
	}

	/**
	 * Test outer content container class function with bad characters.
	 */
	function test_r_container_outer_class_bad_characters() {
		$this->expectOutputString( 'class="container te&quot;st c&amp;lass"' );
		r_container_outer_class( array( 'te"st', 'c&lass' ) );
	}

	/**
	 * Test outer content container class function with no classes.
	 */
	function test_r_container_outer_class_no_classes() {
		$this->expectOutputString( '' );

		add_filter( 'r_container_outer_class', '__return_empty_array' );
		r_container_outer_class( array( 'test', 'class' ) );
		remove_all_filters( 'r_container_inner_class' );
	}

	/**
	 * Test when an empty array is passed.
	 */
	function test_r_prepare_passed_classes_empty_array() {
		$this->assertSame( array(), r_prepare_passed_classes( array() ) );
	}

	/**
	 * Test when an empty string is passed.
	 */
	function test_r_prepare_passed_classes_empty_string() {
		$this->assertSame( array(), r_prepare_passed_classes( '' ) );
	}

	/**
	 * Test when a single string class is passed.
	 */
	function test_r_prepare_passed_classes_single_string_class() {
		$expected = array(
			'some-class',
		);

		$this->assertSame( $expected, r_prepare_passed_classes( 'some-class' ) );
	}

	/**
	 * Test when multiple classes in a string are passed.
	 */
	function test_r_prepare_passed_classes_multiple_string_classes() {
		$expected = array(
			'some-class',
			'another-class',
		);

		$this->assertSame( $expected, r_prepare_passed_classes( 'some-class another-class' ) );
	}

	/**
	 * Test when a single class in an array is passed.
	 */
	function test_r_prepare_passed_classes_single_array_classes() {
		$expected = array(
			'some-class',
		);

		$this->assertSame( $expected, r_prepare_passed_classes( $expected ) );
	}

	/**
	 * Test when multiple classes in an array are passed.
	 */
	function test_r_prepare_passed_classes_multiple_array_classes() {
		$expected = array(
			'some-class',
			'another-class',
		);

		$this->assertSame( $expected, r_prepare_passed_classes( $expected ) );
	}
}
