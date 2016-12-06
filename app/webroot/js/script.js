;(function( $ ) {
	"use strict";


	$( document ).on( 'ready', function() {

		/* =======================================
		 * Splash Screen Logo
		 * =======================================
		 */
		 $( '#preloader .preloader-logo > img' ).on( 'load', function() {
		 	$( this ).show().addClass( 'bounceIn' ).next().show();
		 });
		});
	$( window ).on( 'load', function() {
		$( '#preloader' ).fadeOut( 1000, function() {
			$( 'body' ).addClass( 'preloader-done' );
		});

	});

})( jQuery );
