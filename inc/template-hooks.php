<?php
/**
 * Hooks that aid in templating
 *
 * A template hook is considered as any function that hooks into the actions
 * or filters provided by the theme. These are mostly hooks intended for the
 * front-end of a website to affect theme appearance.
 *
 * Examples:
 * - Adding content to the action hook `r_before_opening_container_outer` fired
 *   from `header.php`.
 * - Using the native WP `body_class` filter to add additional body classes to
 *   aid in templating.
 *
 * @link       www.bu.edu/interactive-design/
 *
 * @package    Responsive_Framework
 * @subpackage Responsive_Framework/inc
 * @since      2.2.1
 */

/**
 * Filters the path of the current template before including it.
 *
 * @since 2.2.1
 *
 * @link https://developer.wordpress.org/reference/hooks/template_include/
 *
 * @param string $template The path of the template to include.
 * @return string $template The path of the template to include.
 */
function responsive_calendar_template_include( $template ) {

	// Bails immediately if this is not the calendar template.
	if ( 'page-templates/calendar.php' !== $template ) {
		return $template;
	}

	// Attempt to retrieve an event ID.
	$event_id = responsive_calendar_get_event_id();

	// Conditionally load the single event template.
	if ( ! is_null( $event_id ) ) {
		// Attempt to locate the single event template.
		$single_event_template = locate_template( 'page-template/calendar-single.php' );
		// If single event template exists, laod it instead of calendar template.
		$template = $single_event_template;
	}

	return $template;
}
add_filter( 'template_include', 'responsive_calendar_template_include' );

/**
 * Adds the page title to the front end immediately after opening article tag.
 *
 * @since 2.2.1
 *
 * @see inc/template-tags.php for `responsive_the_title()` definition.
 */
add_action( 'r_after_opening_article', 'responsive_the_title' );

if ( ! function_exists( 'responsive_single_profile_img' ) ) {
	/**
	 * Adds a profile image intended for `single-profile.php`.
	 *
	 * @since 2.2.1
	 */
	function responsive_single_profile_img() {

		// Sets profile thumbnail to false by default.
		$profile_thumb = false;

		// If BU Thumbnail exists, attempt to retrieve the image HTML.
		if ( function_exists( 'bu_thumbnail' ) ) {
			$thumb_args = array(
				'maxwidth'  => 300,
				'maxheight' => 300,
				'size'      => 'responsive_profile_large',
			);
			$profile_thumb = bu_get_thumbnail_src( get_the_ID(), $thumb_args );
		}

		// Output the thumbnail if found.
		if ( $profile_thumb ) :
			?>
			<figure class="profile-photo profile-single-photo">
				<?php echo wp_kses_post( $profile_thumb ); ?>
			</figure>
			<?php
		endif;

	}
}
add_action( 'r_after_opening_article', 'responsive_single_profile_img', 9 );

if ( ! function_exists( 'responsive_single_profile_subheader' ) ) {
	/**
	 * Adds a profile title intended for `single-profile.php`.
	 *
	 * @since 2.2.1
	 */
	function responsive_single_profile_subheader() {
		?>
		<h2 class="profile-single-title"><?php bu_profile_detail( 'title' ); ?></h2>
		<?php
	}
}
add_action( 'r_after_opening_article', 'responsive_single_profile_subheader', 11 );
