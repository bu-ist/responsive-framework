/**
 * Toggle behavior for navigation / search buttons.
 */
( function ( $ ) {
	$( '.js-nav-toggle' ).on( 'click', function ( e ) {
		e.preventDefault();
		$( 'nav, .js-nav-toggle' ).toggleClass( 'is-open' );
		$( '.js-search-toggle, .js-quick-search' ).removeClass( 'is-open' );
		$( 'body' ).toggleClass( 'nav-open' ).removeClass( 'search-open' );
	});

	$( '.js-search-toggle' ).on( 'click', function ( e ) {
		e.preventDefault();
		$( 'nav, .js-nav-toggle' ).removeClass( 'is-open' );

		if( ! $( this ).hasClass( 'is-open' ) ){
			setTimeout(function(){
				$( '#q' ).focus();
			}, 100 );
		}

		$( '.js-search-toggle, .js-quick-search' ).toggleClass( 'is-open' );
		$( 'body' ).toggleClass( 'search-open' ).removeClass('nav-open');
	});
} ( jQuery ) );