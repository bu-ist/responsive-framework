/**
 * Toggle behavior for navigation / search buttons.
 */
( function ( $ ) {
	$( '.nav-toggle' ).on( 'click', function ( e ) {
		e.preventDefault();
		$( 'nav, .nav-toggle' ).toggleClass( 'is-open' );
		$( '.searchToggle, #quicksearch' ).removeClass( 'is-open' );
		$( 'body' ).toggleClass( 'nav-open' ).removeClass( 'search-open' );
	});

	$( '.searchToggle' ).on( 'click', function ( e ) {
		e.preventDefault();
		$( 'nav, .nav-toggle' ).removeClass( 'is-open' );

		if( ! $( this ).hasClass( 'is-open' ) ){
			setTimeout(function(){
				$( '#q' ).focus();
			}, 100 );
		}

		$( '.searchToggle, #quicksearch' ).toggleClass( 'is-open' );
		$( 'body' ).toggleClass( 'search-open' ).removeClass('nav-open');
	});
} ( jQuery ) );
