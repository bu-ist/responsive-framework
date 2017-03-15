<?php
/**
 * Flexi migration routines.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Migrate_Flexi
 *
 * @group upgrades
 */
class Tests_Responsive_Framework_Migrate_Flexi extends WP_UnitTestCase {
	/**
	 * Setup parent class.
	 */
	function setUp() {
		parent::setUp();

		require_once dirname( dirname( __FILE__ ) ) . '/inc/migration-helpers.php';
	}

	/**
	 * Test post display option conversion.
	 */
	function test_responsive_migrate_post_display_options() {
		update_option( 'flexi_display', array( 'cat' => 1, 'tag' => 1, 'author' => 1 ) );

		$this->assertTrue( responsive_migrate_post_display_options( false ) );
		$this->assertEquals( 'categories,tags,author', get_option( 'burf_setting_post_display_options' ) );
	}

	/**
	 * Test flexi footbar conversion.
	 */
	function test_responsive_migrate_flexi_footbars() {
		$test_id = $this->factory->post->create( array(
			'post_title' => 'Test Post',
			'post_type' => 'post',
			'meta_input' => array(
				'_bu_flexi_framework_footbar' => 'A test value.',
			),
		) );

		update_option( 'bu_flexi_framework_dynamic_footbars', true );

		responsive_migrate_flexi_footbars( false );

		$this->assertEquals( 'dynamic_footbars', get_option( 'burf_setting_sidebar_options' ) );
		$this->assertEquals( 'A test value.', get_post_meta( $test_id, '_bu_footbar_id', true ) );
	}
}
