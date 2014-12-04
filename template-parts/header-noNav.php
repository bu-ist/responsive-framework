<?php
/**
 * Header layout without navigation.
 */
?>
<div class="brand">
	<?php responsive_branding(); ?>

	<p class="siteDescription"><?php bloginfo( 'description' ); ?></p>

	<a href="#quicksearch" class="searchToggle"><span>Search</span></a>
</div>

<?php responsive_utility_nav(); ?>

<?php responsive_search_form(); ?>
