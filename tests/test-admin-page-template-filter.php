<?php
/**
 * Test the page filter for page template.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Admin_Page_Template_Filter
 *
 * @group admin-page-template-filter
 */
class Tests_Responsive_Framework_Admin_Page_Template_Filter extends WP_UnitTestCase {

	/**
	 * Check query vars are not added when they shouldn't be.
	 */
	function test_page_template_filter_query_vars_admin_not_edit() {
		include_once dirname( dirname( __FILE__ ) ) . '/admin/admin.php';

		set_current_screen( 'dashboard' );

		$expected = array(
			'query_var_1',
			'query_var_2',
		);

		$this->assertSame( $expected, BU\Responsive\Admin\Page_Template_Filters\query_vars( $expected ) );
	}

	/**
	 * Check query vars are added on the edit posts screen.
	 */
	function test_page_template_filter_query_vars_admin_edit_page() {
		include_once dirname( dirname( __FILE__ ) ) . '/admin/admin.php';

		set_current_screen( 'edit-posts' );

		$expected = array(
			'query_var_1',
			'query_var_2',
			'responsive_template_filter_top',
			'responsive_template_filter_bottom',
		);

		$this->assertSame( $expected, BU\Responsive\Admin\Page_Template_Filters\query_vars( $expected ) );
	}
}
