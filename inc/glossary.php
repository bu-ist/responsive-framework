<?php
/**
 * Default settings for the Codeat Glossary plugin.
 *
 * @package Responsive_Framework
 */

namespace BU\Themes\Responsive_Framework\Glossary;

/**
 * Increase the number of posts that show on the 'glossary' archive.
 *
 * @param WP_Query $query The WP_Query instance (passed by reference).
 */
function archive_pre_get_posts( $query ) {
	if ( $query->is_post_type_archive( 'glossary' ) ) {
		$query->query_vars['posts_per_page'] = 250;
	}
}
add_action( 'pre_get_posts', __NAMESPACE__ . '\archive_pre_get_posts' );
