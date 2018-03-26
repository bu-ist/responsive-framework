<?php
/**
 * Calendar sidebar template.
 *
 * @package Responsive_Framework
 */

/**
 * Fires immediately before the opening calendar sidebar container element.
 */
do_action( 'r_before_sidebar_calendar_opening' );
?>
<aside class="sidebar sidebar-calendar">
<?php
	/**
	 * Fires immediately after the opening calendar sidebar container element.
	 */
	do_action( 'r_after_sidebar_calendar_opening' );

	responsive_calendar_sidebar();

	/**
	 * Fires immediately before the closing calendar sidebar container element.
	 */
	do_action( 'r_before_sidebar_calendar_closing' );
?>
</aside>
<?php
/**
 * Fires immediately after the closing calendar sidebar container element.
 */
do_action( 'r_after_sidebar_calendar_closing' );
