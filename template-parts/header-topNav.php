<?php
/**
 * Header layout with navigation bar over branding.
 */
?>
<nav class="primary-nav" role="navigation">
	<a href="#primary-nav-menu" class="navToggle"><span>Menu</span></a>

	<?php if ( responsive_search_is_enabled() ) : ?>
	<a href="#quicksearch" class="searchToggle"><span>Search</span></a>
	<?php endif; ?>

	<?php responsive_primary_nav(); ?>

	<?php responsive_utility_nav(); ?>
</nav>

<?php responsive_search_form(); ?>

<div class="brand">
	<?php responsive_branding(); ?>

	<p class="site-description brand-site-description"><?php bloginfo( 'description' ); ?></p>

	<?php if ( responsive_search_is_enabled() ) : ?>
	<a href="#quicksearch" class="searchToggle"><span>Search</span></a>
	<?php endif; ?>

</div>

<?php responsive_utility_nav();