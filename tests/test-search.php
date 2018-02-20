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
	 * Test responsive_bu_search_form_contexts()
	 */
	function test_responsive_bu_search_form_contexts() {
		$this->assertEquals( responsive_bu_search_form_contexts(), array( 'site' => 'This Site' ) );
	}
}
