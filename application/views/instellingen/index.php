<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<?=add_metatags()?>

<?=add_title("Design Klasy biznes - SuperCMS")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,all.css,instellingen.css')?>

<?=javascript_load('table.js,jQuery.js,script.js,jquery.localscroll-1.2.5.js,coda-slider.js?no_compress,jquery.scrollTo-1.3.3.js,jquery.serialScroll-1.2.1.js,main.js,sidebar.js')?> 
    
<?=icon_load("pp_fav.ico")?>
<?=include_once('adressen.php');
$sidebarController = new instellingen(); ?>

<script src="/application/media/js/table.js"></script>

</head>

<body>
 
	<?=module_load('SIDEBAR')?>
	<div class="tableholder">
    <?=module_load('instellingenmenu')?>
	<form class="form-inline" method="post" action="">

		<div class="form-group mx-sm-3 mb-2">
        <label class="sr-only">Stad Name</label>
			<input type="text" class="form-control" id="inputPassword2" name="cityname" placeholder="Stad Name">
		</div>
        <button type="submit" class="btn btn-danger mb-2">Toevoegen</button>

    </form>
    


	
	<?=module_load('FOOTER')?>
	</div>
</body>
</html>
