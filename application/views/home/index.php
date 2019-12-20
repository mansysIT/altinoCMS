<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>

<?=add_metatags()?>

<?=add_title("Design Klasy biznes - SuperCMS")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css')?>

<?=javascript_load('table.js,jQuery.js,script.js,jquery.localscroll-1.2.5.js,coda-slider.js?no_compress,jquery.scrollTo-1.3.3.js,jquery.serialScroll-1.2.1.js,main.js,sidebar.js')?> 
    
<?=icon_load("pp_fav.ico")?>
<?=include_once($_SERVER['DOCUMENT_ROOT'].'/application/controllers/home.php');
$sidebarController = new home(); ?>

<script src="/application/media/js/table.js"></script>

</head>

<body>
 
	<?=module_load('SIDEBAR')?>
	<button id="sidebarCollapse">X</button>
	<div class="tableholder">
	<form class="form-inline">
		<div class="form-group mx-sm-3 mb-2">
			<label class="sr-only">Woord</label>
			<input type="text" class="form-control" id="inputPassword2" placeholder="Key Word">
		</div>
		<div class="form-group mx-sm-3 mb-2">
			<label class="sr-only">Vanaf</label>
			<input type="date" class="form-control" id="inputPassword2">
		</div>
		<div class="form-group mx-sm-3 mb-2">
			<label class="sr-only">Tot</label>
			<input type="date" class="form-control" id="inputPassword2" value="1999-11-11">
		</div>
		<button type="submit" class="btn btn-danger mb-2">Confirm identity</button>
	</form>
	<div class="table-responsive">
	<table class="table table-striped" id="myTable2">
		<thead>
				<tr>
					<th onclick="sortTable(0)">Id</th>
					<th onclick="sortTable(1)">City</th>
					<th onclick="sortTable(2)">Adres</th>
					<th onclick="sortTable(3)">Borg</th>
					<th onclick="sortTable(4)">Varfor</th>
					<th onclick="sortTable(5)">water</th>
					<th onclick="sortTable(6)">imie</th>
					<th onclick="sortTable(7)">nazwisko</th>
					<th onclick="sortTable(8)">email</th>
					<th onclick="sortTable(9)">kod</th>
					<th onclick="sortTable(9)">Data2</th>
					<th onclick="sortTable(9)">Data3</th>
				</tr>
		</thead>
		<tbody>
			<?php foreach($sidebarController->getAdress() as $row): ?>
				<tr>
					<td><a style="color: #000!important;" href="#"><?php echo $row[0]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[1]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[2]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[3]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[4]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[5]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[6]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[7]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[8]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[9]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[11]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[13]; ?></a></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
		</table>
	</div>
	</div>
</body>
</html>
