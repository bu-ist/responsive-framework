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
	do_action( 'r_before_sidebar_posts_opening' );
	?>
	<aside class="sidebar sidebar-posts">
	<?php
		/**
		 * Fires immediately after the opening posts sidebar container element.
		 */
		do_action( 'r_after_sidebar_posts_opening' );

		dynamic_sidebar( 'posts' );

		/**
		 * Fires immediately before the closing posts sidebar container element.
		 */
		do_action( 'r_before_sidebar_posts_closing' );
	?>
	</aside>
	<?php
	/**
	 * Fires immediately after the closing posts sidebar container element.
	 */
	do_action( 'r_after_sidebar_posts_closing' );

endif;
