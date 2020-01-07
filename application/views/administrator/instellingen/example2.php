<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<?=add_metatags()?>

<?=add_title("Design Klasy biznes - SuperCMS")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,all.css,instellingen.css,instellingenmenu.css')?>

<?=javascript_load('jQuery.js,script.js,jquery.localscroll-1.2.5.js,coda-slider.js?no_compress,jquery.scrollTo-1.3.3.js,jquery.serialScroll-1.2.1.js,main.js,sidebar.js')?> 
    
<?=icon_load("pp_fav.ico")?>
<?=include_once('adressen.php');
$sidebarController = new instellingen(); ?>

</head>

<body>
 
	<?=module_load('SIDEBAR')?>
    <div class="stedenlijstholder">
    <?=module_load('instellingenmenu')?>
    <div class="maincontainer">
        <h1>EXAMPLE 2</h1>
    </div>
	<?=module_load('FOOTER')?>
	</div>
</body>
</html>