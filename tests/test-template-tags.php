<?php
/**
 * Test template tag functions.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Template_Tags
 *
 * @group sidebars
 */
class Tests_Responsive_Framework_Template_Tags extends WP_UnitTestCase {

	var $test_post_id = 0;

	/**
	 * Setup parent class.
	 */
	function setUp() {
		parent::setUp();

		$this->test_post_id = $this->factory->post->create( array(
			'post_title' => 'Test Post',
			'post_type' => 'post',
		) );
	}

	/**
	 * Default site title.
	 */
	function test_responsive_get_title() {
		update_option( 'blogname', 'Responsive Framework' );

		$expected = 'Responsive Framework';

		ob_start();
		responsive_get_title();
		$actual = ob_get_clean();

		$this->assertEquals( $expected, $actual );
	}

	/**
	 * Test default comment support.
	 */
	function test_responsive_has_comment_support() {
		$this->assertTrue( responsive_has_comment_support() );
	}

	/**
	 * Test default search setting.
	 */
	function test_responsive_search_is_enabled() {
		$this->assertTrue( responsive_search_is_enabled() );
	}

	/**
	 * Test the default search form output.
	 */
	function test_responsive_search_form() {
		ob_start();
		get_search_form();
		$expected_output = ob_get_clean();

		$this->expectOutputString( $expected_output );

		responsive_search_form();
	}

	/**
	 * Test category link list output.
	 */
	function test_responsive_category_links() {
		wp_set_object_terms( $this->test_post_id, array( 'Category 1', 'Category 2' ), false );

		$this->expectOutputString( get_the_category_list( ', ', '', $this->test_post_id ) );

		responsive_category_links();

		wp_set_object_terms( $this->test_post_id, array( 'Uncategorized' ), false );
	}

	/**
	 * Test default content banner return value.
	 */
	function test_responsive_content_banner() {
		$this->assertEmpty( responsive_content_banner( 'test' ) );
	}

}
