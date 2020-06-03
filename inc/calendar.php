<?php
/**
 * BU Calendar plugin support functions & templates.
 *
 * @package Responsive_Framework\bu-calendar
 */

/**
 * Retrieves an event from the BU Calendar App.
 *
 * All parameters are optional. This function may be called without parameters
 * in order to retrieve a single event on the calendar template when all the
 * URL query parameters are currently present in the request.
 *
 * @since 2.3.3
 *
 * @link https://github.com/bu-ist/bu-calendar-plugin/blob/master/calendar.php#L539-L549
 *
 * @global $buCalendar Calendar plugin instance.
 *
 * @param int $calendar_id The calendar ID to retrieve events from.
 * @param int $event_id    The event ID for the event post.
 * @param int $oid         The event occurrence ID. May have multiple occurrences.
 * @return array $event An array of single-event data.
 */
function responsive_calendar_get_event( $calendar_id = false, $event_id = false, $oid = false ) {
	global $buCalendar;

	// Setup parameters for $buCalendar->getEvent() method.
	$calendar_id = ! empty( $calendar_id ) ? $calendar_id : responsive_calendar_get_calendar_id();
	$event_id    = ! empty( $event_id ) ? $event_id : responsive_calendar_get_event_id();
	$oid         = ! empty( $oid ) ? $oid : responsive_calendar_get_oid();

	// Retrieve the event by these IDs.
	$event = $buCalendar->getEvent( $calendar_id, $event_id, $oid );

	return $event;
}

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
	global $buCalendar;

	$topics    = apply_filters( 'responsive_calendar_sidebar_topics', responsive_calendar_get_topics() );
	$timestamp = responsive_calendar_get_timestamp();
	$yyyymmdd  = responsive_calendar_get_yyyymmdd();

	$defaults = array(
		'calendar_id'      => responsive_calendar_get_calendar_id(),
		'show_topics'      => true,
		'calendar_uri'     => responsive_calendar_get_calendar_url(),
		'page_template'    => 'page-templates/calendar.php',
		'topic_heading'    => __( 'Topics', 'responsive-framework' ),
		'monthly_dropdown' => false,
	);

	$args = wp_parse_args( $args, $defaults );

	/**
	 * Filters the calendar sidebar arguments.
	 *
	 * @since 2.0.0
	 *
	 * @param array $args Calendar sidebar arguments.
	 */
	$args = apply_filters( 'responsive_calendar_sidebar', $args );

	$all_topics_url = add_query_arg( 'date', date( 'Ymd', $timestamp ), $args['calendar_uri'] );

	if ( ! empty( $_GET['cid'] ) ) {
		$all_topics_url = add_query_arg( 'cid', intval( $_GET['cid'] ), $all_topics_url );
	}

	if ( is_page_template( $args['page_template'] ) && ! empty( $args['calendar_uri'] ) ) { ?>

		<div class="widget widget-calendar-picker">
			<h3 class="widget-title"><?php esc_html_e( 'Event Calendar', 'responsive-framework' ); ?></h3>
			<?php echo $buCalendar->buildMonthCalendar( $yyyymmdd, null, $args['monthly_dropdown'] ); ?>
		</div>

		<?php if ( $args['show_topics'] ) : ?>
			<div id="calendar-topics" class="widget widget-calendar-topics">
				<h3 class="widget-title"><?php esc_html_e( 'Event', 'responsive-framework' ); ?> <?php echo esc_html( $args['topic_heading'] ); ?></h3>

				<a class="content-nav-header" href="<?php echo esc_url( $all_topics_url ); ?>">
					<?php
						/* translators: %s: topic name. */
						printf( esc_html__( 'All %s', 'responsive-framework' ), esc_html( $args['topic_heading'] ) );
					?>
				</a>
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

	$formats['default'] = array(
		'label'    => __( 'Default', 'responsive-framework' ),
		'callback' => 'responsive_calendar_format_default',
	);

	$formats['full-date'] = array(
		'label'    => __( 'Full Date', 'responsive-framework' ),
		'callback' => 'responsive_calendar_format_fulldate',
	);

	$formats['graphic'] = array(
		'label'    => __( 'Graphic', 'responsive-framework' ),
		'callback' => 'responsive_calendar_format_graphic',
	);

	return $formats;
}

add_filter( 'bu_calendar_widget_formats', 'responsive_calendar_widget_formats', 12, 1 );

