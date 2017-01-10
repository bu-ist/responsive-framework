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
		<span class="site-name"><?php echo $name; ?></span>
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
	$defaults = array(
		'before' => '<div class="site-footer-brand">',
		'after'  => '</div>',
		);
	$args = wp_parse_args( $args, $defaults );

	if ( function_exists( 'bu_branding_masterplate' ) ) {
		return bu_branding_masterplate( $args );
	}
	return false;
}

/**
 * Display the BUMC logo if branding is configured to do so.
 *
 * Wrapper around `bu_branding_bumc_logo`.
 *
 * @see  mu-plugins/bu-branding
 */
function responsive_branding_bumc_logo( $args = array() ) {
	$defaults = array(
		'before' => '<div class="site-footer-bumc">',
		'after'  => '</div>',
		);
	$args = wp_parse_args( $args, $defaults );

	if ( function_exists( 'bu_branding_bumc_logo' ) ) {
		return bu_branding_bumc_logo( $args );
	}
	return false;
}

/**
 * Display the disclaimer if branding is configured to do so.
 *
 * Wrapper around `bu_branding_disclaimer`.
 *
 * @see  mu-plugins/bu-branding
 */
function responsive_branding_disclaimer( $args = array() ) {
	$defaults = array(
		'before' => '<div class="site-footer-disclaimer">',
		'after'  => '</div>',
		);
	$args = wp_parse_args( $args, $defaults );

	if ( function_exists( 'bu_branding_disclaimer' ) ) {
		return bu_branding_disclaimer( $args );
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

/**
 * Prevent duplicate loading of branding styles by BU Branding.
 */
function responsive_dequeue_branding_fonts() {
	if ( wp_style_is( 'bu-branding' ) ) {
		wp_dequeue_style( 'bu-branding' );
		wp_enqueue_style( 'bu-branding-fonts' );
	}
}

add_action( 'wp_enqueue_scripts', 'responsive_dequeue_branding_fonts', 12 );
