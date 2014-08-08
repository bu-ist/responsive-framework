<?php

/* Get site's title */
function responsive_get_title(){
	global $page, $paged;
	wp_title( '|', true, 'right' );
	bloginfo( 'name' );
		
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ){
		echo " | $site_description";
	}
	if ( $paged >= 2 || $page >= 2 ){
		echo ' | ' . sprintf( __( 'Page %s' ), max( $paged, $page ) );
	}
}

/* Get site's description */
function responsive_get_description(){
	if ( is_single() ) {
		single_post_title('', true);
	} else {
		bloginfo('name'); echo " - "; bloginfo('description');
	}
}

/**
 * Displays the comments template if the current site supports comments.
 *
 * If the current site has the '_bu_supports_comments' option set to '1',
 * the comment template is displayed.
 *
 * @see  mu-plugins/bu-comments
 */
function responsive_comments() {
  if ( function_exists( 'bu_supports_comments' ) && ! bu_supports_comments() ) {
    return;
  }

  comments_template( '', true );
}

/**
 * Displays search form for the site based on whether or not there is a site-wide ACL in place
 */
function responsive_search_form() {

  // Check that search form is enabled
  if ( function_exists( 'bu_search_form' ) ) {
    if ( BU_SearchForm::isEnabled() === true ) {
      $bu_search = true;
    } else {
      return;
    }
  }

  // Check for site restrictions through the ACL plugin
  if ( function_exists( 'bu_acl_get_site_acl' ) ) {
    $site_acl = bu_acl_get_site_acl();

    if( ! $site_acl->isEmpty() ) {
      $site_restricted = true;
    } else {
      $site_restricted = false;
    }
  }

  // Display search form based on whether or not site wide restriction is in place
  if ( $bu_search && ! $site_restricted ) {

    /*
      Using custom markup for the Research launch until the BU CMS search plugin can be modified
      to add a placeholder attribute to the search input.
     */

    // bu_search_form();
?>
<form method="get" action="http://www.bu.edu/phpbin/search/cms.php" id="quicksearch">
  <fieldset>
    <input type="hidden" name="site" value="<?php echo home_url('/'); ?>">
    <select name="context" id="qs_search_scope">
      <option value="site">This Site</option>
      <option value="bumc">BU Medical</option>
      <option value="all_of_bu">All BU</option>
      <option value="maps">BU Maps</option>
      <option value="directory">BU Directory</option>
    </select>
    <input name="q" type="text" id="q" placeholder="Search site...">
    <input class="button" type="submit" name="do_search" value="Search">
  </fieldset>
</form>
<?php
  } else {
    // If bu_search_form doesn't exist or the site is restricted, use default WP Search
    get_search_form();
  }
}

/* Determines whether or not a child theme */
function if_child_path() {
    if (is_child_theme()){
        $p = get_template_directory_uri();
    }else {
        $p = get_stylesheet_directory_uri();
    }
    return $p;
}


/* Get the number of widgets in the sidebar */
function count_sidebar_widgets( $sidebar_id, $echo = true ) {
    $the_sidebars = wp_get_sidebars_widgets();
    if(!isset($the_sidebars[$sidebar_id])){
        return __('Invalid sidebar ID');
    }
    if($echo){
        echo count($the_sidebars[$sidebar_id]);
    }else{
        return count($the_sidebars[$sidebar_id]);
    }
}

/* Get the term's link */
function custom_taxonomies_terms_links(){
  // get post by post id
  $post = get_post( $post->ID );

  // get post type by post
  $post_type = $post->post_type;

  // get post type taxonomies
  $taxonomies = get_object_taxonomies( $post_type, 'objects' );

  $out = array();
  foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){
	 if($taxonomy_slug !== "category" && $taxonomy_slug !== "post_tag"){
    // get the terms related to post
    $terms = get_the_terms( $post->ID, $taxonomy_slug );
	
    if ( !empty( $terms ) ) {
      $out[] =  $taxonomy->label . ": ";
      foreach ( $terms as $term ) {
        $out[] =
          '  <a href="'
        .    get_term_link( $term->slug, $taxonomy_slug ) .'">'
        .    $term->name
        . "</a>";
      }
    }
    }
  }

  return implode('', $out );
}


/* Remove Extra Padding for Captions */
add_filter('shortcode_atts_caption', 'fixExtraCaptionPadding');

function fixExtraCaptionPadding($attrs) {
    if (!empty($attrs['width'])) {
        $attrs['width'] += 10;
    }
    return $attrs;
}




/* - - - - - - - - - - - - - - - - -
  Widget Counts
  *from http://wordpress.org/support/topic/how-to-first-and-last-css-classes-for-sidebar-widgets
  - - - - - - - - - - - - - - - - - */

function widget_first_last_classes($params) {

    global $my_widget_num; // Global a counter array
    $this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
    $arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets	

    if (!$my_widget_num) {// If the counter array doesn't exist, create it
        $my_widget_num = array();
    }

    if (!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) { // Check if the current sidebar has no widgets
        return $params; // No widgets in this sidebar... bail early.
    }

    if (isset($my_widget_num[$this_id])) { // See if the counter array has an entry for this sidebar
        $my_widget_num[$this_id] ++;
    } else { // If not, create it starting with 1
        $my_widget_num[$this_id] = 1;
    }

    $class = 'class="widget-' . $my_widget_num[$this_id] . ' '; // Add a widget number class for additional styling options

    if ($my_widget_num[$this_id] == 1) { // If this is the first widget
        $class .= 'widget-first ';
    } elseif ($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) { // If this is the last widget
        $class .= 'widget-last ';
    }

    $params[0]['before_widget'] = preg_replace('/class=\"/', "$class", $params[0]['before_widget'], 1);

    return $params;
}

add_filter('dynamic_sidebar_params', 'widget_first_last_classes');


?>