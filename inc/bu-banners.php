<?php
/**
 * Extended functionality and support for BU Banners plugin
 *
 * @link    https://github.com/bu-ist/bu-banners/
 *
 * @package Responsive_Framework\bu-banners
 */

if ( ! function_exists( 'responsive_bu_banner_title' ) ) {

	/**
	 * Sets the banner title to the current page title if empty.
	 *
	 * If a banner exists, and the banner title is empty, adds the page title
	 * to the banner and removes it from the general page content area.
	 *
	 * - Hooks into BU Banners plugin filter `bu_banners_banner_info` to modify banner values.
	 * - Hooks into Responsive Framework theme filter `responsive_filter_the_title` to set an
	 *   empty page title since BU Banners will have it.
	 *
	 * @since 2.1.5
	 */
	function responsive_bu_banner_title() {

		// Returns immediately if this is the admin, or if there is no `bu_has_banner` function.
		if ( is_admin() || ! function_exists( 'bu_has_banner' ) ) {
			return;
		}

		// Retrieves the banner content field.
		$banner_content = get_post_meta( get_the_id(), '_bu_banner_content', true );

		// Only continues if we have a bu banner, its content is not empty, and there is no title field supplied.
		if ( bu_has_banner() && ! empty( $banner_content[0] ) && empty( $banner_content[0]['title'] ) ) {

			/**
			 * Filters BU Banner values.
			 *
			 * Sets banner title to the current page title.
			 * Sets banner heading tags to use a heading 1 element.
			 *
			 * @since 2.1.5
			 *
			 * @param  array $banner_info Banner content values.
			 * @return array $banner_info
			 */
			add_filter( 'bu_banners_banner_info', function( $banner_info ) {
				$banner_info['title']        = get_the_title();
				$banner_info['title_before'] = '<h1 class="page-title bu-banner-title">';
				$banner_info['title_after']  = '</h1>';
				return $banner_info;
			} );

			/**
			 * Filters Responsive Framework page title.
			 *
			 * Removes the H1 that would normally appear and current page title from theme.
			 *
			 * @since 2.1.5
			 *
			 * @param  array $title_args Page title arguments, same as `the_title()`.
			 * @return array $title_args
			 */
			add_filter( 'responsive_filter_the_title', function( $title_args ) {
				$title_args['title'] = false;
				return $title_args;
			} );

		}

	}
}
add_action( 'wp', 'responsive_bu_banner_title' );
