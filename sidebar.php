<?php
/**
 * Default sidebar template.
 *
 * @package Responsive_Framework
 */

if ( is_active_sidebar( 'sidebar' ) ) :

	/**
	 * Fires immediately before the opening sidebar container element.
	 */
	do_action( 'r_sidebar_opening_before' );
	?>
	<aside class="sidebar">
		<?php
			/**
			 * Fires immediately after the opening sidebar container element.
			 */
			do_action( 'r_sidebar_opening_after' );
		?>

		<?php dynamic_sidebar( 'sidebar' ); ?>

		<?php
			/**
			 * Fires immediately before the closing sidebar container element.
			 */
			do_action( 'r_sidebar_closing_before' );
		?>
	</aside>
	<?php
	/**
	 * Fires immediately after the closing sidebar container element.
	 */
	do_action( 'r_sidebar_closing_after' );

endif;
