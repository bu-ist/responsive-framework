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


?>