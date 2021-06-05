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
	 * Test our theme is actually active.
	 */
	function test_responsive_framework_upgrade() {
		update_option( '_responsive_framework_version', '0.0' );

		responsive_framework_upgrade( false );

		$this->assertEquals( RESPONSIVE_FRAMEWORK_VERSION, get_option( '_responsive_framework_version' ) );
	}

	/**
	 * Test upgrade routines from Responsive 0.91.
	 */
	function test_responsive_upgrade_091() {
		$test_page_id_1 = $this->factory->post->create(
			array(
				'post_title' => 'Test Page 1',
				'post_type'  => 'page',
				'meta_input' => array(
					'_wp_page_template' => 'calendar.php',
					'_bu_banner'        => array(
						'position' => 'content-width',
					),
				),
			)
		);
		$test_page_id_2 = $this->factory->post->create(
			array(
				'post_title' => 'Test Page 2',
				'post_type'  => 'page',
				'meta_input' => array(
					'_wp_page_template' => 'news.php',
					'_bu_banner'        => array(
						'position' => 'page-width',
					),
				),
			)
		);
		$test_page_id_3 = $this->factory->post->create(
			array(
				'post_title' => 'Test Page 3',
				'post_type'  => 'page',
				'meta_input' => array(
					'_wp_page_template' => 'page-nosidebars.php',
					'_bu_banner'        => array(
						'position' => 'window-width',
					),
				),
			)
		);
		$test_page_id_4 = $this->factory->post->create(
			array(
				'post_title' => 'Test Page 4',
				'post_type'  => 'page',
				'meta_input' => array(
					'_wp_page_template' => 'profiles.php',
				),
			)
		);

		responsive_upgrade_091( false );

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

	/**
	 * Test Responsive 2.0 upgrade routine for banner positions.
	 */
	function test_responsive_upgrade_2_0_banner_positions() {
		$test_page_id_1 = $this->factory->post->create(
			array(
				'post_title' => 'Test Page 1',
				'post_type'  => 'page',
				'meta_input' => array(
					'_wp_page_template' => 'calendar.php',
					'_bu_banner'        => array(
						'position' => 'contentWidth',
					),
				),
			)
		);
		$test_page_id_2 = $this->factory->post->create(
			array(
				'post_title' => 'Test Page 2',
				'post_type'  => 'page',
				'meta_input' => array(
					'_wp_page_template' => 'news.php',
					'_bu_banner'        => array(
						'position' => 'pageWidth',
					),
				),
			)
		);
		$test_page_id_3 = $this->factory->post->create(
			array(
				'post_title' => 'Test Page 3',
				'post_type'  => 'page',
				'meta_input' => array(
					'_wp_page_template' => 'page-nosidebars.php',
					'_bu_banner'        => array(
						'position' => 'windowWidth',
					),
				),
			)
		);

		responsive_upgrade_2_0( false );

		$this->assertEquals( array( 'position' => 'content-width' ), get_post_meta( $test_page_id_1, '_bu_banner', true ) );
		$this->assertEquals( array( 'position' => 'page-width' ), get_post_meta( $test_page_id_2, '_bu_banner', true ) );
		$this->assertEquals( array( 'position' => 'window-width' ), get_post_meta( $test_page_id_3, '_bu_banner', true ) );
	}

	/**
	 * Test Responsive 2.0 upgrade routine for layout names.
	 */
	function test_responsive_upgrade_2_0_layout_names() {
		update_option( 'burf_setting_layout', 'topNav' );
		responsive_upgrade_2_0( false );
		$this->assertEquals( 'top-nav', get_option( 'burf_setting_layout' ) );

		update_option( 'burf_setting_layout', 'sideNav' );
		responsive_upgrade_2_0( false );
		$this->assertEquals( 'side-nav', get_option( 'burf_setting_layout' ) );

		update_option( 'burf_setting_layout', 'noNav' );
		responsive_upgrade_2_0( false );
		$this->assertEquals( 'no-nav', get_option( 'burf_setting_layout' ) );
	}

	/**
	 * Test Responsive 2.0 upgrade routine when no layout is saved and no constant is set.
	 */
	function test_responsive_upgrade_2_0_layout_empty() {
		delete_option( 'burf_setting_layout' );

		responsive_upgrade_2_0( false );

		$this->assertSame( 'default', get_option( 'burf_setting_layout' ) );
	}

	/**
	 * Test Responsive 2.0 upgrade routine when no layout is saved and a constant
	 * is set with a value that is not an allowed layout.
	 */
	function test_responsive_upgrade_2_0_layout_invalid_constant() {
		update_option( 'burf_setting_layout', 'not-a-valid-layout' );

		responsive_upgrade_2_0( false );

		$this->assertSame( 'default', get_option( 'burf_setting_layout' ) );
	}

	/**
	 * Test Responsive 2.0 upgrade routine for template names.
	 */
	function test_responsive_upgrade_2_0_templates() {
		$test_page_id = $this->factory->post->create(
			array(
				'post_title' => 'Test Page 4',
				'post_type'  => 'page',
				'meta_input' => array(
					'_wp_page_template' => 'page-templates/profiles.php',
				),
			)
		);

		responsive_upgrade_2_0( false );

		$this->assertEquals( 'profiles.php', get_post_meta( $test_page_id, '_wp_page_template', true ) );
	}
}
