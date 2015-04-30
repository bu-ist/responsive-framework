<?php
/**
 * Header layout without navigation.
 */
?>
<div class="brand">
	<?php responsive_branding(); ?>

	<p class="siteDescription"><?php bloginfo( 'description' ); ?></p>

	<?php if ( responsive_search_is_enabled() ) : ?>
	<a href="#quicksearch" class="searchToggle"><span>Search</span></a>
	<?php endif; ?>
</div>

<?php responsive_utility_nav(); ?>

<?php responsive_search_form(); ?>
