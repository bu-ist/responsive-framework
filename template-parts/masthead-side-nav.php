<?php
/**
 * Masthead layout with left side navigation bar.
 *
 * @package Responsive_Framework
 */

?>
<div class="brand">
	<?php responsive_branding(); ?>

	<p class="site-description brand-site-description"><?php bloginfo( 'description' ); ?></p>

	<?php if ( responsive_search_is_enabled() ) : ?>
		<a href="#quicksearch" class="search-toggle search-toggle-sidenav"><span>Search</span></a>
	<?php endif; ?>
</div>

<nav class="primary-nav primary-nav-sidenav" role="navigation">
	<a href="#primary-nav-menu" class="nav-toggle nav-toggle-sidenav"><span class="nav-toggle-icon">Menu</span></a>

	<?php responsive_primary_nav( 'primary-nav-menu-sidenav' ); ?>
	<?php responsive_utility_nav( 'utility-nav-sidenav' ); ?>
</nav>

<?php
responsive_search_form();
