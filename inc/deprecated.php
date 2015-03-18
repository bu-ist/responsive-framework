<?php
/**
 * Deprecated functions from past framework versions. You shouldn't use these
 * functions and look for the alternatives instead.
 */

/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @deprecated  1.1.0
 * @deprecated  responsive_posts_navigation()
 *
 * @param  WP_Query $query [description]
 */
function responsive_paging_nav( WP_Query $query = null, $args = array() ) {
	_deprecated_function( __FUNCTION__, '1.1.0', 'responsive_posts_navigation()' );

	responsive_posts_navigation( $args, $query );
}
