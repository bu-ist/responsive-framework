<?php
/**
 * BUniverse integrations.
 */

/**
 * Renders BUniverse video player.
 *
 * @param array $atts {
 *     Optional. Shortcode attributes.
 *
 *     @type  string $vid             BUniverse video ID.
 *     @type  string $id              HTML ID attribute for video wrapper <div>.
 *     @type  string $class           HTML class attribute for video wrapper <div>.
 *     @type  int    $width           Width attribute for <iframe>. Default 550.
 *     @type  int    $height          Height attribute for <iframe>. Default 310.
 *     @type  string $caption         Caption content.
 *     @type  bool   $allowfullscreen Whether or not to allow fullscreen embeds. Default true.
 * }
 * @param  string $content Shortcode content. Unused.
 */
function buniverse_shortcode( $atts, $content ) {
	$atts = shortcode_atts( array(
			'vid'             => '',
			'id'              => '',
			'class'           => '',
			'width'           => 550,
			'height'          => 310,
			'caption'         => '',
		), $atts, 'buniverse' );

	// Sanitize and build wrapper attributes
	$atts['id'] = trim( $atts['id'] );
	$id_attr = '';
	if ( $atts['id'] ) {
		$id_attr = sprintf( 'id="%s"', esc_attr( $atts['id'] ) );
	}

	$classes = '';
	$atts['class'] = trim( $atts['class'] );
	if ( $atts['class'] ) {
		$classes = implode( ' ', array_map( 'esc_attr', explode( ' ', $atts['class'] ) ) );
	}

	// Build <iframe> attributes
	$iframe = $iframe_atts = array();
	$iframe['src'] = esc_url( sprintf( apply_filters( 'buniverse_shortcode_src', 'http://www.bu.edu/buniverse/interface/embed/embed.html?v=%s' ), $atts['vid'] ) );
	$iframe['width'] = (int) $atts['width'];
	$iframe['height'] = (int) $atts['height'];
	$iframe['frameborder'] = 0;

	foreach ( $iframe as $key => $val ) {
		// Boolean attributes
		if ( is_bool( $val ) && $val ) {
			$iframe_atts[] = $key;
		} else {
			$iframe_atts[] = $key . '=' . esc_attr( $val );
		}
	}
	$iframe_atts = implode( ' ', $iframe_atts );

	// Build caption markup
	$caption = '';
	if ( $atts['caption'] ) {
		$caption = '<p class="caption">' . wp_kses_post( $atts['caption'] ) . '</p>';
	}

	$embed = <<<EMBED
<div $id_attr class="responsiveVideo-wrapper $classes">
	<div class="responsiveVideo">
		<iframe $iframe_atts></iframe>
	</div>
	$caption
</div>
EMBED;

	return apply_filters( 'buniverse_shortcode', $embed, $atts, $content );
}

add_shortcode( 'buniverse', 'buniverse_shortcode' );

/**
 * Automatically converts BUniverse URLs (e.g. http://www.bu.edu/buniverse/view/?v=yVVrH1ZO) into embeds
 *
 * Note that the URL must be isolated on a single line (with no surrounding markup) to be converted.
 *
 * If you require markup around embeds, use the [buniverse] shortcode instead.
 *
 * @uses  buniverse_shortcode
 */
function buniverse_embed_handler( $matches, $attr, $url, $rawattr ) {
	$atts = array(
		'vid' => $matches[1],
		);

	if ( ! empty( $rawattr['width'] ) && ! empty( $rawattr['height'] ) ) {
		$atts['width'] = (int) $rawattr['width'];
		$atts['height'] = (int) $rawattr['height'];
	}

	return buniverse_shortcode( $atts, '' );
}

wp_embed_register_handler( 'buniverse', '#http://(?:www-syst\.|www-devl\.|www-test\.|www\.)?bu\.edu/buniverse/view/\?v=(.+?)(?:$|&)#i', 'buniverse_embed_handler' );
