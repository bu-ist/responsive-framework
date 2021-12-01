<?php
/**
 * Kaltura integrations.
 *
 * @package Responsive_Framework\kaltura
 */

/**
 * Renders Kaltura video player.
 *
 * @param array  $atts {
 *     Optional. Shortcode attributes.
 *
 *     @type string $vid Kaltura video ID.
 *     @type string $id HTML ID attribute for video wrapper <div>.
 *     @type string $class HTML class attribute for video wrapper <div>.
 *     @type int    $width Width attribute for <iframe>. Default 550.
 *     @type int    $height Height attribute for <iframe>. Default 310.
 *     @type string $caption Caption content.
 * }
 * @param string $content Shortcode content. Currently unused.
 *
 * @return string Shortcode output.
 */
function kaltura_shortcode( $atts, $content ) {
	$atts = shortcode_atts(
		array(
			'vid'     => '',
			'id'      => '',
			'class'   => '',
			'width'   => 550,
			'height'  => 310,
			'caption' => '',
		), $atts, 'kaltura'
	);

	// Remove whitespace from the video id.
	$atts['vid'] = trim( $atts['vid'] );

	// Sanitize and build wrapper attributes.
	$atts['id'] = trim( $atts['id'] );
	$id_attr    = '';
	if ( $atts['id'] ) {
		$id_attr = sprintf( 'id="%s"', esc_attr( $atts['id'] ) );
	}

	$classes       = '';
	$atts['class'] = trim( $atts['class'] );
	if ( $atts['class'] ) {
		$classes = implode( ' ', array_map( 'esc_attr', explode( ' ', $atts['class'] ) ) );
	}

	$iframe = render_kaltura_iframe( $atts );

	// Build caption markup.
	$caption = '';
	if ( $atts['caption'] ) {
		$caption = '<p class="caption">' . wp_kses_post( $atts['caption'] ) . '</p>';
	}

	$embed = <<<EMBED
<div $id_attr class="responsive-video-wrapper $classes">
	<div class="responsive-video">
		$iframe
	</div>
	$caption
</div>
EMBED;

/**
	 * Filters the Kaltura shortcut HTML.
	 *
	 * @param string $embed   Shortcode HTML.
	 * @param array  $atts    Shortcode attributes.
	 * @param string $content Shortcode content.
	 *
	 * @since 1.1.0
	 */
	return apply_filters( 'kaltura_shortcode', $embed, $atts, $content );
}
add_shortcode( 'kaltura', 'kaltura_shortcode' );


function render_kaltura_iframe( $atts ) {
	ob_start();
	?>
<iframe id="kaltura_player" src="https://cdnapisec.kaltura.com/p/2159741/sp/215974100/embedIframeJs/uiconf_id/39435141/partner_id/2159741?iframeembed=true&playerId=kaltura_player&entry_id=<?php echo esc_attr( $atts['vid'] ); ?>&flashvars[streamerType]=auto&flashvars[localizationCode]=en&flashvars[leadWithHTML5]=true&flashvars[sideBarContainer.plugin]=true&flashvars[sideBarContainer.position]=left&flashvars[sideBarContainer.clickToClose]=true&flashvars[chapters.plugin]=true&flashvars[chapters.layout]=vertical&flashvars[chapters.thumbnailRotator]=false&flashvars[streamSelector.plugin]=true&flashvars[EmbedPlayer.SpinnerTarget]=videoHolder&flashvars[dualScreen.plugin]=true&flashvars[Kaltura.addCrossoriginToIframe]=true&wid=1_dkoelt72" width="<?php echo esc_attr( $atts['width'] ); ?>" height="<?php echo esc_attr( $atts['height'] ); ?>" allowfullscreen webkitallowfullscreen mozAllowFullScreen allow="autoplay *; fullscreen *; encrypted-media *" sandbox="allow-forms allow-same-origin allow-scripts allow-top-navigation allow-pointer-lock allow-popups allow-modals allow-orientation-lock allow-popups-to-escape-sandbox allow-presentation allow-top-navigation-by-user-activation" frameborder="0" title="Kaltura Player">
</iframe>
	<?php
	return ob_get_clean();
}


/**
 * Automatically converts Kaltura URLs (e.g. https://mymedia.bu.edu/media/t/1_h6afo1nn ) into embeds.
 * Note that the URL must be isolated on a single line (with no surrounding markup) to be converted.
 * If you require markup around embeds, use the [kaltura] shortcode instead.
 *
 * @uses  kaltura_shortcode
 *
 * @param array  $matches The RegEx matches from the provided regex when calling
 *                        wp_embed_register_handler().
 * @param array  $attr    Embed attributes.
 * @param string $url     The original URL that was matched by the regex.
 * @param array  $rawattr The original unmodified attributes.
 *
 * @return string The embed HTML.
 */
function kaltura_embed_handler( $matches, $attr, $url, $rawattr ) {
	$atts = array(
		'vid' => $matches[1],
	);

	if ( ! empty( $rawattr['width'] ) && ! empty( $rawattr['height'] ) ) {
		$atts['width']  = (int) $rawattr['width'];
		$atts['height'] = (int) $rawattr['height'];
	}

	return kaltura_shortcode( $atts, '' );
}
wp_embed_register_handler( 'kaltura', '#https?://(?:www-syst\.|www-devl\.|www-test\.|www\.)?mymedia\.bu\.edu/media/t/(.+?)(?:$|&)#i', 'kaltura_embed_handler' );
