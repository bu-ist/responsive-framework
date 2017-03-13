<?php
/**
 * Test default search functions.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Search
 *
 * @group search
 */
class Tests_Responsive_Framework_Search extends WP_UnitTestCase {
	/**
	 * Setup parent class.
	 */
	function setUp() {
		parent::setUp();

		if ( ! function_exists( 'responsive_bu_search_form_contexts' ) ) {
			require_once( dirname( dirname( __FILE__ ) ) . '/inc/search-form.php' );
		}
	}

	/**
	 * Test responsive_bu_search_form_contexts()
	 */
	function test_responsive_bu_search_form_contexts() {
		$this->assertEquals( responsive_bu_search_form_contexts(), array( 'site' => 'This Site' ) );
	}

	/**
	 * Test responsive_bu_search_form_query_attributes()
	 */
	function test_responsive_bu_search_form_query_attributes() {
		$this->assertEquals( responsive_bu_search_form_query_attributes( '' ), 'placeholder="Search site&hellip;"' );
	}
}
