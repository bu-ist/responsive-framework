<?php
/**
 * Calendar partial for the calendar template.
 *
 * @package Responsive_Framework
 */

global $buCalendar;

// Displays the h1 page title and content.
if ( have_posts() ) {
	while ( have_posts() ) :
		the_post();
		the_title( '<h1 ' . r_page_title_class() . '>', '</h1>' );
		the_content( '<p class="serif">Read the rest of this page &raquo;</p>' );
		wp_link_pages( array(
			'before'         => '<p><strong>Pages:</strong> ',
			'after'          => '</p>',
			'next_or_number' => 'number',
		) );
	endwhile;
}

// Displays calendar component.
$calendar_id  = responsive_calendar_get_calendar_id();
$calendar_url = responsive_calendar_get_calendar_url();

// If no calendar ID exists, display error message.
if ( ! $calendar_id ) {
	?>
		<p>This site does not have any calendar associated with it.</p>
	<?php
} else {

	// Get initial values.
	$yyymmdd   = responsive_calendar_get_yyyymmdd();
	$timestamp = responsive_calendar_get_timestamp();

	/*
	* Check that date falls between:
	* The year 2000 (http://www.nbc.com/nbc/Late_Night_with_Conan_OBrien/intheyear2000/)
	* Ten years in the future from the current date
	*/
	$boundary_past   = responsive_calendar_get_boundary_past();
	$boundary_future = responsive_calendar_get_boundary_future();
	if ( $timestamp < $boundary_past ) {
		$timestamp = $boundary_past;
		$yyyymmdd = date( 'Ymd', $timestamp );
	}
	if ( $timestamp > $boundary_future ) {
		$timestamp = $boundary_future;
		$yyyymmdd = date( 'Ymd', $timestamp );
	}

	// Conditionally overwrite timestamp.
	if ( array_key_exists( 'date', $_GET ) ) {
		$timestamp = strtotime( $_GET['date'], 0 );
	}

	$start_date = strtotime( '00:00', $timestamp );
	$start_date = date( 'Y-m-d', $start_date );

	$months_to_show = 2;  // additional months to show.

	$days = ( intval( date( 't', $timestamp ) ) - intval( date( 'j', $timestamp ) ) ); // days left in current month.

	$cur_mo = intval( date( 'n', $timestamp ) );
	for ( $mo = 1; $mo <= $months_to_show; $mo++ ) {
		$days = $days + intval( date( 't', mktime( 0, 0, 0, date( 'n', $timestamp ) + $mo, 1 ) ) ); // let the month overflow for month&year.
	}

	$params = array( 'maxevents' => 25 );
	$events = $buCalendar->getEvents( $calendar_id, $start_date, $days, responsive_calendar_get_topic(), $params );

	$last_event = $events[ ( count( $events ) - 1 ) ]['starts']; // timestamp for the last event retrieved.

	$range_end = strtotime( '+' . $days . ' day', $timestamp );

	if ( count( $events ) < 25 ) {
		$query_end = $range_end;
	} else {
		$query_end = $last_event;
	}

	/* Content: Calendar Topic */
	$topic_detail = responsive_calendar_get_topic_detail();
	if ( is_array( $topic_detail ) ) {
		?>
			<h2 class="calendar-list-topic">
				<?php echo esc_html( $topic_detail['name'] ); ?><span class="calendar-list-range">
					(<?php echo esc_html( date( 'F j', $timestamp ) ); ?> through <?php echo esc_html( date( 'F j', $query_end ) ); ?>)
				</span>
			</h2>
		<?php
	}

	// Set initial values.
	$day        = null;
	$time       = null;
	$allday     = false;
	$nDisplayed = 0;

	if ( ( is_array( $events ) ) && ( count( $events ) > 0 ) ) {
		foreach ( $events as $e ) {

			$_day       = date( 'l, F j', $e['starts'] );
			$_time      = date( 'g:i A', $e['starts'] );
			$_allday    = $e['allday'];
			$event_time = '';
			if ( $_day != $day ) {
				if ( 0 != $nDisplayed ) {
					echo '</ul>' . PHP_EOL;
				}
				printf( '<h3 class="calendar-list-event-date">%s</h3>', esc_html( $_day ) );
				echo PHP_EOL . '<ul class="calendar-list-events">' . PHP_EOL;
				$day  = $_day;
				$time = null;
			}

			if ( $_allday ) {
				if ( $_allday != $allday ) {
					$event_time = 'All Day';
				}
			} else {
				if ( $_time != $time ) {
					$event_time = $_time;
					$time       = $_time;
				}
			}

			$event_url = $calendar_url;
			$event_url = add_query_arg( 'eid', $e['id'], $event_url );
			if ( ! empty( $e['oid'] ) ) {
				$event_url = add_query_arg( 'oid', $e['oid'], $event_url );
			}
			if ( ! empty( $_GET['cid'] ) ) {
				$event_url = add_query_arg( 'cid', intval( $_GET['cid'] ), $event_url );
			}
			echo "\t";

			if ( $event_time ) {
				printf( '<li class="calendar-list-event calendar-list-event-first-at-time"><span class="calendar-list-event-time">%s</span> ', esc_html( $event_time ) );
			} else {
				echo '<li class="calendar-list-event">';
			}

			printf( '<a class="calendar-list-event-link" href="%s">%s</a></li>', esc_url( $event_url ), wp_kses_post( $e['summary'] ) );
			echo PHP_EOL;

			$nDisplayed++;
			/* not sure how to close a day with multiple events...  */

			if ( count( $events ) === $nDisplayed ) {
				echo '</ul>' . PHP_EOL;
			}
		}
	}

	if ( 0 === $nDisplayed ) {
		printf( '<div id="noevents"><p>There are no events in <strong>%s</strong> during the specified time period.</p></div>', esc_html( $topic_detail['name'] ) );
	}
} // end if $calenderID
// end of calendar templating.
