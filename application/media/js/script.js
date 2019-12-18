// JavaScript Document
$( function()
{
	var iWidth = 0;
	var iMargin = 0;
	
	$( '#header ul li' ).each( function()
					{
						iWidth += parseInt( $( this ).width() ) + parseInt( $( this ).css( 'margin-left' ) ) + parseInt( $( this ).css( 'margin-right' ) );
					});
					$( '#header ul' ).css({
										  'width': iWidth
										  })
	});
