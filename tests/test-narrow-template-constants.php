<?php
/**
 * Narrow template tests that depend on constants.
 *
 * Tests involving constants are intentionally separate because each test needs
 * to be run in an isolated process, drastically slowing down each test method.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Narrow_Template_Constants
 *
 * @group narrow-templates
 */
class Tests_Responsive_Framework_Narrow_Template_Constants extends WP_UnitTestCase {

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
	 * When posts sidebar show bottom constant is false, no narrow templates are allowed.
	 */
	function test_r_is_narrow_template_sidebar_bottom_constant_false() {
		define( 'BU_RESPONSIVE_POSTS_SIDEBAR_SHOW_BOTTOM', false );

		$this->assertFalse( r_is_narrow_template() );

		// Single posts (normally considered narrow), should not be narrow.
		$post_id = $this->factory->post->create( array(
			'post_title' => 'A Test Post',
			'post_type' => 'post',
		) );

		$this->go_to( get_permalink( $post_id ) );
		$this->assertFalse( r_is_narrow_template() );

		// Changing the option should have no effect.
		update_option( 'burf_setting_posts_sidebar_bottom', true );
		$this->assertFalse( r_is_narrow_template() );
		update_option( 'burf_setting_posts_sidebar_bottom', false );

		// Changing the sidebar position option should have no effect.
		update_option( 'burf_setting_sidebar_location', 'bottom' );
		$this->assertFalse( r_is_narrow_template() );
		update_option( 'burf_setting_sidebar_location', 'right' );

		// Defining the sidebar position constant should have no effect.
		define( 'BU_RESPONSIVE_SIDEBAR_POSITION', 'bottom' );

		$this->go_to( get_permalink( $post_id ) );
		$this->assertFalse( r_is_narrow_template() );
	}

	/**
	 * When posts sidebar show bottom constant is true, make sure narrow
	 * templates are returned correctly.
	 */
	function test_r_is_narrow_template_sidebar_bottom_constant_true() {
		define( 'BU_RESPONSIVE_POSTS_SIDEBAR_SHOW_BOTTOM', true );

		$this->assertFalse( r_is_narrow_template() );

		// Single posts should be narrow.
		$post_id = $this->factory->post->create( array(
			'post_title' => 'A Test Post',
			'post_type' => 'post',
		) );

		$this->go_to( get_permalink( $post_id ) );
		$this->assertTrue( r_is_narrow_template() );

		// Changing the option should have no effect.
		update_option( 'burf_setting_posts_sidebar_bottom', false );
		$this->assertTrue( r_is_narrow_template() );
		update_option( 'burf_setting_posts_sidebar_bottom', true );

		// Single pages should not be narrow, unless they have a whitelisted template.
		$page_id = $this->factory->post->create( array(
			'post_title' => 'A Test Page',
			'post_type' => 'page',
		) );

		$this->go_to( get_permalink( $page_id ) );
		$this->assertFalse( r_is_narrow_template() );

		update_post_meta( $page_id, '_wp_page_template', 'page-templates/news.php' );
		$this->assertTrue( r_is_narrow_template() );

		// Defining the sidebar position constant should have no effect.
		define( 'BU_RESPONSIVE_SIDEBAR_POSITION', 'right' );

		$this->go_to( get_permalink( $post_id ) );
		$this->assertTrue( r_is_narrow_template() );
	}

	/**
	 * When posts sidebar location is right, check the correct narrow templates
	 * are identified.
	 */
	function test_r_is_narrow_template_sidebar_location_right() {
		define( 'BU_RESPONSIVE_SIDEBAR_POSITION', 'right' );
		update_option( 'burf_setting_posts_sidebar_bottom', true );

		$this->assertFalse( r_is_narrow_template() );

		// Single posts should be narrow.
		$post_id = $this->factory->post->create( array(
			'post_title' => 'A Test Post',
			'post_type'  => 'post',
		) );

		$this->go_to( get_permalink( $post_id ) );
		$this->assertTrue( r_is_narrow_template() );

		// Pages should not be narrow, except if they have a whitelisted template.
		$page_id = $this->factory->post->create( array(
			'post_title' => 'A Test Page',
			'post_type' => 'page',
		) );

		$this->go_to( get_permalink( $page_id ) );
		$this->assertFalse( r_is_narrow_template() );

		update_post_meta( $page_id, '_wp_page_template', 'page-templates/news.php' );
		$this->assertTrue( r_is_narrow_template() );

		// Only single events should be narrow.
		$_GET['eid'] = '1';
		$this->assertTrue( r_is_narrow_template() );

		// Changing the option should have no effect.
		update_option( 'burf_setting_sidebar_location', 'bottom' );
		$this->assertTrue( r_is_narrow_template() );
		update_option( 'burf_setting_sidebar_location', 'right' );

		// Setting posts sidebar bottom to false makes less items narrow.
		update_option( 'burf_setting_posts_sidebar_bottom', false );
		$this->go_to( get_permalink( $post_id ) );
		$this->assertFalse( r_is_narrow_template() );

		$this->go_to( get_permalink( $page_id ) );
		$this->assertFalse( r_is_narrow_template() );

		update_post_meta( $page_id, '_wp_page_template', 'default' );
		$this->assertFalse( r_is_narrow_template() );
	}

	/**
	 * When posts sidebar location is bottom, everything is narrow.
	 */
	function test_r_is_narrow_template_sidebar_location_bottom() {
		define( 'BU_RESPONSIVE_SIDEBAR_POSITION', 'bottom' );

		$this->assertTrue( r_is_narrow_template() );

		// Single posts should be narrow.
		$post_id = $this->factory->post->create( array(
			'post_title' => 'A Test Post',
			'post_type'  => 'post',
		) );

		$this->go_to( get_permalink( $post_id ) );
		$this->assertTrue( r_is_narrow_template() );

		// Pages should be narrow, even if they are not whitelisted template.
		$page_id = $this->factory->post->create( array(
			'post_title' => 'A Test Page',
			'post_type'  => 'page',
		) );

		$this->go_to( get_permalink( $page_id ) );
		$this->assertTrue( r_is_narrow_template() );

		update_post_meta( $page_id, '_wp_page_template', 'page-templates/news.php' );
		$this->assertTrue( r_is_narrow_template() );

		// Changing the option should have no effect.
		update_option( 'burf_setting_sidebar_location', 'right' );
		$this->assertTrue( r_is_narrow_template() );
		update_option( 'burf_setting_sidebar_location', 'bottom' );

		// Defining posts sidebar show bottom false should prevent narrow templates.
		define( 'BU_RESPONSIVE_POSTS_SIDEBAR_SHOW_BOTTOM', false );

		// Test all previously true assertions.
		$this->assertFalse( r_is_narrow_template() );
		$this->go_to( get_permalink( $page_id ) );
		$this->assertFalse( r_is_narrow_template() );
		$this->go_to( get_permalink( $post_id ) );
		$this->assertFalse( r_is_narrow_template() );
	}
}
