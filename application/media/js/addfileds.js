function nowywiersz(index, row_one, id )
{
	index++;

		$(".nag").parent().append(row_one).children().last().attr("id", "nag_" + index);
}

function zamiana_daty(date)
{
	var tab = date.split("-");
	return tab[2]+"-"+tab[1]+"-"+tab[0];
}

$(document).ready(function () {


    
	var row_one = $(".nag:first").html();   
	var fields_line_one = $(".nag").find("input, select, textarea");
	var index = 1; 
	var id_adres = $("#aaa").attr("value");

	

	$(".nag").first().attr("id", "nag_1");

	//dodanie nowego wiersza, nadanie id i walidacji

    $('#dodaj').on('click', function () {

		nowywiersz(index, "<tr style='display: flex' class=warforadd'>"+row_one+"</tr>");
        index++;
    });

	//Usuwanie i reset pól
	$('#kopia_wiersz').on('click', ".del", function (e) {
		e.preventDefault();
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

	});
	
	
});
