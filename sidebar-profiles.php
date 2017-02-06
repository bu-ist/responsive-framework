<?php
/**
 * Profiles sidebar template.
 *
 * @package Responsive_Framework\BU_Profiles
 */

?>
<?php if ( is_active_sidebar( 'profiles' ) ) : ?>
	<aside class="sidebarProfiles">
		<?php dynamic_sidebar( 'profiles' ); ?>
	</aside>
<?php endif;
