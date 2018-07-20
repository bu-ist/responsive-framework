<?php
/**
 * Template Name: Calendar
 *
 * @package Responsive_Framework
 */

$calendarID = array_key_exists( 'cid', $_GET ) ? intval( $_GET['cid'] ) : get_option( 'bu_calendar_id' );

$calendarURI = get_permalink( $post );

$topics = null;
$topic_detail = null;
$event = null;

// input.
$yyyymmdd = array_key_exists( 'date', $_GET ) ? $_GET['date'] : null;

$topic = null;
if ( array_key_exists( 'topic', $_GET ) ) {
	$topic = intval( $_GET['topic'] );
}

/**
 * Filters the current topic ID before retrieving events from BU Calendar.
 *
 * @since 0.9.0
 * @since 2.0.0 Renamed from bu_flexi_calendar_topic to responsive_calendar_topic.
 *
 * @param int $topic Topic ID.
 */
$topic = apply_filters( 'responsive_calendar_topic', $topic );

$eventID = array_key_exists( 'eid', $_GET ) ? intval( $_GET['eid'] ) : null;

$topics = $buCalendar->getTopics( $calendarID );
$topic_detail = ( $topic ) ? $buCalendar->pullTopicDetail( $topic, $topics ) : array( 'name' => 'All Topics' );

if ( ! is_null( $eventID ) ) {
	$oid = array_key_exists( 'oid', $_GET ) ? intval( $_GET['oid'] ) : 0;
	$event = $buCalendar->getEvent( $calendarID, $eventID, $oid );
	$yyyymmdd = date( 'Ymd', $event['starts'] );
}

$timestamp = time();
$now = $timestamp;

if ( $yyyymmdd ) {
	$timestamp = strtotime( $yyyymmdd, 0 );
}

$timestamp = strtotime( '00:00', $timestamp );

/*
 * Check that date falls between:
 * The year 2000 (http://www.nbc.com/nbc/Late_Night_with_Conan_OBrien/intheyear2000/)
 * Ten years in the future from the current date
 */

$boundary_past = strtotime( '2000-01-01 00:00:00', 0 );
$boundary_future = strtotime( '+10 years', $now );

if ( $timestamp < $boundary_past ) {
	$timestamp = $boundary_past;
	$yyyymmdd = date( 'Ymd', $timestamp );
}

if ( $timestamp > $boundary_future ) {
	$timestamp = $boundary_future;
	$yyyymmdd = date( 'Ymd', $timestamp );
}

get_header();

$extra_classes = array( 'content-area' );

