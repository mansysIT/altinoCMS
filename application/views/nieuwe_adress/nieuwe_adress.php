<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<?=add_metatags()?>

<?=add_title("Adressen Alle")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,all.css')?>

<?=javascript_load('table.js,jQuery.js,script.js,jquery.localscroll-1.2.5.js,coda-slider.js?no_compress,jquery.scrollTo-1.3.3.js,jquery.serialScroll-1.2.1.js,main.js,sidebar.js,table.js')?> 
    
<?=icon_load("pp_fav.ico")?>
<?=include_once('adressen.php');
// $sidebarController = new adressen(); ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>

<body>
 
<?=module_load('SIDEBAR')?>
    <div class="Mycontainer">
    <?=module_load('nieuweadressmenu')?>
    <div class="maincontainer">
        <div class="info">													
            <div class="infoUp">
            <form action="nieuwe_adress/savenieuwe_adress" method="post">								
                <p class="info pFirstChild">Adres
                <input class="inputNewHuurder" type="text" name="adres" value='' >
                </p>
                <p class="info p">Postcode 
                <input class="inputNewHuurder" type="text" name="postcode" value=''>
                </p>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Example select</label>
                    <select name="city" class="form-control" id="exampleFormControlSelect1">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-danger mb-2" name="adresbtn">Toevoegen</button>
            </form>		
            </div>										
        </div>
        
       
    </div>
	<?=module_load('FOOTER')?>
	</div>
</body>
</html>
