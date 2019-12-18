$(function() {


        
            $("#reg-form").validate({
	   
                debug: true,
                submitHandler: function(form) {

                    form.submit();
                    //alert("Użytkownik gotowy do rejestracji w systemie :)");
                        
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
                
                    name: {
                        required: 'To pole jest obowiązkowe!',
                        minlength: 'Podano mniej niż 3 znaki',
                        maxlength: 'Podano więcej niż 20 znaków'
                    },
                    surname: {
                        required: 'To pole jest obowiązkowe!',
                        maxlength: 'Podano więcej niż 25 znaków'
                    },
                    nick: {
                        required: 'To pole jest obowiązkowe!',
                        minlength: 'Podano mniej niż 5 znaki',
                        maxlength: 'Podano więcej niż 25 znaków'
                    },
                    pass1: {
                        required: 'To pole jest obowiązkowe!',
                        minlength: 'Podano mniej niż 5 znaków',
                        maxlength: 'Podano więcej niż 50 znaków'
                    },
                    pass2: {
                        required: 'To pole jest obowiązkowe!',
                        minlength: 'Podano mniej niż 5 znaków',
                        maxlength: 'Podano więcej niż 50 znaków',
                        equalTo: 'To powtórzone hasło musi być identyczne z oryginalnym'
                    },
                    mail: {
                        required: 'To pole jest obowiązkowe!',
                        email: 'Podano nie prawidłowy e-mail'
                    }
                },
               rules: {
                pass1: true,
                pass2: {
                  equalTo: "#pass1"
                }
              }
	});
});