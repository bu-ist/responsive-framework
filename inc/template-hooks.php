<?php
/**
 * Hooks that aid in templating
 *
 * A template hook is considered as any function that hooks into the actions
 * or filters provided by the theme. These are mostly hooks intended for the
 * front-end of a website to affect theme appearance.
 *
 * Examples:
 * - Adding content to the action hook `r_before_opening_container_outer` fired
 *   from `header.php`.
 * - Using the native WP `body_class` filter to add additional body classes to
 *   aid in templating.
 *
 * @link       www.bu.edu/interactive-design/
 *
 * @package    Responsive_Framework
 * @subpackage Responsive_Framework/inc
 * @since      2.2.1
 */

if ( ! function_exists( 'responsive_the_title_location' ) ) {
	/**
	 * Adds the page title to the front end.
	 *
	 * Fires on the `wp` hook so that the global WP class object is set up, and
	 * the query has already been parsed so that WP Conditional Tags can be
	 * used.
	 *
	 * @since 2.2.1
	 *
	 * @link https://codex.wordpress.org/Plugin_API/Action_Reference
	 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/wp
	 * @link https://codex.wordpress.org/Conditional_Tags
	 */
	function responsive_the_title_location() {

		// Returns immediately if this is not the front-end.
		if ( is_admin() ) {
			return;
		}

		// Adds the title tag immediately after opening article tag, by default.
		add_action( 'r_after_opening_article', 'responsive_the_title' );
	}
}
add_action( 'wp', 'responsive_the_title_location' );
