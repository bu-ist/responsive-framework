<?php
/**
 * Let's provide a better experience for the WordPress core gallery shortcode.
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
		add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );

		add_filter( 'shortcode_atts_gallery', array( $this, 'shortcode_atts_gallery' ) );
	}

	/**
	 * Add a larger thumbnail sizes to prevent pixelated images in galleries.
	 */
	function after_setup_theme() {
		add_image_size( 'responsive_gallery', 420, 420, true );
		add_image_size( 'responsive_gallery_1col', 710, 710, true );
		add_image_size( 'responsive_gallery_5col_up', 260, 200, true );
	}

	/**
	 * Load Lightgallery on single posts that contain galleries.
	 */
	function wp_enqueue_scripts() {
		if ( ! is_singular() ) {
			return;
		}

		$galleries = get_post_galleries( get_queried_object(), false );

		if ( empty( $galleries ) ) {
			return;
		}

		$postfix = '';
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			$postfix = '.min';
		}

		wp_enqueue_script( 'lightgallery', get_template_directory_uri() . "/js/vendor/lightgallery/js/lightgallery{$postfix}.js", array( 'jquery' ), '1.3.9', true );
		wp_enqueue_script( 'responsive-framework-gallery', get_template_directory_uri() . "/js/galleries{$postfix}.js", array( 'jquery', 'lightgallery', 'lightgallery-thumbnail' ), RESPONSIVE_FRAMEWORK_VERSION, true );
		wp_enqueue_script( 'lightgallery-thumbnail', get_template_directory_uri() . "/js/vendor/lg-thumbnail/lg-thumbnail{$postfix}.js", array( 'jquery', 'lightgallery' ), '1.0.3', true );

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
}
$responsive_galleries = new Responsive_Galleries();
