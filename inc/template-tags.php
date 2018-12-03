<?php
/**
 * Custom template tags for this framework.
 *
 * @package Responsive_Framework
 */

/**
 * Print the site's title tag for `<head />` element.
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
		/* translators: %d: number of pages. */
		echo esc_html( ' | ' . sprintf( __( 'Page %d', 'responsive-framework' ), max( $paged, $page ) ) );
	}
}

if ( ! function_exists( 'responsive_the_title' ) ) {

	/**
	 * Outputs the title for the current query with h1 tag.
	 *
	 * @since    2.1.4
	 *
	 * @see      responsive_get_the_title
	 *
	 * @param array $args {
	 *     Optional. An array of arguments.
	 *
	 *     @type string $class Class to be applied to h1 element. Default 'page-title'.
	 *     @type bool   $echo  Whether to echo or return the title. Default true for echo.
	 * }
	 *
	 * @return   string $html The current query's title with h1 tag.
	 */
	function responsive_the_title( $args = array() ) {

		/**
		 * Theme filter for preventing any output of page title.
		 *
		 * Useful in contexts for turning off the page title, such as
		 * when it already exists in BU Banners.
		 *
		 * @since 2.1.5
		 * @return bool False by default. Set to true to return immediately.
		 */
		if ( apply_filters( 'responsive_the_title_is_hidden', false ) ) {
			return;
		}

		// Declares default arguments.
		$defaults = array(
			'class' => 'page-title',
			'echo'  => true,
		);

		// Merges supplied arguments with defaults.
		$args = wp_parse_args( $args, $defaults );

		// Allows class to be filtered.
		$args['class'] = (string) apply_filters( 'responsive_the_title_class', $args['class'] );

		// Stores the title.
		$title = responsive_get_the_title();

		// Returns immediately if no title.
		if ( empty( $title ) ) {
			return;
		}

		// Builds the h1 tag.
		if ( ! empty( $args['class'] ) ) {
			$html = '<h1 class="' . esc_attr( $args['class'] ) . '">' . $title . '</h1>';
		} else {
			$html = '<h1>' . $title . '</h1>';
		}

		// Echoes or returns the html.
		if ( $args['echo'] ) {
			echo wp_kses(
				$html,
				array(
					'h1' => array(
						'class' => array(),
					),
				)
			);
		} else {
			return $html;
		}
	}
}

if ( ! function_exists( 'responsive_get_the_title' ) ) {

	/**
	 * Returns the title for the current query.
	 *
	 * - For pages and posts, `the_title` will be used.
	 * - For taxonomy term queries, `single_term_title` will be used.
	 * - For post-type or date-based archives, `get_the_archive_title` will be used.
	 *
	 * Note: Intended only to be used once, where the main page title is.
	 *
	 * @since    2.1.4
	 *
	 * @link     https://developer.wordpress.org/reference/functions/single_term_title/
	 * @link     https://developer.wordpress.org/reference/functions/get_the_archive_title/
	 *
	 * @return   string $title The current query's title.
	 */
	function responsive_get_the_title() {

		// Search query title.
		if ( is_search() ) :
			/* translators: %s: current search query. */
			$title = sprintf( __( 'Search Results for: %s', 'responsive-framework' ), '<span>' . get_search_query() . '</span>' );
			// Error 404 page title.
		elseif ( is_404() ) :
			$title = __( 'Yikes! We couldn\'t find that.', 'responsive-framework' );
			// Blog home.
		elseif ( is_home() ) :
			// If Settings > Reading > Front page set to a specific posts page, use that page title.
			$posts_page_id = get_option( 'page_for_posts' );
			if ( ! empty( $posts_page_id ) ) :
				$title = get_the_title( $posts_page_id );
				// Else, if Settings > Reading > Front page is using default settings, use blog title and description from Settings > General.
			elseif ( is_home() && is_front_page() ) :
				$title = get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' );
			endif;
			// Archives.
		elseif ( is_archive() ) :
			// BU Profles archive.
			if ( is_post_type_archive( 'profile' ) ) {
				$title = __( 'Profile Directory', 'responsive-framework' );
				// Custom taxonomies, categories, and tags.
			} elseif ( is_tax() || is_category() || is_tag() ) {
				$title = single_term_title( '', false );
				// All other archives (custom post-types, date-based).
			} else {
				$title = get_the_archive_title();
			}
			// Singular profile.
		elseif ( is_singular( 'profile' ) && function_exists( 'bu_profile_detail' ) ) :
			// @see bu-profiles plugin: bu-profiles/bu-profile-template-tags.php.
			$first_name = bu_profile_detail( 'first_name', array( 'echo' => false ) );
			$last_name  = bu_profile_detail( 'last_name', array( 'echo' => false ) );
			if ( ! empty( $first_name ) && ! empty( $last_name ) ) {
				$title = $first_name . ' ' . $last_name;
			} else {
				$title = get_the_title();
			}
		else :
			// Default: A single post/page.
			$title = get_the_title();
		endif;

		// Allow the current title to be filtered.
		$title = apply_filters( 'responsive_filter_get_the_title', $title );

		return $title;
	}
}

