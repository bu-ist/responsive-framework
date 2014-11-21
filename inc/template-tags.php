<?php
/**
 * Custom template tags for this framework
 */

/**
 * Print the site's title.
 */
function responsive_get_title() {
	global $page, $paged;
	wp_title( '|', true, 'right' );
	bloginfo( 'name' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		echo " | $site_description";
	}
	if ( $paged >= 2 || $page >= 2 ) {
		echo ' | ' . sprintf( __( 'Page %s' ), max( $paged, $page ) );
	}
}

/**
 * Print the site's description.
 */
function responsive_get_description() {
	if ( is_single() ) {
		single_post_title( '', true );
	} else {
		bloginfo( 'name' ); echo ' - '; bloginfo( 'description' );
	}
}

/**
 * Whether or not the current network is a bu.edu domain.
 *
 * @return bool
 */
function responsive_is_bu_domain() {
	$current_site = get_current_site();
	return preg_match( '#bu.edu$#', $current_site->domain );
}

/**
 * Whether or not comments are open for this site.
 *
 * If the BU Comments plugin is not active, this will always return true.
 */
function responsive_has_comment_support() {
	if ( function_exists( 'bu_supports_comments' ) ) {
		return bu_supports_comments();
	}
	return true;
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
	if ( ! responsive_has_comment_support() ) {
		return;
	}

	if ( comments_open() || get_comments_number() ) {
		comments_template( '', true );
	}
}

/**
 * Displays search form for the site based on whether or not there is a site-wide ACL in place
 */
function responsive_search_form() {
	$bu_search = false;

	// Check that search form is enabled
	if ( function_exists( 'bu_search_form' ) ) {
		if ( true === BU_SearchForm::isEnabled() ) {
			$bu_search = true;
		} else {
			return;
		}
	}

	// Check for site restrictions through the ACL plugin
	if ( function_exists( 'bu_acl_get_site_acl' ) ) {
		$site_acl = bu_acl_get_site_acl();

		if ( ! $site_acl->isEmpty() ) {
			$site_restricted = true;
		} else {
			$site_restricted = false;
		}
	}

	// Display search form based on whether or not site wide restriction is in place
	if ( $bu_search && ! $site_restricted ) {
		bu_search_form();
	} else {
		// If bu_search_form doesn't exist or the site is restricted, use default WP Search
		get_search_form();
	}
}

function responsi_bu_search_form_query_attributes( $attrs ) {
	return 'placeholder="Search site..."';
}

add_filter( 'bu_search_form_query_attributes', 'responsi_bu_search_form_query_attributes' );

/**
 * Generates a list of term links for the given post.
 *
 * @todo  Review.
 */
function responsive_term_links( $post = null ) {
	$post = get_post( $post );

	if ( ! $post ) {
		return '';
	}

	// get post type by post
	$post_type = $post->post_type;

	// get post type taxonomies
	$taxonomies = get_object_taxonomies( $post_type, 'objects' );

	$out = array();
	foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {
		if ( 'category' !== $taxonomy_slug && 'post_tag' !== $taxonomy_slug ) {
			// get the terms related to post
			$terms = get_the_terms( $post->ID, $taxonomy_slug );

			if ( ! empty( $terms ) ) {
				$out[] = $taxonomy->label . ': ';
				foreach ( $terms as $term ) {
					$out[] =
						'  <a href="'
						.    get_term_link( $term->slug, $taxonomy_slug ) .'">'
						.    $term->name
						. '</a>';
				}
			}
		}
	}

	return implode( '', $out );
}

/**
 * A wrapper around `bu_content_banner` to keep templates clean.
 *
 * @param  string $position A registered content banner position.
 */
function responsive_content_banner( $position ) {
	if ( ! function_exists( 'bu_content_banner' ) ) {
		return;
	}

	/*
	 * Only use current post ID for singular requests. Avoids
	 * banner display for first post in archive requests. We still
	 * pass a null value to `bu_content_banner` in this case so
	 * that site-wide content banners are displayed if set.
	 */
	$post_id = null;
	if ( is_singular() ) {
		// Returns the current post ID
		$post_id = get_post()->ID;
	}

	$banner_args = array(
		'before'   => sprintf( '<div class="bannerContainer bannerContainer-%s">', $position ),
		'after'    => '</div>',
		'class'    => 'banner',
		'position' => $position,
		'echo'     => false,
		);

	echo do_shortcode( bu_content_banner( $post_id, $banner_args ) );
}

function responsive_primary_nav() {
	if ( ! method_exists( 'BuAccessControlPlugin', 'is_site_403' ) ||
		false == BuAccessControlPlugin::is_site_403() ) {
		bu_navigation_display_primary( array(
					'container_id'    => 'primaryNav',
					'container_class' => 'primaryNav',
					) );
	}
}

