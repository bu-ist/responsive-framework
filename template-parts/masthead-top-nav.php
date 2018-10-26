<?php
/**
 * Masthead layout with navigation bar over branding.
 *
 * @package Responsive_Framework
 */

?>
<nav class="primary-nav primary-nav-topnav" role="navigation">
	<a href="#primary-nav-menu" class="nav-toggle nav-toggle-topnav"><span class="nav-toggle-icon">Menu</span></a>

	<?php if ( responsive_search_is_enabled() ) : ?>
		<a href="#quicksearch" class="search-toggle search-toggle-topnav"><span>Search</span></a>
	<?php endif; ?>

	<?php responsive_primary_nav( 'primary-nav-menu-topnav' ); ?>

	<?php responsive_utility_nav( 'utility-nav-topnav' ); ?>
</nav>

<?php responsive_search_form(); ?>

<div class="brand">
	<?php responsive_branding(); ?>

	<p class="site-description brand-site-description"><?php bloginfo( 'description' ); ?></p>
</div>