/**
 * Whether or not the current network is a bu.edu domain.
 *
 * @return bool true if the blog is a BU domain, false if it is not or returns
 *              an error.
 */
function responsive_is_bu_domain() {
	return (bool) preg_match( '#\bbu\.edu\b#', network_home_url() );
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
		'before'    => sprintf( '<span class="categories">%s: ', esc_html__( 'Categories', 'responsive-framework' ) ),
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
 * Generates a list of term links for each taxonomy registered to the post's type, excluding categories and tags.
 *
 * @param int|WP_Post|null $post Optional.   Post ID or post object. Defaults to global $post.
 * @param string           $before Optional. Before list.
 * @param string           $sep Optional.    Separate items using this.
 * @param string           $after Optional.  After list.
 *
 * @return string A list of term links.
 */
function responsive_term_links( $post = null, $before = '', $sep = '', $after = '' ) {
	if ( ! $post = get_post( $post ) ) {
		return;
	}

	// Get taxonomies registered for the current post type.
	$taxonomies = get_object_taxonomies( $post->post_type );

	if ( empty( $taxonomies ) || is_wp_error( $taxonomies ) ) {
		return;
	}

	$output = '';

	foreach ( $taxonomies as $taxonomy ) {
		if ( 'category' === $taxonomy && 'post_tag' === $taxonomy ) {
			continue;
		}

		$output .= get_the_term_list( $post->ID, $taxonomy, $before, $sep, $after );
	}

	return $output;
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

		if ( function_exists( 'bu_navigation_display_primary' ) ) {
			bu_navigation_display_primary( array(
				'container_id'    => 'primary-nav-menu',
				'container_class' => 'primary-nav-menu',
			) );
		} else {
			wp_nav_menu( array(
				'theme_location' => 'responsive-primary',
				'menu_id'        => 'primaryNav-menu',
				'menu_class'     => 'primaryNav-menu',
				'container_tag'  => 'ul',
				'depth'          => 2,
			) );
		}
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

	if ( ! method_exists( 'BuAccessControlPlugin', 'is_site_403' ) || false == BuAccessControlPlugin::is_site_403() ) {
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
 * Renders short navigation menu.
 *
 * If the current site has a site-wide ACL applied or the short menu has
 * no items nothing will be displayed.
 *
 * @param array $args {
 *     Optional. Arguments to configure menu markup.
 *
 *     @type  string $before HTML markup to display before menu.
 *     @type  string $after  HTML markup to display after menu.
 * }
 */
function responsive_short_nav( $args = array() ) {
	if ( ! has_nav_menu( 'short' ) ) {
		return;
	}

	$after  = '<button type = "button" class                                                                                                                      = "nav-toggle js-nav-toggle" aria-label = "' . __( 'Open menu', 'responsive-framework' ) . '" aria-expanded = "true">';
	$after .= '<div class = "nav-toggle-label-closed">' . apply_filters( 'responsive_mega_menu_closed', __( 'Full Menu', 'responsive-framework' ) ) . '</div>';
	$after .= '<div class = "nav-toggle-label-open">' . apply_filters( 'responsive_mega_menu_opened', __( 'Close Menu', 'responsive-framework' ) ) . '</div>';
	$after .= '<span></span>';
	$after .= '</button>';
	$after .= '</nav>';

	$defaults = array(
		'before' => '<nav class="short-nav" role="navigation">',
		'after'  => $after,
	);

	$args = wp_parse_args( $args, $defaults );
	$menu = '';

	if ( ! method_exists( 'BuAccessControlPlugin', 'is_site_403' ) || false == BuAccessControlPlugin::is_site_403() ) {
		$menu = wp_nav_menu( array(
			'theme_location' => 'short',
			'menu_id'        => 'short-nav-menu',
			'menu_class'     => 'short-nav-menu',
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
		'link_before'    => '<span>',
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
		$wp_query  = $query;
	}

	$archive_type = 'posts';

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages >= 2 ) :
		$queried_object = get_queried_object();
		if ( is_post_type_archive() ) {
			$archive_type = $queried_object->labels->singular_name;
		} elseif ( is_tax() || is_category() || is_tag() ) {
			$taxonomy_object = get_taxonomy( $queried_object->taxonomy );

			$post_type = get_post_type( $taxonomy_object->object_type[0] );

			$archive_type = $post_type->labels->singular_name;
		}

		$defaults = array(
			'prev_text'          => '<span class="meta-nav">&larr;</span> Previous',
			'next_text'          => 'Next <span class="meta-nav">&rarr;</span>',
			/* translators: %s: archive type singular name. */
			'screen_reader_text' => sprintf( __( '%s navigation', 'responsive-framework' ), ucfirst( $archive_type ) ),
		);

			// Post archive labels are more specific.
		if ( 'posts' === $archive_type ) {
			$defaults['prev_text'] = sprintf( '<span class="meta-nav">&larr;</span> %s', esc_html__( 'Newer posts', 'responsive-framework' ) );
			$defaults['next_text'] = sprintf( '%s <span class="meta-nav">&rarr;</span>', esc_html__( 'Older posts', 'responsive-framework' ) );
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
		'screen_reader_text' => __( 'Post navigation', 'responsive-framework' ),
	) );

	$previous = get_previous_post_link( '<div class="nav-previous">%link</div>', $args['prev_text'] );
	$next     = get_next_post_link( '<div class="nav-next">%link</div>', $args['next_text'] );

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

/**
 * Render post meta entry HTML.
 */
function responsive_post_meta() {
	?>
	<div class="meta post-meta">
		<?php if ( responsive_posts_should_display( 'author' ) ) : ?>
			<span class="author">
			<?php
				/* translators: %s: author name linking to their archive page. */
				printf( wp_kses( __( '<em>By </em>%s', 'responsive-framework' ), array(
					'em' => array(),
				) ), get_the_author_posts_link() );
			?>
		<?php endif; ?>
		<?php if ( responsive_posts_should_display( 'date' ) ) : ?>
			<span class="date"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" pubdate><?php echo esc_html( get_the_date( 'F jS Y' ) ); ?></time></span>
		<?php endif; ?>
		<?php if ( responsive_posts_should_display( 'categories' ) ) : ?>
			<?php
			$category_list = get_the_category_list( ', ' );

			if ( ! empty( $category_list ) ) :
				?>
				<span class="category">
				<?php
					/* translators: %s: category list for the post. */
					printf( wp_kses_post( __( '<em>in</em> %s', 'responsive-framework' ) ), $category_list ); // WPCS: XSS ok.
				?>
				</span>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( function_exists( 'bu_supports_comments' ) && bu_supports_comments() ) : ?>
			<span class="comment-counter">
				<a href="<?php comments_link(); ?>" rel="nofollow">
					<?php comments_number( wp_kses_post( __( '<strong>0</strong> comments', 'responsive-framework' ) ), wp_kses_post( __( '<strong>1</strong> comment', 'responsive-framework' ) ), wp_kses_post( __( '<strong>%</strong> comments', 'responsive-framework' ) ) ); ?>
				</a>
			</span>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Returns one or more Customizer display option value.
 *
 * Site admin can configure display of the following post meta for single and archive post templates:
 *
 * - Categories
 * - Tags
 * - Author
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
 * 1. First page with news template applied to post's first category.
 * 2. First page with news template applied set to "All Categories"
 * 3. Permalink for page set as "Posts page" via Settings > Reading
 * 4. Home page if front page displays latest posts
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
	$post_cats = get_the_terms( get_post(), 'category' );
	$post_cat_ids = wp_list_pluck( $post_cats, 'term_id' );
	$all_cats = false;

	$news_pages = get_pages( array(
		'hierarchical' => 0,
		'parent' => -1,
		'meta_key'     => '_wp_page_template',
		'meta_value'   => 'page-templates/news.php',
	) );

	foreach( $news_pages as $page ) {
		$page_cat_id = get_post_meta( $page->ID, '_bu_list_news_category', true );

		if ( in_array( $page_cat_id, $post_cat_ids ) ) {
			$archive_link = get_permalink( $page->ID );
			break;
		}

		// Find the first news page set to display "All Categories".
		// Hold onto it in case we can't find a page that matches the category.
		if ( empty( $page_cat_id ) && ! $all_cats ) {
			$all_cats = get_permalink( $page->ID );
			continue;
		}
	}

	wp_reset_postdata();

	// If we don't have a category match, but we have an all categories page, use that.
	if ( ! $archive_link && $all_cats ) {
			$archive_link = $all_cats;
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

	/**
	 * Filters the post archive link.
	 *
	 * @since 1.0.0
	 *
	 * @param string Post archive link.
	 */
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
		'label'  => __( 'View all posts', 'responsive-framework' ),
		'before' => '<p class="archive-link-container">',
		'after'  => '</p>',
		'class'  => 'archive-link posts-archive-link',
		'echo'   => true,
	);

	$args       = wp_parse_args( $args, $defaults );
	$link       = '';
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
		'before' => '<p class="archive-link-container">',
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
	$count        = ( $widget_count > 0 ) ? $widget_count : 'none';

	echo esc_attr( "widget-count-$count" );
}

/**
 * Generates class attributes for the site footer container.
 *
 * Provides the `responsive_extra_footer_classes` filter for child theme extension.
 */
function responsive_extra_footer_classes() {
	$classes = array();

	// Is the Customizer-provided footer info in use?
	if ( responsive_customizer_has_footer_info() ) {
		$classes[] = 'has-footer-info';
	}

	// Is the custom footer links menu in use?
	if ( has_nav_menu( 'footer' ) ) {
		$classes[] = 'has-footer-links';
	}

	// Is the custom social menu in use?
	if ( has_nav_menu( 'social' ) ) {
		$classes[] = 'has-footer-social';
	}

	/**
	 * Filters extra footer classes.
	 *
	 * @since 1.0.0
	 *
	 * @param array Extra classes for the footer.
	 */
	$classes = apply_filters( 'responsive_extra_footer_classes', $classes );

	$classes = array_unique( array_map( 'esc_attr', $classes ) );

	echo esc_attr( implode( ' ', $classes ) );
}

/**
 * Is the archive query for the given post type?
 *
 * @deprecated 2.0.0 Use is_post_type_archive()
 *
 * @param string $type Plural post type name for comparison.
 *
 * @return bool
 */
function responsive_is_archive_type( $type ) {
	_deprecated_function( __FUNCTION__, '2.0.0', 'is_post_type_archive()' );

	return is_post_type_archive( $type );
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
		'footbar'           => __( 'Footbar', 'responsive-framework' ),
		'alternate-footbar' => __( 'Alternate Footbar', 'responsive-framework' ),
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
	$post    = get_post( $post );
	$footbar = 'footbar';

	if ( $post && responsive_theme_supports_dynamic_footbars() && post_type_supports( $post->post_type, 'bu-dynamic-footbars' ) ) {
		$selected_footbar = get_post_meta( $post->ID, '_bu_footbar_id', true );
		if ( $selected_footbar ) {
			$footbar = $selected_footbar;
		}
	}

	return $footbar;
}

/**
 * Check a theme for a generic template part, or specialised template for a post type.
 *
 * If no template part exists for the given post type.
 *
 * @param string $post_type The slug name for the post type.
 * @param string $name      The name of the specialised template.
 */
function r_get_template_part( $post_type, $name = null ) {
	$templates = array();
	$name      = (string) $name;

	if ( '' !== $name ) {
		$templates[] = "template-parts/{$post_type}-{$name}.php";
	}

	$templates[] = "template-parts/{$post_type}.php";

	if ( ! locate_template( $templates, true, false ) ) {
		get_template_part( 'template-parts/content', $name );
	}
}

/**
 * Load sidebar template for an archive page.
 *
 * Templates will be searched for from most specific to least specific.
 *
 * @param string $name The name of the specialised sidebar.
 */
function r_get_archive_sidebar( $name = null ) {
	$templates = array();
	$name      = (string) $name;

	$queried_object = get_queried_object();

	if ( is_tag() || is_category() || is_tax() ) {
		if ( ! empty( $name ) ) {
			$templates[] = "sidebar-{$queried_object->taxonomy}-{$queried_object->slug}-{$name}.php";
		}
		$templates[] = "sidebar-{$queried_object->taxonomy}-{$queried_object->slug}.php";

		if ( ! empty( $name ) ) {
			$templates[] = "sidebar-{$queried_object->taxonomy}-{$name}.php";
		}
		$templates[] = "sidebar-{$queried_object->taxonomy}.php";

		if ( ! empty( $name ) ) {
			$templates[] = "sidebar-taxonomy-{$name}.php";
		}
		$templates[] = 'sidebar-taxonomy.php';
	} elseif ( is_post_type_archive() ) {
		if ( ! empty( $name ) ) {
			$templates[] = "sidebar-{$queried_object->name}-{$name}.php";
		}
		$templates[] = "sidebar-{$queried_object->name}.php";

		if ( ! empty( $name ) ) {
			$templates[] = "sidebar-post-type-{$name}.php";
		}
		$templates[] = 'sidebar-post-type.php';
	} elseif ( is_author() ) {
		if ( ! empty( $name ) ) {
			$templates[] = "sidebar-{$queried_object->user_login}-{$name}.php";
		}
		$templates[] = "sidebar-{$queried_object->user_login}.php";

		if ( ! empty( $name ) ) {
			$templates[] = "sidebar-author-{$name}.php";
		}
		$templates[] = 'sidebar-author.php';
	}

	$templates[] = "sidebar-{$name}.php";
	$templates[] = 'sidebar.php';

	locate_template( $templates, true );
}
