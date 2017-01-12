/* global responsiveColor */

/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 * Also trigger an update of the Color Scheme CSS when a color is changed.
 */

( function( api, $ ) {
	var cssTemplate = wp.template( 'responsive-framework-color-scheme' ),
		colorSchemes = responsiveColor.schemes,
		colorRegions = _.keys( responsiveColor.regions ),
		optionalRegions = responsiveColor.optional;

	api.controlConstructor.select = api.Control.extend( {
		ready: function() {
			if ( 'burf_setting_color_scheme' === this.id ) {
				this.setting.bind( 'change', function( value ) {

					// Update color pickers when new scheme is selected
					_.each( colorRegions, function ( setting, index ) {
						api( 'burf_setting_custom_colors[' + setting + ']' ).set( colorSchemes[ value ].colors[ index ] );
						api.control( 'burf_setting_custom_colors[' + setting + ']' ).container.find( '.color-picker-hex' )
							.data( 'data-default-color', colorSchemes[ value ].colors[ index ] )
							.wpColorPicker( 'defaultColor', colorSchemes[ value ].colors[ index ] );
					});

					// Reset active region toggles
					_.each( colorSchemes[value].active, function ( value, key ) {
						api( 'burf_setting_active_color_regions[' + key + ']' ).set( value );
					} );
				} );
			}
		}
	} );

	// Generate the CSS for the current Color Scheme.
	function updateCSS() {
		var scheme = api( 'burf_setting_color_scheme' )(), css,
			colors = _.object( colorRegions, colorSchemes[ scheme ].colors );

		// Merge in color scheme overrides.
		_.each( colorRegions, function( setting ) {
			colors[ setting ] = api( 'burf_setting_custom_colors[' + setting + ']' )();
		});

		// Merge in optional region states for template conditionals
		colors.active = {};
		_.each( _.keys( colorSchemes[scheme].active ), function ( setting ) {
			colors.active[ setting ] = api( 'burf_setting_active_color_regions[' + setting + ']' )();
		} );

		css = cssTemplate( colors );

		api.previewer.send( 'update-color-scheme-css', css );
	}

	// Update the CSS whenever a color setting is changed.
	_.each( colorRegions, function( setting ) {
		api( 'burf_setting_custom_colors[' + setting + ']', function( setting ) {
			// TODO: Toggle visibility of associated color picker
			setting.bind( updateCSS );
		} );
	} );

	// Update the CSS whenever an optional region checkbox is toggled.
	_.each( optionalRegions, function ( region ) {
		api( 'burf_setting_active_color_regions[' + region + ']', function( setting ) {
			setting.bind( updateCSS );
		} );
	} );

	// Sync checkbox group values to hidden setting checkbox
	$( document ).ready( function () {
		$( '.customize-control-burf-checkbox-group input[type="checkbox"]' ).on( 'change', function() {
			// Convert selected checkboxes into comma-separated list of display options
			var checkbox_values = $( this ).parents( '.customize-control' ).find( 'input[type="checkbox"]:checked' ).map(
				function() {
					return this.value;
				}
			).get().join( ',' );

			// Set hidden setting field and notify customizer of change
			$( this ).parents( '.customize-control' ).find( 'input[type="hidden"]' ).val( checkbox_values ).trigger( 'change' );
		} );
	} );

	// Manage the sidebar & layout controls. If left layout, then left sidebar is disabled and switched to right
	$( document ).ready( function () {
		$( '#burf_setting_layout input[type="radio"]' ).on( 'change', function() {
			if( $( '#burf_setting_layout_side-nav').is( ':checked' ) ){
				if( $( '#customize-control-burf_setting_sidebar_location input[value="left"]' ).is( ':checked' ) ){
					$( '#customize-control-burf_setting_sidebar_location input[value="left"]' ).attr( 'checked', false ).attr( 'disabled', 'disabled' );
					$( '#customize-control-burf_setting_sidebar_location input[value="right"]' ).attr( 'checked', true ).change();
				}
			}else {
				$( '#customize-control-burf_setting_sidebar_location input[value="left"]' ).attr( 'checked', false ).attr( 'disabled', false );
			}

		} );
	} );

} ) ( wp.customize, jQuery );
