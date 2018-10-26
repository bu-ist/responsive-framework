<?php
/**
 * Masthead layout without navigation.
 *
 * @package Responsive_Framework
 */

?>
<div class="brand">
	<?php responsive_branding(); ?>

	<p class="site-description brand-site-description"><?php bloginfo( 'description' ); ?></p>

	<?php if ( responsive_search_is_enabled() ) : ?>
		<a href="#quicksearch" class="search-toggle search-toggle-nonav"><span>Search</span></a>
	<?php endif; ?>
</div>

<?php responsive_utility_nav( 'utility-nav-nonav' ); ?>

<?php responsive_search_form();
