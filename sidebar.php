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
	do_action( 'r_before_sidebar_opening' );
	?>
	<aside class="sidebar">
		<?php
			/**
			 * Fires immediately after the opening sidebar container element.
			 */
			do_action( 'r_after_sidebar_opening' );
		?>

		<?php dynamic_sidebar( 'sidebar' ); ?>

		<?php
			/**
			 * Fires immediately before the closing sidebar container element.
			 */
			do_action( 'r_before_sidebar_closing' );
		?>
	</aside>
	<?php
	/**
	 * Fires immediately after the closing sidebar container element.
	 */
	do_action( 'r_after_sidebar_closing' );

endif;
