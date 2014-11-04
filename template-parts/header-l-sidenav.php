<?php
/**
 * Header layout with left side navigation bar.
 */
?>
<div id="brand">
	<a id="siteName" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="logo">
		Boston University <span><?php bloginfo( 'name' ); ?></span>
	</a>

	<p class="desc"><?php bloginfo( 'description' ); ?></p>

	<div class="searchToggle"><?php include get_template_directory() . '/images/search.svg'; ?></div>
</div>

<nav class="mainNav" role="navigation">
	<div class="navToggle"><?php include get_template_directory() . '/images/menu.svg'; ?></div>
	<div class="searchToggle"><?php include get_template_directory() . '/images/search.svg'; ?></div>

	<?php responsive_primary_nav(); ?>

	<nav id="utility" role="utility"><?php responsive_utility_nav(); ?></nav>
</nav>

<?php responsive_search_form(); ?>
