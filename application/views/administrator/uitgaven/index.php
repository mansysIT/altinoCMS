<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<?=add_metatags()?>

<?=add_title("Uitagven")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,all.css,instellingenmenu.css')?>

<?=javascript_load('sidebar.js,table.js')?> 
    
<?=icon_load("pp_fav.ico")?>



<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link href="/application/media/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">

</head>


<?php 
$id = model_load('mainmodel', 'getScroolPosition', '');
$adress=model_load('uitgavenmodel', 'removeUitgaaf', '');
$adress=model_load('uitgavenmodel', 'getFactur', ''); 
//$waarvoor=model_load('waarvoormodel', 'getwaarvoor', '1');

//print_r($waarvoor); 
 
$d = new DateTime(date("Y-m-d"));

$dOd = new DateTime(date("Y-m-d"));
$dOd->modify('first day of this month');   


?> 

<body>

	<?=module_load('SIDEBAR')?>

	<div class="tableholder">
    <h1>Uitagven</h1> 
	<form class="form-inline" method="post" action="">
		<button type="submit" class="btn btn-danger mb-2" name="clear">Clear</button> 
		<div class="form-group mx-sm-3 mb-2">
			<label class="sr-only">Woord</label>
			<input type="text" class="form-control" id="inputPassword2" name="word" placeholder="Key Word" value= <?php if(isset($sidebarController->__params['POST']['clear'])){echo '';} else if(isset($sidebarController->__params['POST']['word'])){echo $sidebarController->__params['POST']['word']; } else if(isset($_SESSION['word'])){echo $_SESSION['word']; } else {echo '';}?> >
		</div>
		<div class="form-group mx-sm-3 mb-2">
			<label class="sr-only">Vanaf</label>
			<input type="date" class="form-control" id="inputPassword2" style="line-height: 20px;" name="vanaf" value=<?php if(isset($sidebarController->__params['POST']['clear'])){echo $dOd->format('Y-m-d');} else if(isset($sidebarController->__params['POST']['vanaf'])){echo $sidebarController->__params['POST']['vanaf']; } else if(isset($_SESSION['vanaf'])){echo $_SESSION['vanaf']; } else {echo $dOd->format('Y-m-d'); }?>>
		</div>
		<div class="form-group mx-sm-3 mb-2">
			<label class="sr-only">Tot</label>
			<input type="date" class="form-control aaa" id="inputPassword2" style="line-height: 20px;" name="tot" value= <?php if(isset($sidebarController->__params['POST']['clear'])){echo $d->format('Y-m-d');} else if(isset($sidebarController->__params['POST']['tot'])){echo $sidebarController->__params['POST']['tot']; } else if(isset($_SESSION['tot'])){echo $_SESSION['tot']; } else {echo $d->format('Y-m-d'); }?>>
		</div>
        <button type="submit" class="btn btn-danger mb-2" name="zoeken">Zoeken</button>
		<a class="btn btn-danger mb-2" href="administrator/uitgaven/addUitgaaf" role="button">+Uitgaven</a> 
	</form> 

	<div class="table-responsive"> 
	<table class="table table-striped" id="myTable2">
		<thead>
				<tr>
					<th onclick="sortTable(0)">ID</th>
					<th onclick="sortTable(1)">STAD</th>
					<th onclick="sortTable(2)">ADRES</th>
					<th onclick="sortTable(3)">OFFERTEN</th> 
					<th onclick="sortTable(4)">WAARVOOR</th>  
					<th onclick="sortTable(5)">BEDRAG</th>
					<th onclick="sortTable(6)">DATUM</th>
					<th>FILE</th>
					<th>ACTION</th>
				</tr>
		</thead>
		<tbody>
			
        
			<?php 
			$total  = 0;
			
			foreach($adress as $k=>$row): 
				$files = model_load('uitgavenmodel', 'getAllFilesFromUitgaven', $row[0]);
				$w = model_load('mainmodel', 'getwaarvoor', $row[6]); 

                if ($row[6] != 0) {
                    $waar = $w[0][1];
                } else {
					$waar = null;
				}
				$total += $row[4];

				$file = $files[1][0];

				if(isset($file)){
					$fileRow = " <a style='color: #000!important;' href='/application/storage/uitgaven/$row[0]/$file'><span class='oi oi-image' title='image' aria-hidden='true'></span></a>";
				} else {
					$fileRow = "";
				}

				$d = new DateTime(date($row[5]));
				
				// $w = '';
				// echo '<pre>';
				// $w =  $waarvoor[$k][1];  
				// //print_r($waarvoor);
				// echo '<br>bbb:'.$w;
				?>  
				<tr id="<?=$row[0]?>">
					<td><?=" <a style='color: #000!important;' href='administrator/uitgaven/addUitgaaf/$row[0]'>$row[0]</a>" ?></td>
					<td><?=" <a style='color: #000!important;' href='administrator/uitgaven/addUitgaaf/$row[0]'>$row[1]</a>" ?></td>
					<td><?=" <a style='color: #000!important;' href='administrator/uitgaven/addUitgaaf/$row[0]'>$row[2]</a>" ?></td>
					<td><?=" <a style='color: #000!important;' href='administrator/uitgaven/addUitgaaf/$row[0]'>$row[3]</a>" ?></td>
					<td><?=" <a style='color: #000!important;' href='administrator/uitgaven/addUitgaaf/$row[0]'>$waar</a>" ?></td> 
					<td><?=" <a style='color: #000!important;' href='administrator/uitgaven/addUitgaaf/$row[0]'>€ ".number_format($row[4],2,',', '.')."</a>" ?></td>
					<td><?=" <a style='color: #000!important;' href='administrator/uitgaven/addUitgaaf/$row[0]'>".$d->format('d-m-Y')."</a>"?></td>
					<td><?=$fileRow?></td>
					<td> <form  method="post" action=""><button class="btnCityRemove" type="submit" name="uitgaafremove" value="<?php echo $row[0]; ?>"><span class="oi oi-trash" title="trash" aria-hidden="true"></span></button></form></td>
				</tr>
			<?php endforeach; ?> 

			<tr class="suma">
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td><?="€ ".number_format($total,2,',', '.')."" ?></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
		</table>
	</div>
	<?=module_load('FOOTER')?>
	</div>
</body>
</html>
<script language="JavaScript" type="text/javascript">
$("html, body").animate({
scrollTop: $("#<?=$id?>").offset().top -155
}, 1000);
</script>
