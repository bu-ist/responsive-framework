<?php
/**
 * Posts sidebar template.
 *
 * @package Responsive_Framework
 */

if ( is_active_sidebar( 'posts' ) ) :

	/**
	 * Fires immediately before the opening posts sidebar container element.
	 */
	do_action( 'r_sidebar_posts_opening_before' );
	?>
	<aside class="sidebar sidebar-posts">
	<?php
		/**
		 * Fires immediately after the opening posts sidebar container element.
		 */
		do_action( 'r_sidebar_posts_opening_after' );

		dynamic_sidebar( 'posts' );

		/**
		 * Fires immediately before the closing posts sidebar container element.
		 */
		do_action( 'r_sidebar_posts_closing_before' );
	?>
	</aside>
	<?php
	/**
	 * Fires immediately after the closing posts sidebar container element.
	 */
	do_action( 'r_sidebar_posts_closing_after' );

endif;
