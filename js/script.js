/**
 * Toggle behavior for navigation / search buttons.
 */
( function ( $ ) {
	var $body = $( 'body' ),
		 $toggle = $( '.js-nav-toggle' ),
		 $toggleitems = $toggle.add( 'nav' ),
		 $searchtoggle = $( '.js-search-toggle' ),
		 $searchitems = $searchtoggle.add( '#quicksearch' );

	$searchtoggle.attr( 'aria-expanded', 'false' )
					 .attr( 'aria-controls', 'quicksearch' );

	$toggle.attr( 'aria-expanded', 'false' )
			 .attr( 'aria-controls', 'primary-nav-menu' );

	$toggle.on( 'click', function ( e ) {
		e.preventDefault();

		if ( $toggle.attr( 'aria-expanded' ) === 'false' ) {
			$toggle.attr( 'aria-expanded', 'true' )
					 .attr( 'aria-label', 'Close menu' );
		} else {
			$toggle.attr( 'aria-expanded', 'false' )
					 .attr( 'aria-label', 'Open menu' );
		}

		$toggleitems.toggleClass( 'is-open' );
		$searchitems.removeClass( 'is-open' );
		$body.toggleClass( 'nav-open' ).removeClass( 'search-open' );
	});

	function toggleSearchPanel( focus ) {
		$toggleitems.removeClass( 'is-open' );

		if( focus === true && ! $( this ).hasClass( 'is-open' ) ){
			setTimeout(function(){
				$( '#q' ).focus();
			}, 100 );
		}

		if ( $searchtoggle.attr( 'aria-expanded' ) === 'false' ) {
			$searchtoggle.attr( 'aria-expanded', 'true' )
							 .attr( 'aria-label', 'Close search' );
		} else {
			$searchtoggle.attr( 'aria-expanded', 'false' )
							 .attr( 'aria-label', 'Open search' );
		}

		$searchitems.toggleClass( 'is-open' );
		$body.toggleClass( 'search-open' ).removeClass( 'nav-open' );
	}

	$searchtoggle.on({
		click: function (e) {
			e.preventDefault();
			toggleSearchPanel( true );
		},
		keypress: function (e) {
			if ( e.keyCode == 13 ) {
				e.preventDefault();
				toggleSearchPanel( false );
			}
		}
	});

} ( jQuery ) );