$(function() {
    
$("#lostpw-form").validate({
	   
                debug: true,
                submitHandler: function(form) {

                    form.submit();
                    //alert("Użytkownik gotowy do przypomnienia hasła!");
                        
                },
                errorElement: "div",
    			errorContainer: $("#warning, #summary"),
    			errorPlacement: function(error, element) {
    				error.appendTo( element.parent("td").next("td") );
    			},
                success: function(label) {
                 label.addClass("valid").text("Dane wprowadzone poprawnie!")
               },
                messages: {
                
                    nick: {
                        required: 'To pole jest obowiązkowe!',
                        minlength: 'Podano mniej niż 5 znaki',
                        maxlength: 'Podano więcej niż 25 znaków'
                    },
                    mail: {
                        required: 'To pole jest obowiązkowe!',
                        email: 'Podano nie prawidłowy e-mail'
                    }
                }
	});
    
});