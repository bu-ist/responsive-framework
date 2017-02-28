<?php
/**
 *
 * @package Responsive_Framework
 */

/**
 * Class Responsive_Galleries
 */
class Responsive_Galleries {

	/**
	 * Responsive_Galleries constructor.
	 */
	function __construct() {
		add_action( 'after_setup_theme', array( $this,'after_setup_theme' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );

//		add_filter( 'use_default_gallery_style', array( $this, 'use_default_gallery_style' ) );
		add_filter( 'shortcode_atts_gallery', array( $this, 'shortcode_atts_gallery' ), 10, 3 );
	}

	/**
	 * Add a larger thumbnail size to prevent pixelated images in galleries.
	 */
	function after_setup_theme() {
		add_image_size( 'responsive-gallery-thumbnail', 500, 500, true );
	}

	/**
	 * Load Lightgallery on single posts that contain galleries.
	 */
	function wp_enqueue_scripts() {
		if ( ! is_singular() ) {
			return;
		}

		if ( ! $galleries = get_post_galleries( get_queried_object(), false ) ) {
			return;
		}

		wp_enqueue_script( 'lightgallery', get_template_directory_uri() . '/js/vendor/lightgallery/js/lightgallery.min.js', array( 'jquery' ), '1.3.9', true );
		wp_enqueue_script( 'lightgallery-thumbnail', get_template_directory_uri() . '/js/vendor/lg-thumbnail/lg-thumbnail.min.js', array( 'jquery', 'lightgallery' ), '1.0.3', true );
		wp_enqueue_style( 'lightgallery', get_template_directory_uri() . '/js/vendor/lightgallery/css/lightgallery.min.css', array(), '1.3.9' );
	}

	/**
	 * Don't use WordPress default gallery style if using Lightgallery.
	 *
	 * @param bool $print Whether to print default gallery styles.
	 *
	 * @return bool Whether to print default gallery styles.
	 */
	function use_default_gallery_style( $print ) {
		if ( wp_script_is( 'lightgallery' ) ) {
			return false;
		}

		return $print;
	}

	/**
	 * Filter the default image size to prevent pixelated images in galleries.
	 *
	 * @param array  $out   The output array of shortcode attributes.
	 * @param array  $pairs The supported attributes and their defaults.
	 * @param array  $atts  The user defined shortcode attributes.
	 *
	 * @return array Filtered shortcode attributes.
	 */
	function shortcode_atts_gallery( $out, $pairs, $atts ) {
		if ( 'thumbnail' === $out['size'] ) {
			$out['size'] = 'responsive-gallery-thumbnail';
		}

		/**
		 * Force the file link type so galleries work.
		 */
		$out['link'] = 'file';

		return $out;
	}
}
$responsive_galleries = new Responsive_Galleries();
