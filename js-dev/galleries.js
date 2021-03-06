/**
 * Entry point for Image gallery functionality.
 *
 * Bundles the `lightgallery` jQuery plugin along with this custom
 * responsive_framework.galleries script.
 *
 * @package ResponsiveFramework
 */

import $ from 'jquery';

/**
 * Requires the lightgallery jQuery library.
 *
 * @link https://github.com/sachinchoolur/lightgallery.js
 */
import lightGallery from 'lightgallery';

/**
 * Requires the lg-thumbnail plugin for lightgallery.
 *
 * @link https://github.com/sachinchoolur/lg-thumbnail
 */
import lgThumbnail from 'lightgallery/plugins/thumbnail';

/**
 * A better WordPress gallery experience for Responsive Framework.
 *
 * @package Resopnsive_Framework
 */
var responsive_framework = responsive_framework || {};

responsive_framework.galleries = responsive_framework.galleries || {};

responsive_framework.galleries = ( function( $ ) {
	let $window = $( window ),
		$doc = $( document ),
		$body = $( 'body' ),
		self;

	return {
		/**
		 * Initialize our dismiss
		 * Add our events
		 */
		init: function() {
			self = responsive_framework.galleries;

			$doc.on( 'ready', self.setup_gallery );

			$window.on( 'load', self.initialize_lightgallery );
		},

		setup_gallery: function() {
			$.each( $( '.gallery-item' ), function() {
				const $this = $( this ),
					$icon_container = $( '.gallery-icon', $this ),
					$caption_container = $( '.wp-caption-text', $this ),
					$link = $( 'a', $icon_container );

				$caption_container.addClass( 'gallery-caption' );

				if ( 0 < $caption_container.length ) {
					const caption_text = $.trim( $caption_container.text() );
					$link.attr( 'data-sub-html', caption_text );

					if ( 60 < $caption_container.text().length ) {
						$caption_container.html(
							$caption_container.text().substring( 0, 60 ) +
								'&hellip;'
						);
					}
				} else {
					$link.attr( 'data-sub-html', '' );
				}
			} );
		},

		initialize_lightgallery: function() {
			lightGallery( document.querySelector('.gallery'), {
				plugins: [lgThumbnail],
				selector: document.querySelectorAll('.gallery-icon a'),
				download: false,
				thumbnail: true,
				enableDrag: false,
				getCaptionFromTitleOrAlt: false,
				licenseKey: '6B97C46B-6808444C-8930A490-8D052085' // Licensed for Responsive Framework only. Checked with Ben, this is OK to store here.
			} );
		},
	};
}( jQuery ) );

responsive_framework.galleries.init();
