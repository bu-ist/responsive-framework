<?php

/* - - - - - - - - - - - - - - - - -
  BU Profiles
  - - - - - - - - - - - - - - - - - */

/**
 * Display profile sidebar
 *
 * @todo determine the best actions/filters to make available to theme devs
 * @todo determine appropriate markup to house the profile archive link
 *
 * @param type    $args
 */
function bu_flexi_profile_sidebar( $args = array() ) {

	do_action( 'bu_flexi_above_profile_sidebar' );

	if ( is_active_sidebar( 'sidebar-profile' ) ) {

		// Profile widgets
		dynamic_sidebar( 'sidebar-profile' );
	}
}

// Add support for the custom post type version of profile plugin
add_theme_support( 'bu-profiles-post_type' );

add_action( 'bu_flexi_above_profile_sidebar', 'bu_flexi_profile_sidebar_link' );