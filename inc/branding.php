<?php
/**
 * Branding
 */

/*
TODO:
[ ] Expose in Customizer (even for child themes)
[ ] Review functionality provided by Flexi / Logo generator
	- Custom header
	- Offical sites
	- Disclaimer
	- Masterplate
	- BUMC branding
[ ] Migration plan for Flexi options
[ ] Move to plugin
*/

define( 'BU_BRANDING_TYPE_OPTION', 'bu_branding' );
define( 'BU_BRANDING_PARENT_OPTION', 'bu_branding_parent' );

// TODO: Implement
// define( 'BU_BRANDING_OFFICIAL_OPTION', 'bu_branding_is_official' );
// define( 'BU_BRANDING_MASTERPLATE_OPTION', 'bu_branding_show_masterplate' );
// define( 'BU_BRANDING_BUMC_OPTION', 'bu_branding_show_bumc' );
// define( 'BU_BRANDING_DISCLAIMER_OPTION', 'bu_branding_show_disclaimer' );

// define( 'BU_BRANDING_DISCLAIMER_URL', 'http://www.bu.edu/tech/policies/websites-disclaimer/' );

/**
 * Get branding options for this site.
 */
function bu_get_branding() {
	return array(
		'type'   => bu_branding_type(),
		'parent' => bu_branding_parent_entity(),
		);
}

/**
 * Returns available branding types.
 */
function bu_branding_types() {
	return array(
		'logotype'   => 'Logotype',
		'signature'  => 'Signature',
		'non-entity' => 'Non-Entity',
		);
}

/**
 * Get current branding type for this site.
 *
 * Themes can define the BU_BRANDING_TYPE constant to force a specific type.
 *
 * @see  bu_branding_types()
 */
function bu_branding_type() {
	if ( defined( 'BU_BRANDING_TYPE' ) && array_key_exists( BU_BRANDING_TYPE, bu_branding_types() ) ) {
		return BU_BRANDING_TYPE;
	}

	return get_option( BU_BRANDING_TYPE_OPTION, 'logotype' );
}

/**
 * Get parent / sponsoring entity for this site.
 *
 * Themes can define the BU_BRANDING_PARENT constant to force a specific parent entity.
 */
function bu_branding_parent_entity() {
	if ( defined( 'BU_BRANDING_PARENT' ) ) {
		return BU_BRANDING_PARENT;
	}

	return get_option( BU_BRANDING_PARENT_OPTION, '' );
}

/**
 * Display branding HTML.
 */
function responsive_branding() {
	$branding = bu_get_branding();
	$name = $branding['parent'] ? $branding['parent'] : get_bloginfo( 'name' );
	$subname = $branding['parent'] ? '<br><span>' . get_bloginfo( 'name' ) . '</span>' : '';

	// Container classes
	$classes = array();
	$classes[] = 'brand-' . $branding['type'];
	if ( $branding['parent'] ) {
		$classes[] = 'brand-has-parent';
	}
	$classes = implode( ' ', $classes );

	?>
	<a class="<?php esc_attr_e( $classes ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( $name ); ?>" rel="home">
		<strong>Boston University</strong> 
		<?php esc_html_e( $name ); ?>
		<span class="siteName"><?php echo $subname; ?></span>
	</a>
	<?php
}
