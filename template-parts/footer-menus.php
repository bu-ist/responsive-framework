<?php
/**
 * Footer menus partial
 *
 * @package Responsive_Framework
 */

/**
 * Fires immediately before the footer menus.
 *
 * @since 2.0.0
 */
do_action( 'r_before_footer_menus' );

?>
<div class="site-footer-menus">
	<?php responsive_footer_menu(); ?>
	<?php responsive_social_menu(); ?>
</div>
<?php

/**
 * Fires immediately after the footer menus.
 *
 * @since 2.0.0
 */
do_action( 'r_after_footer_menus' );
