/**
 * A better WordPress gallery experience for Responsive Framework.
 *
 * @package Resopnsive_Framework
 */

var responsive_framework = responsive_framework || {};

responsive_framework.galleries = responsive_framework.galleries || {};

responsive_framework.galleries = ( function( $ ) {

	var $window = $( window ),
		$doc  = $( document ),
		$body = $( 'body' ),
		self;

	return {

		/**
		 * Initialize our dismiss
		 * Add our events
		 */
		init: function () {
			self = responsive_framework.galleries;

			$doc
				.on( 'ready', self.setup_gallery );

			$window
				.on( 'load', self.initialize_lightgallery );
		},

		setup_gallery: function () {
			$.each( $('.gallery-item'), function() {
				var $this = $(this),
					$icon_container = $( '.gallery-icon', $this ),
					$caption_container = $( '.wp-caption-text', $this ),
					$link = $( 'a', $icon_container );

				$caption_container.addClass( 'gallery-caption' );

				if ( 0 < $caption_container.length ) {
					$link.attr( 'data-sub-html', '#' + $caption_container.attr( 'id' ) );
				} else {
					$link.attr( 'data-sub-html', '' );
				}
			});
		},

		initialize_lightgallery : function() {
			$('.gallery').lightGallery({
				selector: '.gallery-icon a',
				download: false,
				thumbnail: true,
				zoom: false,
				animateThumb: true,
				getCaptionFromTitleOrAlt: false
			});
		}
	}

})( jQuery );

responsive_framework.galleries.init();
