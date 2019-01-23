<?php
/**
 * Test Responsive layout related functions that depend on constants.
 *
 * Tests involving constants are intentionally separate because each test needs
 * to be run in an isolated process, drastically slowing down each test method.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Layouts_Constants
 *
 * @group layouts
 */
class Tests_Responsive_Framework_Layouts_Constants extends WP_UnitTestCase {

	/**
	 * Do not preserve global state between test methods.
	 *
	 * @var bool
	 */
	protected $preserveGlobalState = false;

	/**
	 * Run each test method in a separate, isolated process.
	 *
	 * This ensures constants are properly set and tested.
	 *
	 * @var bool
	 */
	protected $runTestInSeparateProcess = true;

	/**
	 * Setup each test method.
	 *
	 * - Make sure to load the admin.php file.
	 * - Make sure the layout option is empty.
	 * - Make sure the transient does not exist.
	 */
	function setUp() {
		parent::setUp();

		include_once dirname( dirname( __FILE__ ) ) . '/admin/admin.php';

		set_current_screen( 'dashboard' );

		delete_option( 'burf_setting_layout' );
		delete_transient( 'responsive_layout_setting_check' );
	}

	/**
	 * Test default responsive layout options.
	 */
	function test_responsive_layout_options() {
		$layout_options = array(
			'default' => 'Default Navigation <span class="ui-context">A good choice for most websites</span>',
			'top-nav'  => 'Top Navigation <span class="ui-context">Best for websites without dropdowns</span>',
			'side-nav' => 'Side Navigation <span class="ui-context">Best for small websites with few nested pages</span>',
			'mega-nav' => 'Mega Navigation <span class="ui-context">Best for large, complex websites</span>',
			'no-nav'   => 'No Navigation <span class="ui-context">Best for single-page websites</span>',
		);

		$this->assertEquals( $layout_options, responsive_layout_options() );
	}

	/**
	 * Test default responsive layout when no constant is set.
	 */
	function test_responsive_layout_no_constant() {
		$this->assertEquals( 'default', responsive_layout() );

		update_option( 'burf_setting_layout', 'side-nav' );
		$this->assertEquals( 'side-nav', responsive_layout() );

		update_option( 'burf_setting_layout', 'not-a-layout' );
		$this->assertEquals( 'default', responsive_layout() );
	}

	/**
	 * Test default responsive layout when a constant is set with an invalid layout.
	 */
	function test_responsive_layout_invalid_constant() {
		define( 'BU_RESPONSIVE_LAYOUT', 'not-a-layout' );

		$this->assertEquals( 'default', responsive_layout() );

		update_option( 'burf_setting_layout', 'side-nav' );
		$this->assertEquals( 'side-nav', responsive_layout() );

		update_option( 'burf_setting_layout', 'not-a-layout' );
		$this->assertEquals( 'default', responsive_layout() );
	}

	/**
	 * Test default responsive layout when a constant is set with an valid layout.
	 */
	function test_responsive_layout_valid_constant() {
		define( 'BU_RESPONSIVE_LAYOUT', 'side-nav' );

		$this->assertEquals( 'side-nav', responsive_layout() );

		update_option( 'burf_setting_layout', 'top-nav' );
		$this->assertEquals( 'side-nav', responsive_layout() );

		update_option( 'burf_setting_layout', 'default' );
		$this->assertEquals( 'side-nav', responsive_layout() );
	}

	/**
	 * Test that default is saved to the option when no constant is defined
	 * and the option is empty.
	 */
	function test_responsive_maybe_save_layout_setting_no_constant_no_option() {
		responsive_maybe_save_layout_setting();

		$this->assertSame( 'default', get_option( 'burf_setting_layout' ) );
	}

	/**
	 * Test that the constant value is saved when no option exists.
	 */
	function test_responsive_maybe_save_layout_setting_constant_no_option() {
		define( 'BU_RESPONSIVE_LAYOUT', 'top-nav' );

		responsive_maybe_save_layout_setting();

		$this->assertSame( 'top-nav', get_option( 'burf_setting_layout' ) );
	}

	/**
	 * Test that the constant value is saved when an option value exists.
	 */
	function test_responsive_maybe_save_layout_setting_constant_option_mismatch() {
		define( 'BU_RESPONSIVE_LAYOUT', 'top-nav' );
		update_option( 'burf_setting_layout', 'side-nav' );

		responsive_maybe_save_layout_setting();

		$this->assertSame( 'top-nav', get_option( 'burf_setting_layout' ) );
	}

	/**
	 * Test that the constant value does not overwrite when the transient is valid.
	 */
	function test_responsive_maybe_save_layout_setting_constant_option_transient() {
		define( 'BU_RESPONSIVE_LAYOUT', 'top-nav' );
		update_option( 'burf_setting_layout', 'side-nav' );

		set_transient( 'responsive_layout_setting_check', '', WEEK_IN_SECONDS );

		responsive_maybe_save_layout_setting();

		$this->assertSame( 'side-nav', get_option( 'burf_setting_layout' ) );
	}
}
