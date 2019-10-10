/**
 * SAU/CAL Script
 *
 * Add logic to load our widget dinamically.
 *
 */

jQuery( document ).ready( function() {
	var widgets = jQuery('.saucal-user-settings');

	if ( wpApiSettings.logged_in && widgets.length > 0 ) {
		jQuery.ajax( {
			url: wpApiSettings.root + 'saucal/v1/external-api',
			method: 'GET',
			beforeSend: function ( xhr ) {
				xhr.setRequestHeader( 'X-WP-Nonce', wpApiSettings.nonce );
			},
		} ).done( function ( data ) {
			console.log(data);
			// Display data in every wrapper we find.
			widgets.html( JSON.stringify( data ) );
		} );
	} else {
		widgets.remove();
	}
});
