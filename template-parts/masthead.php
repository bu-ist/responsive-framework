<?php
/**
 * Default masthead layout.
 *
 * @package Responsive_Framework
 */

?>
<div class="brand">
	<?php responsive_branding(); ?>
	<p class="site-description brand-site-description"><?php bloginfo( 'description' ); ?></p>
</div>

<nav class="primary-nav" role="navigation">
	<a href="#primary-nav-menu" class="nav-toggle"><span class="nav-toggle-icon">Menu</span></a>

	<?php if ( responsive_search_is_enabled() ) : ?>
		<button type="button" class="search-toggle js-search-toggle" aria-label="<?php esc_attr_e( 'Open search', 'responsive-framework' ); ?>" aria-expanded="true"><span><?php esc_html_e( 'Search', 'responsive-framework' ); ?></span></button>
	<?php endif; ?>

	<?php responsive_primary_nav(); ?>
	<?php responsive_utility_nav(); ?>
</nav>

<?php
responsive_search_form();
