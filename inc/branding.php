<?php
/**
 * Branding.
 *
 * @package Responsive_Framework\branding
 */

/**
 * Display branding HTML.
 *
 * If the current theme does not support 'bu-branding', the BU Branding plugin is not loaded.
 * Child themes can define custom brand markup within the branding.php template file to override the default branding template.
 *
 * @uses bu_branding()
 *
 * @see  mu-plugins/bu-branding
 */
function responsive_branding() {
	if ( current_theme_supports( 'bu-branding' ) && function_exists( 'bu_branding' ) ) {
		bu_branding();

		return;
	}

	get_template_part( 'template-parts/branding' );
}

/**
 * Display the BU masterplate if branding configuration requires it.
 *
 * Wrapper around `bu_branding_masterplate`.
 *
 * @see  mu-plugins/bu-branding
 *
 * @param array $args {
 *     Optional. Shortcode attributes.
 *
 *     @type string $before Markup or text to go before the branding masterplate.
 *     @type string $after  Markup or text to go after the branding masterplate.
 * }
 */
function responsive_branding_masterplate( $args = array() ) {
	$defaults = array(
		'before' => '<div class="site-footer-brand">',
		'after'  => '</div>',
		);
	$args = wp_parse_args( $args, $defaults );

	if ( current_theme_supports( 'bu-branding' ) && function_exists( 'bu_branding_masterplate' ) ) {
		/**
		 * Fires immediately before the BU branding masterplate.
		 *
		 * @since 2.0.0
		 */
		do_action( 'r_before_branding_masterplate' );

		bu_branding_masterplate( $args );

		/**
		 * Fires immediately after the BU branding masterplate.
		 *
		 * @since 2.0.0
		 */
		do_action( 'r_after_branding_masterplate' );
	}
}

/**
 * Display the BUMC logo if branding is configured to do so.
 *
 * Wrapper around `bu_branding_bumc_logo`.
 *
 * @see  mu-plugins/bu-branding
 *
 * @param array $args {
 *     Optional. Shortcode attributes.
 *
 *     @type string $before Markup or text to go before the branding masterplate.
 *     @type string $after  Markup or text to go after the branding masterplate.
 * }
 */
function responsive_branding_bumc_logo( $args = array() ) {
	$defaults = array(
		'before' => '<div class="siteFooter-bumc">',
		'after'  => '</div>',
		);
	$args = wp_parse_args( $args, $defaults );

	if ( current_theme_supports( 'bu-branding' ) && function_exists( 'bu_branding_bumc_logo' ) ) {
		/**
		 * Fires immediately before the BUMC branding logo.
		 *
		 * @since 2.0.0
		 */
		do_action( 'r_before_bumc_branding_logo' );

		bu_branding_bumc_logo( $args );

		/**
		 * Fires immediately after the BUMC branding logo.
		 *
		 * @since 2.0.0
		 */
		do_action( 'r_after_bumc_branding_logo' );
	}
}

/**
 * Display the disclaimer if branding is configured to do so.
 *
 * Wrapper around `bu_branding_disclaimer`.
 *
 * @see  mu-plugins/bu-branding
 *
 * @param array $args {
 *     Optional. Shortcode attributes.
 *
 *     @type string $before Markup or text to go before the branding disclaimer.
 *     @type string $after  Markup or text to go after the branding disclaimber.
 * }
 */
function responsive_branding_disclaimer( $args = array() ) {
	$defaults = array(
		'before' => '<div class="siteFooter-disclaimer">',
		'after'  => '</div>',
		);
	$args = wp_parse_args( $args, $defaults );

	if ( current_theme_supports( 'bu-branding' ) && function_exists( 'bu_branding_disclaimer' ) ) {
		/**
		 * Fires immediately before the BU branding disclaimer.
		 *
		 * @since 2.0.0
		 */
		do_action( 'r_before_branding_disclaimer' );

		bu_branding_disclaimer( $args );

		/**
		 * Fires immediately after the BU branding disclaimer.
		 *
		 * @since 2.0.0
		 */
		do_action( 'r_after_branding_disclaimer' );
	}
}


/**
 * Adds branding classes to the footer container.
 *
 * Used to determine layout of footer columns.
 *
 * @param array $classes Array of classes.
 *
 * @return array Filtered array of classes.
 */
function responsive_branding_footer_classes( $classes ) {
	if ( current_theme_supports( 'bu-branding' ) && function_exists( 'bu_branding_has_masterplate' ) && bu_branding_has_masterplate() ) {
		$classes[] = 'has-branding';
	}

	return $classes;
}

add_filter( 'responsive_extra_footer_classes', 'responsive_branding_footer_classes' );

/**
 * Prevent duplicate loading of branding styles by BU Branding.
 */
function responsive_dequeue_branding_fonts() {
	if ( wp_style_is( 'bu-branding' ) ) {
		wp_dequeue_style( 'bu-branding' );
		wp_enqueue_style( 'bu-branding-fonts' );
	}
}

add_action( 'wp_enqueue_scripts', 'responsive_dequeue_branding_fonts', 12 );
