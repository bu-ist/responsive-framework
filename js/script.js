/**
 * Toggle behavior for navigation / search buttons.
 */
( function ( $ ) {
	$( '.navToggle' ).on( 'click', function ( e ) {
		e.preventDefault();
		$( 'nav, .navToggle' ).toggleClass( 'is-open' );
		$( '.searchToggle, #quicksearch' ).removeClass( 'is-open' );
		$( 'body' ).toggleClass( 'nav-open' ).removeClass( 'search-open' );
	});

	$( '.searchToggle' ).on( 'click', function ( e ) {
		e.preventDefault();
		$( 'nav, .navToggle' ).removeClass( 'is-open' );

		if( ! $( this ).hasClass( 'is-open' ) ){
			setTimeout(function(){
				$( '#q' ).focus();
			}, 100 );
		}

		$( '.searchToggle, #quicksearch' ).toggleClass( 'is-open' );
		$( 'body' ).toggleClass( 'search-open' ).removeClass('nav-open');
	});
} ( jQuery ) );
