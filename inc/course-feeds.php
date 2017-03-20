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
<div class="responsive-table cf-section-wrapper">
<table class="cf-table">
	<caption>Section {{section_name}}, {{semester}} {{year}} {{date_start}} to {{date_end}} {{year}}</caption>
	<thead class="cf-section-header">
		<tr>
			<th class="cf-section-instructortitle">Instructor</th>
			<th class="cf-section-typetitle">Type</th>
			<th class="cf-section-daytitle">Days</th>
			<th class="cf-section-timestitle">Times</th>
			<th class="cf-section-locationtitle">Location</th>
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
	<td class="cf-section-instructor">{{instructor}}</td>
	<td class="cf-section-type">{{class_type_text}}</td>
	<td class="cf-section-day">{{days}}</td>
	<td class="cf-section-start">{{time_start}}&ndash;{{time_end}}</td>
	<td class="cf-section-location"><a href="http://www.bu.edu/maps/?search={{building}}">{{building}} {{room}}</a></td>
</tr>
TPL;

	return $template;
}

add_filter( 'bu_course_feeds_default_schedule_template', 'responsive_schedule_template', 10, 1 );
