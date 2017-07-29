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
		<button type="button" class="search-toggle js-search-toggle" aria-label="Open search" aria-expanded="true"><span>Search</span></button>
	<?php endif; ?>
</div>

<?php responsive_utility_nav(); ?>

<?php responsive_search_form();
