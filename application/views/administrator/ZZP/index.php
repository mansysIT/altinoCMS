<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



<?=add_metatags()?>

<?=add_title("ZZP-res")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,all.css,instellingenmenu.css,klanten.css')?>

<?=javascript_load('main.js,sidebar.js,table.js')?> 
    
<?=icon_load("pp_fav.ico")?>
<?php 
$id = model_load('mainmodel', 'getScroolPosition', '');
$zzpData=model_load('ZZPmodel', 'getZZP', '');

$d = new DateTime(date("Y-m-d"));
			
$dOd = new DateTime(date("Y-m-d"));
$dOd->modify('-12 month'); 

// $pageno = 
header("Cache-Control: no-cache, must-revalidate");
header('Cache-Control: max-age=900');
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link href="/application/media/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">

</head>

<body>

	<?=module_load('SIDEBAR')?>
	<div class="container-fluid klantenTable">
		<div class="row">
			<h1 class="title">ZZP-res</h1> 
		</div>
		<div class="row columnAlignText my-auto">
			<div class="col-sm">
			<form class="form-inline klantenForm" method="post" action="">
					<button type="submit" class="btn btn-danger mb-2" name="clear">Clear</button> 
					<div class="form-group mx-sm-3 mb-2">
						<label class="sr-only">Woord</label>
						<input type="text" class="form-control" id="inputPassword2" name="word" placeholder="Key Word" value= <?php if(isset($sidebarController->__params['POST']['clear'])){echo '';} else if(isset($sidebarController->__params['POST']['word'])){echo $sidebarController->__params['POST']['word']; } else if(isset($_SESSION['word'])){echo $_SESSION['word']; } else {echo '';}?> >
					</div>
					<div class="form-group mx-sm-3 mb-2">
						<label class="sr-only">Vanaf</label>
						<input type="date" class="form-control" id="inputPassword2" style="line-height: 20px;" name="vanaf" value=<?php if(isset($sidebarController->__params['POST']['clear'])){echo $dOd->format('Y-m-d');} else if(isset($sidebarController->__params['POST']['vanaf'])){echo $sidebarController->__params['POST']['vanaf']; } else if(isset($_SESSION['vanafYear'])){echo $_SESSION['vanafYear']; } else {echo $dOd->format('Y-m-d'); }?>>
					</div>
					<div class="form-group mx-sm-3 mb-2">
						<label class="sr-only">Tot</label>
						<input type="date" class="form-control aaa" id="inputPassword2" style="line-height: 20px;" name="tot" value= <?php if(isset($sidebarController->__params['POST']['clear'])){echo $d->format('Y-m-d');} else if(isset($sidebarController->__params['POST']['tot'])){echo $sidebarController->__params['POST']['tot']; } else if(isset($_SESSION['totYear'])){echo $_SESSION['totYear']; } else {echo $d->format('Y-m-d'); }?>>
					</div>
					<button type="submit" class="btn btn-danger mb-2" name="zoeken">Zoeken</button>
					<a class="btn btn-danger mb-2" href="administrator/ZZP/ZZP" role="button">Nieuwe</a>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="table-responsive">
				<table class="table table-striped" id="myTable2">
					<thead>
						<tr>
							<th onclick="sortTable(0)">ID</th>
							<th onclick="sortTable(0)">ADRES</th>
							<th onclick="sortTable(0)">STAD</th>
							<th onclick="sortTable(0)">POSTCODE</th>
							<th onclick="sortTable(1)"><?=$zzpData[0][0]?></th>
							<th onclick="sortTable(2)"><?=$zzpData[0][1]?></th>
							<th onclick="sortTable(3)"><?=$zzpData[0][2]?></th>
							<th onclick="sortTable(0)">BEDRAG</th>
							<th onclick="sortTable(4)">TELEFOON</th>
							<th onclick="sortTable(5)">E-MAIL</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach(array_slice($zzpData, 2) as $row): ?>
						<tr id="<?=$row[0]?>">
							<?="<td><a style='color: #000!important;' href='administrator/ZZP/ZZP/$row[0]'>$row[0]</a>" ?></td>
							<?="<td><a style='color: #000!important;' href='administrator/ZZP/ZZP/$row[0]'>$row[6]</a>" ?></td>
							<?="<td><a style='color: #000!important;' href='administrator/ZZP/ZZP/$row[0]'>$row[7]</a>" ?></td>
							<?="<td><a style='color: #000!important;' href='administrator/ZZP/ZZP/$row[0]'>$row[8]</a>" ?></td>
							<?="<td><a style='color: #000!important;' href='administrator/ZZP/ZZP/$row[0]'>$row[1]</a>" ?></td>
							<?="<td><a style='color: #000!important;' href='administrator/ZZP/ZZP/$row[0]'>$row[2]</a>" ?></td>
							<?="<td><a style='color: #000!important;' href='administrator/ZZP/ZZP/$row[0]'>$row[3]</a>" ?></td>
							<?="<td><a style='color: #000!important;' href='administrator/uitgaven/index/zzp/$row[0]'>€ ".number_format($row[9],2,',', '.')."</a>" ?></td>
							<?="<td><a style='color: #000!important;' href='administrator/ZZP/ZZP/$row[0]'>$row[4]</a>" ?></td>
							<?="<td><a style='color: #000!important;' href='administrator/ZZP/ZZP/$row[0]'>$row[5]</a>" ?></td>

						</tr>
						<?php endforeach; ?>
						<tr class="suma">
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="container-fluid">
		<ul class="pagination">
			<?php
			$pageno = $zzpData[1][0];
			$total_pages = $zzpData[1][1];
			$currentPage = $zzpData[1][2];
			
			?>
			<li><a href="administrator/ZZP/index/1">First</a></li>
			<li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
				<a href="<?php if($pageno <= 1){ echo 'administrator/ZZP/index/1'; } else { echo "administrator/ZZP/index/".($pageno - 1); } ?>">Prev</a>
			</li>
			<?php for($x = 1; $x <= $total_pages;$x++): ?>
				<li>
					<a <?php if($currentPage == $x){ echo "style='color: red!important;'"; } ?> href="administrator/ZZP/index/<?=$x?>"><?=$x?></a>
				</li>
			<?php endfor; ?>
			<li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
				<a href="<?php if($pageno >= $total_pages){ echo 'administrator/ZZP/index/'.$total_pages; } else { echo "administrator/ZZP/index/".($pageno + 1); } ?>">Next</a>
			</li>
			<li><a href="administrator/ZZP/index/<?=$total_pages?>">Last</a></li>
		</ul>
		</div>
		<div class="row">
			<div class="col-sm">
				<?=module_load('FOOTER')?>
			</div>
		</div>
    </div>
           
</body>
</html>
<script language="JavaScript" type="text/javascript">
$("html, body").animate({
scrollTop: $("#<?=$id?>").offset().top -155
}, 1000);
</script>
