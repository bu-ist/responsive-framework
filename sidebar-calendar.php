<?php
/**
 * Calendar sidebar template.
 *
 * @package Responsive_Framework
 */

/**
 * Fires immediately before the opening calendar sidebar container element.
 *
 * @since 2.0.0
 */
do_action( 'r_sidebar_calendar_opening_before' );
?>
<aside class="sidebar sidebar-calendar">
<?php
	/**
	 * Fires immediately after the opening calendar sidebar container element.
	 *
	 * @since 2.0.0
	 */
	do_action( 'r_sidebar_calendar_opening_after' );

	responsive_calendar_sidebar();

	/**
	 * Fires immediately before the closing calendar sidebar container element.
	 *
	 * @since 2.0.0
	 */
	do_action( 'r_sidebar_calendar_closing_before' );
?>
</aside>
<?php
/**
 * Fires immediately after the closing calendar sidebar container element.
 *
 * @since 2.0.0
 */
do_action( 'r_sidebar_calendar_closing_after' );
