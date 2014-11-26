<?php
/**
 * Header layout without navigation.
 */
?>
<div class="brand">
	<?php responsive_branding(); ?>

	<p class="siteDescription"><?php bloginfo( 'description' ); ?></p>

	<a href="#quicksearch" class="searchToggle"><span>Search</span></a>

	<nav class="utilityNav" role="navigation"><?php responsive_utility_nav(); ?></nav>

</div>

<?php responsive_search_form(); ?>
