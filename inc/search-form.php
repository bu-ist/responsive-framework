<?php
/**
 * BU CMS search form related functionality.
 *
 * @package Responsive_Framework
 */

/**
 * Responsive Framework sites do not want to support form contexts/scopes.
 *
 * @return array Option to only search current site
 */
function responsive_bu_search_form_contexts() {
	return array(
		'site' => __( 'This Site', 'responsive-framework' ),
	);
}
add_filter( 'bu_search_form_contexts', 'responsive_bu_search_form_contexts' );