function responsive_utility_nav() {
	if ( ! method_exists( 'BuAccessControlPlugin', 'is_site_403' ) ||
		false == BuAccessControlPlugin::is_site_403() ) {
		wp_nav_menu( array(
			'theme_location' => 'utility',
			'container'      => 'false',
			'items_wrap'     => '<ul>%3$s</ul>',
		) );
	}
}

if ( ! function_exists( 'responsive_paging_nav' ) ) :

/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @param  WP_Query $query [description]
 */
function responsive_paging_nav( WP_Query $query = null ) {
	global $wp_query;

	// By default the `*_posts_link` functions rely on the global
	// WP_Query instance. We temporarily overwrite it here so that
	// pagination can work for custom queries (e.g. for the News
	// template).
	$tmp_query = null;
	if ( ! is_null( $query ) ) {
		$tmp_query = $wp_query;
		$wp_query = $query;
	}

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h3 class="screen-reader-text"><?php _e( 'Posts navigation' ); ?></h3>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php

	// Restore the global WP_Query instance if we replaced it.
	if ( ! is_null( $query ) && $tmp_query ) {
		$wp_query = $tmp_query;
	}
}

endif;

if ( ! function_exists( 'responsive_post_nav' ) ) :

/**
 * Display navigation to next/previous post when applicable.
 */
function responsive_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h3 class="screen-reader-text"><?php _e( 'Post navigation' ); ?></h3>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span>&nbsp;%title', 'Previous post link' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title&nbsp;<span class="meta-nav">&rarr;</span>', 'Next post link'     ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}

endif;

/**
 * Display the appropriate content for the primary sidebar depending on current page request.
 *
 * @global WP_Query $wp_query
 */
function responsive_primary_sidebar() {
	$queried_object = get_queried_object();

	// Single page (i.e. page.php, custom-template.php) or static front page (front-page.php)
	if ( is_page() || is_front_page() ) {
		$template = get_page_template_slug();
		responsive_primary_sidebar_for_page_template( $template );
	}
	// Single post (i.e. single.php, single-profile.php)
	else if ( is_single() ) {
		responsive_primary_sidebar_for_post_type( $queried_object->post_type );
	}
	// Specific post type archive (i.e. archive-profile.php)
	else if ( is_post_type_archive() ) {
		responsive_primary_sidebar_for_post_type( $queried_object->name );
	}
	// Blog, author and date archives are limited to posts by default
	else if ( is_home() || is_author() || is_date() ) {
		responsive_primary_sidebar_for_post_type( 'post' );
	}
	// Taxonomy term archive (taxonomy.php, category.php, tag.php)
	else if ( is_tax() || is_category() || is_tag() ) {
		$post_types = responsive_get_queried_post_types();
		if ( count( $post_types ) > 1 ) {
				dynamic_sidebar( 'sidebar' );
		} else {
			responsive_primary_sidebar_for_post_type( reset( $post_types ) );
		}
	}
	// Everything else
	else {
		dynamic_sidebar( 'sidebar' );
	}

}

/**
 * Display primary sidebar for specific post type
 *
 * @param string $post_type Name of post type
 */
function responsive_primary_sidebar_for_post_type( $post_type ) {
	switch ( $post_type ) {
		case 'post':
			dynamic_sidebar( 'posts' );
			break;
		case 'profile':
			dynamic_sidebar( 'profiles' );
			break;
		default:
			dynamic_sidebar( 'sidebar' );
	}
}

/**
 * Display primary sidebar for specific page template
 *
 * @param string $template name of template to check
 */
function responsive_primary_sidebar_for_page_template( $template ) {
	switch ( $template ) {
		case 'page-templates/calendar.php':
			responsive_calendar_sidebar();
			break;
		case 'page-templates/profiles.php':
			dynamic_sidebar( 'profiles' );
			break;
		case 'page-templates/news.php':
			dynamic_sidebar( 'posts' );
			break;
		default:
			dynamic_sidebar( 'sidebar' );
	}
}

/**
 * A helper function to determine which post type is currently being queried for
 *
 * @return array all queried post types for the current page request
 */
function responsive_get_queried_post_types() {
	$queried_object = get_queried_object();

	// Post (post object)
	if ( is_single() || is_page() ) {
		return array(  $queried_object->post_type );
	}

	// Archive (post type object)
	if ( is_post_type_archive() ) {
		return array(  $queried_object->name );
	}

	// Archive (post type object)
	if ( is_tax() || is_category() || is_tag() ) {
		$tax = get_taxonomy( $queried_object->taxonomy );
		return $tax->object_type;
	}
}
