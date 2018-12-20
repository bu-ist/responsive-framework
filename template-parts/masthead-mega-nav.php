<?php
/**
 * Masthead layout with larger, expanded menu.
 *
 * @package Responsive_Framework
 */

/**
 * Filters the position of the search bar.
 *
 * @since 2.1.11
 *
 * @param boolean Default true for top position.
 */
$responsive_search_top = apply_filters( 'responsi_search_position_top', true );
?>

<div class="brand">
	<?php responsive_branding(); ?>
	<p class="site-description brand-site-description"><?php bloginfo( 'description' ); ?></p>
	<?php responsive_short_nav(); ?>
</div>

<nav class="primary-nav" role="navigation">
	<?php do_action( 'responsive_before_mega_nav', '' ); ?>
	<?php
	if ( $responsive_search_top ) {
		responsive_search_form();
	}
	?>
	<?php responsive_primary_nav(); ?>
	<?php responsive_utility_nav(); ?>
	<?php
	if ( ! $responsive_search_top ) {
		responsive_search_form();
	}
	?>
	<?php do_action( 'responsive_after_mega_nav', '' ); ?>
</nav>
