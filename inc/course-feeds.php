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
	<h4 class="cf-course-title">{{title}}</h4>
	<p class="meta cf-course-info">{{college}} {{department}} {{course_num}} ({{credits}} credits)</p>
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
<div class="responsive-table cf-section-wrapper">
<table class="cf-table">
	<thead class="cf-section-header">
		<tr>
			<th class="cf-section-daytitle">Days</th>
			<th class="cf-section-starttitle">Start</th>
			<th class="cf-section-endtitle">End</th>
			<th class="cf-section-typetitle">Type</th>
			<th class="cf-section-bldgtitle">Bldg</th>
			<th class="cf-section-roomtitle">Room</th>
		</tr>
	</thead>
	<tbody>
		[bu-course-feed_schedule]
	</tbody>
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
<tr class="cf-section-item">
	<td class="cf-section-day">{{days}}</td>
	<td class="cf-section-start">{{time_start}}</td>
	<td class="cf-section-end">{{time_end}}</td>
	<td class="cf-section-type">{{type}}</td>
	<td class="cf-section-bldg">{{building}}</td>
	<td class="cf-section-room">{{room}}</td>
</tr>
TPL;

	return $template;
}

add_filter( 'bu_course_feeds_default_schedule_template', 'responsive_schedule_template', 10, 1 );
