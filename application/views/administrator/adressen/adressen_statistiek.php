<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

<meta name="viewport" content="width=device-width, initial-scale=0.7, shrink-to-fit=no">

<?=add_metatags()?>

<?=add_title("Dashboard")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,all.css,instellingenmenu.css,klanten.css,dashboard.css,nieuwe_adress.css')?>

<?=javascript_load('main.js,sidebar.js')?> 
    
<?=icon_load("pp_fav.ico")?>

<?php $getDataFromAdres=model_load('adressenmodel', 'getAdressById', '')?>

<?php 

$BtwValue = model_load('dashboardmodel', 'getAllStatistic', '');
$yearForChart = model_load('dashboardmodel', 'getYearForChart', '');
$waarvoorValue = model_load('adressenmodel', 'AllWaarfoor', '');
$waarvoorValueUitgaven = model_load('adressenmodel', 'AllWaarfoorUitgaven', '');

// print_r($waarvoorValue);

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
<div class="Mycontainer">
    <h1 class="title">
    <?=$getDataFromAdres['city']." ".$getDataFromAdres['adres']?>
    </h1> 
    <?=module_load('adresmenu')?>
<?php if(true): ?>
    <div class="row mainContainer"> 
    
        <div class="col-sm-6 noPadding">
            <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="row">
                        <h1 class="contentCenter">INKOMSTEN</h1>
                    </div>
                    <div class="row borderBottom">
                        <h2 class="contentCenter ">WAARVOOR</h2>
                    </div>
                    <div class="row" id="inkomstenWaarvoorHeight">
                        <div class="col-sm-12 noPadding" >
                            <?php foreach($waarvoorValue as $row => $stawki_vat): ?>
                                <div class="row borderBottom margin-top-8">
                                    <div class="col-7">
                                        <h4><?=$row?></h4>
                                    </div>
                                    <div class="col-5 noPadding col-sm-offset-2">
                                        <div class="row">
                                            <div class="col-3 noPadding text-right">
                                                <h4>€</h4>
                                            </div>
                                            <div class="col-9 noPadding text-right">
                                                <?php $waarvoorTotalInkomsten += $stawki_vat; ?>
                                                <h4 style="color: black!important" ><?=number_format($stawki_vat,2,',', '.')?></a></h4>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="row borderTop">
                        <div class="col-7">
                            <h4>Totaal</h4>
                        </div>
                        <div class="col-5 noPadding col-sm-offset-2">
                            <div class="row">
                                <div class="col-3 noPadding text-right">
                                    <h4>€</h4>
                                </div>
                                <div class="col-9 noPadding text-right">
                                    <h4><?=number_format($waarvoorTotalInkomsten,2,',', '.')?></h4>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
        <div class="col-sm-6 noPadding">
            <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="row">
                    <h1 class="contentCenter">UITGAVEN</h1>
                </div>
                <div class="row borderBottom">
                        <h2 class="contentCenter ">WAARVOOR</h2>
                    </div>
                    <div class="row" id="uitgavenWaarvoorHeight">
                        <div class="col-sm-12 noPadding" >
                            <?php foreach($waarvoorValueUitgaven as $row => $stawki_vat): ?>
                                <div class="row borderBottom margin-top-8">
                                    <div class="col-7">
                                        <h4><?=$row?></h4>
                                    </div>
                                    <div class="col-5 noPadding col-sm-offset-2">
                                        <div class="row">
                                            <div class="col-3 noPadding text-right">
                                                <h4>€</h4>
                                            </div>
                                            <div class="col-9 noPadding text-right">
                                            <?php $waarvoorTotalUitgaven += $stawki_vat; ?>
                                                <h4 style="color: black!important" ><?=number_format($stawki_vat,2,',', '.')?></a></h4>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="row borderTop">
                        <div class="col-7">
                            <h4>Totaal</h4>
                        </div>
                        <div class="col-5 noPadding col-sm-offset-2">
                            <div class="row">
                                <div class="col-3 noPadding text-right">
                                    <h4>€</h4>
                                </div>
                                <div class="col-9 noPadding text-right">
                                    <h4><?=number_format($waarvoorTotalUitgaven,2,',', '.')?></h4>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
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
$(document).ready(function () {
    $("#datepicker").datepicker({
    format: "yyyy",
    viewMode: "years", 
    minViewMode: "years"
});
});
		window.onload = function() {

            var inkomstenWaarvoorHeight = document.getElementById('inkomstenWaarvoorHeight');
            var uitgavenWaarvoorHeight = document.getElementById('uitgavenWaarvoorHeight');

            var inkomsten = inkomstenWaarvoorHeight.style;
            var uitgaven = uitgavenWaarvoorHeight.style;

            if(inkomstenWaarvoorHeight.offsetHeight >= uitgavenWaarvoorHeight.offsetHeight){
                uitgaven.height = inkomstenWaarvoorHeight.offsetHeight + "px";
            } else {
                inkomsten.height = uitgavenWaarvoorHeight.offsetHeight + "px";
            }

		};


</script>