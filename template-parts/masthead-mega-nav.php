<?php
/**
 * Masthead layout with larger, expanded menu.
 *
 * @package Responsive_Framework
 */

?>
<div class="utility-up"><?php responsive_utility_nav(); ?></div>

<div class="brand">
	<?php responsive_branding(); ?>
	<p class="site-description brand-site-description"><?php bloginfo( 'description' ); ?></p>
</div>

<nav class="primary-nav" role="navigation">
	<?php do_action( 'responsive_before_mega_nav', '' ); ?>
	<div class="search-bar"><?php responsive_search_form(); ?></div>
	<?php responsive_short_nav(); ?>
	<?php responsive_primary_nav(); ?>
	<div class="utility-down"><?php responsive_utility_nav(); ?></div>
	<?php do_action( 'responsive_after_mega_nav', '' ); ?>
</nav>
