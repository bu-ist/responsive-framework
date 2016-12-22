<?php
/*
Template Name: Calendar
*/

$calendarID = array_key_exists( 'cid', $_GET ) ? intval( $_GET['cid'] ) : get_option( 'bu_calendar_id' );

$calendarURI = get_permalink( $post );

$topics = null;
$topicDetail = null;
$event = null;

/* input */
$yyyymmdd = array_key_exists( 'date', $_GET ) ? $_GET['date'] : null;

$topic = null;
if ( array_key_exists( 'topic', $_GET ) ) {
	$topic = intval( $_GET['topic'] );
}
$topic = apply_filters( 'bu_flexi_calendar_topic', $topic );

$eventID = array_key_exists( 'eid', $_GET ) ? intval( $_GET['eid'] ) : null;

$topics = $buCalendar->getTopics( $calendarID );
$topicDetail = ( $topic ) ? $buCalendar->pullTopicDetail( $topic, $topics ) : array( 'name' => 'All Topics' );

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

/* check that date falls between:
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

?>
<?php get_header(); ?>

<?php responsive_content_banner( 'pageWidth' ); ?>

<article role="main" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php responsive_content_banner( 'contentWidth' ); ?>

		<?php if ( is_null( $eventID ) ) { ?>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php the_title( '<h1>', '</h1>' ); ?>
				<?php the_content( '<p class="serif">Read the rest of this page &raquo;</p>' ); ?>

				<?php wp_link_pages( array( 'before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number' ) ); ?>
		<?php endwhile; endif; ?>

		<?php if ( ! $calendarID ) { ?>
			<p>This site does not have any calendar associated with it.</p>
		<?php } else {
		if ( array_key_exists( 'date', $_GET ) ) {
			$timestamp = strtotime( $_GET['date'], 0 );
		}

		$start_date = strtotime( '00:00', $timestamp );
		$start_date = date( 'Y-m-d', $start_date );

		$months_to_show = 2;  //additional months to show

		$days = ( intval( date( 't', $timestamp ) ) - intval( date( 'j', $timestamp ) ) );  //days left in current month

		$cur_mo = intval( date( 'n', $timestamp ) );
		for ( $mo = 1; $mo <= $months_to_show; $mo++ ) {
			$days = $days + intval( date( 't', mktime( 0, 0, 0, date( 'n', $timestamp ) + $mo, 1 ) ) );  //let the month overflow for month&year
		}

		$params = array( 'maxevents' => 25 );
		$events = $buCalendar->getEvents( $calendarID, $start_date, $days, $topic, $params );

		$last_event = $events[ ( count( $events ) - 1 ) ]['starts'];  //timestamp for the last event retrieved

		$range_end = strtotime( '+' . $days . ' day', $timestamp );

		if ( count( $events ) < 25 ) {
			$query_end = $range_end;
		} else {
			$query_end = $last_event;
		}

		/* Content: Calendar Topic */
		if ( is_array( $topicDetail ) ) { ?>
				<h2 class="calendar-topic">
					<?php echo $topicDetail['name']; ?><span class="calendar-range">
						(<?php echo date( 'F j', $timestamp ); ?> through <?php echo date( 'F j', $query_end ); ?>)
					</span>
				</h2>
			<?php } ?>
				<div class="event-list">
					<div id="events">
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
					printf( '<h3 class="event-date">%s</h3>', $_day );
					echo PHP_EOL . '<ul>' . PHP_EOL;
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
				printf( '<li><span class="event-time">%s</span> ', $event_time );

				printf( '<span class="event-link"><a href="%s">%s</a></span></li>',  $event_url, $e['summary'] );
				echo PHP_EOL;

				$nDisplayed++;
				/* not sure how to close a day with multiple events...  */

				if ( count( $events ) == $nDisplayed ) {
					echo '</ul>' . PHP_EOL;
				}
			}
		}

		if ( 0 === $nDisplayed ) {
			printf( '<div id="noevents"><p>There are no events in <strong>%s</strong> during the specified time period.</p></div>', $topicDetail['name'] );
		}
