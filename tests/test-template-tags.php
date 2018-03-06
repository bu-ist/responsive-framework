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

	/**
	 * Test post ID.
	 *
	 * @var int
	 */
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

		responsive_category_links(
			array(
				'post_id' => $this->test_post_id,
				'before' => '',
				'after' => '',
			)
		);

		wp_set_object_terms( $this->test_post_id, array( 'Uncategorized' ), false );
	}

	/**
	 * Test default post display options.
	 */
	function test_responsive_get_post_display_options() {
		$this->assertEquals( array( 'categories', 'tags' ), responsive_get_post_display_options() );
	}

	/**
	 * Test display checking for post fields.
	 */
	function test_responsive_posts_should_display() {
		$this->assertTrue( responsive_posts_should_display( 'categories' ) );
		$this->assertTrue( responsive_posts_should_display( 'tags' ) );
		$this->assertFalse( responsive_posts_should_display( 'some-other-field' ) );
	}

	/**
	 * Test the responsive term links output.
	 */
	function test_responsive_term_links() {
		register_taxonomy( 'test_taxonomy', 'post' );

		$cat_term_id = self::factory()->term->create( array( 'category' => 'test category 1' ) );
		$cat_term_id_2 = self::factory()->term->create( array( 'category' => 'test category 2' ) );
		$custom_term_id = self::factory()->term->create( array( 'test_taxonomy' => 'test term 1' ) );
		$custom_term_id_2 = self::factory()->term->create( array( 'test_taxonomy' => 'test term 2' ) );

		wp_set_object_terms( $this->test_post_id, array_map( 'intval', array( $cat_term_id, $cat_term_id_2 ) ), 'category', false );
		wp_set_object_terms( $this->test_post_id, array_map( 'intval', array( $custom_term_id, $custom_term_id_2 ) ), 'test_taxonomy', false );

		$expected = get_the_term_list( $this->test_post_id, 'test_taxonomy', '<div class="test-container">', ', ', '</div>' );

		$this->assertEquals( $expected, responsive_term_links( get_post( $this->test_post_id ), '<div class="test-container">', ', ', '</div>' ) );

		// Add a second taxonomy.
		register_taxonomy( 'second_taxonomy', 'post' );
		$custom_tax_2_term_id = self::factory()->term->create( array( 'second_taxonomy' => 'test term 1' ) );
		$custom_tax_2_term_id_2 = self::factory()->term->create( array( 'second_taxonomy' => 'test term 2' ) );
		wp_set_object_terms( $this->test_post_id, array_map( 'intval', array( $custom_tax_2_term_id, $custom_tax_2_term_id_2 ) ), 'second_taxonomy', false );

		$expected = get_the_term_list( $this->test_post_id, 'test_taxonomy', '<div class="test-container">', ', ', '</div>' ) . get_the_term_list( $this->test_post_id, 'second_taxonomy', '<div class="test-container">', ', ', '</div>' );

		$this->assertEquals( $expected, responsive_term_links( get_post( $this->test_post_id ), '<div class="test-container">', ', ', '</div>' ) );
	}

	/**
	 * Test inner content container class function with no args.
	 */
	function test_r_container_inner_class_no_args() {
		$this->expectOutputString( 'class="content-container"' );
		r_container_inner_class();
	}

	/**
	 * Test inner content container class function with no args when on a narrow template.
	 */
	function test_r_container_inner_class_no_args_narrow_template() {
		update_option( 'burf_setting_sidebar_location', 'bottom' );
		$this->expectOutputString( 'class="content-container-narrow"' );
		r_container_inner_class();
		update_option( 'burf_setting_sidebar_location', 'right' );
	}

	/**
	 * Test inner content container class function with string arg.
	 */
	function test_r_container_inner_class_string_arg() {
		$this->expectOutputString( 'class="content-container test class"' );
		r_container_inner_class( 'test class' );
	}

	/**
	 * Test inner content container class function with array arg.
	 */
	function test_r_container_inner_class_array_arg() {
		$this->expectOutputString( 'class="content-container test class"' );
		r_container_inner_class( array( 'test', 'class' ) );
	}

	/**
	 * Test inner content container class function with bad characters.
	 */
	function test_r_container_inner_class_bad_characters() {
		$this->expectOutputString( 'class="content-container te&quot;st c&amp;lass"' );
		r_container_inner_class( array( 'te"st', 'c&lass' ) );
	}

	/**
	 * Test inner content container class function with no classes.
	 */
	function test_r_container_inner_class_no_classes() {
		$this->expectOutputString( '' );

		add_filter( 'r_container_inner_class', '__return_empty_array' );
		r_container_inner_class( array( 'test', 'class' ) );
		remove_all_filters( 'r_container_inner_class' );
	}

	/**
	 * Test outer content container class function with no args.
	 */
	function test_r_container_outer_class_no_args() {
		$this->expectOutputString( 'class="container"' );
		r_container_outer_class();
	}

	/**
	 * Test outer content container class function with string arg.
	 */
	function test_r_container_outer_class_string_arg() {
		$this->expectOutputString( 'class="container test class"' );
		r_container_outer_class( 'test class' );
	}

	/**
	 * Test outer content container class function with array arg.
	 */
	function test_r_container_outer_class_array_arg() {
		$this->expectOutputString( 'class="container test class"' );
		r_container_outer_class( array( 'test', 'class' ) );
	}

	/**
	 * Test outer content container class function with bad characters.
	 */
	function test_r_container_outer_class_bad_characters() {
		$this->expectOutputString( 'class="container te&quot;st c&amp;lass"' );
		r_container_outer_class( array( 'te"st', 'c&lass' ) );
	}

	/**
	 * Test outer content container class function with no classes.
	 */
	function test_r_container_outer_class_no_classes() {
		$this->expectOutputString( '' );

		add_filter( 'r_container_outer_class', '__return_empty_array' );
		r_container_outer_class( array( 'test', 'class' ) );
		remove_all_filters( 'r_container_inner_class' );
	}

	/**
	 * Test that non BU domains do not match.
	 */
	function test_responsive_is_bu_domain() {
		$this->assertFalse( responsive_is_bu_domain() );
	}

	/**
	 * Test that BU domains correctly match.
	 */
	function test_responsive_is_bu_domain_true() {
		update_option( 'siteurl', 'http://www.bu.edu/' );
		$this->assertTrue( responsive_is_bu_domain() );

		update_option( 'siteurl', 'http://www-staging.bu.edu/' );
		$this->assertTrue( responsive_is_bu_domain() );

		update_option( 'siteurl', 'http://www-test.bu.edu/' );
		$this->assertTrue( responsive_is_bu_domain() );

		update_option( 'siteurl', 'http://bu.edu/' );
		$this->assertTrue( responsive_is_bu_domain() );

		update_option( 'siteurl', 'http://cms-devl.bu.edu/' );
		$this->assertTrue( responsive_is_bu_domain() );
	}
}
