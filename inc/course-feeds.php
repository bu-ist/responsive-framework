<?php
/**
 * BU Course Feeds plugin support functions & templates.
 *
 * @package Responsive_Framework\course-feeds
 */

/**
 * Default display callback for the [bu-course-feed] shortcode.
 *
 * @param string $template Default HTML template to filter.
 *
 * @return string $template HTML template to use for displaying a course.
 */
function responsive_course_template( $template ) {
	$template = <<<TPL
<div class="cf-course">
	<h4>{{title}}</h4>
	<p class="meta">{{college}} {{department}} {{course_num}} ({{credits}} credits)</p>
	<p>{{description}}</p>

	[bu-course-feed_section]
</div>
TPL;

	return $template;
}

add_filter( 'bu_course_feeds_default_course_template', 'responsive_course_template', 10, 1 );

/**
 * Default display callback for the [bu-course-feed_section] shortcode.
 *
 * @param string $template Default HTML template to filter.
 *
 * @return string $template HTML template to use for displaying a section.
 */
function responsive_section_template( $template ) {
	$template = <<<TPL
<p class=""><em>{{section_id}}, {{date_start}} to {{date_end}} {{year}}</em></p>
<div class="responsive-table">
<table>
	<tr>
		<th>Days</th>
		<th>Start</th>
		<th>End</th>
		<th>Type</th>
		<th>Bldg</th>
		<th>Room</th>
	</tr>
	[bu-course-feed_schedule]
</table>
</div>
TPL;
	return $template;
}

add_filter( 'bu_course_feeds_default_section_template', 'responsive_section_template', 10, 1 );

/**
 * Default display callback for the [bu-course-feed_schedule] shortcode.
 *
 * @param string $template Default HTML template to filter.
 *
 * @return string $template HTML template to use for displaying a schedule.
 */
function responsive_schedule_template( $template ) {
	$template = <<<TPL
<tr>
	<td>{{days}}</td>
	<td>{{time_start}}</td>
	<td>{{time_end}}</td>
	<td>{{type}}</td>
	<td>{{building}}</td>
	<td>{{room}}</td>
</tr>
TPL;

	return $template;
}

add_filter( 'bu_course_feeds_default_schedule_template', 'responsive_schedule_template', 10, 1 );
