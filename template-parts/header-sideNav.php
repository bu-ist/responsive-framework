<?php
/**
 * Header layout with left side navigation bar.
 */
?>
<div class="brand">
	<?php responsive_branding(); ?>

	<p class="siteDescription"><?php bloginfo( 'description' ); ?></p>

	<a href="#quicksearch" class="searchToggle"><span>Search</span></a>
</div>

<nav class="primaryNav" role="navigation">
	<a href="#primaryNav-menu" class="navToggle"><span>Menu</span></a>
	<a href="#quicksearch" class="searchToggle"><span>Search</span></a>

	<?php responsive_primary_nav(); ?>
	<?php responsive_utility_nav(); ?>
</nav>

<?php responsive_search_form(); ?>
