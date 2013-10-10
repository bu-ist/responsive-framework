<?php
function initialize_theme() {
	error_log('initalizing theme...');

	update_option('sidebars_widgets', array(
		'sidebar-main' => array('bu_pages-1', 'bu_calendar-1', 'bu-posts-1', 'links-1'),
		'array_version' => 3
	));

    update_option('widget_bu_pages', array(
        '_multiwidget' => 1,
        1 => array(
        	'navigation_title' => 'section',
        	'navigation_title_text' => '',
        	'navigation_title_url' => '',
        	'navigation_style' => 'section'
        )
    ));

	update_option('widget-bu-calendar-widget', array(
		'_multiwidget'=> 1,
		1 => array(
		'title' => 'Calendar',
		'calendar_id' => get_option('bu_calendar_id'),
		'topic_id' => null,
		'maxevents' => 5,
		'url' => get_bloginfo('url') . '/calendar/',
		'format' => 'big')
	));

	update_option('widget_bu-posts', array(
		'_multiwidget'=> 1,
		1 => array(
			'category' => 0,
			'random' => 0,
			'number' => 3,
			'title' => 'News',
			'title_link' => get_bloginfo('url') . '/news/',
			'display_format' => 'date_title_excerpt',
			'show_thumbnail' => 0
		)
	));
}
add_action('switch_theme', 'initialize_theme');

?>