?>
					</div>
				</div>
			<?php } ?>
		<?php } else { ?>
			<div class="single-event">
				<div class="event-summary">

					<h1><?php echo $event['summary'];?></h1>
					<div class="date-summary">
						<ul>
							<?php if ( $event['start_time'] != '' ) { ?>
							<li><span class="label">Starts: </span><?php printf( '<span class="time">%s</span><em> on </em><span class="date">%s</span>', date( 'g:i a', $event['starts'] ), date( 'l, F j, Y', $event['starts'] ) ); ?></li>
							<?php if ( $event['ends'] > 0 ) { ?>
								<li><span class="label">Ends: </span><?php printf( '<span class="time">%s</span><em> on </em><span class="date">%s</span>', date( 'g:i a', $event['ends'] ), date( 'l, F j, Y', $event['ends'] ) ); ?></dd>
								<?php }
								} else {
									printf( '<li class="allday"><span class="label">All Day</span><em> on </em><span class="date">%s</span></li>', date( 'l, F j, Y', $event['starts'] - intval( date( 'Z' ) ) ) );
								}
							?>
						</ul>
					</div> <!-- /.date-summary -->
					<div class="description"><?php echo html_entity_decode( $event['description'] ); ?></div>
				</div> <!-- /.eventSummary -->

				<div class="additional-details">
					<dl class="tabular">
						<?php if ( $event['speakers'] ) { ?>
							<dt class="label">Speakers:</dt>
							<dd><?php echo $event['speakers']; ?></dd>
						<?php } ?>
						<?php if ( $event['audience'] ) { ?>
							<dt class="label">Audience:</dt>
							<dd><?php echo $event['audience']; ?></dd>
						<?php } ?>
						<?php if ( $event['departments'] ) { ?>
							<dt class="label">Departments:</dt>
							<dd><?php echo $event['departments']; ?></dd>
						<?php } ?>
						<?php if ( $event['location'] ) { ?>
							<dt class="label">Location:</dt>
							<dd><?php echo $event['location']; ?></dd>
						<?php } ?>
						<?php if ( $event['locationBuilding'] ) { ?>
							<dt class="label">Address:</dt>
							<dd><?php echo $event['locationBuilding']; ?></dd>
						<?php } ?>
						<?php if ( $event['locationRoom'] ) { ?>
							<dt class="label">Room:</dt>
							<dd><?php echo $event['locationRoom']; ?></dd>
						<?php } ?>
						<?php if ( $event['fees'] ) { ?>
							<dt class="label">Fees:</dt>
							<dd><?php echo $event['fees']; ?></dd>
						<?php } ?>
						<?php if ( $event['fee'] ) { ?>
							<dt class="label">Fees:</dt>
							<dd><?php echo $event['fee']; ?></dd>
						<?php } ?>
						<?php if ( $event['feeGeneral'] ) { ?>
							<dt class="label">Fee (General):</dt>
							<dd><?php echo $event['feeGeneral']; ?></dd>
						<?php } ?>
						<?php if ( $event['feePublic'] ) { ?>
							<dt class="label">Fee (Public):</dt>
							<dd><?php echo $event['feePublic']; ?></dd>
						<?php } ?>
						<?php if ( $event['feeStaff'] ) { ?>
							<dt class="label">Fee (Staff):</dt>
							<dd><?php echo $event['feeStaff']; ?></dd>
						<?php } ?>
						<?php if ( $event['feeStudent'] ) { ?>
							<dt class="label">Fee (Students):</dt>
							<dd><?php echo $event['feeStudent']; ?></dd>
						<?php } ?>
						<?php if ( $event['feeBUStudent'] ) { ?>
							<dt class="label">Fee (BU Students):</dt>
							<dd><?php echo $event['feeBUStudent']; ?></dd>
						<?php } ?>
						<?php if ( $event['feeSenior'] ) { ?>
							<dt class="label">Fee (Seniors):</dt>
							<dd><?php echo $event['feeSenior']; ?></dd>
						<?php } ?>
						<?php if ( $event['deadline'] ) { ?>
							<dt class="label">Deadline:</dt>
							<dd><?php echo $event['deadline']; ?></dd>
						<?php } ?>
						<?php if ( $event['url'] ) {
							$urlText = $event['url'];
							if ( $event['urlText'] ) {
								$urlText = $event['urlText'];
							}
						?>
							<dt class="label">Registration:</dt>
							<dd><?php printf( '<a href="%s">%s</a>', $event['url'], $urlText ); ?></dd>
						<?php } ?>
						<?php if ( $event['contactOrganization'] ) { ?>
							<dt class="label">Contact Organization:</dt>
							<dd><?php echo $event['contactOrganization']; ?></dd>
						<?php } ?>
						<?php if ( $event['contact_name'] ) { ?>
							<dt class="label">Contact Name:</dt>
							<dd><?php echo $event['contact_name']; ?></dd>
						<?php } ?>
						<?php if ( $event['contact_email'] ) { ?>
							<dt class="label">Contact Email:</dt>
							<dd><?php printf( '<a href="mailto:%s">%s</a>', $event['contact_email'], $event['contact_email'] ); ?></dd>
						<?php } ?>
						<?php if ( $event['phone'] ) { ?>
							<dt class="label">Contact Phone:</dt>
							<dd><?php echo $event['phone']; ?></dd>
						<?php } ?>

					</dl>
				</div> <!-- /.additional-details -->

				<p><a href="<?php the_permalink(); ?>" class="archive-link calendar-archive-link">Back to Calendar</a></p>

			</div><!-- /.single-event -->
		<?php } ?>
</article>

<?php if ( is_null( $eventID ) ) {
	get_sidebar( 'calendar' );
} ?>

<?php get_footer();