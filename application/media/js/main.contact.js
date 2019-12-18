$(function() {


            
            $("#kontakt-form").validate({
	   
                debug: true,
                submitHandler: function(form) {

                    form.submit();
                    //alert("Mail gotowy do wysłania!");
                        
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
                        minlength: 'Podano mniej niż 3 znaki'
                    },
                    surname: {
                        required: 'To pole jest obowiązkowe!',
                        email: 'Podano nie prawidłowy adres e-mail'
                    },
                    subject: {
                        required: 'To pole jest obowiązkowe!',
                        minlength: 'Podano mniej niż 10 znaków'
                    },
                    msg: {
                        required: 'To pole jest obowiązkowe!',
                        minlength: 'Podano mniej niż 20 znaków'
                    }
                }
	});
    
 });