<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



<?=add_metatags()?>

<?=add_title("Design Klasy biznes - SuperCMS")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,nieuwe_adress.css')?>

<?=javascript_load('table.js,jQuery.js,script.js,jquery.localscroll-1.2.5.js,coda-slider.js?no_compress,jquery.scrollTo-1.3.3.js,jquery.serialScroll-1.2.1.js,main.js,sidebar.js')?> 
    
<?=icon_load("pp_fav.ico")?>
<?=include_once('adressen.php');
// $sidebarController = new adressen(); ?>

<script src="/application/media/js/table.js"></script>

</head>

<body>
 
<?=module_load('SIDEBAR')?>
    <div class="Mycontainer">
    <?=module_load('nieuweadressmenu')?>
    <div class="maincontainer">
        <div class="info">													
            <div class="infoUp">										
                <p class="info pFirstChild">Adres
                <input class="inputNewHuurder" type="text" name="Adres" value='' >
                </p>
                <p class="info p">Postcode 
                <input class="inputNewHuurder" type="text" name="Postcode" value=''>
                </p>
            </div>										
        </div>
        
       
    </div>
	<?=module_load('FOOTER')?>
	</div>
</body>
</html>
