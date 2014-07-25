<?php

/* - - - - - - - - - - - - - - - - -
  Course Feed Template
  - - - - - - - - - - - - - - - - - */

function bu_flexi_course_template($template) {
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

add_filter('bu_course_feeds_default_course_template', 'bu_flexi_course_template', 10, 1);

function bu_flexi_section_template($template) {
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

function bu_flexi_schedule_template($template) {
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

add_filter('bu_course_feeds_default_schedule_template', 'bu_flexi_schedule_template', 10, 1);


/* - - - - - - - - - - - - - - - - -
  BU Calendar Widget Formats
  - - - - - - - - - - - - - - - - - */

function bu_flexi_calendar_widget_formats($formats) {

    unset($formats['plain']);
    unset($formats['big']);

    $formats['full-date'] = array(
        'label' => 'Full Date',
        'callback' => 'bu_flexi_calendar_full_date'
    );


    $formats['graphic'] = array(
        'label' => 'Graphic',
        'callback' => 'bu_calendar_widget_format_big'
    );

    return $formats;
}

function bu_flexi_calendar_full_date($events, $base_url, $calendar_id = null) {
    $output = '';

    if ((is_array($events)) && (count($events) > 0)) {

        foreach ($events as $e) {
            $url = sprintf('%s?eid=%s', $base_url, urlencode($e['id']));
            if (!empty($e['oid']))
                $url .= '&oid=' . urlencode($e['oid']);
            if (!empty($calendar_id))
                $url .= '&cid=' . urlencode($calendar_id);

            if (isset($e['subscription_name']))
                $url .= '&sub=' . urlencode($e['subscription_name']);

            $output .= sprintf('<li><span class="date">%s</span> <a href="%s"><span class="title">%s</span></a></li>', date('l, F j', $e['starts']), esc_url($url), $e['summary']);
            $output .= "\n";
        }
    }

    return $output;
}

add_filter('bu_calendar_widget_formats', 'bu_flexi_calendar_widget_formats', 12, 1);


/* - - - - - - - - - - - - - - - - -
  BU Post Widget Formats
  - - - - - - - - - - - - - - - - - */

function bu_flexi_posts_widget_formats($formats) {

    unset($formats['date_title_excerpt']);

    $formats['title_date'] = array(
        'label' => 'title, date',
        'callback' => 'bu_flexi_title_date_callback',
        'supports_thumbnail' => true,
        'requires_commenting' => false
    );

    $formats['title_excerpt'] = array(
        'label' => 'title, excerpt',
        'callback' => 'bu_flexi_posts_widget_default_callback',
        'supports_thumbnail' => true,
        'requires_commenting' => false
    );

    $formats['title_date_excerpt'] = array(
        'label' => 'title, date, excerpt',
        'callback' => 'bu_flexi_posts_widget_default_callback',
        'supports_thumbnail' => true,
        'requires_commenting' => false
    );

    $formats['title_author_excerpt'] = array(
        'label' => 'title, author, excerpt',
        'callback' => 'bu_flexi_posts_widget_default_callback',
        'supports_thumbnail' => true,
        'requires_commenting' => false
    );

    $formats['title_date_comments_excerpt'] = array(
        'label' => 'title, date, comments, excerpt',
        'callback' => 'bu_flexi_posts_widget_default_callback',
        'supports_thumbnail' => true,
        'requires_commenting' => true
    );

    $formats['title_author_comments_excerpt'] = array(
        'label' => 'title, author, comments, excerpt',
        'callback' => 'bu_flexi_posts_widget_default_callback',
        'supports_thumbnail' => true,
        'requires_commenting' => true
    );

    return $formats;
}

add_filter('bu_posts_widget_formats', 'bu_flexi_posts_widget_formats', 1, 1);

function bu_flexi_title_date_callback($post, $args) {
    global $post;

    $output = '';
    $output .= '<section class="post">';
    if ($args['show_thumbnail'] && function_exists('bu_get_thumbnail_src')) {
        $output .= bu_get_thumbnail_src($post->ID, array(
            'maxwidth' => 88,
            'maxheight' => 88,
            'classes' => 'thumb',
            'use_thumb' => true)
        );
    }
    $output .= sprintf('<h1><a href="%s" rel="bookmark">%s</a></h1>', get_permalink(), get_the_title());
    $output .= sprintf('<p class="meta"><span class="published">%s</span></p>', BU_PostList::post_date('F j, Y'));
    $output .= '</section>';
    return $output;
}

function bu_flexi_posts_widget_default_callback($post, $args) {
    global $post;

    $output = '';
    $meta = '';
    $output .= '<section class="post">';
    if ($args['show_thumbnail'] && function_exists('bu_get_thumbnail_src')) {
        $output .= bu_get_thumbnail_src($post->ID, array(
            'maxwidth' => 260,
            'maxheight' => 260,
            'classes' => 'thumb',
            'use_thumb' => false)
        );
    }
    $output .= sprintf('<h1 class="headline"><a href="%s" rel="bookmark">%s</a></h1>', get_permalink(), get_the_title());

    switch ($args['current_format']) {
        case 'title_date_excerpt':
            $output .= sprintf('<p class="meta"><span class="published">%s</span></p>', BU_PostList::post_date('F j, Y'));
            break;
        case 'title_author_excerpt':
            $output .= sprintf('<p class="meta"><span class="author">by %s</span></p>', get_the_author());
            break;
        case 'title_date_comments_excerpt':
            $output .= sprintf('<p class="meta"><span class="published">%s</span>  <span class="comment-counter"> <a href="%s" rel="nofollow"><strong>%s</strong> comments</a></span></p>', BU_PostList::post_date('F j, Y'), get_comments_link(), get_comments_number($post->ID));
            break;

        case 'title_author_comments_excerpt':
            $output .= sprintf('<p class="meta"><span class="author">by %s</span>  <span class="comment-counter">
				<a href="%s" rel="nofollow"><strong>%s</strong> comments</a></span></p>', get_the_author(), get_comments_link(), get_comments_number($post->ID));
            break;
    }
    
	if(BU_PostList::get_post_excerpt(12)){
	   	$output .= sprintf('<p class="excerpt">%s</p>', BU_PostList::get_post_excerpt(12));
    }
    $output .= '</section>';
    return $output;
}

/* - - - - - - - - - - - - - - - - -
  BU Profiles
  - - - - - - - - - - - - - - - - - */

/**
 * Display profile sidebar
 * 
 * @todo determine the best actions/filters to make available to theme devs
 * @todo determine appropriate markup to house the profile archive link
 * 
 * @param type $args 
 */
function bu_flexi_profile_sidebar($args = array()) {

    do_action('bu_flexi_above_profile_sidebar');

    if (is_active_sidebar('sidebar-profile')) {

        // Profile widgets
        dynamic_sidebar('sidebar-profile');
    }
}

// Add support for the custom post type version of profile plugin
add_theme_support( 'bu-profiles-post_type' );
add_action( 'bu_flexi_above_profile_sidebar', 'bu_flexi_profile_sidebar_link' );

?>