<?php
/**
 * BU Calendar plugin support functions & templates.
 */

/**
 * Display the calendar widget markup.
 *
 * @global  $buCalendar Calendar plugin instance.
 *
 * @param  array  $args [description]
 * @return [type]       [description]
 */
function responsive_calendar_sidebar( $args = array() ) {
	global $post, $buCalendar, $topics, $timestamp, $yyyymmdd;

	$defaults = array(
		'calendar_id'   => array_key_exists( 'cid', $_GET ) ? intval( $_GET['cid'] ) : get_option( 'bu_calendar_id' ),
		'show_topics'   => true,
		'calendar_uri'  => get_permalink( $post ),
		'page_template' => 'page-templates/calendar.php',
	);

	$args = wp_parse_args( $args, $defaults );

	$args = apply_filters( 'responsive_calendar_sidebar', $args );

	$all_topics_url = add_query_arg( 'date', date( 'Ymd', $timestamp ), $args['calendar_uri'] );

	if ( ! empty( $_GET['cid'] ) ) {
		$all_topics_url = add_query_arg( 'cid', intval( $_GET['cid'] ), $all_topics_url );
	}

	if ( is_page_template( $args['page_template'] ) && ! empty( $args['calendar_uri'] ) ) { ?>

		<div class="widget">
			<h2 class="widgettitle">Event Calendar</h2>
			<?php echo $buCalendar->buildMonthCalendar( $yyyymmdd ); ?>
		</div>
		<?php if ( $args['show_topics'] ): ?>
		<div id="calendar-topics" class="widget">
			<h4>Event Topics</h4>
			<p><a class="content_nav_header" href="<?php echo $all_topics_url; ?>">All Topics</a></p>
		<?php  echo $buCalendar->buildTopicTree( $topics ); ?>
		</div>
		<?php endif; ?>
		<?php
	}
}

/**
 * Register custom calendar widget formats
 */
function responsive_calendar_widget_formats( $formats ) {

	unset( $formats['plain'] );
	unset( $formats['big'] );

	$formats['full-date'] = array(
		'label'    => 'Full Date',
		'callback' => 'responsive_calendar_format_callback',
	);

	$formats['graphic'] = array(
		'label'    => 'Graphic',
		'callback' => 'bu_calendar_widget_format_big',
	);

	return $formats;
}

/**
 * Calendar widget format display callbacks
 *
 * @param  array  $events      Event list
 * @param  string $base_url    Calendar URL
 * @param  int    $calendar_id Calendar ID
 * @return string              Calendar widget markup
 */
function responsive_calendar_format_callback( $events, $base_url, $calendar_id = null ) {
	$output = '';

	if ( ( is_array( $events ) ) && ( count( $events ) > 0 ) ) {

		foreach ( $events as $e ) {
			$url = sprintf( '%s?eid=%s', $base_url, urlencode( $e['id'] ) );
			if ( ! empty( $e['oid'] ) ) {
				$url .= '&oid=' . urlencode( $e['oid'] );
			}
			if ( ! empty( $calendar_id ) ) {
				$url .= '&cid=' . urlencode( $calendar_id );
			}
			if ( isset( $e['subscription_name'] ) ) {
				$url .= '&sub=' . urlencode( $e['subscription_name'] );
			}

			$output .= sprintf( '<li><span class="date">%s</span> <a href="%s"><span class="title">%s</span></a></li>', date( 'l, F j', $e['starts'] ), esc_url( $url ), $e['summary'] );
			$output .= "\n";
		}
	}

	return $output;
}

add_filter( 'bu_calendar_widget_formats', 'responsive_calendar_widget_formats', 12, 1 );
