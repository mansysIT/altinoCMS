<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<?=add_metatags()?>

<?=add_title("Instellingen Stedenlist")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,all.css,instellingen.css,instellingenmenu.css')?>

<?=javascript_load('jQuery.js,script.js,jquery.localscroll-1.2.5.js,coda-slider.js?no_compress,jquery.scrollTo-1.3.3.js,jquery.serialScroll-1.2.1.js,main.js,sidebar.js')?> 
    
<?=icon_load("pp_fav.ico")?>
<?php 
$sidebarController = model_load('instellingenmodel', 'stedenlijstGetCityName', '');
?>

<script src="/application/media/js/sidebar.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link href="/application/media/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">

</head>

<body>
 
	<?=module_load('SIDEBAR')?>
    <div class="stedenlijstholder">
    <h1 style="margin-bottom: 30px">Instellingen</h1>
    <?=module_load('instellingenmenu')?>
    <div class="maincontainer">
        <ul class="list-group list-group-flush">
        <form class="form-inline" method="post" action="administrator/instellingen/addCity">

            <div class="form-group mx-sm-3 mb-2">
            <label class="sr-only">Stad Name</label>
                <input type="text" class="form-control" id="inputPassword2" name="cityname" placeholder="Stad Name">
            </div>
            <button type="submit" class="btn btn-danger mb-2" name="addCity">Toevoegen</button>
        </form>
        <?php foreach($sidebarController as $row): ?>
        <?php if($row[1] != 0): ?>
        <li class="list-group-item"><?php echo $row[0]; ?><form style="width: 10%; float: right; padding: 0;" class="form-inline" method="post" action="administrator/instellingen/removeCity"><button class="btnCityRemove" type="submit" name="cityName" value="<?php echo $row[1]; ?>"><span class="oi oi-delete" title="delete" aria-hidden="true"></span></button></form></li>
        <?php endif; ?>
        <?php endforeach; ?>
        </ul>
    </div>
	<?=module_load('FOOTER')?>
	</div>
</body>
</html>
