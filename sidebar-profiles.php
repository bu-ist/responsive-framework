<?php
/**
 * Profiles sidebar template.
 *
 * @package Responsive_Framework\BU_Profiles
 */

if ( is_active_sidebar( 'profiles' ) ) :
	/**
	 * Fires immediately before the opening profiles sidebar container element.
	 */
	do_action( 'r_sidebar_profiles_opening_before' );
	?>
	<aside class="sidebar sidebar-profiles">
	<?php
		/**
		 * Fires immediately after the opening profiles sidebar container element.
		 */
		do_action( 'r_sidebar_profiles_opening_after' );

		dynamic_sidebar( 'profiles' );

		/**
		 * Fires immediately before the closing profiles sidebar container element.
		 */
		do_action( 'r_sidebar_profiles_closing_before' );
	?>
	</aside>
	<?php
	/**
	 * Fires immediately after the closing profiles sidebar container element.
	 */
	do_action( 'r_sidebar_profiles_closing_after' );

endif;
