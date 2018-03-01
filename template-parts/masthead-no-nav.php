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
		<a href="#quicksearch" class="search-toggle js-search-toggle"><span><?php esc_html_e( 'Search', 'responsive-framework' ); ?></span></a>
	<?php endif; ?>
</div>

<?php responsive_utility_nav(); ?>

<?php responsive_search_form();
