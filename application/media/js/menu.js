$( '.container-fluid .navbar-nav a' ).on( 'click', function () {
	$( '.container-fluid .navbar-nav' ).find( '.active' ).removeClass( '.active' );
	$( this ).addClass( '.active' );
});