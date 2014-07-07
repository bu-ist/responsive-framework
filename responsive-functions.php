<?php

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

function responsive_get_description(){
	if ( is_single() ) {
		single_post_title('', true);
	} else {
		bloginfo('name'); echo " - "; bloginfo('description');
	}
}

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

// get taxonomies terms links
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


?>