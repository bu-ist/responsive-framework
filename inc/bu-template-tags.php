<?php
/**
 * BU Specific functionality
 * expanding from template-tags.php
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
				'post_types'      => array( 'page' ),
				'include_links'   => true,
				'depth'           => BU_NAVIGATION_PRIMARY_DEPTH,
				'max_items'       => BU_NAVIGATION_PRIMARY_MAX,
				'dive'            => true,
				'container_tag'   => 'ul',
				'container_id'    => 'primary-nav-menu',
				'container_class' => 'primary-nav-menu',
				'item_tag'        => 'li',
				'identify_top'    => false,
				'whitelist_top'   => null,
				'title_before'    => '',
				'title_after'     => '',
			) );

			bu_navigation_display_primary( $args );
		}
	}
}
