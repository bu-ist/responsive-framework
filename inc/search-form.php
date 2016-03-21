<?php

/**
 * Responsive Framework sites do not want to support form contexts/scopes.
 * @return array Option to only search current site
 */
function responsive_bu_search_form_contexts() {
	return array( 'site' => 'This Site' );
}
add_filter( 'bu_search_form_contexts', 'responsive_bu_search_form_contexts' );

/**
 * Add a placeholder attribute to the search form added by BU CMS.
 */
function responsive_bu_search_form_query_attributes( $attrs ) {
	return 'placeholder="Search site&hellip;"';
}
add_filter( 'bu_search_form_query_attributes', 'responsive_bu_search_form_query_attributes' );
