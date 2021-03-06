<?php
/**
 * Template used for individual event views.
 *
 * This is not a selectable page template - its use is determined by query
 * parameters via the `responsive_calendar_template_include` function in
 * `inc/template-hooks.php`.
 *
 * @package Responsive_Framework
 */

/**
 * Replace WP Title with event's title from BU Calendar App.
 *
 * @since 2.3.3
 *
 * @param string $title The title of the page based on the current query.
 * @return string $title The modified title printed to the page.
 */
function responsive_get_the_title_single_event( $title ) {

	// Retrieve single-event parameters.
	$event = responsive_calendar_get_event();

	// Conditionally change page title to event title from BU Calendar App.
	if ( ! empty( $event['summary'] ) ) {
		$title = $event['summary'];
	}

	return $title;
}
add_filter( 'responsive_get_the_title', 'responsive_get_the_title_single_event' );

/**
 * Begin templating.
 */
get_header();

/**
 * Fires immediately before the opening article tag.
 *
 * @since 2.3.3
 */
do_action( 'r_before_opening_article' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'content-area' ); ?>>

	<?php
	/**
	 * Fires immediately after opening article tag.
	 *
	 * @since 2.3.3
	 */
	do_action( 'r_after_opening_article' );

	// Retrieves the single event partial.
	get_template_part( 'template-parts/calendar/single-event' );

	/**
	 * Fires immediately before closing article tag.
	 *
	 * @since 2.3.3
	 */
	do_action( 'r_before_closing_article' );
	?>

</article>

<?php
/**
 * Fires immediately after closing article tag.
 *
 * @since 2.3.3
 */
do_action( 'r_after_closing_article' );

get_footer();
