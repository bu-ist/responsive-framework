<?php
/**
 * Custom template tags for this framework
 *
 * @package Responsive_Framework
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
		echo esc_html( " | $site_description" );
	}
	if ( $paged >= 2 || $page >= 2 ) {
		echo esc_html( ' | ' . sprintf( __( 'Page %s' ), max( $paged, $page ) ) );
	}
}

/**
 * Print the site's description.
 *
 * TODO: Remove once child themes have migrated to 1.0.0.
 */
function responsive_get_description() {
	if ( is_single() ) {
		single_post_title( '', true );
	} else {
		bloginfo( 'name' );
		echo ' - ';
		bloginfo( 'description' );
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
 * Whether or not search form should be displayed.
 */
function responsive_search_is_enabled() {
	if ( class_exists( 'BU_SearchForm' ) ) {
		return BU_SearchForm::isEnabled();
	}
	return true;
}

/**
 * Displays search form for the site based on whether or not there is a site-wide ACL in place
 */
function responsive_search_form() {
	$bu_search = false;

	// Check that search form is enabled.
	if ( function_exists( 'bu_search_form' ) ) {
		if ( responsive_search_is_enabled() ) {
			$bu_search = true;
		} else {
			return;
		}
	}

	// Check for site restrictions through the ACL plugin.
	if ( function_exists( 'bu_acl_get_site_acl' ) ) {
		$site_acl = bu_acl_get_site_acl();

		if ( ! $site_acl->isEmpty() ) {
			$site_restricted = true;
		} else {
			$site_restricted = false;
		}
	}

	// Display search form based on whether or not site wide restriction is in place.
	if ( $bu_search && ! $site_restricted ) {
		bu_search_form( '', '', array( 'responsive' => true ) );
	} else {
		// If bu_search_form doesn't exist or the site is restricted, use default WP Search.
		get_search_form();
	}
}

/**
 * Generates a list of category links.
 *
 * Thin wrapper around `get_the_category_list` that makes it behave more like `the_tags`.
 *
 * @param array $args {
 *     Optional. Arguments to configure term link markup.
 *
 *     @type  string $before     HTML markup to display before links.
 *     @type  string $after      HTML markup to display after links.
 *     @type  string $separator  String to insert between links.
 *     @type  string $parents    How to display the parents.
 *     @type  int    $post_id    Post ID to retrieve categories for.
 * }
 */
function responsive_category_links( $args = array() ) {
	$defaults = array(
		'before'    => '<span class="categories">Categories: ',
		'after'     => '</span>',
		'separator' => ', ',
		'parents'   => '',
		'post_id'   => null,
		);
	$args = wp_parse_args( $args, $defaults );

	$categories = get_the_category_list( $args['separator'], $args['parents'], $args['post_id'] );
	if ( $categories ) {
		echo $args['before'] . $categories . $args['after'];
	}
}

/**
 * Generates a list of term links (excluding categories and tags) for the given post.
 *
 * @param int|WP_Post|null $post Optional. Post ID or post object. Defaults to global $post.
 *
 * @return string A list of term links.
 */
function responsive_term_links( $post = null ) {
	$post = get_post( $post );

	if ( ! $post ) {
		return '';
	}

	// Get taxonomies registered for the current post type.
	$taxonomies = get_object_taxonomies( $post->post_type, 'objects' );

	$out = array();
	foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {
		if ( 'category' !== $taxonomy_slug && 'post_tag' !== $taxonomy_slug ) {

			$terms = get_the_terms( $post->ID, $taxonomy_slug );

			if ( ! empty( $terms ) ) {
				$out[] = $taxonomy->label . ': ';
				foreach ( $terms as $term ) {
					$out[] =
						'  <a href="'
						. get_term_link( $term->slug, $taxonomy_slug ) . '">'
						. $term->name
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
	 * pass a false value to `bu_content_banner` in this case so
	 * that site-wide content banners are displayed if set.
	 */
	$post_id = false;
	if ( is_singular() ) {
		// Returns the current post ID.
		$post_id = get_post()->ID;
	}

	/**
	 * Fires immediately before a content banner is displayed.
	 *
	 * The dynamic portion of the hook name, `$position`, refers to
	 * the registered content banner position.
	 *
	 * @since 2.0.0
	 *
	 * @param int $post_id Post ID.
	 */
	do_action( "r_before_content_banner_{$position}", $post_id );

	/**
	 * Fires immediately before a content banner.
	 *
	 * @since 2.0.0
	 *
	 * @param string $position Registered content banner position.
	 * @param int    $post_id  Post ID.
	 */
	do_action( 'r_before_content_banner', $position, $post_id );

	$banner_args = array(
		'before'   => sprintf( '<div class="banner-container bannerContainer-%s">', $position ),
		'after'    => '</div>',
		'class'    => 'banner',
		'position' => $position,
		'echo'     => false,
	);

	/**
	 * Filters the generated content banner arguments.
	 *
	 * @since 2.0.0
	 *
	 * @param array  $banner_args Whether the slug would be bad as an attachment slug.
	 * @param string $position    Registered content banner position.
	 * @param int    $post_id     Post ID.
	 */
	$banner_args = apply_filters( 'r_content_banner_args', $banner_args, $position, $post_id );

	$banner_output = bu_content_banner( $post_id, $banner_args );

	/**
	 * Filters the generated content banner markup.
	 *
	 * @since 2.0.0
	 *
	 * @param array  $banner_output Output markup generated by BU Content Banner.
	 * @param string $position      Registered content banner position.
	 * @param int    $post_id       Post ID.
	 */
	$banner_output = apply_filters( 'r_content_banner_output', $banner_output, $position, $post_id );

	echo $banner_output;

	/**
	 * Fires immediately after a content banner is displayed.
	 *
	 * The dynamic portion of the hook name, `$position`, refers to
	 * the registered content banner position.
	 *
	 * @since 2.0.0
	 *
	 * @param int $post_id Post ID.
	 */
	do_action( "r_after_content_banner_{$position}", $post_id );

	/**
	 * Fires immediately after a content banner.
	 *
	 * @since 2.0.0
	 *
	 * @param string $position Registered content banner position.
	 * @param int    $post_id  Post ID.
	 */
	do_action( 'r_after_content_banner', $position, $post_id );
}

/**
 * Renders the primary navigation menu.
 *
 * If the current site has a site-wide ACL applied nothing will be displayed.
 *
 * @uses  BU Navigation plugin
 */
function responsive_primary_nav() {
	if ( ! method_exists( 'BuAccessControlPlugin', 'is_site_403' ) ||
		false == BuAccessControlPlugin::is_site_403() ) {
		bu_navigation_display_primary( array(
			'container_id'    => 'primary-nav-menu',
			'container_class' => 'primary-nav-menu',
		) );
	}
}

/**
 * Renders utility navigation menu.
 *
 * If the current site has a site-wide ACL applied or the utility menu has
 * no items nothing will be displayed.
 *
 * @param array $args {
 *     Optional. Arguments to configure menu markup.
 *
 *     @type  string $before HTML markup to display before menu.
 *     @type  string $after  HTML markup to display after menu.
 * }
 */
function responsive_utility_nav( $args = array() ) {
	if ( ! has_nav_menu( 'utility' ) ) {
		return;
	}

	$defaults = array(
		'before' => '<nav class="utility-nav" role="navigation">',
		'after'  => '</nav>',
		);
	$args = wp_parse_args( $args, $defaults );
	$menu = '';

	if ( ! method_exists( 'BuAccessControlPlugin', 'is_site_403' ) ||
		false == BuAccessControlPlugin::is_site_403() ) {
		$menu = wp_nav_menu( array(
			'theme_location' => 'utility',
			'menu_id'        => 'utility-nav-menu',
			'menu_class'     => 'utility-nav-menu',
			'container'      => false,
			'echo'           => false,
		) );
	}

	if ( $menu ) {
		echo $args['before'] . $menu . $args['after'];
	}
}

/**
 * Renders footer links custom menu.
 *
 * @param array $args {
 *     Optional. Arguments to configure menu markup.
 *
 *     @type  string $before HTML markup to display before menu.
 *     @type  string $after  HTML markup to display after menu.
 * }
 */
function responsive_footer_menu( $args = array() ) {
	if ( ! has_nav_menu( 'footer' ) ) {
		return;
	}

	$defaults = array(
		'before' => '<nav class="site-footer-links" role="navigation">',
		'after'  => '</nav>',
		);
	$args = wp_parse_args( $args, $defaults );
	$menu = '';

	$menu = wp_nav_menu( array(
		'theme_location' => 'footer',
		'depth'          => 1,
		'menu_id'        => 'site-footer-links-menu',
		'menu_class'     => 'site-footer-links-menu',
		'container'      => false,
		'echo'           => false,
	) );

	if ( $menu ) {
		echo $args['before'] . $menu . $args['after'];
	}
}

/**
 * Renders the social links menu for the footer.
 *
 * A filter is used to ensure the menu link has a title attribute.
 *
 * @param array $args {
 *     Optional. Arguments to configure menu markup.
 *
 *     @type  string $before HTML markup to display before menu.
 *     @type  string $after  HTML markup to display after menu.
 * }
 */
function responsive_social_menu( $args = array() ) {
	if ( ! has_nav_menu( 'social' ) ) {
		return;
	}

	$defaults = array(
		'before' => '<nav class="site-footer-social" role="navigation">',
		'after'  => '</nav>',
		);
	$args = wp_parse_args( $args, $defaults );
	$menu = '';

	add_filter( 'nav_menu_link_attributes', 'responsive_social_nav_menu_link_attributes', 10, 2 );

	$menu = wp_nav_menu( array(
		'theme_location' => 'social',
		'depth'          => 1,
		'link_before'    => '<i aria-hidden="true"></i><span>',
		'link_after'     => '</span>',
		'menu_id'        => 'site-footer-social-menu',
		'menu_class'     => 'site-footer-social-menu',
		'container'      => false,
		'echo'           => false,
	) );

	remove_filter( 'nav_menu_link_attributes', 'responsive_social_nav_menu_link_attributes', 10, 2 );

	if ( $menu ) {
		echo $args['before'] . $menu . $args['after'];
	}
}

/**
 * Sets <a> tags title attribute to the item title if none is set.
 *
 * @param array   $atts {
 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
 *
 *     @type string $title  Title attribute.
 *     @type string $target Target attribute.
 *     @type string $rel    The rel attribute.
 *     @type string $href   The href attribute.
 * }
 * @param WP_Post $item  The current menu item.
 *
 * @return array $atts
 */
function responsive_social_nav_menu_link_attributes( $atts, $item ) {
	if ( empty( $atts['title'] ) ) {
		$atts['title'] = $item->title;
	}

	return $atts;
}

if ( ! function_exists( 'responsive_posts_navigation' ) ) :

	/**
	 * Display navigation to next/previous set of posts when applicable.
	 *
	 * @param array         $args {
	 *     The attributes used for formatting and displaying post navigation links.
	 *
	 *     @type string $prev_text  The previous link text.
	 *     @type string $next_text The next link text.
	 *     @type string $screen_reader_text The text to display for screen readers.
	 * }
	 * @param WP_Query|null $query WP_Query object to display post navigation for. Default is the global page query.
	 */
	function responsive_posts_navigation( $args = array(), WP_Query $query = null ) {
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
		if ( $wp_query->max_num_pages >= 2 ) :
			$archive_type = responsive_archive_type( $wp_query );
			$defaults = array(
				'prev_text'          => '<span class="meta-nav">&larr;</span> Previous',
				'next_text'          => 'Next <span class="meta-nav">&rarr;</span>',
				'screen_reader_text' => ucfirst( $archive_type ) . ' navigation',
				);

				// Post archive labels are more specific.
			if ( 'posts' === $archive_type ) {
				$defaults['prev_text'] = '<span class="meta-nav">&larr;</span> Newer posts';
				$defaults['next_text'] = 'Older posts <span class="meta-nav">&rarr;</span>';
			}

			$args = wp_parse_args( $args, $defaults );
		?>
		<nav class="navigation posts-navigation paging-navigation" role="navigation">
		<h3 class="screen-reader-text"><?php echo esc_html( $args['screen_reader_text'] ); ?></h3>
		<div class="nav-links">
			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-previous"><?php previous_posts_link( $args['prev_text'] ); ?></div>
			<?php endif; ?>

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-next"><?php next_posts_link( $args['next_text'] ); ?></div>
			<?php endif; ?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
	endif;

		// Restore the global WP_Query instance if we replaced it.
		if ( ! is_null( $query ) && $tmp_query ) {
			$wp_query = $tmp_query;
		}
	}

endif;

if ( ! function_exists( 'responsive_post_navigation' ) ) :

	/**
	 * Display navigation to next/previous post when applicable.
	 *
	 * @param array $args {
	 *     The attributes used for formatting and displaying post navigation links.
	 *
	 *     @type string $prev_text  The previous link text.
	 *     @type string $next_text The next link text.
	 *     @type string $screen_reader_text The text to display for screen readers.
	 * }
	 */
	function responsive_post_navigation( $args = array() ) {
		$args = wp_parse_args( $args, array(
			'prev_text'          => '<span class="meta-nav">&larr;</span>&nbsp;%title',
			'next_text'          => '%title&nbsp;<span class="meta-nav">&rarr;</span>',
			'screen_reader_text' => 'Post navigation',
		) );

			$previous   = get_previous_post_link( '<div class="nav-previous">%link</div>', $args['prev_text'] );
			$next       = get_next_post_link( '<div class="nav-next">%link</div>', $args['next_text'] );

		if ( $previous || $next ) :
			?>
			<nav class="navigation post-navigation" role="navigation">
			<h3 class="screen-reader-text"><?php echo esc_html( $args['screen_reader_text'] ); ?></h3>
			<div class="nav-links">
			<?php echo $previous . $next; ?>
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
		endif;
	}

endif;

if ( ! function_exists( 'responsive_post_meta' ) ) :

	/**
	 * Render post meta entry HTML.
	 */
	function responsive_post_meta() {
		?>
		<div class="entry-meta">
		<?php if ( responsive_posts_should_display( 'author' ) ) : ?>
		<span class="author"><em>By</em> <?php the_author_posts_link(); ?></span>
		<?php endif; ?>
		<?php if ( responsive_posts_should_display( 'date' ) ) : ?>
		<span class="date"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ) ?>" pubdate><?php echo esc_html( get_the_date( 'F jS Y' ) ); ?></time></span>
		<?php endif; ?>
		<?php if ( responsive_posts_should_display( 'categories' ) && $category_list = get_the_category_list( ', ' ) ) : ?>
		<span class="category"><em>in</em> <?php echo $category_list; ?></span>
		<?php endif; ?>
		<?php if ( bu_supports_comments() ) : ?>
		<span class="comment-counter"><a href="<?php comments_link(); ?>" rel="nofollow"><?php comments_number( '<strong>0</strong> comments', '<strong>1</strong> comment', '<strong>%</strong> comments' ); ?></a></span>
		<?php endif; ?>
	</div>
	<?php
	}

endif;

/**
 * Returns one or more Customizer display option value.
 *
 * Site admin can configure display of the following post meta for single and archive post templates:
 * 	- Categories
 * 	- Tags
 * 	- Author
 *
 * @return array $display_options Post display options array, or the specified option.
 */
function responsive_get_post_display_options() {
	$display_options = get_option( 'burf_setting_post_display_options' );

	// First time load -- default to "Categories" and "Tags".
	if ( false === $display_options ) {
		$display_options = array( 'categories', 'tags' );
	} else {
		if ( ! is_array( $display_options ) ) {
			$display_options = explode( ',', $display_options );
		}
	}

	return $display_options;
}

/**
 * Whether or not the given post field should be displayed.
 *
 * @param string $field Field to check should display.
 *
 * @return boolean Whether to display the field.
 */
function responsive_posts_should_display( $field ) {
	return in_array( $field, responsive_get_post_display_options() );
}

/**
 * Attempts to find a suitable post archive link for this site.
 *
 * 1. First page with news template applied set to "All Categories"
 * 2. Permalink for page set as "Posts page" via Settings > Reading
 * 3. Home page if front page displays latest posts
 *
 * Child themes can override if they're doing something crazy by hooking
 * in to the `responsive_get_posts_archive_link` filter.
 *
 * @todo Move news template category logic to the bu-post-lists plugin.
 *
 * @return mixed Post archive link, or false if no good candidates were found.
 */
function responsive_get_posts_archive_link() {
	$archive_link = false;

	// Look first for pages with the News template applied.
	$news_pages = get_pages( array(
		'meta_key'   => '_wp_page_template',
		'meta_value' => 'page-templates/news.php',
	) );

	// Find the first news page set to display "All Categories".
	foreach ( $news_pages as $page ) {
		$categories = get_post_meta( $page->ID, '_bu_list_news_category', true );
		if ( empty( $categories ) ) {
			$archive_link = get_permalink( $page );
			break;
		}
	}

	if ( ! $archive_link ) {
		// If current site has Settings > Reading set to display Posts on a page use that.
		if ( 'page' === get_option( 'show_on_front' ) ) {
			$posts_page = get_option( 'page_for_posts' );
			if ( $posts_page ) {
				$archive_link = get_permalink( $posts_page );
			}
			// Use home page link if Settings > Reading is set to display latest posts.
		} else {
			$archive_link = home_url();
		}
	}

	return apply_filters( 'responsive_get_posts_archive_link', $archive_link );
}

/**
 * Display a post archive link.
 *
 * @param array $args {
 *     Optional. Arguments to configure link markup.
 *
 *     @type  string $label The link label.
 *     @type  string $class The class attribute for the anchor tag.
 *     @type  bool   $echo If true, print link. Otherwise return it.
 * }
 * @return string The post archive anchor tag.
 */
function responsive_posts_archive_link( $args = array() ) {
	$defaults = array(
		'label'  => 'View all posts',
		'before' => '<p>',
		'after'  => '</p>',
		'class'  => 'archive-link posts-archive-link',
		'echo'   => true,
		);
	$args = wp_parse_args( $args, $defaults );

	$link = '';
	$class_attr = '';
	if ( ! empty( $args['class'] ) ) {
		$class_attr = ' class="' . esc_attr( $args['class'] ) . '"';
	}

	$archive_link = responsive_get_posts_archive_link();

	if ( $archive_link ) {
		$link = sprintf( '%s<a href="%s"%s>%s</a>%s',
			$args['before'],
			esc_url( $archive_link ),
			$class_attr,
			$args['label'],
			$args['after']
		);
	}

	if ( $args['echo'] ) {
		echo $link;
	} else {
		return $link;
	}
}

/**
 * Display a profiles archive link.
 *
 * A thin wrapper around the BU Profiles-provided `bu_profile_archive_link` function.
 *
 * @param array $args {
 *     Optional. Arguments to configure link markup.
 *
 *     @type  string $label The link label.
 *     @type  string $class The class attribute for the anchor tag.
 *     @type  bool   $echo If true, print link. Otherwise return it.
 * }
 * @return string The profiles archive anchor tag.
 */
function responsive_profiles_archive_link( $args = array() ) {
	$defaults = array(
		'before' => '<p>',
		'after'  => '</p>',
		'class'  => 'archive-link profiles-archive-link',
		'echo'   => true,
		);
	$args = wp_parse_args( $args, $defaults );

	if ( function_exists( 'bu_profile_archive_link' ) ) {
		return bu_profile_archive_link( $args );
	}
}

/**
 * Returns the number of widgets contained in the given sidebar.
 *
 * @param  string $sidebar_id  The sidebar to check.
 *
 * @return int|bool            Number of widgets, or false if the sidebar is not registered.
 */
function responsive_get_widget_counts( $sidebar_id ) {
	$sidebars = wp_get_sidebars_widgets();

	if ( array_key_exists( $sidebar_id, $sidebars ) ) {
		return count( $sidebars[ $sidebar_id ] );
	}
	return false;
}

/**
 * Prints out contextual classes for sidebar containers.
 *
 * Used to included widget counts.
 *
 * @param string $sidebar_id Sidebar ID to retrieve class for.
 */
function responsive_sidebar_classes( $sidebar_id ) {
	$widget_count = responsive_get_widget_counts( $sidebar_id );
	$count = ( $widget_count > 0 ) ? $widget_count : 'none';

	echo esc_attr( "widgetCount-$count" );
}

/**
 * Generates class attributes for the site footer container.
 *
 * Provides the `responsive_extra_footer_classes` filter for child theme extension.
 */
function responsive_extra_footer_classes() {
	$classes = array();

	// Build an array to capture current footer content permutation.
	$footer_components = array();

	// Is the Customizer-provided footer info in use?
	if ( responsive_customizer_has_footer_info() ) {
		$footer_components[] = 'info';
	}
	// Is the custom footer links menu in use?
	if ( has_nav_menu( 'footer' ) ) {
		$footer_components[] = 'links';
	}
	// Is the custom social menu in use?
	if ( has_nav_menu( 'social' ) ) {
		$footer_components[] = 'social';
	}

	// Combine all components in to one stateful class.
	if ( ! empty( $footer_components ) ) {
		$classes[] = 'has-' . implode( '-', $footer_components );
	}

	$classes = apply_filters( 'responsive_extra_footer_classes', $classes );
	$classes = array_unique( array_map( 'esc_attr', $classes ) );

	echo esc_attr( implode( ' ', $classes ) );
}

/**
 * Get list of all post types included for the given query
 *
 * @param  WP_Query $query Query object to check. Optional. Defaults to current global query.
 * @return array  Array of post type names
 */
function responsive_queried_post_types( WP_Query $query = null ) {
	if ( is_null( $query ) ) {
		$query = $GLOBALS['wp_query'];
	}

	$queried_object = $query->get_queried_object();

	// Post = post object.
	if ( $query->is_single() || $query->is_page() ) {
		$post_types = array( $queried_object->post_type );
	} // Post type archive = post type object.
	elseif ( $query->is_post_type_archive() ) {
		$post_types = array( $queried_object->name );
	} // Taxonomy archive = taxonomy object.
	elseif ( $query->is_tax() || $query->is_category() || $query->is_tag() ) {
		$tax = get_taxonomy( $queried_object->taxonomy );
		$post_types = $tax->object_type;
	} // All other requests default to posts (author archives, date archives, etc.).
	else {
		$post_types = array( 'post' );
	}

	return apply_filters( 'responsive_queried_post_types', $post_types, $query );
}

/**
 * Determine primary post type of archive query
 *
 * @param  WP_Query $query Query object to check. Optional. Defaults to current global query.
 * @return string Post type name. Uses lowercase version of plural (name) label.
 */
function responsive_archive_type( WP_Query $query = null ) {
	$post_types = responsive_queried_post_types( $query );

	// Default type.
	$archive_type = 'posts';

	// Use plural label.
	if ( is_array( $post_types ) && 1 === count( $post_types ) ) {
		$pto = get_post_type_object( reset( $post_types ) );
		if ( $pto ) {
			$archive_type = strtolower( $pto->label );
		}
	}

	return apply_filters( 'responsive_archive_type', $archive_type, $post_types );
}

/**
 * Is the archive query for the given post type?
 *
 * @param  string   $type  Plural post type name for comparison.
 * @param  WP_Query $query Query object to check. Optional. Defaults to current global query.
 * @return bool
 */
function responsive_is_archive_type( $type, WP_Query $query = null ) {
	return ( strtolower( $type ) === responsive_archive_type( $query ) );
}

/**
 * Whether or not the current theme supports alternate footbar registration.
 */
function responsive_theme_supports_dynamic_footbars() {

	// Check for theme constant.
	if ( defined( 'BU_SUPPORTS_DYNAMIC_FOOTBARS' ) ) {
		return BU_SUPPORTS_DYNAMIC_FOOTBARS;
		// Check for site option.
	} else {
		$sidebar_options = get_option( 'burf_setting_sidebar_options', array() );
		if ( ! is_array( $sidebar_options ) ) {
			$sidebar_options = explode( ',', $sidebar_options );
		}
		return ( in_array( 'dynamic_footbars', $sidebar_options ) );
	}
}

/**
 * Return a list of available dynamic footbars.
 */
function responsive_get_dynamic_footbars() {
	return array(
		'footbar'           => 'Footbar',
		'alternate-footbar' => 'Alternate Footbar',
		);
}

/**
 * Retrieve the footbar selected for the given post.
 *
 * @param null|WP_Post|int $post Null to use the global post object, WP_Post or post ID to use a specific post.
 *
 * @return string $footbar Selected footbar ID for the post.
 */
function responsive_get_footbar_id( $post = null ) {
	$post = get_post( $post );
	$footbar = 'footbar';

	if ( $post && responsive_theme_supports_dynamic_footbars() && post_type_supports( $post->post_type, 'bu-dynamic-footbars' ) ) {
		$selected_footbar = get_post_meta( $post->ID, '_bu_footbar_id', true );
		if ( $selected_footbar ) {
			$footbar = $selected_footbar;
		}
	}

	return $footbar;
}
