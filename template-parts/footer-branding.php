<?php
/**
 * Footer branding partial
 *
 * @package Responsive_Framework
 */

/**
 * Fires immediately before the footer brand assets.
 *
 * @since 2.0.0
 */
do_action( 'r_before_footer_brand_assets' );

?>
<div class="site-footer-brand-assets">
	<?php responsive_branding_masterplate(); ?>
	<?php responsive_branding_bumc_logo(); ?>
	<?php responsive_branding_disclaimer(); ?>
	<?php responsive_customizer_footer_info(); ?>
</div>
<?php

/**
 * Fires immediately after the footer brand assets.
 *
 * @since 2.0.0
 */
do_action( 'r_after_footer_brand_assets' );
