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
		'before'   => sprintf( '<div class="banner-container %s">', $position ),
		'after'    => '</div>',
		'class'    => 'banner',
		'position' => $position,
		'echo'     => false,
		);

	echo do_shortcode( bu_content_banner( $post_id, $banner_args ) );
}

if ( ! function_exists( 'responsive_paging_nav' ) ) :

/**
 * Display navigation to next/previous set of posts when applicable.
 */
function responsive_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation' ); ?></h1>
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
		<h1 class="screen-reader-text"><?php _e( 'Post navigation' ); ?></h1>
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