/**
 * Helper function to determine URL for widget format display callbacks.
 *
 * @param int $event       An event.
 * @param int $base_url    Calendar URL.
 * @param int $calendar_id Calendar ID.
 *
 * @return string $url         The URL to the event.
 */
function responsive_calendar_build_url( $event, $base_url, $calendar_id ) {
	$url = sprintf( '%s?eid=%s', $base_url, urlencode( $event['id'] ) );

	if ( ! empty( $event['oid'] ) ) {
		$url .= '&oid=' . urlencode( $event['oid'] );
	}
	if ( ! empty( $calendar_id ) ) {
		$url .= '&cid=' . urlencode( $calendar_id );
	}
	if ( isset( $event['subscription_name'] ) ) {
		$url .= '&sub=' . urlencode( $event['subscription_name'] );
	}

	return $url;
}

/**
 * Calendar widget format display for the default format.
 *
 * @param  array  $events      Event list.
 * @param  string $base_url    Calendar URL.
 * @param  int    $calendar_id Calendar ID.
 *
 * @return string              Calendar widget markup.
 */
function responsive_calendar_format_default( $events, $base_url, $calendar_id = null ) {
	$output = '';

	if ( ( is_array( $events ) ) && ( count( $events ) > 0 ) ) {

		foreach ( $events as $event ) {
			$url = responsive_calendar_build_url( $event, $base_url, $calendar_id );

			$output .= sprintf( '
				<li class="widget-calendar-event widget-calendar-event-default">
					<time class="widget-calendar-date widget-calendar-date-default">%s</time>
					<a href="%s" class="widget-calendar-title widget-calendar-title-default widget-calendar-link widget-calendar-link-default" rel="no-follow">%s</a>
				</li>', date( 'n.j', $event['starts'] ), esc_url( $url ), $event['summary'] );

			$output .= "\n";
		}
	}

	return $output;
}

/**
 * Calendar widget format display for the full date format.
 *
 * @param  array  $events      Event list.
 * @param  string $base_url    Calendar URL.
 * @param  int    $calendar_id Calendar ID.
 *
 * @return string              Calendar widget markup.
 */
function responsive_calendar_format_fulldate( $events, $base_url, $calendar_id = null ) {
	$output = '';

	if ( ( is_array( $events ) ) && ( count( $events ) > 0 ) ) {

		foreach ( $events as $event ) {
			$url = responsive_calendar_build_url( $event, $base_url, $calendar_id );

			$output .= sprintf( '
				<li class="widget-calendar-event widget-calendar-event-fulldate">
					<time class="widget-calendar-date widget-calendar-date-fulldate">%s</time>
					<a href="%s" class="widget-calendar-title widget-calendar-title-fulldate widget-calendar-link widget-calendar-link-fulldate" rel="no-follow">%s</a>
				</li>', date( 'l, F j', $event['starts'] ), esc_url( $url ), $event['summary'] );

			$output .= "\n";
		}
	}

	return $output;
}

/**
 * Calendar widget format display for the graphic format.
 *
 * @param  array  $events      Event list.
 * @param  string $base_url    Calendar URL.
 * @param  int    $calendar_id Calendar ID.
 *
 * @return string              Calendar widget markup.
 */
function responsive_calendar_format_graphic( $events, $base_url, $calendar_id = null ) {
	$output = '';

	if ( ( is_array( $events ) ) && ( count( $events ) > 0 ) ) {

		foreach ( $events as $event ) {
			$url = responsive_calendar_build_url( $event, $base_url, $calendar_id );

			$output .= sprintf( '
				<li class="widget-calendar-event widget-calendar-event-graphic">
					<a href="%s" class="widget-calendar-link widget-calendar-link-graphic" rel="no-follow">
						<time class="widget-calendar-date widget-calendar-date-graphic">
							<span class="widget-calendar-day widget-calendar-day-graphic">%s</span>
							<span class="widget-calendar-month widget-calendar-month-graphic">%s</span>
						</time>
						<span class="widget-calendar-title widget-calendar-title-graphic">%s</span>
					</a>
				</li>', esc_url( $url ), date( 'j', $event['starts'] ), date( 'M', $event['starts'] ), $event['summary'] );

			$output .= "\n";
		}
	}

	return $output;
}

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

	$day      = date( 'Y-m-d', $ts );
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
	/**
	 * Filters calendar page templates.
	 *
	 * @since 1.0.0
	 *
	 * @param array Calendar page templates.
	 */
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

if ( ! function_exists( 'responsive_calendar_get_calendar_id' ) ) {
	/**
	 * Retrieve the calendar ID for the calendar template.
	 *
	 * @return int $calendar_id Set from URL parameter if exists, else a site option.
	 */
	function responsive_calendar_get_calendar_id() {
		$cid = filter_input( INPUT_GET, 'cid', FILTER_VALIDATE_INT );
		if ( empty( $cid ) ) {
			$cid = get_option( 'bu_calendar_id' );
		}

		return apply_filters( 'responsive_calendar_get_calendar_id', $cid );
	}
}

if ( ! function_exists( 'responsive_calendar_get_calendar_url' ) ) {
	/**
	 * Retrieve the calendar url for the calendar template.
	 *
	 * This permalnk is used to do two things:
	 * - Create a URL back to the calendar page.
	 * - Create event URLs by adding query parameters to this permalink.
	 *
	 * NOTE: For now, this just returns the current page permalink.
	 *       In the future, this may need to be refactored to grab a
	 *       site option if you wanted to link to the calendar template
	 *       page id from another page. In the meantime, just use the
	 *       current page permalink until a need to refactor comes up.
	 *
	 * @return int $calendar_id Set from URL parameter if exists, else a site option.
	 */
	function responsive_calendar_get_calendar_url() {
		return get_permalink();
	}
}

if ( ! function_exists( 'responsive_calendar_get_event_id' ) ) {
	/**
	 * Retrieve the event ID for the calendar template.
	 *
	 * @return int|null $event_id.
	 */
	function responsive_calendar_get_event_id() {
		return array_key_exists( 'eid', $_GET ) ? intval( $_GET['eid'] ) : null;
	}
}

if ( ! function_exists( 'responsive_calendar_get_oid' ) ) {
	/**
	 * Retrieve the oid for the calendar template.
	 *
	 * The 'oid' value is the Occurrence ID. A BU Calendar event can be recurring,
	 * so the `oid` tracks which particular occurrence of the event this is.
	 *
	 * @return int|null $oid.
	 */
	function responsive_calendar_get_oid() {
		return array_key_exists( 'oid', $_GET ) ? intval( $_GET['oid'] ) : 0;
	}
}

if ( ! function_exists( 'responsive_calendar_article_classes' ) ) {
	/**
	 * Add classes to the `<article />` element on calendar template.
	 *
	 * @return array $extra_classes
	 */
	function responsive_calendar_article_classes() {

		// Define extra classes to be added to `<article />` element.
		$extra_classes = array( 'content-area' );

		// Get the event ID if exists.
		$event_id = responsive_calendar_get_event_id();

		// If event ID does not exist, add listing class. If it does exist, add single class.
		if ( is_null( $event_id ) ) {
			$extra_classes[] = 'calendar-list';
		} else {
			$extra_classes[] = 'calendar-single';
		}

		return $extra_classes;
	}
}

if ( ! function_exists( 'responsive_calendar_get_timestamp' ) ) {
	/**
	 * Retrieves the timestamp.
	 *
	 * @return time $timestamp.
	 */
	function responsive_calendar_get_timestamp() {

		// Sets initial timestamp to now.
		$timestamp = time();

		// Retrieves parameter for date, if exists.
		$yyyymmdd = responsive_calendar_get_yyyymmdd();

		// Modify timestamp based on date parameter, if exists.
		if ( $yyyymmdd ) {
			$timestamp = strtotime( $yyyymmdd, 0 );
		}

		$timestamp = strtotime( '00:00', $timestamp );

		return $timestamp;
	}
}

if ( ! function_exists( 'responsive_calendar_get_yyyymmdd' ) ) {
	/**
	 * Retrieves the timestamp.
	 *
	 * @global $buCalendar
	 *
	 * @return string|null $timestamp The query parameter of date if exists; null on failure.
	 *                                If event ID exists, the event's start date will be returned.
	 */
	function responsive_calendar_get_yyyymmdd() {
		global $buCalendar;

		// Sets initial value based on if date parameter exists or not.
		$yyyymmdd = array_key_exists( 'date', $_GET ) ? $_GET['date'] : null;

		// Modifies value if an event ID exists and is being queried.
		$event_id = responsive_calendar_get_event_id();
		if ( ! is_null( $event_id ) ) {
			$event    = $buCalendar->getEvent( responsive_calendar_get_calendar_id(), $event_id, responsive_calendar_get_oid() );
			$yyyymmdd = date( 'Ymd', $event['starts'] );
		}

		return $yyyymmdd;
	}
}

if ( ! function_exists( 'responsive_calendar_get_boundary_past' ) ) {
	/**
	 * Retrieve calendar template event boundary past.
	 *
	 * @return time results from strtotime.
	 */
	function responsive_calendar_get_boundary_past() {
		return strtotime( '2000-01-01 00:00:00', 0 );
	}
}

if ( ! function_exists( 'responsive_calendar_get_boundary_future' ) ) {
	/**
	 * Retrieve calendar template event boundary future.
	 *
	 * @return time results from strtotime.
	 */
	function responsive_calendar_get_boundary_future() {
		return strtotime( '+10 years', time() );
	}
}

if ( ! function_exists( 'responsive_calendar_get_topic_detail' ) ) {
	/**
	 * Retrieve the topic detail.
	 *
	 * @global $buCalendar
	 *
	 * @return array
	 */
	function responsive_calendar_get_topic_detail() {
		global $buCalendar;

		$topic  = responsive_calendar_get_topic();
		$topics = responsive_calendar_get_topics();
		return ( $topic ) ? $buCalendar->pullTopicDetail( $topic, $topics ) : array( 'name' => 'All Topics' );
	}
}


if ( ! function_exists( 'responsive_calendar_get_topics' ) ) {
	/**
	 * Retrieve calendar template topics.
	 *
	 * @global $buCalendar
	 *
	 * @return array
	 */
	function responsive_calendar_get_topics() {
		global $buCalendar;

		return $buCalendar->getTopics( responsive_calendar_get_calendar_id() );
	}
}

if ( ! function_exists( 'responsive_calendar_get_topic' ) ) {
	/**
	 * Retrieve calendar template topic query parameter from URL.
	 *
	 * NOTE: This may be filtered by developers after retrieving the $_GET parameter.
	 *
	 * @return int|null Topic ID if exists in query parameter in URL. Null on false.
	 */
	function responsive_calendar_get_topic() {
		$topic = array_key_exists( 'topic', $_GET ) ? intval( $_GET['topic'] ) : null;

		/**
		 * Filters the current topic ID before retrieving events from BU Calendar.
		 *
		 * @since 0.9.0
		 * @since 2.0.0 Renamed from bu_flexi_calendar_topic to responsive_calendar_topic.
		 *
		 * @param int $topic Topic ID.
		 */
		return apply_filters( 'responsive_calendar_topic', $topic );
	}
}

/**
 * Get generic single event labels.
 *
 * Returns an array of labels used for templating the single-event view.
 * Note: These labels are not the field labels; instead they are intended for
 * other parts of the UI such as the "Back to Calendar" link and "Starts" and
 * "Ends" text. See `responsive_calendar_event_field_labels` for all event field
 * backend names and their correspondinng labels.
 *
 * @since 2.1.5
 *
 * @return array $labels Labels for templating a single-event.
 */
function responsive_calendar_event_labels() {
	$labels = array(
		'back_to_calendar' => __( 'Back to Calendar', 'responsive-framework' ),
		'ends'             => __( 'Ends', 'responsive-framework' ) . ':',
		'starts'           => __( 'Starts', 'responsive-framework' ) . ':',
	);

	/**
	 * Allow labels to be modified.
	 *
	 * @since 2.1.5
	 * @param array $labels Labels for templating a single-event.
	 */
	return apply_filters( 'responsive_calendar_event_labels', $labels );
}

/**
 * Returns an array of labels for each standard field.
 *
 * Notes:
 * - Fields are organized into 'name' => 'label' pairs, where the 'name' equals
 *   the backend name for the BU Calendar Plugin field, and 'label' equals the
 *   human-readable label that is visible on the front-end.
 * - The order of these fields matters; it determines the order of outputted
 *   fields to the front-end.
 *
 * @since 2.3.3
 *
 * @return array $labels An associated array of field names and their front-end labels.
 */
function responsive_calendar_event_field_labels() {

	// Defines all the labels for standard fields. Field name => Field label.
	$labels = array(
		'speakers'            => __( 'Speakers', 'responsive-framework' ) . ':',
		'audience'            => __( 'Audience', 'responsive-framework' ) . ':',
		'departments'         => __( 'Departments', 'responsive-framework' ) . ':',
		'location'            => __( 'Location', 'responsive-framework' ) . ':',
		'locationBuilding'    => __( 'Address', 'responsive-framework' ) . ':',
		'locationRoom'        => __( 'Room', 'responsive-framework' ) . ':',
		'fees'                => __( 'Fees', 'responsive-framework' ) . ':',
		'fee'                 => __( 'Fees', 'responsive-framework' ) . ':',
		'feeGeneral'          => __( 'Fee (General)', 'responsive-framework' ) . ':',
		'feePublic'           => __( 'Fee (Public)', 'responsive-framework' ) . ':',
		'feeStaff'            => __( 'Fee (Staff)', 'responsive-framework' ) . ':',
		'feeStudent'          => __( 'Fee (Students)', 'responsive-framework' ) . ':',
		'feeBUStudent'        => __( 'Fee (BU Students)', 'responsive-framework' ) . ':',
		'feeSenior'           => __( 'Fee (Seniors)', 'responsive-framework' ) . ':',
		'deadline'            => __( 'Deadline', 'responsive-framework' ) . ':',
		'url'                 => __( 'Registration', 'responsive-framework' ) . ':',
		'contactOrganization' => __( 'Contact Organization', 'responsive-framework' ) . ':',
		'contact_name'        => __( 'Contact Name', 'responsive-framework' ) . ':',
		'contact_email'       => __( 'Contact Email', 'responsive-framework' ) . ':',
		'phone'               => __( 'Contact Phone', 'responsive-framework' ) . ':',
	);

	/**
	 * Allows standard field labels to be modified.
	 *
	 * Useful for changing field labels, removing standard fields, or changing
	 * the order.
	 *
	 * @since 2.3.3
	 * @param array $labels An associated array of field names and their front-end labels.
	 */
	return apply_filters( 'responsive_calendar_event_field_labels', $labels );
}

/**
 * Return all event fields for a given calendar (standard + custom).
 *
 * Useful for templating out the event fields.
 *
 * @since 2.3.3
 *
 * @param int $calendar_id The calendar ID to retrieve events from.
 * @param int $event_id    The event ID for the event post.
 * @param int $oid         The event occurrence ID. May have multiple occurrences.
 */
function responsive_calendar_get_fields( $calendar_id = false, $event_id = false, $oid = false ) {

	// Retrieves the standard fields from BU Calendar Plugin.
	$standard_fields = responsive_calendar_get_fields_standard( $calendar_id, $event_id, $oid );

	// Retrieves any custom fields from BU Calendar Plugin.
	$custom_fields = responsive_calendar_get_fields_custom( $calendar_id, $event_id, $oid );

	// Combines the result of both arrays.
	$all_fields = array_merge( $standard_fields, $custom_fields );

	/**
	 * Modifies the combined result of standard calendar fields and custom
	 * fields.
	 *
	 * @since 2.3.3
	 * @param array $all_fields Combined result of standard and custom fields.
	 */
	return apply_filters( 'responsive_calendar_get_fields', $all_fields );
}

/**
 * Returns standard event fields for a given calendar.
 *
 * @since 2.3.3
 *
 * @param int $calendar_id The calendar ID to retrieve events from.
 * @param int $event_id    The event ID for the event post.
 * @param int $oid         The event occurrence ID. May have multiple occurrences.
 */
function responsive_calendar_get_fields_standard( $calendar_id = false, $event_id = false, $oid = false ) {

	// Retrieves the event.
	$event = responsive_calendar_get_event( $calendar_id, $event_id, $oid );

	// Retrieves all the standard field names and labels.
	$labels = responsive_calendar_event_field_labels();

	// Sets an empty array of fieldnames and their values.
	$standard_fields = array();

	// Loop through event field names to return their values.
	foreach ( $labels as $name => $label ) {
		// Validates the field is set before adding it.
		if ( isset( $event[ $name ] ) ) {
			// Adds an associative array ( name => array( label, value ) ).
			$standard_fields[ $name ] = array(
				'label' => $label,
				'value' => $event[ $name ],
			);
		}
	}

	/**
	 * Modifies the array of standard event fieldnames and their values.
	 *
	 * @since 2.3.3
	 * @param array $standard_fields Array of standard fieldnames and their label/value.
	 */
	return apply_filters( 'responsive_calendar_get_fields_standard', $standard_fields );
}

/**
 * Filters standard event field values.
 *
 * Provides a better user-experience for values that are expected to be links,
 * such as adding link tags for registration url / email address values.
 *
 * @since 2.3.3
 *
 * @param array $standard_fields Array of standard fieldnames and their label/value.
 * @return array $standard_fields Modified array of standard fields.
 */
function responsive_calendar_modify_fields_standard( $standard_fields ) {

	// Changes the url field to link html.
	$standard_fields = responsive_calendar_modify_field_url( $standard_fields );

	// Changes the contact_email email value to mailto link html.
	$standard_fields = responsive_calendar_modify_field_contact_email( $standard_fields );

	return $standard_fields;
}
add_filter( 'responsive_calendar_get_fields_standard', 'responsive_calendar_modify_fields_standard' );

/**
 * Changes event link URL value into link HTML.
 *
 * @since 2.3.3
 *
 * @param array $standard_fields Array of standard fieldnames and their label/value.
 * @return array $standard_fields Modified array of standard fields.
 */
function responsive_calendar_modify_field_url( $standard_fields ) {

	// Bails immediately if there is no url value for this event.
	if ( empty( $standard_fields['url']['value'] ) ) {
		return $standard_fields;
	}

	// Sets the link text by default to be the href.
	$link_text = $standard_fields['url']['value'];

	// Conditionally use provided link text if exists.
	if ( ! empty( $standard_fields['urlText']['value'] ) ) {
		$link_text = $standard_fields['urlText']['value'];
		// Remove urlText from the array of fields.
		unset( $standard_fields['urlText'] );
	}

	// Overwrite url value with link HTML.
	$standard_fields['url']['value'] = sprintf(
		'<a href="%s" class="single-event-registration-link">%s</a>',
		esc_url( $standard_fields['url']['value'] ),
		esc_html( $link_text )
	);

	return $standard_fields;
}

/**
 * Changes event contact email value into mailto link HTML.
 *
 * @since 2.3.3
 *
 * @param array $standard_fields Array of standard fieldnames and their label/value.
 * @return array $standard_fields Modified array of standard fields.
 */
function responsive_calendar_modify_field_contact_email( $standard_fields ) {

	// Bails immediately if there is no contact_email value for this event.
	if ( empty( $standard_fields['contact_email']['value'] ) ) {
		return $standard_fields;
	}

	// Encodes the email address to prevent spam.
	$encoded_email = antispambot( $standard_fields['contact_email']['value'] );

	// Overwrites contact_email value with mailto link html.
	$standard_fields['contact_email']['value'] = sprintf(
		'<a href="mailto:%s" class="single-event-contact-email-link">%s</a>',
		esc_url( $encoded_email ),
		esc_html( $encoded_email )
	);

	return $standard_fields;
}

/**
 * Returns custom event fields for a given calendar.
 *
 * @since 2.3.3
 *
 * @global $buCalendar Calendar plugin instance.
 *
 * @param int $calendar_id The calendar ID to retrieve events from.
 * @param int $event_id    The event ID for the event post.
 * @param int $oid         The event occurrence ID. May have multiple occurrences.
 */
function responsive_calendar_get_fields_custom( $calendar_id = false, $event_id = false, $oid = false ) {
	global $buCalendar;

	// Ensures we have a calendar ID.
	$calendar_id = ! empty( $calendar_id ) ? $calendar_id : responsive_calendar_get_calendar_id();

	// Retrieves the event.
	$event = responsive_calendar_get_event( $calendar_id, $event_id, $oid );

	/**
	 * Retrieve the fields, will be cached from hasCustomFields call.
	 *
	 * Note that these are not fields associated with data/values,
	 * rather these are the base fields this calendar has. The
	 * actual event, e.g. $event, contains the data/value for an
	 * event's custom fields.
	 */
	$has_fields = $buCalendar->hasCustomFields( $calendar_id );
	$fields     = $buCalendar->getCustomFields( $calendar_id );

	// Sets an empty array of custom fieldnames and their values.
	$custom_fields = array();

	// Only continue if calendar has custom event fields + they aren't empty.
	if ( $has_fields && ! empty( $fields ) ) {

		// Now we loop through each field and check
		// if that field has a value for this event.
		foreach ( $fields as $field ) {

			// Skip checkbox fields. Those shouldn't output to front-end.
			if ( 'checkbox' === $field['html_type'] ) {
				continue;
			}

			// Stores the value of the custom field.
			$value = ! empty( $event[ $field['name'] ] ) ? $event[ $field['name'] ] : false;

			// If the event has this field and it has a value then print
			// the field label and the event's field value.
			if ( ! empty( $value ) && ! empty( $value ) ) {
				$custom_fields[ $field['name'] ] = array(
					'label' => $field['label'],
					'value' => $value,
				);
			}
		}
	}

	/**
	 * Modifies the array of custom event fieldnames and their values.
	 *
	 * @since 2.3.3
	 * @param array $custom_fields Array of custom fieldnames and their label/value.
	 */
	return apply_filters( 'responsive_calendar_get_fields_custom', $custom_fields );
}
