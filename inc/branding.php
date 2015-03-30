<?php
/**
 * Branding
 */

/**
 * Display branding HTML.
 *
 * Wrapper around `bu_branding`.
 *
 * @see  mu-plugins/bu-branding
 */
function responsive_branding() {
	if ( function_exists( 'bu_branding' ) ) {
		return bu_branding();
	}

	$name = get_bloginfo( 'name' );
?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( $name ); ?>" rel="home">
		<span class="siteName"><?php echo $name; ?></span>
	</a>
<?php
}

/**
 * Display the BU masterplate if branding configuration requires it.
 *
 * Wrapper around `bu_branding_masterplate`.
 *
 * @see  mu-plugins/bu-branding
 */
function responsive_branding_masterplate( $args = array() ) {
	if ( function_exists( 'bu_branding_masterplate' ) ) {
		return bu_branding_masterplate( $args );
	}
	return false;
}

/**
 * Adds branding classes to the footer container.
 *
 * Used to determine layout of footer columns.
 */
function responsive_branding_footer_classes( $classes ) {
	if ( function_exists( 'bu_branding_has_masterplate' ) && bu_branding_has_masterplate() ) {
		$classes[] = 'has-branding';
	}

	return $classes;
}

add_filter( 'responsive_extra_footer_classes', 'responsive_branding_footer_classes' );
