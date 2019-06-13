/* global responsiveColor */

/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 * Also trigger an update of the Color Scheme CSS when a color is changed.
 */

( function( api, $ ) {

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
