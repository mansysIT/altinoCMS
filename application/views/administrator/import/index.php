<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> 

<meta name="viewport" content="width=device-width, initial-scale=0.7, shrink-to-fit=no">

<?=add_metatags()?>

<?=add_title("Dashboard")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,nieuwe_adress.css,factur.css')?>

<?=javascript_load('main.js,sidebar.js,nieuwe_adress.js,addfileds.js')?> 
    
<?=icon_load("pp_fav.ico")?>

<?php 

$BtwValue = model_load('dashboardmodel', 'getAllStatistic', '');
$yearForChart = model_load('dashboardmodel', 'getYearForChart', '');
$waarvoorValue = model_load('dashboardmodel', 'AllWaarfoor', '');
$waarvoorValueUitgaven = model_load('dashboardmodel', 'AllWaarfoorUitgaven', '');
$data = model_load('importmodel', 'getCurrentData', ''); 
model_load('importmodel', 'importen', '');

$waarvoorTotalInkomsten = 0;
$waarvoorTotalUitgaven = 0;

$d = new DateTime(date("Y-m-d"));
			
$dOd = new DateTime(date("Y-m-d"));
// $dOd->modify('-12 month');
$dOd->modify('first day of this month');

?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>

</head>

<body>
 
<?=module_load('SIDEBAR')?>
<div class="container-fluid dashboard">
    <div class="row">
        <h1 class="title">IMPORTEN</h1> 
    </div>
<?php if(true): ?>
    <div class="maincontainer">
        <div class="row"> 
            <div class="col-sm-12">
                <h3>Import inkomsten en uitgaven</h3>
            </div>
        </div>
        <div class="row"> 
            <div class="col-sm-12">
                <h5>Laatse geimporteerd periode: <?=date('d-m-Y', $data[1])." - ".date('d-m-Y', $data[0])?></h5>
            </div>
        </div>
        <div class="row"> 
            <div class="col-sm-12">
                <h5>Bestand:</h5>
            </div>
        </div>
        <div class="row"> 
            <div class="col-sm-12">
                <form action="" method="post" enctype="multipart/form-data">

                    <div class="row"> 
                        <div class="col-sm-12">
                            <input type="file" name="fileToUpload" id="fileToUpload">
                        </div>
                    </div>
                    
                    <div class="row"> 
                        <div class="col-sm-12">
                            <button type="button" id="showModal" class="btn btn-danger mb-2 btn-small">IMPORTEEREN</button>
                        </div>
                    </div>
    <div class="modal fade" id="myModal" role="dialog" >
		<div class="modal-dialog">
		
		  <!-- Modal content-->
		 <div id="lista" class="modal-content"> 
			<div class="modal-header">
			  <h3 class="modal-title text-center">
			  Fout
			  </h3>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  
			</div>
			<div class="modal-body">
				<h5 id="fault"></h5>
				<ul style="color: red; list-style-type: none;" id="modalBody">
				</ul>
			</div>
			<div class="modal-footer">

					<button style=" padding: 8px 10px;background-color: black; border: none; color: white"  type="button" data-dismiss="modal" class="dodaj">Discard</button>
					</a>
					<input name="importen" value="IMPORTEEREN" type="submit">
			</div>
		  </div>
		  
		</div>
	  </div>  
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
    <div class="row justify-content-center">
        <?=module_load('FOOTER')?>
    </div>
</div>
</body>
</html>
<script>
jQuery(document).ready(function(){
		   // $("#myBtn").click(function(){
			   
			   <?php
			   //echo $showModal;
			  // if(true)
				//   echo 'jQuery("#myModal").modal({show: true});';
				//else
				//   echo 'jQuery("#myModal").modal({show: false});';	
			   
			   ?>
			   
		
		
		
			
		   // });

			jQuery("#myBtn2").click(function(){
				jQuery("#myModal").modal({show: false});
			});
			jQuery("#sidebar button").click(function(){
				jQuery("#myModal").modal({show: true});
			});
});

$('#showModal').on('click', function () {
removeWarfor();
 jQuery("#myModal").modal({show: true});
})

function removeWarfor() {      
    var pictures = $("#fileToUpload").prop('files')[0];
	var form_data = new FormData(); 
    form_data.append('pictures', pictures);
    var dataString = {
        action: "checkFileToUpload",
        pictures: pictures
        };
        
        $.ajax
        ({
            url: "application/views/administrator/import/importiren_file.php",
			dataType: 'text',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
            success: function(html)
            {
                //res = html;
                //alert(html); 
				if(html != ''){
					$("#fault").html('Overmaken onder vorige datum');
				} else {
					$("#fault").html('Er is geen fouten');
				}

				$("#modalBody").html(html);
            }
        });
	};
</script>
