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

define( 'BU_BRANDING_DEFAULT_TYPE', 'logotype' );

define( 'BU_BRANDING_TYPE_OPTION', 'bu_branding' );
define( 'BU_BRANDING_SPONSOR_OPTION', 'bu_branding_sponsor' );

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
		'type'    => bu_branding_type(),
		'sponsor' => bu_branding_sponsor(),
		);
}

/**
 * Returns available branding types.
 */
function bu_branding_types() {
	return array(
		'logotype'    => 'Logotype',
		'signature'   => 'Signature',
		'sponsored'   => 'Sponsored',
		'unbranded'   => 'Unbranded',
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

	return get_option( BU_BRANDING_TYPE_OPTION, BU_BRANDING_DEFAULT_TYPE );
}

/**
 * Get sponsoring entity for this site.
 *
 * Themes can define the BU_BRANDING_SPONSOR constant to force a specific sponsoring entity.
 */
function bu_branding_sponsor() {
	if ( defined( 'BU_BRANDING_SPONSOR' ) ) {
		return BU_BRANDING_SPONSOR;
	}

	return get_option( BU_BRANDING_SPONSOR_OPTION, '' );
}

/**
 * Customizer interface for managing branding options.
 *
 * Defined here (as opposed to in `admin/theme-customizer.php`) to keep this
 * code self-contained in case we decide to move it to a plugin.
 */
function responsive_branding_customize_register( $wp_customize ) {

	// If current theme is defining both branding type and sponsor hide this panel
	if ( ! defined( 'BU_BRANDING_TYPE' ) || ! defined( 'BU_BRANDING_SPONSOR' ) ) {
		$wp_customize->add_section( 'bu_branding', array(
			'title'    => __( 'Branding', 'burf' ),
			'capability' => 'bu_manage_branding',
			'priority' => 30,
		) );

		// Render radio options for branding type
		if ( ! defined( 'BU_BRANDING_TYPE' ) ) {
			$wp_customize->add_setting( BU_BRANDING_TYPE_OPTION, array(
				'default'    => BU_BRANDING_DEFAULT_TYPE,
				'capability' => 'bu_manage_branding',
				'type'       => 'option',
			) );
			$wp_customize->add_control( BU_BRANDING_TYPE_OPTION, array(
				'label'      => 'Type',
				'section'    => 'bu_branding',
				'settings'   => BU_BRANDING_TYPE_OPTION,
				'type'       => 'radio',
				'choices'    => bu_branding_types(),
			) );
		}

		// Render text field for sponsoring entity
		if ( ! defined( 'BU_BRANDING_SPONSOR' ) ) {
			$wp_customize->add_setting( BU_BRANDING_SPONSOR_OPTION, array(
				'default'    => '',
				'capability' => 'bu_manage_branding',
				'type'       => 'option',
			) );
			$wp_customize->add_control( BU_BRANDING_SPONSOR_OPTION, array(
				'label'      => 'Sponsor',
				'section'    => 'bu_branding',
				'settings'   => BU_BRANDING_SPONSOR_OPTION,
				'type'       => 'text',
			) );
		}
	}
}

add_filter( 'customize_register', 'responsive_branding_customize_register' );

/**
 * Display branding HTML.
 */
function responsive_branding() {
	$branding = bu_get_branding();
	if ( 'sponsored' == $branding['type'] ) {
		$name = $branding['sponsor'];
		$subname = get_bloginfo( 'name' );
	} else {
		$name = get_bloginfo( 'name' );
		$subname = '';
	}

	// Container classes
	$class_attr = 'brand-' . $branding['type'];

	?>
	<a class="<?php esc_attr_e( $class_attr ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( $name ); ?>" rel="home">
		<?php if ( 'unbranded' !== $branding['type'] ) : ?>
		<strong>Boston University</strong>
		<?php esc_html_e( $name ); ?>
		<span class="siteName"><?php echo $subname; ?></span>
		<?php else : ?>
		<span class="siteName"><?php echo $name; ?></span>
		<?php endif; ?>
	</a>
	<?php
}

/**
 * Whether or not the current site requires the BU masterplate in the footer.
 *
 * Currently this will return true if the branding type is not Signature or
 * Unbranded.
 */
function responsive_branding_has_masterplate() {
	$branding = bu_get_branding();
	return ! in_array( $branding['type'], array( 'signature', 'unbranded' ) );
}

/**
 * Display the BU masterplate if branding configuration requires it.
 *
 * @param array $args {
 *     Optional. Arguments to configure masterplate markup.
 *
 *     @type  string $before HTML markup to display before masterplate.
 *     @type  string $after  HTML markup to display after masterplate.
 * }
 */
function responsive_branding_masterplate( $args = array() ) {
	$defaults = array(
		'before' => '<div class="siteFooter-brand">',
		'after'  => '</div>',
		);
	$args = wp_parse_args( $args, $defaults );

	$branding = bu_get_branding();
	if ( responsive_branding_has_masterplate() ) {
		echo $args['before'] . '<a href="#" class="brand-masterPlate">Boston University</a>' . $args['after'];
	}
}

/**
 * Adds branding classes to the footer container.
 */
function responsive_branding_footer_classes( $classes ) {
	if ( responsive_branding_has_masterplate() ) {
		$classes[] = 'has-branding';
	}

	return $classes;
}

add_filter( 'responsive_extra_footer_classes', 'responsive_branding_footer_classes' );