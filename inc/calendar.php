<?php
/**
 * BU Calendar plugin support functions & templates.
 *
 * @package Responsive_Framework\bu-calendar
 */

/**
 * Display the calendar widget markup.
 *
 * @global $buCalendar Calendar plugin instance.
 *
 * @param array $args {
 *     Optional. Arguments to configure link markup.
 *
 *     @type string $calendar_id      BU Calendar ID. Default is the current site's BU Calendar ID defined in settings.
 *     @type bool   $show_topics      Whether to show a list of linked topics. Default is true.
 *     @type string $calendar_uri     URL of the calendar. Default is current post's URL.
 *     @type string $page_template    Page template to use for displaying the calendar. Default is "page-templates/calendar.php".
 *     @type string $topic_heading    Heading text to use for topics. Default "Topics".
 *     @type bool   $monthly_dropdown
 * }
 */
function responsive_calendar_sidebar( $args = array() ) {
	global $post, $buCalendar, $topics, $timestamp, $yyyymmdd;

	$defaults = array(
		'calendar_id'   => array_key_exists( 'cid', $_GET ) ? intval( $_GET['cid'] ) : get_option( 'bu_calendar_id' ),
		'show_topics'   => true,
		'calendar_uri'  => get_permalink( $post ),
		'page_template' => 'page-templates/calendar.php',
		'topic_heading' => 'Topics',
		'monthly_dropdown' => false,
	);

	$args = wp_parse_args( $args, $defaults );

	$args = apply_filters( 'responsive_calendar_sidebar', $args );

	$all_topics_url = add_query_arg( 'date', date( 'Ymd', $timestamp ), $args['calendar_uri'] );

	if ( ! empty( $_GET['cid'] ) ) {
		$all_topics_url = add_query_arg( 'cid', intval( $_GET['cid'] ), $all_topics_url );
	}

	if ( is_page_template( $args['page_template'] ) && ! empty( $args['calendar_uri'] ) ) { ?>

		<div class="widget widget-calendar-picker">
			<h2 class="widget-title">Event Calendar</h2>
			<?php echo $buCalendar->buildMonthCalendar( $yyyymmdd, null, $args['monthly_dropdown'] ); ?>
		</div>

		<?php if ( $args['show_topics'] ) : ?>
			<div id="calendar-topics" class="widget widget-calendar-topics">
				<h2 class="widget-title">Event <?php echo esc_html( $args['topic_heading'] ); ?></h2>
				<a class="content-nav-header" href="<?php echo esc_url( $all_topics_url ); ?>">All <?php echo esc_html( $args['topic_heading'] ); ?></a>
				<?php echo $buCalendar->buildTopicTree( $topics ); ?>
			</div>
		<?php endif; ?>
		<?php
	}
}

/**
 * Register custom calendar widget formats.
 *
 * @param array $formats List of calendar widget formats.
 *
 * @return array $formats Filtered array of formats.
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
 * Calendar widget format display callbacks.
 *
 * @param  array  $events      Event list.
 * @param  string $base_url    Calendar URL.
 * @param  int    $calendar_id Calendar ID.
 *
 * @return string              Calendar widget markup.
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

/**
 * Ensure that sidebar mini-calendar view adds a 'busy' class to days with events.
 *
 * The mini-calendar is built in the BU Calendar plugin using the NIS_HTML_Calendar class.
 * The calendar plugin adds this function as a callback for `NIS_HTML_Calendar::onDate`,
 * but it requires themes to define the function.
 *
 * This was done to allow themes to add custom markup inside the day <td> element.
 * We don't add any markup (hence the empty space below), but if we return no content
 * it won't add the `busy` class to the <td>.
 *
 * Yes, this is insane, and should be fixed when there's time.
 *
 * @todo  Move to calendar plugin.
 *
 * @param int $ts Timestamp.
 *
 * @return null|string $contents Null if no events exist for the day, a space if there are.
 */
function onYearDay( $ts ) {
	global $buCalendar, $events;

	$day = date( 'Y-m-d', $ts );
	$contents = null;

	if ( $buCalendar->hasEventsOnDay( $day, $events ) ) {
		$contents = ' ';
	}

	return $contents;
}

/**
 * Appends calendar template body classes.
 *
 * @todo  Move to calendar plugin.
 *
 * @param array $classes A list of body classes.
 *
 * @return array Filtered list of body classes.
 */
function responsive_calendar_body_classes( $classes ) {
	$calendar_templates = apply_filters( 'responsive_calendar_templates', array(
		'page-templates/calendar.php',
	) );
	$is_calendar_template = array_filter( $calendar_templates, 'is_page_template' );

	// The current request is for one of our calendar templates.
	if ( $is_calendar_template ) {
		if ( isset( $_GET['eid'] ) ) {
			$classes[] = 'single-calendar';
		} else {
			$classes[] = 'archive-calendar';
		}
		if ( isset( $_GET['topic'] ) ) {
			$classes[] = 'calendar-topic';
		}
	}

	return $classes;
}

add_filter( 'body_class', 'responsive_calendar_body_classes' );
