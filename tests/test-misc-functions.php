<?php
/**
 * Test miscellaneous functions.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Miscellaneous_Functions
 *
 * @group narrow-templates
 */
class Tests_Responsive_Framework_Miscellaneous_Functions extends WP_UnitTestCase {

	/**
	 * Test for narrow template when feature is disabled.
	 */
	function test_r_is_narrow_template() {
		$this->assertFalse( r_is_narrow_template() );
	}

	/**
	 * If sidebar is on the bottom, it should always be narrow.
	 */
	function test_r_is_narrow_template_bottom_sidebar_location() {
		update_option( 'burf_setting_sidebar_location', 'bottom' );
		$this->assertTrue( r_is_narrow_template() );
		update_option( 'burf_setting_sidebar_location', 'right' );
	}

	/**
	 * Single posts should be considered narrow.
	 */
	function test_r_is_narrow_template_single_post() {
		update_option( 'burf_setting_posts_sidebar_bottom', true );

		$post_id = $this->factory->post->create( array(
			'post_title' => 'A Test Post',
			'post_type' => 'post',
		) );

		$this->go_to( get_permalink( $post_id ) );

		$this->assertTrue( r_is_narrow_template() );

		update_option( 'burf_setting_posts_sidebar_bottom', false );
	}

	/**
	 * Single posts should not be considered narrow when filtered.
	 */
	function test_r_is_narrow_template_single_post_filtered() {
		update_option( 'burf_setting_posts_sidebar_bottom', true );

		$post_id = $this->factory->post->create( array(
			'post_title' => 'A Test Post',
			'post_type' => 'post',
		) );

		$this->go_to( get_permalink( $post_id ) );

		/**
		 * Remove posts from allowed post types and test.
		 */
		add_filter( 'r_narrow_single_templates', array( $this, 'filter_r_narrow_single_templates' ) );
		$this->assertFalse( r_is_narrow_template() );
		remove_all_filters( 'r_narrow_single_templates' );

		update_option( 'burf_setting_posts_sidebar_bottom', false );
	}

	/**
	 * Post type archives should be considered narrow.
	 */
	function test_r_is_narrow_template_post_archive() {
		update_option( 'burf_setting_posts_sidebar_bottom', true );

		$post_id = $this->factory->post->create( array(
			'post_title' => 'A Test Post',
			'post_type' => 'post',
		) );

		$this->go_to( get_post_type_archive_link( 'post' ) );

		$this->assertTrue( r_is_narrow_template() );

		update_option( 'burf_setting_posts_sidebar_bottom', false );
	}

	/**
	 * Calendar page should not be considered narrow.
	 */
	function test_r_is_narrow_template_calendar_page() {
		update_option( 'burf_setting_posts_sidebar_bottom', true );

		$page_id = $this->factory->post->create( array(
			'post_title' => 'Calendar',
			'post_type' => 'page',
			'pagename' => 'calendar',
		) );

		$this->go_to( get_permalink( $page_id ) );

		$this->assertFalse( r_is_narrow_template() );

		update_post_meta( $page_id, '_wp_page_template', 'page-templates/calendar.php' );

		$this->assertFalse( r_is_narrow_template() );

		update_post_meta( $page_id, '_wp_page_template', 'page-templates/news.php' );

		$this->assertTrue( r_is_narrow_template() );

		update_post_meta( $page_id, '_wp_page_template', 'another-post-template.php' );

		/**
		 * Add calendar page template to list of allowed post types to check our filter works properly.
		 */
		add_filter( 'r_narrow_page_templates', array( $this, 'filter_r_narrow_page_templates' ) );
		$this->assertTrue( r_is_narrow_template() );
		remove_all_filters( 'r_narrow_page_templates' );

		update_option( 'burf_setting_posts_sidebar_bottom', false );
	}

	/**
	 * Single events should always be considered narrow.
	 */
	function test_r_is_narrow_template_single_calendar_event() {
		$_GET['eid'] = 1;

		$this->assertTrue( r_is_narrow_template() );

		update_option( 'burf_setting_posts_sidebar_bottom', true );

		$this->assertTrue( r_is_narrow_template() );

		update_option( 'burf_setting_posts_sidebar_bottom', false );
	}

	/**
	 * Alter allowed post types for testing.
	 *
	 * @return array
	 */
	function filter_r_narrow_single_templates() {
		return array(
			'profile',
		);
	}

	/**
	 * Alter allowed page templates for testing.
	 *
	 * @param array $templates List of allowed templates.
	 *
	 * @return array
	 */
	function filter_r_narrow_page_templates( $templates ) {
		$templates[] = 'another-post-template.php';

		return $templates;
	}

	/**
	 * Test the default image link type is set to none.
	 */
	function test_responsive_update_image_default_link_type() {
		update_option( 'image_default_link_type', 'file' );
		$this->assertEquals( 'file', get_option( 'image_default_link_type' ) );

		responsive_update_image_default_link_type();
		$this->assertEquals( 'none', get_option( 'image_default_link_type' ) );
	}
}
