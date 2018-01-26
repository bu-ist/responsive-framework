<?php
/**
 * Test Responsive Gallery related functions.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Gallery
 *
 * @group branding
 */
class Tests_Responsive_Framework_Gallery extends WP_UnitTestCase {

	/**
	 * Ensure scripts are dequeued after each test method.
	 */
	function tearDown() {
		parent::tearDown();

		wp_dequeue_script( 'responsive-framework-gallery' );
		wp_dequeue_style( 'lightgallery' );
	}

	/**
	 * Ensure the scripts and styles are registered correctly.
	 */
	function test_responsive_gallery_wp_default_scripts() {
		BU\Themes\Responsive_Framework\Galleries\wp_default_scripts();

		$this->assertTrue( wp_script_is( 'responsive-framework-gallery', 'registered' ) );
		$this->assertTrue( wp_style_is( 'lightgallery', 'registered' ) );

		$this->assertFalse( wp_script_is( 'responsive-framework-gallery' ) );
		$this->assertFalse( wp_style_is( 'lightgallery' ) );
	}

	/**
	 * Test default responsive layout.
	 */
	function test_responsive_gallery_after_setup_theme() {
		BU\Themes\Responsive_Framework\Galleries\after_setup_theme();

		$this->assertTrue( has_image_size( 'responsive_gallery' ) );
		$this->assertTrue( has_image_size( 'responsive_gallery_1col' ) );
		$this->assertTrue( has_image_size( 'responsive_gallery_5col_up' ) );
	}

	/**
	 * Ensure lightgallery scripts are not loaded when not on a singular post.
	 */
	function test_responsive_gallery_wp_enqueue_scripts_front_page() {
		$this->go_to( home_url() );

		BU\Themes\Responsive_Framework\Galleries\wp_enqueue_scripts();
		$this->assertFalse( wp_script_is( 'responsive-framework-gallery' ) );
		$this->assertFalse( wp_style_is( 'lightgallery' ) );
	}

	/**
	 * Ensure lightgallery scripts are not loaded when on a post with no\
	 * gallery.
	 */
	function test_responsive_gallery_wp_enqueue_scripts_singular_no_gallery() {
		$post_id = $this->factory->post->create(
			array(
				'post_type'  => 'post',
				'post_title' => 'A Post With No Gallery',
			)
		);
		$this->go_to( get_permalink( $post_id ) );

		BU\Themes\Responsive_Framework\Galleries\wp_enqueue_scripts();
		$this->assertFalse( wp_script_is( 'responsive-framework-gallery' ) );
		$this->assertFalse( wp_style_is( 'lightgallery' ) );
	}

	/**
	 * Ensure scripts are enqueued when there is a shortcode in post content.
	 */
	function test_responsive_gallery_wp_enqueue_scripts_with_shortcode() {
		$post_id = $this->factory->post->create(
			array(
				'post_type'    => 'post',
				'post_title'   => 'A Post With A Gallery',
				'post_content' => '[gallery size="medium" ids="11,10,9,8,12"]',
			)
		);
		$this->go_to( get_permalink( $post_id ) );

		BU\Themes\Responsive_Framework\Galleries\wp_enqueue_scripts();
		$this->assertTrue( wp_script_is( 'responsive-framework-gallery' ) );
		$this->assertTrue( wp_style_is( 'lightgallery' ) );
	}

	/**
	 * Ensure a gallery that does not use the thumbnail size is unchanged.
	 */
	function test_responsive_galleries_shortcode_atts_gallery_not_thumbnail() {
		$original = array(
			'size'    => 'medium',
			'columns' => 3,
			'link'    => 'none',
		);

		$expected = array(
			'size'    => 'medium',
			'columns' => 3,
			'link'    => 'file',
		);

		$this->assertSame( $expected, BU\Themes\Responsive_Framework\Galleries\shortcode_atts_gallery( $original ) );
	}

	/**
	 * Ensure a 1 column gallery gets the correct image size.
	 */
	function test_responsive_galleries_shortcode_atts_gallery_1_column() {
		$original = array(
			'size'    => 'thumbnail',
			'columns' => 1,
			'link'    => 'none',
		);

		$expected = array(
			'size'    => 'responsive_gallery_1col',
			'columns' => 1,
			'link'    => 'file',
		);

		$this->assertSame( $expected, BU\Themes\Responsive_Framework\Galleries\shortcode_atts_gallery( $original ) );
	}

	/**
	 * Ensure a 2 column gallery gets the correct image size.
	 */
	function test_responsive_galleries_shortcode_atts_gallery_2_column() {
		$original = array(
			'size'    => 'thumbnail',
			'columns' => 2,
			'link'    => 'none',
		);

		$expected = array(
			'size'    => 'responsive_gallery',
			'columns' => 2,
			'link'    => 'file',
		);

		$this->assertSame( $expected, BU\Themes\Responsive_Framework\Galleries\shortcode_atts_gallery( $original ) );
	}

	/**
	 * Ensure a 4 column gallery gets the correct image size.
	 */
	function test_responsive_galleries_shortcode_atts_gallery_4_column() {
		$original = array(
			'size'    => 'thumbnail',
			'columns' => 4,
			'link'    => 'none',
		);

		$expected = array(
			'size'    => 'responsive_gallery',
			'columns' => 4,
			'link'    => 'file',
		);

		$this->assertSame( $expected, BU\Themes\Responsive_Framework\Galleries\shortcode_atts_gallery( $original ) );
	}

	/**
	 * Ensure a 5 column gallery gets the correct image size.
	 */
	function test_responsive_galleries_shortcode_atts_gallery_5_column() {
		$original = array(
			'size'    => 'thumbnail',
			'columns' => 5,
			'link'    => 'none',
		);

		$expected = array(
			'size'    => 'responsive_gallery_5col_up',
			'columns' => 5,
			'link'    => 'file',
		);

		$this->assertSame( $expected, BU\Themes\Responsive_Framework\Galleries\shortcode_atts_gallery( $original ) );
	}

	/**
	 * Ensure an 8 column gallery gets the correct image size.
	 */
	function test_responsive_galleries_shortcode_atts_gallery_8_column() {
		$original = array(
			'size'    => 'thumbnail',
			'columns' => 8,
			'link'    => 'none',
		);

		$expected = array(
			'size'    => 'responsive_gallery_5col_up',
			'columns' => 8,
			'link'    => 'file',
		);

		$this->assertSame( $expected, BU\Themes\Responsive_Framework\Galleries\shortcode_atts_gallery( $original ) );
	}

	/**
	 * Test that the gallery scripts are correctly enqueued.
	 */
	function test_r_enqueue_fancy_gallery() {
		$this->assertFalse( wp_script_is( 'responsive-framework-gallery' ) );
		$this->assertFalse( wp_style_is( 'lightgallery' ) );

		r_enqueue_fancy_gallery();

		$this->assertTrue( wp_script_is( 'responsive-framework-gallery' ) );
		$this->assertTrue( wp_style_is( 'lightgallery' ) );
	}


}
