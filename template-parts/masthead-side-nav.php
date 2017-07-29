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
		<button type="button" class="search-toggle js-search-toggle" aria-label="Open search" aria-expanded="true"><span>Search</span></button>
	<?php endif; ?>
</div>

<nav class="primary-nav" role="navigation">
	<button type="button" class="nav-toggle js-nav-toggle" aria-label="Open menu" aria-expanded="true"><span>Menu</span></button>

	<?php responsive_primary_nav(); ?>
	<?php responsive_utility_nav(); ?>
</nav>

<?php responsive_search_form();
