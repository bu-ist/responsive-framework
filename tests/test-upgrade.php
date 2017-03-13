<?php
/**
 * Theme upgrade routines.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Upgrades
 *
 * @group upgrades
 */
class Tests_Responsive_Framework_Upgrades extends WP_UnitTestCase {
	/**
	 * Setup parent class.
	 */
	function setUp() {
		parent::setUp();
	}

	/**
	 * Test our theme is actually active.
	 */
	function test_responsive_framework_upgrade() {
		update_option( '_responsive_framework_version', '0.0' );

		responsive_framework_upgrade();

		$this->assertEquals( RESPONSIVE_FRAMEWORK_VERSION, get_option( '_responsive_framework_version' ) );
	}

	/**
	 * Test upgrade routines from Responsive 0.91.
	 */
	function test_responsive_upgrade_091() {
		$test_page_id_1 = $this->factory->post->create( array(
			'post_title' => 'Test Page 1',
			'post_type' => 'page',
			'meta_input' => array(
				'_wp_page_template' => 'calendar.php',
				'_bu_banner' => array(
					'position' => 'content-width',
				),
			),
		) );
		$test_page_id_2 = $this->factory->post->create( array(
			'post_title' => 'Test Page 2',
			'post_type' => 'page',
			'meta_input' => array(
				'_wp_page_template' => 'news.php',
				'_bu_banner' => array(
					'position' => 'page-width',
				),
			),
		) );
		$test_page_id_3 = $this->factory->post->create( array(
			'post_title' => 'Test Page 3',
			'post_type' => 'page',
			'meta_input' => array(
				'_wp_page_template' => 'page-nosidebars.php',
				'_bu_banner' => array(
					'position' => 'window-width',
				),
			),
		) );
		$test_page_id_4 = $this->factory->post->create( array(
			'post_title' => 'Test Page 4',
			'post_type' => 'page',
			'meta_input' => array(
				'_wp_page_template' => 'profiles.php',
			),
		) );

		responsive_upgrade_091();

		// Test page template conversions.
		$this->assertEquals( 'page-templates/calendar.php', get_post_meta( $test_page_id_1, '_wp_page_template', true ) );
		$this->assertEquals( 'page-templates/news.php', get_post_meta( $test_page_id_2, '_wp_page_template', true ) );
		$this->assertEquals( 'page-templates/no-sidebars.php', get_post_meta( $test_page_id_3, '_wp_page_template', true ) );
		$this->assertEquals( 'page-templates/profiles.php', get_post_meta( $test_page_id_4, '_wp_page_template', true ) );

		// Test BU Banner conversions.
		$this->assertEquals( array( 'position' => 'contentWidth' ), get_post_meta( $test_page_id_1, '_bu_banner', true ) );
		$this->assertEquals( array( 'position' => 'pageWidth' ), get_post_meta( $test_page_id_2, '_bu_banner', true ) );
		$this->assertEquals( array( 'position' => 'windowWidth' ), get_post_meta( $test_page_id_3, '_bu_banner', true ) );
	}
}
