<?php

/*
 * @global object $buCalendar
 * @global array $topics
 * @global int $timestamp
 * @global int $yyyymmdd
 */

function bu_flexi_calendar_sidebar( $args = array() ) {
	global $post, $buCalendar, $topics, $timestamp, $yyyymmdd;

	$defaults = array(
		'calendar_id' => array_key_exists( 'cid', $_GET ) ? intval( $_GET['cid'] ) : get_option( 'bu_calendar_id' ),
		'show_topics' => true,
		'calendar_uri' => get_permalink( $post ),
		'page_template' => 'calendar.php'
	);

	$args = wp_parse_args( $args, $defaults );

	$args = apply_filters( 'bu_flexi_calendar_sidebar', $args );

	$all_topics_url = add_query_arg( 'date', date( 'Ymd', $timestamp ), $args['calendar_uri'] );

	if ( !empty( $_GET['cid'] ) ) $all_topics_url = add_query_arg( 'cid', intval( $_GET['cid'] ), $all_topics_url );

	if ( is_page_template( $args['page_template'] ) && !empty( $args['calendar_uri'] ) ) { ?>

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

		do_action( 'bu_flexi_calendar_sidebar_content' );
	}
}

function bu_flexi_micro_calendar( $args = array() ) {
	global $post, $buCalendar, $topics, $timestamp, $yyyymmdd;

	$defaults = array(
		'calendar_id' => array_key_exists( 'cid', $_GET ) ? intval( $_GET['cid'] ) : get_option( 'bu_calendar_id' ),
		'show_topics' => true,
		'calendar_uri' => get_permalink( $post ),
		'page_template' => 'calendar.php'
	);

	$args = wp_parse_args( $args, $defaults );

	$args = apply_filters( 'bu_flexi_calendar_micro', $args );

	$all_topics_url = add_query_arg( 'date', date( 'Ymd', $timestamp ), $args['calendar_uri'] );

	if ( !empty( $_GET['cid'] ) ) $all_topics_url = add_query_arg( 'cid', intval( $_GET['cid'] ), $all_topics_url );

?>
<div id="micro_calendar" class="container sub">
	<div class="widget">
	<h2 class="widgettitle">Event Dates &amp; Topics</h2>
		<div class="calendar-nav">
			<div class="month">
				<?php echo $buCalendar->buildMonthCalendar( $yyyymmdd ); ?>
			</div>
			<?php if ( $args['show_topics'] ): ?>
			<div id="calendar-topics" class="topics">
				<h4>Event Topics</h4>
				<p><a href="<?php echo $all_topics_url; ?>">All Topics</a></p>
			<?php echo $buCalendar->buildTopicTree( $topics ); ?>
			</div>
		<?php endif; ?>
		</div>
		<?php do_action( 'bu_flexi_calendar_micro_content' ); ?>
	</div>
</div>
<?php
}
?>
