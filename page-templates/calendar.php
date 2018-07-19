<?php
/**
 * Template Name: Calendar
 *
 * @package Responsive_Framework
 */

// Retrieves event id. This is used to determine if calendar view or single-event view, and if a sidebar should show up.
$event_id = responsive_calendar_get_event_id();

get_header();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( responsive_calendar_article_classes() ); ?>>
	<?php
	// Retrieves calendar or single-event partial.
	if ( is_null( $event_id ) ) {
		get_template_part( 'template-parts/calendar/calendar.php' );
	} else {
		get_template_part( 'template-parts/calendar/single-event.php' );
	}
	?>
</article>

<?php
// Retrieve the sidebar if there is no event id.
if ( is_null( $event_id ) ) {
	get_sidebar( 'calendar' );
}

get_footer();
