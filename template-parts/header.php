<?php
/**
 * Default header layout.
 */
?>
<div class="brand">
	<?php responsive_branding(); ?>
	<p class="siteDescription brand-siteDescription"><?php bloginfo( 'description' ); ?></p>
</div>

<?php responsive_utility_nav(); ?>

<nav class="primaryNav" role="navigation">
	<a href="#primaryNav-menu" class="navToggle"><span>Menu</span></a>

	<?php if ( responsive_search_is_enabled() ) : ?>
	<a href="#quicksearch" class="searchToggle"><span>Search</span></a>
	<?php endif; ?>

	<?php responsive_primary_nav(); ?>
	<?php responsive_utility_nav(); ?>
</nav>

<?php responsive_search_form();