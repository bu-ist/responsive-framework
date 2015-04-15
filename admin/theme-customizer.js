
/* global responsiveColor, Color */
/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 * Also trigger an update of the Color Scheme CSS when a color is changed.
 */

( function( api ) {
	var cssTemplate = wp.template( 'responsive-framework-color-scheme' ),
		colorScheme = responsiveColor.schemes,
		colorSettings = _.keys( responsiveColor.regions );

	api.controlConstructor.select = api.Control.extend( {
		ready: function() {
			if ( 'burf_color_scheme' === this.id ) {
				this.setting.bind( 'change', function( value ) {

					// Update color pickers when new scheme is selected
					_.each( colorSettings, function ( setting, index ) {
						api( 'burf_custom_colors[' + setting + ']' ).set( colorScheme[ value ].colors[ index ] );
						api.control( 'burf_custom_colors[' + setting + ']' ).container.find( '.color-picker-hex' )
							.data( 'data-default-color', colorScheme[ value ].colors[ index ] )
							.wpColorPicker( 'defaultColor', colorScheme[ value ].colors[ index ] );
					});
				} );
			}
		}
	} );

	// Generate the CSS for the current Color Scheme.
	function updateCSS() {
		var scheme = api( 'burf_color_scheme' )(), css,
			colors = _.object( colorSettings, colorScheme[ scheme ].colors );

		// Merge in color scheme overrides.
		_.each( colorSettings, function( setting ) {
			colors[ setting ] = api( 'burf_custom_colors[' + setting + ']' )();
		});

		css = cssTemplate( colors );

		api.previewer.send( 'update-color-scheme-css', css );
	}

	// Update the CSS whenever a color setting is changed.
	_.each( colorSettings, function( setting ) {
		api( 'burf_custom_colors[' + setting + ']', function( setting ) {
			setting.bind( updateCSS );
		} );
	} );
} )( wp.customize );
