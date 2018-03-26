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
	do_action( 'r_before_sidebar_profiles_opening' );
	?>
	<aside class="sidebar sidebar-profiles">
	<?php
		/**
		 * Fires immediately after the opening profiles sidebar container element.
		 */
		do_action( 'r_after_sidebar_profiles_opening' );

		dynamic_sidebar( 'profiles' );

		/**
		 * Fires immediately before the closing profiles sidebar container element.
		 */
		do_action( 'r_before_sidebar_profiles_closing' );
	?>
	</aside>
	<?php
	/**
	 * Fires immediately after the closing profiles sidebar container element.
	 */
	do_action( 'r_after_sidebar_profiles_closing' );

endif;
