$(function() {
                $('a[href=#top]').click(function(){
                    $('html, body').animate({scrollTop:0}, 'slow', 'linear', function() { $('#login-form span.title').trigger('click'); });
                    return false;
                });
                
                
            
                var bottom_border = "-90px";
                var logoutbtn = $("#logged").attr('href');
                
                if(logoutbtn == undefined)
                {
                    $("#login-form span.title").click(function() {
                    
                        if($("#login-form").css("top") == bottom_border)
                        {
                            $("#login-form").animate({
                                top: "0px"
                            }, 300)
                            
                        }
                        else
                        {
                            $("#login-form").animate({
                                top: "-90px"
                            }, 300)
                        }
                        
                    });
                }
                
            
            
});

function changeLangTo(lang)
{   
    $.ajax({
        type: "POST",
        url: "application/media/_external/lang_ajax.php",
        processdata: false,
        data: "chlang=true&lang="+lang,
        success: function(data)
        {
            window.location.reload();
        }	            
   	});
    
}