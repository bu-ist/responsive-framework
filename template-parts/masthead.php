<?php
/**
 * Default masthead layout.
 *
 * @package Responsive_Framework
 */

?>
<div class="brand">
	<?php responsive_branding(); ?>
	<p class="site-description brand-site-description"><?php bloginfo( 'description' ); ?></p>
</div>

<nav class="primary-nav" role="navigation">
	<a href="#primary-nav-menu" class="nav-toggle js-nav-toggle"><span>Menu</span></a>

	<?php if ( responsive_search_is_enabled() ) : ?>
		<button type="button" class="search-toggle js-search-toggle"><span>Search</span></button>
	<?php endif; ?>

	<?php responsive_primary_nav(); ?>
	<?php responsive_utility_nav(); ?>
</nav>

<?php responsive_search_form();
