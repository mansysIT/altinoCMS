<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<?=add_metatags()?>

<?=add_title("Dashboard")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,all.css,instellingenmenu.css,klanten.css,dashboard.css')?>

<?=javascript_load('main.js,sidebar.js')?> 
    
<?=icon_load("pp_fav.ico")?>

<?php 

$BtwValue = model_load('dashboardmodel', 'getAllStatistic', '');

// print_r($BtwValue[4]);

$d = new DateTime(date("Y-m-d"));
			
$dOd = new DateTime(date("Y-m-d"));
// $dOd->modify('-12 month');
$dOd->modify('first day of this month');

?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</head>

<body>
 
<?=module_load('SIDEBAR')?>
<div class="container-fluid dashboard">
    <div class="row">
        <h1 class="title">DASHBOARD</h1> 
    </div>
    <div class="row columnAlignText my-auto">
        <div class="col-sm">
        <form class="form-inline dashboardForm" method="post" action="">
                <button type="submit" class="btn btn-danger mb-2" name="clear">Clear</button> 
                <div class="form-group mx-sm-3 mb-2">
                    <h4>Vanaf</h4>
                    <input type="date" class="form-control" id="inputPassword2" style="line-height: 20px;" name="vanafStatistic" value=<?php if(isset($sidebarController->__params['POST']['clear'])){echo $dOd->format('Y-m-d');} else if(isset($sidebarController->__params['POST']['vanafStatistic'])){echo $sidebarController->__params['POST']['vanafStatistic']; } else if(isset($_SESSION['vanafStatistic'])){echo $_SESSION['vanafStatistic']; } else {echo $dOd->format('Y-m-d'); }?>>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <h4>Tot</h4>
                    <input type="date" class="form-control aaa" id="inputPassword2" style="line-height: 20px;" name="totStatistic" value= <?php if(isset($sidebarController->__params['POST']['clear'])){echo $d->format('Y-m-d');} else if(isset($sidebarController->__params['POST']['totStatistic'])){echo $sidebarController->__params['POST']['totStatistic']; } else if(isset($_SESSION['totStatistic'])){echo $_SESSION['totStatistic']; } else {echo $d->format('Y-m-d'); }?>>
                </div>
                <button type="submit" class="btn btn-danger mb-2" name="zoeken">Zoeken</button>
            </form>
        </div>
    </div>
    <div class="row mainContainer"> 
        <div class="col-sm-6 noPadding">
            <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="row">
                        <h1 class="contentCenter">INKOMSTEN</h1>
                    </div>
                    <div class="row borderBottom">
                        <h2 class="contentCenter ">BTW</h2>
                    </div>
                    <?php foreach($BtwValue[0] as $row => $stawki_vat): ?>
                        <div class="row borderBottom margin-top-8">
                            <div class="col-5">
                                <h4><?=$row?> %</h4>
                            </div>
                            <div class="col-7 noPadding col-sm-offset-2">
                                <div class="row">
                                    <div class="col-3 noPadding text-right">
                                        <h4>€</h4>
                                    </div>
                                    <div class="col-9 noPadding text-right">
                                        <h4><?=number_format($stawki_vat,2,',', '.')?></h4>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="row borderTop">
                        <div class="col-5">
                            <h4>Totaal</h4>
                        </div>
                        <div class="col-7 noPadding col-sm-offset-2">
                            <div class="row">
                                <div class="col-3 noPadding text-right">
                                    <h4>€</h4>
                                </div>
                                <div class="col-9 noPadding text-right">
                                    <h4><?=number_format($BtwValue[1],2,',', '.')?></h4>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="row margin-top-40 borderBottom">
                        <div class="row contentCenter">
                            <h2 class="contentCenter ">TOTAAL INKOMSTEN</h2>
                        </div>
                    </div>
                    <div class="row contentCenter">
                        <h3 class="contentCenter "><?="€ ".number_format($BtwValue[4],2,',', '.')?></h3>
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
                    <h2 class="contentCenter ">BTW</h2>
                </div>
                    <?php foreach($BtwValue[2] as $row => $stawki_vat): ?>
                        <div class="row borderBottom margin-top-8">
                            <div class="col-5">
                                <h4><?=$row?> %</h4>
                            </div>
                            <div class="col-7 noPadding col-sm-offset-2">
                                <div class="row">
                                    <div class="col-3 noPadding text-right">
                                        <h4>€</h4>
                                    </div>
                                    <div class="col-9 noPadding text-right">
                                        <h4><?=number_format($stawki_vat,2,',', '.')?></h4>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="row borderTop">
                        <div class="col-5">
                            <h4>Totaal</h4>
                        </div>
                        <div class="col-7 noPadding col-sm-offset-2">
                            <div class="row">
                                <div class="col-3 noPadding text-right">
                                    <h4>€</h4>
                                </div>
                                <div class="col-9 noPadding text-right">
                                    <h4><?=number_format($BtwValue[3],2,',', '.')?></h4>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="row margin-top-40 borderBottom">
                        <div class="row contentCenter">
                            <h2 class="contentCenter ">TOTAAL UITGAVEN</h2>
                        </div>
                    </div>
                    <div class="row contentCenter">
                        <h3 class="contentCenter "><?="€ ".number_format($BtwValue[5],2,',', '.')?></h3>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row ">
                <div class="col-sm-4"></div>
                <div class="col-sm-4 contentCenter margin-top-40 ">
                    <div class="row borderBottom ">
                        <h1 class="contentCenter">WINST</h1>
                    </div>
                    <div class="row">
                        <?php $winst = $BtwValue[4] - $BtwValue[5] ?>
                        <h3 class="contentCenter" <?php  if($winst < 0) { echo "style='color: red!important;'"; } else { echo "style='color: green!important;'"; } ?>><?="€ ".number_format($winst,2,',', '.')?></h3>
                    </div>
                </div>
                <div class="col-sm-4"></div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <?=module_load('FOOTER')?>
    </div>
</div>	
</body>
</html>