if ( is_null( $eventID ) ) {
	$extra_classes[] = 'calendar-list';
} else {
	$extra_classes[] = 'calendar-single';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $extra_classes ); ?>>

		<?php if ( is_null( $eventID ) ) { ?>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php responsive_the_title( '<h1 ' . r_page_title_class() . '>', '</h1>' ); ?>
				<?php the_content( '<p class="serif">Read the rest of this page &raquo;</p>' ); ?>

				<?php wp_link_pages( array( 'before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number' ) ); ?>
		<?php endwhile;
endif; ?>

		<?php if ( ! $calendarID ) { ?>
			<p>This site does not have any calendar associated with it.</p>
		<?php } else {
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
		$events = $buCalendar->getEvents( $calendarID, $start_date, $days, $topic, $params );

		$last_event = $events[ ( count( $events ) - 1 ) ]['starts']; // timestamp for the last event retrieved.

		$range_end = strtotime( '+' . $days . ' day', $timestamp );

	if ( count( $events ) < 25 ) {
		$query_end = $range_end;
	} else {
		$query_end = $last_event;
	}

		/* Content: Calendar Topic */
	if ( is_array( $topic_detail ) ) { ?>
				<h2 class="calendar-list-topic">
					<?php echo esc_html( $topic_detail['name'] ); ?><span class="calendar-list-range">
						(<?php echo esc_html( date( 'F j', $timestamp ) ); ?> through <?php echo esc_html( date( 'F j', $query_end ) ); ?>)
					</span>
				</h2>
			<?php } ?>
						<?php
						$day = null;
						$time = null;
						$allday = false;
						$nDisplayed = 0;

						if ( ( is_array( $events ) ) && ( count( $events ) > 0 ) ) {
							foreach ( $events as $e ) {

								$_day = date( 'l, F j', $e['starts'] );
								$_time = date( 'g:i A', $e['starts'] );
								$_allday = $e['allday'];
								$event_time = '';
								if ( $_day != $day ) {
									if ( 0 != $nDisplayed ) {
										echo '</ul>' . PHP_EOL;
									}
									printf( '<h3 class="calendar-list-event-date">%s</h3>', esc_html( $_day ) );
									echo PHP_EOL . '<ul class="calendar-list-events">' . PHP_EOL;
									$day = $_day;
									$time = null;
								}

								if ( $_allday ) {
									if ( $_allday != $allday ) {
										$event_time = 'All Day';
									}
								} else {
									if ( $_time != $time ) {
										$event_time = $_time;
										$time = $_time;
									}
								}

								$event_url = $calendarURI;
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

								printf( '<a class="calendar-list-event-link" href="%s">%s</a></li>',  esc_url( $event_url ), wp_kses_post( $e['summary'] ) );
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
?>
			<?php } ?>
		<?php } else { ?>
			<div class="single-event">
				<div class="single-event-summary">

					<h1><?php echo wp_kses_post( $event['summary'] ); ?></h1>
					<div class="single-event-schedule">
						<ul class="single-event-schedule-list">
							<?php if ( ! empty( $event['start_time'] ) ) { ?>
								<li class="single-event-schedule-start">
									<span class="single-event-label">Starts: </span><?php printf( '<span class="single-event-time">%s</span><em class="event-time-make-sentence"> on </em><span class="single-event-date">%s</span>', esc_html( date( 'g:i a', $event['starts'] ) ), esc_html( date( 'l, F j, Y', $event['starts'] ) ) ); ?>
								</li>
								<?php if ( $event['ends'] > 0 ) { ?>
									<li class="single-event-schedule-end"><span class="single-event-label">Ends: </span><?php printf( '<span class="single-event-time">%s</span><em class="event-time-make-sentence"> on </em><span class="single-event-date">%s</span>', esc_html( date( 'g:i a', $event['ends'] ) ), esc_html( date( 'l, F j, Y', $event['ends'] ) ) ); ?></dd>
								<?php }
} else {
	printf( '<li class="single-event-schedule-allday"><span class="single-event-label">All Day</span><em> on </em><span class="single-event-date">%s</span></li>', esc_html( date( 'l, F j, Y', $event['starts'] - intval( date( 'Z' ) ) ) ) );
}
							?>
						</ul>
					</div> <!-- /.dateSummary -->
					<div class="single-event-description"><?php echo wp_kses_post( html_entity_decode( $event['description'] ) ); ?></div>
				</div> <!-- /.eventSummary -->

				<div class="single-event-additional-details">
					<dl class="tabular">
						<?php if ( $event['speakers'] ) { ?>
							<dt class="single-event-speakers-label">Speakers:</dt>
							<dd class="single-event-speakers-info"><?php echo wp_kses_post( $event['speakers'] ); ?></dd>
						<?php } ?>
						<?php if ( $event['audience'] ) { ?>
							<dt class="single-event-audience-label">Audience:</dt>
							<dd class="single-event-audience-info"><?php echo wp_kses_post( $event['audience'] ); ?></dd>
						<?php } ?>
						<?php if ( $event['departments'] ) { ?>
							<dt class="single-event-departments-label">Departments:</dt>
							<dd class="single-event-departments-info"><?php echo wp_kses_post( $event['departments'] ); ?></dd>
						<?php } ?>
						<?php if ( $event['location'] ) { ?>
							<dt class="single-event-location-label">Location:</dt>
							<dd class="single-event-location-info"><?php echo wp_kses_post( $event['location'] ); ?></dd>
						<?php } ?>
						<?php if ( $event['locationBuilding'] ) { ?>
							<dt class="single-event-location-building-label">Address:</dt>
							<dd class="single-event-location-building-info"><?php echo wp_kses_post( $event['locationBuilding'] ); ?></dd>
						<?php } ?>
						<?php if ( $event['locationRoom'] ) { ?>
							<dt class="single-event-location-room-label">Room:</dt>
							<dd class="single-event-location-room-info"><?php echo wp_kses_post( $event['locationRoom'] ); ?></dd>
						<?php } ?>
						<?php if ( $event['fees'] ) { ?>
							<dt class="single-event-fees-label">Fees:</dt>
							<dd class="single-event-fees-info"><?php echo wp_kses_post( $event['fees'] ); ?></dd>
						<?php } ?>
						<?php if ( $event['fee'] ) { ?>
							<dt class="single-event-fee-label">Fees:</dt>
							<dd class="single-event-fee-info"><?php echo wp_kses_post( $event['fee'] ); ?></dd>
						<?php } ?>
						<?php if ( $event['feeGeneral'] ) { ?>
							<dt class="single-event-fee-general-label">Fee (General):</dt>
							<dd class="single-event-fee-general-info"><?php echo wp_kses_post( $event['feeGeneral'] ); ?></dd>
						<?php } ?>
						<?php if ( $event['feePublic'] ) { ?>
							<dt class="single-event-fee-public-label">Fee (Public):</dt>
							<dd class="single-event-fee-public-info"><?php echo wp_kses_post( $event['feePublic'] ); ?></dd>
						<?php } ?>
						<?php if ( $event['feeStaff'] ) { ?>
							<dt class="single-event-fee-staff-label">Fee (Staff):</dt>
							<dd class="single-event-fee-staff-info"><?php echo wp_kses_post( $event['feeStaff'] ); ?></dd>
						<?php } ?>
						<?php if ( $event['feeStudent'] ) { ?>
							<dt class="single-event-fee-student-label">Fee (Students):</dt>
							<dd class="single-event-fee-student-info"><?php echo wp_kses_post( $event['feeStudent'] ); ?></dd>
						<?php } ?>
						<?php if ( $event['feeBUStudent'] ) { ?>
							<dt class="single-event-fee-bu-student-label">Fee (BU Students):</dt>
							<dd class="single-event-fee-bu-student-info"><?php echo wp_kses_post( $event['feeBUStudent'] ); ?></dd>
						<?php } ?>
						<?php if ( $event['feeSenior'] ) { ?>
							<dt class="single-event-fee-senior-label">Fee (Seniors):</dt>
							<dd class="single-event-fee-senior-info"><?php echo wp_kses_post( $event['feeSenior'] ); ?></dd>
						<?php } ?>
						<?php if ( $event['deadline'] ) { ?>
							<dt class="single-event-deadline-label">Deadline:</dt>
							<dd class="single-event-deadline-info"><?php echo wp_kses_post( $event['deadline'] ); ?></dd>
						<?php } ?>
						<?php if ( $event['url'] ) {
							$url_text = $event['url'];
							if ( $event['urlText'] ) {
								$url_text = $event['urlText'];
							}
						?>
							<dt class="single-event-registration-label">Registration:</dt>
							<dd class="single-event-registration-info"><?php printf( '<a href="%s" class="single-event-registration-link">%s</a>', esc_url( $event['url'] ), esc_html( $url_text ) ); ?></dd>
						<?php } ?>
						<?php if ( $event['contactOrganization'] ) { ?>
							<dt class="single-event-contact-org-label">Contact Organization:</dt>
							<dd class="single-event-contact-org-info"><?php echo wp_kses_post( $event['contactOrganization'] ); ?></dd>
						<?php } ?>
						<?php if ( $event['contact_name'] ) { ?>
							<dt class="single-event-contact-name-label">Contact Name:</dt>
							<dd class="single-event-contact-name-info"><?php echo wp_kses_post( $event['contact_name'] ); ?></dd>
						<?php } ?>
						<?php if ( $event['contact_email'] ) { ?>
							<dt class="single-event-contact-email-label">Contact Email:</dt>
							<dd class="single-event-contact-email-info"><?php printf( '<a href="mailto:%s" class="single-event-contact-email-link">%s</a>', esc_url( $event['contact_email'] ), esc_html( $event['contact_email'] ) ); ?></dd>
						<?php } ?>
						<?php if ( $event['phone'] ) { ?>
							<dt class="single-event-contact-phone-label">Contact Phone:</dt>
							<dd class="single-event-contact-phone-info"><?php echo wp_kses_post( $event['phone'] ); ?></dd>
						<?php } ?>

					</dl>
				</div> <!-- /.additionalDetails -->

				<p class="archive-link-container"><a href="<?php the_permalink(); ?>" class="archive-link calendar-archive-link">Back to Calendar</a></p>

			</div><!-- /.single-event -->
		<?php } ?>
</article>

<?php if ( is_null( $eventID ) ) {
	get_sidebar( 'calendar' );
} ?>

<?php get_footer();
