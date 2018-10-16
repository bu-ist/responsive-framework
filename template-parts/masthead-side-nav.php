<?php
/**
 * Masthead layout with left side navigation bar.
 *
 * @package Responsive_Framework
 */

?>
<div class="brand">
	<?php responsive_branding(); ?>

	<p class="site-description brand-site-description"><?php bloginfo( 'description' ); ?></p>

	<?php if ( responsive_search_is_enabled() ) : ?>
		<button type="button" class="search-toggle js-search-toggle" aria-label="<?php esc_attr_e( 'Open search', 'responsive-framework' ); ?>" aria-expanded="true"><span><?php esc_html_e( 'Search', 'responsive-framework' ); ?></span></button>
	<?php endif; ?>
</div>

<nav class="primary-nav" role="navigation">
	<button type="button" class="nav-toggle js-nav-toggle" aria-label="<?php esc_attr_e( 'Open menu', 'responsive-framework' ); ?>" aria-expanded="true"><span><?php esc_html_e( 'Menu', 'responsive-framework' ); ?></span></button>

	<?php responsive_primary_nav( 'primary-nav-menu-sidenav' ); ?>
	<?php responsive_utility_nav( 'utility-nav-sidenav' ); ?>
</nav>

<?php
responsive_search_form();
