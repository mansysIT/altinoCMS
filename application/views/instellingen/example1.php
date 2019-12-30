<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<?=add_metatags()?>

<?=add_title("Design Klasy biznes - SuperCMS")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,all.css,instellingen.css,instellingenmenu.css')?>

<?=javascript_load('table.js,jQuery.js,script.js,jquery.localscroll-1.2.5.js,coda-slider.js?no_compress,jquery.scrollTo-1.3.3.js,jquery.serialScroll-1.2.1.js,main.js,sidebar.js,sidebar.js,')?> 
    
<?=icon_load("pp_fav.ico")?>
<?=include_once('adressen.php');
$sidebarController = new instellingen(); ?>

<script src="/application/media/js/sidebar.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>

<body>
 
	<?=module_load('SIDEBAR')?>
    <div class="stedenlijstholder">
    <?=module_load('instellingenmenu')?>
    <div class="maincontainer">
        <h1>EXAMPLE 1</h1>
    </div>
	<?=module_load('FOOTER')?>
	</div>
</body>
</html>