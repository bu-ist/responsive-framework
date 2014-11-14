<?php
/**
 * Header layout without navigation.
 */
?>
<div class="brand">
	<a class="siteName" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
		Boston University <span><?php bloginfo( 'name' ); ?></span>
	</a>

	<p class="siteDescription"><?php bloginfo( 'description' ); ?></p>

	<a href="#quicksearch" class="searchToggle"><span>Search</span></a>

	<?php responsive_search_form(); ?>
</div>
