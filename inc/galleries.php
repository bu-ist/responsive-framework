<?php
/**
 * Let's provide a better experience for the WordPress core gallery shortcode.
 *
 * @package Responsive_Framework
 */

namespace BU\Themes\Responsive_Framework\Galleries;

/**
 * Add a larger thumbnail sizes to prevent pixelated images in galleries.
 */
function after_setup_theme() {
	/**
	 * Filters the default gallery thumbnail width.
	 *
	 * @since 2.0.0
	 *
	 * @param int Default gallery image width, 420.
	 */
	$width = (int) apply_filters( 'responsive_gallery_image_width', 420 );

	/**
	 * Filters the default gallery thumbnail height.
	 *
	 * @since 2.0.0
	 *
	 * @param int Default gallery image height, 420.
	 */
	$height = (int) apply_filters( 'responsive_gallery_image_height', 420 );

	add_image_size( 'responsive_gallery', $width, $height, true );

	/**
	 * Filters the image width for 1 column galleries.
	 *
	 * @since 2.0.0
	 *
	 * @param int Default 1 column image width, 710.
	 */
	$width_1col = (int) apply_filters( 'responsive_gallery_1col_image_width', 710 );

	/**
	 * Filters the image height for 1 column galleries.
	 *
	 * @since 2.0.0
	 *
	 * @param int Default 1 column image height, 710.
	 */
	$height_1col = (int) apply_filters( 'responsive_gallery_1col_image_height', 710 );

	add_image_size( 'responsive_gallery_1col', $width_1col, $height_1col, true );

	/**
	 * Filters the image width for galleries with 5 columns or more.
	 *
	 * @since 2.0.0
	 *
	 * @param int Default image width, 260.
	 */
	$width_5col = (int) apply_filters( 'responsive_gallery_5col_up_image_width', 260 );

	/**
	 * Filters the image height for galleries with 5 columns or more.
	 *
	 * @since 2.0.0
	 *
	 * @param int Default image width, 200.
	 */
	$height_5col = (int) apply_filters( 'responsive_gallery_5col_up_image_height', 200 );

	add_image_size( 'responsive_gallery_5col_up', $width_5col, $height_5col, true );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\after_setup_theme' );

/**
 * Register responsive gallery related scripts and styles.
 */
function wp_default_scripts() {
	$postfix = '';
	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
		$postfix = '.min';
	}

	wp_register_script( 'lightgallery', get_template_directory_uri() . "/js/vendor/lightgallery/js/lightgallery{$postfix}.js", array( 'jquery' ), RESPONSIVE_LIGHTGALLERY_VERSION, true );
	wp_register_script( 'lightgallery-thumbnail', get_template_directory_uri() . "/js/vendor/lg-thumbnail/lg-thumbnail{$postfix}.js", array( 'jquery', 'lightgallery' ), RESPONSIVE_LG_THUMBNAIL_VERSION, true );
	wp_register_script( 'responsive-framework-gallery', get_template_directory_uri() . "/js/galleries{$postfix}.js", array( 'jquery', 'lightgallery', 'lightgallery-thumbnail' ), RESPONSIVE_FRAMEWORK_VERSION, true );

	wp_register_style( 'lightgallery', get_template_directory_uri() . '/js/vendor/lightgallery/css/lightgallery.min.css', array(), '1.6.8' );
}
add_action( 'init', __NAMESPACE__ . '\wp_default_scripts' );

/**
 * Load LightGallery on single posts that contain galleries.
 */
function wp_enqueue_scripts() {
	if ( ! is_singular() ) {
		return;
	}

	$galleries = get_post_galleries( get_queried_object(), false );

	if ( empty( $galleries ) ) {
		return;
	}

	r_enqueue_fancy_gallery();
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\wp_enqueue_scripts' );

/**
 * Filter the default image size to prevent pixelated images in galleries.
 *
 * @param array $out The output array of shortcode attributes.
 *
 * @return array Filtered shortcode attributes.
 */
function shortcode_atts_gallery( $out ) {
	if ( 'thumbnail' === $out['size'] ) {
		if ( 1 === (int) $out['columns'] ) {
			$out['size'] = 'responsive_gallery_1col';
		} elseif ( 5 <= $out['columns'] ) {
			$out['size'] = 'responsive_gallery_5col_up';
		} else {
			$out['size'] = 'responsive_gallery';
		}
	}

	/**
	 * Force the file link type so galleries work.
	 */
	$out['link'] = 'file';

	return $out;
}
add_filter( 'shortcode_atts_gallery', __NAMESPACE__ . '\shortcode_atts_gallery' );
