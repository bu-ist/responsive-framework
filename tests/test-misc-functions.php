<?php
/**
 * Test miscellaneous functions.
 *
 * @package Responsive_Framework
 */

/**
 * Class Tests_Responsive_Framework_Miscellaneous_Functions
 *
 * @group misc-functions
 */
class Tests_Responsive_Framework_Miscellaneous_Functions extends WP_UnitTestCase {
	/**
	 * Test the default image link type is set to none.
	 */
	function test_responsive_update_image_default_link_type() {
		update_option( 'image_default_link_type', 'file' );
		$this->assertEquals( 'file', get_option( 'image_default_link_type' ) );

		responsive_update_image_default_link_type();
		$this->assertEquals( 'none', get_option( 'image_default_link_type' ) );
	}

	/**
	 * Test that the news tempalate is correctly removed when BU_News_Page_Template
	 * does not exist.
	 */
	function test_r_remove_news_template() {
		$actual = array(
			'page-templates/some-template.php' => 'Some Template',
			'page-templates/news.php' => 'News',
		);
		$expected = array(
			'page-templates/some-template.php' => 'Some Template',
		);
		$theme = wp_get_theme();

		$this->assertSame( $expected, r_remove_news_template( $actual, $theme, null ) );
	}
}
