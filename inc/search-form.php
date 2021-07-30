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


/**
 * Submit the form to the current site, and display results in the searchpage.php template
 * @return String The site's url where the form should be submited.
 */
function filter_search_action($url){
   return get_search_link();
}
add_filter('bu_search_form_action', 'filter_search_action', 10, 1);

/**
 * Filter the submit button to not submit it's value.
 * @param  String $input_submit_html The old input field
 * @return String                    The new button
 */
function filter_search_form_input_submit($input_submit_html){
   return '<button class="button search-submit" type="submit" />'.esc_attr_x( 'Search', 'submit button', 'responsive-framework' ).'</button>';
}
add_filter('bu_search_form_input_submit', 'filter_search_form_input_submit', 10, 1);

/**
 * Remove the context and site input fields from the search form. No need for them now that /phpbin/search doesn't exist.
 * @param  String $input_site_html The input html markup for the site url field
 * @return String                  Empty string.
 */
function filter_search_ignore_input($input_site_html){
   return "";
}
add_filter('bu_search_form_input_site', 'filter_search_ignore_input', 10, 1);
add_filter('bu_search_form_input_context', 'filter_search_ignore_input', 10, 1);

/**
 * Search results filter for a specific result item.
 * @param  String $html the html of the item being filtered
 * @param  Object $item See item returned by GSS: https://developers.google.com/custom-search/json-api/v1/reference/cse/list#response
 * @return String       html for the specific search result.
 */
function filter_search_results_item($html, $item){
   return $html;
}
add_filter('search_results_item', 'filter_search_results_item', 10 ,2);

/**
 * Seach results filter for paginator's Prev page link.
 * @param  String $html <a> tag for the previous page
 * @param  String $url  the previous result's page url
 * @return String       the html for the previous page
 */
function filter_results_previous_page($html, $url){
   return $html;
}
add_filter('search_results_previous_page','filter_results_previous_page', 10, 2);

/**
 * Search results filter for a specific results page.
 * @param  String $html                 <a> tag for the previous page.
 * @param  Array $url                  Array where: 0=>url of current element, 1=>index of current element, 2=>current of of search results
 * @return String                       the html for the page at index $index.
 */
function filter_results_page($html, $options){
   $opts = array_replace(array("",1,1), $options);
   $url = $opts[0];
   $index = $opts[1];
   $current_results_page = $opts[2];
   return $html;
}
add_filter('search_results_page', 'filter_results_page', 10, 2);

/**
 * Search results filter for the next page
 * @param  String $html <a> tag for the next page
 * @param  String $url  the next resutl's page url.
 * @return String       the html for the next page
 */
function filter_Results_next_page($html, $url){
   return $html;
}
add_filter('search_results_next_page','filter_Results_next_page', 10, 2);

/**
 * search results filter for pager wrapper
 * @param  String $html  the html pager being filtered
 * @param  String $pager the pager links
 * @return String        the html for the final pager in it's container.
 */
function filter_results_pager($html, $pager){
   return $html;
}
add_filter('search_results_pager', 'filter_results_pager', 10, 2);
