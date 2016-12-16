<?php
/**
 * Header layout with left side navigation bar.
 */
?>
<div class="brand">
	<?php responsive_branding(); ?>

	<p class="site-description brand-site-description"><?php bloginfo( 'description' ); ?></p>

	<?php if ( responsive_search_is_enabled() ) : ?>
	<a href="#quicksearch" class="searchToggle"><span>Search</span></a>
	<?php endif; ?>
</div>

<nav class="primaryNav" role="navigation">
	<a href="#primaryNav-menu" class="navToggle"><span>Menu</span></a>

	<?php if ( responsive_search_is_enabled() ) : ?>
	<a href="#quicksearch" class="searchToggle"><span>Search</span></a>
	<?php endif; ?>

	<?php responsive_primary_nav(); ?>
	<?php responsive_utility_nav(); ?>
</nav>

<?php responsive_search_form();
