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
	<a href="#quicksearch" class="search-toggle"><span>Search</span></a>
	<?php endif; ?>
</div>

<nav class="primary-nav" role="navigation">
	<a href="#primary-nav-menu" class="nav-toggle"><span class="nav-toggle-icon">Menu</span></a>

	<?php responsive_primary_nav(); ?>
	<?php responsive_utility_nav(); ?>
</nav>

<?php responsive_search_form();
