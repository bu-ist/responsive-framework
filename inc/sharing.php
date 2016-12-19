<?php
/**
 * BU Sharing integration.
 *
 * @package Responsive_Framework\bu-sharing
 */

/**
 * Modify default share tools configuration.
 */
function responsive_sharing_setup() {
	// Disable default display location.
	remove_filter( 'the_content', 'sharing_display', 19 );
	remove_filter( 'the_excerpt', 'sharing_display', 19 );

	// Disable share counts by default.
	add_filter( 'bu_sharing_counts', '__return_false' );
}

add_action( 'init', 'responsive_sharing_setup' );

/**
 * Prevent duplicate loading of icon fonts by BU Sharing.
 */
function responsive_dequeue_sharing_fonts() {
	if ( wp_style_is( 'bu-icon-font' ) ) {
		wp_dequeue_style( 'bu-icon-font' );
	}
}

add_action( 'wp_head', 'responsive_dequeue_sharing_fonts', 2 );

/**
 * Display share tools configured via BU Sharing plugin.
 *
 * If the BU Sharing plugin is not activated this function will do nothing.
 *
 * @param  string  $text  Content to display before share tools. Will precede user-provided sharing label.
 * @param  boolean $echo Whether or not to immediately echo or return the output. Default true.
 *
 * @return string Sharing tools markup if $echo is false.
 */
function responsive_share_tools( $text = '', $echo = true ) {
	if ( function_exists( 'sharing_display' ) ) {
		return sharing_display( $text, $echo );
	}
}
