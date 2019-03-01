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
 * @param string $nav Default HTML markup for the navigation.
 * @param array $args Default Responsive Framework nav arguments.
 */
function responsive_primary_nav() {
	if ( ! method_exists( 'BuAccessControlPlugin', 'is_site_403' ) || false === BuAccessControlPlugin::is_site_403() ) {

		if ( function_exists( 'bu_navigation_display_primary' ) ) {
			/**
			 * Filters the BU navigation defaults.
			 */
			$args = apply_filters( 'bu_responsive_primary_nav_args', array(
				'container_id'    => 'primary-nav-menu',
				'container_class' => 'primary-nav-menu',
			) );

			bu_navigation_display_primary( $args );
		}
	}
}
