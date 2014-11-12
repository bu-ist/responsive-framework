<?php
/**
 * BU Course Feeds plugin support functions & templates.
 */

/* - - - - - - - - - - - - - - - - -
  Course Feed Template
  - - - - - - - - - - - - - - - - - */

function bu_flexi_course_template( $template ) {
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

add_filter( 'bu_course_feeds_default_course_template', 'bu_flexi_course_template', 10, 1 );

function bu_flexi_section_template( $template ) {
	$template = <<<TPL
<em>{{section_id}}, {{date_start}} to {{date_end}} {{year}}</em><br />
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
TPL;
	return $template;
}

function bu_flexi_schedule_template( $template ) {
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

add_filter( 'bu_course_feeds_default_schedule_template', 'bu_flexi_schedule_template', 10, 1 );
