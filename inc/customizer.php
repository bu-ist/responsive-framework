<?php
/**
 * Theme Settings API
 */

/**
 * Enable Customizer for all Responsive Framework sites.
 *
 * The BU UI Modifications plugin currently hides the Customizer by default
 * as most existing themes don't benefit from it given the limited capabilities
 * that Site Admin have.
 */
function responsive_enable_customizer() {
	if ( class_exists( 'BuInterfaceModifications' ) ) {
		remove_action( 'admin_menu', array( 'BuInterfaceModifications', 'hide_customizer' ) );
	}
}

add_action( 'init', 'responsive_enable_customizer', 12 );

/**
 * Returns layout slug for currently active theme layout.
 *
 * Child themes can force a specific layout option by defining the BU_RESPONSIVE_LAYOUT
 * constant using one of the layout slugs (e.g. topNav, sideNav, etc.).
 *
 * @see  responsive_layout_options()
 */
function responsive_layout() {
	if ( defined( 'BU_RESPONSIVE_LAYOUT' ) && array_key_exists( BU_RESPONSIVE_LAYOUT, responsive_layout_options() ) ) {
		return BU_RESPONSIVE_LAYOUT;
	}
	return get_option( 'burf_setting_layout', 'default' );
}

/**
 * Returns layout options available via Customizer.
 */
function responsive_layout_options() {
	return apply_filters( 'responsive_layout_options', array(
		'default' => 'Default',
		'topNav'  => 'Top Navigation Bar',
		'sideNav' => 'Side Navigation Bar',
		'noNav'   => 'No Navigation Bar',
		) );
}

/**
 * Returns the site's current font palette.
 */
function responsive_get_font_palette() {
	if ( defined( 'BU_RESPONSIVE_FONT_PALETTE' ) && array_key_exists( BU_RESPONSIVE_FONT_PALETTE, responsive_font_options() ) ) {
		return BU_RESPONSIVE_FONT_PALETTE;
	}

	return get_option( 'burf_setting_fonts', 'f1' );
}

/**
 * Returns font palette options available via Customizer.
 */
function responsive_font_options() {
	return array(
		'f1' => 'Capita,Benton',
		'f2' => 'Benton,Benton',
		'f3' => 'Benton,Capita',
		'f4' => 'Pressura,Benton',
		'f5' => 'Stag,Benton',
		);
}

/**
 * Returns any content entered into the Footer > Additional Info textarea.
 */
function responsive_get_customizer_footer_info() {
	$defaults = array(
		'text'  => '',
		'autop' => false,
		);
	$footer = get_option( 'burf_setting_footer', $defaults );

	if ( $footer['autop'] ) {
		return wpautop( $footer['text'] );
	} else {
		return $footer['text'];
	}
}

/**
 * Prints out additional footer info content.
 */
function responsive_customizer_footer_info( $args = array() ) {
	$defaults = array(
		'before' => '<div class="siteFooter-info">',
		'after'  => '</div>',
		'echo'   => true,
		);
	$args = wp_parse_args( $args, $defaults );
	$output = '';

	$footer_info = responsive_get_customizer_footer_info();
	if ( $footer_info ) {
		$output = $args['before'] . $footer_info . $args['after'];
	}

	if ( $args['echo'] ) {
		echo $output;
	} else {
		return $output;
	}
}

/**
 * Returns whether or not the additional info textarea has any content.
 */
function responsive_customizer_has_footer_info() {
	$footer_info = responsive_get_customizer_footer_info();
	return ! empty( $footer_info );
}
