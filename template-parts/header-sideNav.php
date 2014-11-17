<?php
/**
 * Header layout with left side navigation bar.
 */
?>
<div class="brand">
	<?php responsive_branding(); ?>

	<p class="siteDescription"><?php bloginfo( 'description' ); ?></p>

	<a href="#quicksearch" class="searchToggle"><span>Search</span></a>

	<?php responsive_search_form(); ?>
</div>

<nav class="navContainer" role="navigation">
	<a href="#primaryNav" class="navToggle"><span>Menu</span></a>
	<a href="#quicksearch" class="searchToggle"><span>Search</span></a>

	<?php responsive_primary_nav(); ?>

	<nav class="utilityNav" role="navigation"><?php responsive_utility_nav(); ?></nav>
</nav>
