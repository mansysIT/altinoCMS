const formatter = new Intl.NumberFormat('nl-NL', {
	style: 'currency',
	currency: 'EUR'
  })

function sum() {
    
    var element1 = document.querySelectorAll('#num1');
	var element2 = document.querySelectorAll('#num2'); 
    var x = [];
    var y =[];
    var i = 0;
	var sum = 0;
	var btw = 0;
	
	var xVal = 0;
	var yVal = 0;

    element1.forEach(function(userItem) {
		// alert(userItem.value);
		xVal = userItem.value.replace(",", ".");
		
		// alert(xVal);

		x.push(parseFloat(xVal));	
    });
	x.shift()

    element2.forEach(function(userItem) {
		yVal = userItem.value.replace(",", ".");
		// alert(yVal);
		y.push(parseFloat(yVal));
  
	});
	y.shift()
	
	y.forEach(function(userItem) {
		if(isNaN(x[i])) {
			x[i] = 0;
		}		
		if(isNaN(userItem)) {
			userItem = 0;
		}
		sum = sum + (x[i] * userItem);
		i++
	});

	if(isNaN(sum)) {
		sum = 0;
	}

		



	$(".sumValue").html(formatter.format(sum));
	$(".sumBtw").html(formatter.format(btw));

}

function getBTW() {
	var element1 = document.querySelectorAll('#mySelect');
	element1.forEach(function(userItem) {
		var opt;
		for ( var i = 1, len = userItem.options.length; i < len; i++ ) {
			opt = userItem.options[i];
			if ( opt.selected == true ) {
			}
		}
	});
}


function nowywiersz(index, row_one, id )
{
	index++;

		$(".nag").parent().append(row_one).children().last().attr("id", "nag_" + index);

		var sel = document.querySelectorAll('.selectValid');
		var x = [];

		sel.forEach(function(userItem) {
			x.push(userItem);	
			
		});
		x.shift()
		x.forEach(function(userItem) {
			userItem.setAttribute("required", ""); 
		});

		// $(".select").parent().append(row_one).children().last().setAttribute("required", "");
}

function zamiana_daty(date)
{
	var tab = date.split("-");
	return tab[2]+"-"+tab[1]+"-"+tab[0];
}

$(document).ready(function () {


	$("form").keypress(function(e) {
		//Enter key
		if (e.which == 13) {
		  return false;
		}
	  });

    $("body").on("blur", ".getAllWarfor", function(){
        sum();
    });
    
	var row_one = $(".nag:first").html();   
	var fields_line_one = $(".nag").find("input, select, textarea");
	var index = 1; 
	var id_adres = $("#aaa").attr("value");

	

	$(".nag").first().attr("id", "nag_1");

	//dodanie nowego wiersza, nadanie id i walidacji

    $('#dodaj').on('click', function () {

		nowywiersz(index, "<tr style='display: flex' class='warforadd warforCenter'>"+row_one+"</tr>");
        index++;
	});
	
	// Usuwanie i reset pól
	$('#kopia_wiersz').on('click', ".del", function (event) {
		event.preventDefault();
		id_del = $(this).parent().find("input[name='id_edycja[]']").val();  
		//adres_id = $(this).find("input[name='adres_id']").val();
		adres_id = $("input[name='adres_id']").val();	
		nowy_huurder = $("input[name='nowy_huurder']").val();  
		
		//alert(adres_id);
		
		$.ajax(
				{
					type:"POST", 
					url:"js/customer_del_rej.php", 
					data: {
						dane0:id_del,
						adres_id:adres_id,
						nowy_huurder:nowy_huurder
						},
					
						success:function(data) 
						{
							console.log(data); 

						},

						error: function(blad) 
						{
							console.log(blad); 
						}
				});
		$(this).parent().remove();
		sum();
	});
	
});

// function removeWarfor(event) {
        
// 	e.preventDefault();
// 	alert('aaa');
// 		event.preventDefault();
// 		var x = event.which || event.keyCode;
// 		alert(x);
// 	if (e.keyCode != undefined) {
// 		alert('aaa');
// 	// // 
// 		id_del = $(this).parent().find("input[name='id_edycja[]']").val();  
// 		//adres_id = $(this).find("input[name='adres_id']").val();
// 		adres_id = $("input[name='adres_id']").val();	
// 		nowy_huurder = $("input[name='nowy_huurder']").val();  
		
// 		//alert(adres_id);
		
// 		$.ajax(
// 				{
// 					type:"POST", 
// 					url:"js/customer_del_rej.php", 
// 					data: {
// 						dane0:id_del,
// 						adres_id:adres_id,
// 						nowy_huurder:nowy_huurder
// 						},
					
// 						success:function(data) 
// 						{
// 							console.log(data); 

// 						},

// 						error: function(blad) 
// 						{
// 							console.log(blad); 
// 						}
// 				});
// 		$(this).parent().remove();
// 		sum();
// 	}
// };
