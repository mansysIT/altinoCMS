<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<?=add_metatags()?>

<?=add_title("Proforma")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,all.css, instellingenmenu.css')?>

<?=javascript_load('jQuery.js,script.js,jquery.localscroll-1.2.5.js,coda-slider.js?no_compress,jquery.scrollTo-1.3.3.js,jquery.serialScroll-1.2.1.js,main.js,sidebar.js,table.js')?> 
    
<?=icon_load("pp_fav.ico")?>
<?php 
model_load('proformamodel', 'removeproforma', '');
$proforma=model_load('proformamodel', 'getproforma', '');


$d = new DateTime(date("Y-m-d"));
			
$dOd = new DateTime(date("Y-m-d"));
$dOd->modify('first day of this month'); 

?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link href="/application/media/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">

</head>

<body>

	<?=module_load('SIDEBAR')?>

	<div class="tableholder">
	<h1>Proforma</h1> 
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
		<a class="btn btn-danger mb-2" href="administrator/proforma/addproforma" role="button">+Proforma</a>
	</form>

	<div class="table-responsive">
	<table class="table table-striped" id="myTable2">
		<thead>
				<tr>
					<th onclick="sortTable(0)">ID</th>
					<th onclick="sortTable(2)">STAD</th>
					<th onclick="sortTable(3)">ADRES</th>
					<th onclick="sortTable(4)">OFFERTEN</th>
					<th onclick="sortTable(5)">BEDRAG</th>
					<th onclick="sortTable(6)">PROFORMA</th>
					<th onclick="sortTable(8)">DATUM</th>
					<th onclick="sortTable(7)">ACTION</th>
				</tr>
		</thead>
		<tbody>
        
			<?php foreach($proforma as $row): ?>
				<?php print_r($row) ?>
				<tr <?php if($row[6] == 0){echo "class='proformared'"; } else { echo "class='proformablack'"; } ?>>
					<?="<td> <a href='administrator/proforma/sendproforma/$row[4]/$row[0]'>$row[0]</a><a href='administrator/proforma/sendproforma/$row[4]/$row[0]'> <span class='oi oi-envelope-closed' title='envelope-closed' aria-hidden='true'></span></a> " ?></td>
					<?="<td> <a href='administrator/proforma/editproforma/$row[4]'>$row[1]</a>" ?></td>
					<?="<td> <a href='administrator/proforma/editproforma/$row[4]'>$row[3]</a>" ?></td>
					<?="<td> <a href='administrator/proforma/editproforma/$row[4]'>€ ".number_format($row[6],2,',', '.')."</a>" ?></td>
					<?="<td> <a href='administrator/proforma/index/$row[4]/$row[0]'>$row[4]</a><a href='administrator/proforma/index/$row[4]/$row[0]'> <span class='oi oi-file' title='file' aria-hidden='true'></span></a> " ?></td>
					<?="<td> <a href='administrator/proforma/editproforma/$row[4]'>$row[5]</a>" ?></td>
					<td> <form  method="post" action=""><button class="btnCityRemove" type="submit" name="proformremove" value="<?php echo $row[0]; ?>"><span class="oi oi-trash" title="trash" aria-hidden="true"></span></button></form></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
		</table>
	</div>
	<?=module_load('FOOTER')?>
	</div>
</body>
</html>
