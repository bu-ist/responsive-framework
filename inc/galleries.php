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
	add_image_size(
		'responsive_gallery',
		(int) apply_filters( 'responsive_gallery_image_width', 420 ),
		(int) apply_filters( 'responsive_gallery_image_height', 420 ),
		true
	);
	add_image_size(
		'responsive_gallery_1col',
		(int) apply_filters( 'responsive_gallery_1col_image_width', 710 ),
		(int) apply_filters( 'responsive_gallery_1col_image_height', 710 ),
		true
	);
	add_image_size(
		'responsive_gallery_5col_up',
		(int) apply_filters( 'responsive_gallery_5col_up_image_width', 260 ),
		(int) apply_filters( 'responsive_gallery_5col_up_image_height', 200 ),
		true
	);
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

	wp_register_script( 'lightgallery', get_template_directory_uri() . "/js/vendor/lightgallery/js/lightgallery{$postfix}.js", array( 'jquery' ), '1.6.5', true );
	wp_register_script( 'lightgallery-thumbnail', get_template_directory_uri() . "/js/vendor/lg-thumbnail/lg-thumbnail{$postfix}.js", array( 'jquery', 'lightgallery' ), '1.1.0', true );
	wp_register_script( 'responsive-framework-gallery', get_template_directory_uri() . "/js/galleries{$postfix}.js", array( 'jquery', 'lightgallery', 'lightgallery-thumbnail' ), RESPONSIVE_FRAMEWORK_VERSION, true );

	wp_register_style( 'lightgallery', get_template_directory_uri() . '/js/vendor/lightgallery/css/lightgallery.min.css', array(), '1.6.5' );
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
