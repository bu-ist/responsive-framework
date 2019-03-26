<?php
/**
 * BU Specific functionality
 * expanding from template-tags.php
 *
 * @package Responsive_Framework
 */

/**
 * Override the default navigation menu with
 * BU custom version.
 *
 * @since 2.1.12
 */
function responsive_primary_nav() {
	if ( ! method_exists( 'BuAccessControlPlugin', 'is_site_403' ) || false === BuAccessControlPlugin::is_site_403() ) {

		if ( function_exists( 'bu_navigation_display_primary' ) ) {
			/**
			 * Defines arguments to pass in to BU Navigation.
			 *
			 * Note: These arguments will override Primary Navigation defaults +
			 * wp-admin settings defined in Appearance > Primary Navigation.
			 *
			 * @since 2.1.12
			 *
			 * @link https://github.com/bu-ist/bu-navigation
			 * @see bu_navigation_display_primary in BU Navigation for all args.
			 *
			 * @param array $args Array of BU Navigation Primary Nav arguments.
			 */
			$args = apply_filters(
				'bu_responsive_primary_nav_args',
				array(
					'container_id'    => 'primary-nav-menu',
					'container_class' => 'primary-nav-menu',
				)
			);

			// Calls the BU primary navigation, providing overrides.
			bu_navigation_display_primary( $args );
		}
	}
}
