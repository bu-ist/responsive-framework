<?php
/**
 * Extended functionality and support for BU Banners plugin
 *
 * @link    https://github.com/bu-ist/bu-banners/
 *
 * @package Responsive_Framework\bu-banners
 */

/**
 * Sets the page title in banners if banner title is empty.
 *
 * If banner exists, and the banner title is empty, adds the page title
 * to the banner and removes it from the general page content area.
 *
 * @since    2.1.5
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

		// Adds the H1 and current page title to banner.
		add_filter( 'bu_banners_banner_info', function( $banner_info ) {
			$banner_info['title']        = get_the_title();
			$banner_info['title_before'] = '<h1 class="page-title bu-banner-title">';
			$banner_info['title_after']  = '</h1>';
			return $banner_info;
		} );

		// Removes the H1 and current page title from theme.
		add_filter( 'responsive_filter_the_title', function( $title_args ) {
			$title_args['title'] = false;
			return $title_args;
		} );

	}

}
add_action( 'wp', 'responsive_bu_banner_title' );
