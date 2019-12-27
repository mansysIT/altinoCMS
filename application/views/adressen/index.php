<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">





<?=add_metatags()?>

<?=add_title("Design Klasy biznes - SuperCMS")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,all.css')?>

<?=javascript_load('table.js,jQuery.js,script.js,jquery.localscroll-1.2.5.js,coda-slider.js?no_compress,jquery.scrollTo-1.3.3.js,jquery.serialScroll-1.2.1.js,main.js,sidebar.js')?> 
    
<?=icon_load("pp_fav.ico")?>
<?=include_once('adressen.php');

$sidebarController = new adressen(); ?>

<script src="/application/media/js/table.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>

<body>

	<?=module_load('SIDEBAR')?>

	<div class="tableholder">
	<form class="form-inline" method="post" action="">
		<button type="submit" class="btn btn-danger mb-2" name="clear">Clear</button> 
		<div class="form-group mx-sm-3 mb-2">
			<label class="sr-only">Woord</label>
			<input type="text" class="form-control" id="inputPassword2" name="word" placeholder="Key Word" value= <?php if(isset($sidebarController->__params['POST']['clear'])){echo '';} else if(isset($sidebarController->__params['POST']['word'])){echo $sidebarController->__params['POST']['word']; } else if(isset($_SESSION['word'])){echo $_SESSION['word']; } else {echo '';}?> >
		</div>
		<div class="form-group mx-sm-3 mb-2">
			<label class="sr-only">Vanaf</label>
			<input type="date" class="form-control" id="inputPassword2" style="line-height: 20px;" name="vanaf" value=<?php if(isset($sidebarController->__params['POST']['clear'])){echo '2019-01-01';} else if(isset($sidebarController->__params['POST']['vanaf'])){echo $sidebarController->__params['POST']['vanaf']; } else if(isset($_SESSION['vanaf'])){echo $_SESSION['vanaf']; } else {echo '2019-01-01'; }?>>
		</div>
		<div class="form-group mx-sm-3 mb-2">
			<label class="sr-only">Tot</label>
			<input type="date" class="form-control aaa" id="inputPassword2" style="line-height: 20px;" name="tot" value= <?php if(isset($sidebarController->__params['POST']['clear'])){echo '2019-12-31';} else if(isset($sidebarController->__params['POST']['tot'])){echo $sidebarController->__params['POST']['tot']; } else if(isset($_SESSION['tot'])){echo $_SESSION['tot']; } else {echo '2019-12-31'; }?>>
		</div>
        <button type="submit" class="btn btn-danger mb-2">Zoeken</button>
		<a class="btn btn-danger mb-2" href="nieuwe_adress/index" role="button">Nieuwe</a>
		<?php if(isset($sidebarController->__params['POST']['active']) && $sidebarController->__params['POST']['active'] == 0):?>
			<button type="submit" class="btn btn-danger mb-2" name="active" value="1">Aactive</button>
		<?php else: ?>
			<button type="submit" class="btn btn-danger mb-2" name="active" value="0">Niet active</button>
		<?php endif; ?>
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
				</tr>
		</thead>
		<tbody>
			<?php foreach($sidebarController->getAdress() as $row): ?>
				<tr>
					<td><a style="color: #000!important;" href="#"><?php echo $row[0]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[13]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[2]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[3]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[4]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[5]; ?></a></td>
					<td><a style="color: #000!important;" href="#"><?php echo $row[6]; ?></a></td>
					<td><span class="glyphicon glyphicon-search" aria-hidden="true"></span></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
		</table>
	</div>
	<?=module_load('FOOTER')?>
	</div>
</body>
</html>
