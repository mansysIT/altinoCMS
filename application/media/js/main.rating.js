$(function() {
    
$('.rating').allRating({
	   theme: 'star',
	   input:'radio',
	   onClickEvent: function(input)
	   {     
	        var datas = 'rating=true&' + input.attr('name') + '=' + input.val();
	        
	        $.ajax({
	  			type: "POST",
	   			url: $("#voter").attr("action"),
	   			processdata: false,
	   			data: datas,
				success: function(data)
				{
	                if(data == "true")
	                    {
	                    	window.location.reload();
	                    }
	                    else
	                    {
	                    	alert(data); 
	                    }
	    			}
	            });
	            
	       }
	   });
               
});