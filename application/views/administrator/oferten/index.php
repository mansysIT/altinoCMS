<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<?=add_metatags()?>

<?=add_title("Adressen Alle")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,all.css,instellingenmenu.css')?>

<?=javascript_load('main.js,sidebar.js,table.js')?> 
    
<?=icon_load("pp_fav.ico")?>
<?php 
$adress=model_load('adressenmodel', 'getAdress', '');
$proforma=model_load('ofertenmodel', 'getoferten', '');

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
	<h1>Oferten</h1> 
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
		<a class="btn btn-danger mb-2" href="administrator/oferten/addoferten" role="button">+Oferten</a>
	</form>

	<div class="table-responsive">
	<table class="table table-striped" id="myTable2">
		<thead>
				<tr>
					<th onclick="sortTable(0)">ID</th>
					<th onclick="sortTable(1)">STAD</th>
					<th onclick="sortTable(2)">ADRES</th>
					<th onclick="sortTable(3)">BEDRAG</th>
					<th onclick="sortTable(4)">INKOMSTEN</th>
					<th onclick="sortTable(5)">UITGAVEN</th>
					<th onclick="sortTable(6)">WINST</th>
					<th onclick="sortTable(8)">DATUM</th>
					<th>STATUS</th>
				</tr>
		</thead>
		<tbody>
			<?php foreach($proforma as $row): ?>
				<tr>
					<?="<td><a style='color: #000!important;' href='administrator/adressen/adres/$row[0]'>$row[0]</a>" ?></td>
					<?="<td><a style='color: #000!important;' href='administrator/adressen/adres/$row[0]'>$row[1]</a>" ?></td>
					<?="<td><a style='color: #000!important;' href='administrator/adressen/adres/$row[0]'>$row[2]</a>" ?></td>
					<?="<td><a style='color: #000!important;' href='administrator/adressen/adres/$row[0]'>0.00</a>" ?></td>
					<?="<td><a style='color: #000!important;' href='administrator/adressen/adres/$row[0]'>0.00</a>" ?></td>
					<?="<td><a style='color: #000!important;' href='administrator/adressen/adres/$row[0]'>0.00</a>" ?></td>
					<?="<td><a style='color: #000!important;' href='administrator/adressen/adres/$row[0]'>0.00</a>" ?></td>
					<?="<td><a style='color: #000!important;' href='administrator/proforma/editproforma/$row[4]'>$row[3]</a>" ?></td>
					<td><span <?php if($row[4] == 0){ echo "style='color: orange'"; } else if($row[4] == 1) { echo "style='color: green'"; } else if($row[4] == 2) { echo "style='color: red'"; }?>  class="oi oi-media-record" title="media-record" aria-hidden="true"></span></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
		</table>
	</div>
	<?=module_load('FOOTER')?>
	</div>
</body>
</html>
