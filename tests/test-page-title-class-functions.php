<?php
/**
 * Test page title class functions.
 *
 * @package Responsive_Framework
 */

/**
 * Tests_Responsive_Framework_Page_Title_Class_Functions
 *
 * @group sidebars
 */
class Tests_Responsive_Framework_Page_Title_Class_Functions extends WP_UnitTestCase {

	/**
	 * Test page title class function with no args.
	 */
	function test_r_page_title_class_no_args() {
		$this->assertEquals( 'class="page-title"', r_page_title_class() );
	}

	/**
	 * Test page title class function with string arg.
	 */
	function test_r_page_title_class_string_arg() {
		$this->assertEquals( 'class="page-title test class"', r_page_title_class( 'test class' ) );
	}

	/**
	 * Test page title class function with array arg.
	 */
	function test_r_page_title_class_array_arg() {
		$this->assertEquals( 'class="page-title test class"', r_page_title_class( array( 'test', 'class' ) ) );
	}

	/**
	 * Test page title class function with bad characters.
	 */
	function test_r_page_title_class_bad_characters() {
		$this->assertEquals( 'class="page-title te&quot;st c&amp;lass"', r_page_title_class( array( 'te"st', 'c&lass' ) ) );
	}

	/**
	 * Test page title class function with no classes.
	 */
	function test_r_page_title_class_no_classes() {
		add_filter( 'r_page_title_class', '__return_empty_array' );
		$this->assertEquals( '', r_page_title_class( array( 'test', 'class' ) ) );
		remove_all_filters( 'r_page_title_class' );
	}

	/**
	 * Test page title class function with no args, display.
	 */
	function test_r_page_title_class_no_args_display() {
		$this->expectOutputString( 'class="page-title"' );
		r_page_title_class( '', true );
	}

	/**
	 * Test page title class function with string arg, display.
	 */
	function test_r_page_title_class_string_arg_display() {
		$this->expectOutputString( 'class="page-title test class"' );
		r_page_title_class( 'test class', true );
	}

	/**
	 * Test page title class function with array arg, display.
	 */
	function test_r_page_title_class_array_arg_display() {
		$this->expectOutputString( 'class="page-title test class"' );
		r_page_title_class( array( 'test', 'class' ), true );
	}

	/**
	 * Test page title class function with bad characters.
	 */
	function test_r_page_title_class_bad_characters_display() {
		$this->expectOutputString( 'class="page-title te&quot;st c&amp;lass"' );
		r_page_title_class( array( 'te"st', 'c&lass' ), true );
	}

	/**
	 * Test page title class function with no classes.
	 */
	function test_r_page_title_class_no_classes_display() {
		$this->expectOutputString( '' );
		add_filter( 'r_page_title_class', '__return_empty_array' );
		r_page_title_class( array( 'test', 'class' ), true );
		remove_all_filters( 'r_page_title_class' );
	}
}
