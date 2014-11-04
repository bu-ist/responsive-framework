<?php
/**
 * Theme Shortcodes
 */

/**
 * Renders BUniverse video player.
 */
function buniverse_video_func( $atts ) {
	$atts = shortcode_atts( array(
			'vid'     => '',
			'id'      => '',
			'class'   => '',
			'caption' => '',
		), $atts );

	$retstr = '<div class="vid"> <div id="'. $atts['id'] . '" class="responsive-video ' . $atts['class'] . '"><div>';
	$retstr .= '<iframe width="550" height="310" frameborder="0" src="http://www.bu.edu/buniverse/interface/embed/embed.html?v=' . $atts['vid'] . '"></iframe>';
	$retstr .= '</div></div>';
	if ( $atts['caption'] ) {
		$retstr .= '<p class="caption">' . $atts['caption'] . '</p>';
	}
	$retstr .= '</div>';

	return $retstr;
}

add_shortcode( 'buniverse', 'buniverse_video_func' );
