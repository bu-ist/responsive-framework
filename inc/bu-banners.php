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
	 * Filters whether the current banner has text.
	 *
	 * This can be used when custom fields are added to a banner layout that,
	 * when filled in, should indicate that a banner has text.
	 *
	 * @since 2.1.3
	 *
	 * @param bool       $has_text    Whether the current banner has text.
	 * @param array|bool $banner_info Array of banner info for the current banner if it exists,
	 *                                false if the post has no banner info.
	 * @return bool $has_text Defines whether the banner has text.
	 */
	function responsive_bu_banner_has_text( $has_text, $banner_info ) {
		/**
		 * Bails immediately if the following conditions are met:
		 * - this is an admin page (avoids messing with save_post hook).
		 * - this is not a text layout.
		 */
		if ( is_admin() || ! bu_banners_layout_supports_text( $banner_info['layout'] ) ) {
			return $has_text;
		}

		// If this text layout has an empty title, return true. We'll fill it in later.
		if ( empty( $banner_info['title'] ) ) {
			$has_text = true;
		}

		return $has_text;
	}
	add_filter( 'bu_banners_banner_has_text', 'responsive_bu_banner_has_text', 10, 2 );

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
		if ( is_admin() || ! function_exists( 'bu_has_banner' ) || ! function_exists( 'bu_banners_layout_supports_text' ) ) {
			return;
		}

		$disable_archive = apply_filters( 'responsive_disable_archive_banner', false );
		if ( is_archive() && ! $disable_archive ) {
			add_filter( 'responsive_the_title_is_hidden', '__return_true' );
			return;
		}

		// Stores the object id.
		$object_id = get_queried_object_id();

		// Only target text layouts.
		$layout = get_post_meta( $object_id, '_bu_banner_layout', true );
		if ( ! bu_banners_layout_supports_text( $layout ) ) {
			return;
		}

		// Retrieves the banner content field.
		$banner_content = get_post_meta( $object_id, '_bu_banner_content', true );

		// Only continues if we have a bu banner, its content is not empty, and there is no title field supplied.
		if ( bu_has_banner( $object_id ) && bu_banner_has_text( $object_id ) && empty( $banner_content[0]['title'] ) ) {

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
			add_filter(
				'bu_banners_banner_info',
				function( $banner_info ) {
					$banner_info['title']        = get_the_title( get_queried_object_id() );
					$banner_info['title_before'] = '<h1 class="page-title bu-banner-title">';
					$banner_info['title_after']  = '</h1>';
					return $banner_info;
				}
			);

			/**
			 * Filters Responsive Framework page title output.
			 *
			 * Prevents duplicate output of page H1 that would normally appear,
			 * since it already is being used in BU Banners.
			 *
			 * @since 2.1.5
			 *
			 * @return array True (skips the page title and prevents any output of page title).
			 */
			add_filter( 'responsive_the_title_is_hidden', '__return_true' );

			// Else, add classes if we have a bu banner, its content is not empty, and there is a title field supplied.
		} elseif ( bu_has_banner( $object_id ) && ! empty( $banner_content[0] ) && ! empty( $banner_content[0]['title'] ) ) {

			/**
			 * Filters Responsive Framework page title classes, to make the generic H1 visually hidden,
			 * but still accessible to screen readers.
			 *
			 * @since 2.1.5
			 *
			 * @param  string $class Class to be applied to the H1.
			 * @return string $class
			 */
			add_filter(
				'responsive_the_title_class',
				function( $class ) {
					if ( ! empty( $class ) && strpos( $class, 'u-visually-hidden' ) === false ) {
						$class .= ' u-visually-hidden';
					} elseif ( empty( $class ) ) {
						$class = 'u-visually-hidden';
					}

					return $class;
				}
			);
		}

	}
}
add_action( 'wp', 'responsive_bu_banner_title' );

if ( ! function_exists( 'responsive_bu_banners_metabox' ) ) {

	/**
	 * Modifies the BU Banners metabox.
	 *
	 * Adds a description to the title field, indicating to the user that its
	 * an optional field that may be left blank to use the post_title field instead.
	 *
	 * @since 2.1.5
	 *
	 * @param int    $post_id The ID of the current object.
	 * @param object $cmb     This CMB2 object.
	 */
	function responsive_bu_banners_metabox( $post_id, $cmb ) {

		// Retrieve all the fields associated with the metabox.
		$fields = $cmb->prop( 'fields' );

		// Add a description to the bu banner title field.
		$fields['_bu_banner_content']['fields']['title']['desc'] = __( 'Leave blank to use the page title.', 'responsive-framework' );

		// Overwrite the existing metabox fields with this new modified fields.
		$cmb->set_prop( 'fields', $fields );

	}
}
add_action( 'cmb2_before_post_form_bu_banner_info', 'responsive_bu_banners_metabox', 10, 2 );
