<?php
/**
 * Default branding markup.
 *
 * This is only used when the BU Branding plugin is inactive, or RESPONSIVE_BRANDING_OVERRIDE is defined as true in a child theme.
 *
 * @package Responsive_Framework
 */

?>
<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home">
	<span class="siteName"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
</a>
