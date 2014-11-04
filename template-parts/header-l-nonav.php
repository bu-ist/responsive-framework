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

	<div class="searchToggle"><?php include get_template_directory() . '/images/search.svg'; ?></div>

	<?php responsive_search_form(); ?>
</div>
