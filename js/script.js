/**
 * Toggle behavior for navigation / search buttons.
 */
( function ( $ ) {
	$( '.nav-toggle' ).on( 'click', function ( e ) {
		e.preventDefault();
		$( 'nav, .nav-toggle' ).toggleClass( 'is-open' );
		$( '.search-toggle, #quicksearch' ).removeClass( 'is-open' );
		$( 'body' ).toggleClass( 'nav-open' ).removeClass( 'search-open' );
	});

	$( '.search-toggle' ).on( 'click', function ( e ) {
		e.preventDefault();
		$( 'nav, .nav-toggle' ).removeClass( 'is-open' );

		if( ! $( this ).hasClass( 'is-open' ) ){
			setTimeout(function(){
				$( '#q' ).focus();
			}, 100 );
		}

		$( '.search-toggle, #quicksearch' ).toggleClass( 'is-open' );
		$( 'body' ).toggleClass( 'search-open' ).removeClass('nav-open');
	});
} ( jQuery ) );
