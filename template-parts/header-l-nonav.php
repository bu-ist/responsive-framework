<?php
/**
 * Header layout without navigation.
 */
?>
<div id="brand">
	<a id="siteName" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="logo">
		Boston University <span><?php bloginfo( 'name' ); ?></span>
	</a>

	<p class="desc"><?php bloginfo( 'description' ); ?></p>

	<a href="#quicksearch" class="searchToggle"><span>Search</span></a>

	<?php responsive_search_form(); ?>
</div>
