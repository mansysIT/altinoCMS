<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



<?=add_metatags()?>

<?=add_title("Design Klasy biznes - SuperCMS")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,nieuwe_adress.css')?>

<?=javascript_load('table.js,jQuery.js,script.js,jquery.localscroll-1.2.5.js,coda-slider.js?no_compress,jquery.scrollTo-1.3.3.js,jquery.serialScroll-1.2.1.js,main.js,sidebar.js,nieuwe_adress.js')?> 
    
<?=icon_load("pp_fav.ico")?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="/application/media/js/nieuwe_adress.js"></script>
</head>

<body>
 
<?=module_load('SIDEBAR')?>
    <div class="Mycontainer">
    <?=module_load('nieuweadressmenu')?>
    <div class="maincontainer">
        <div class="info">										
            <div class="infoUp" id="nieuweadressprivate">	
				<button id="privatetoogler" style="margin-top: 1%; margin-left: 0.8%" class="btn btn-danger mb-2">Private</button>									
                <p class="info pFirstChild">Naam
                <input class="inputNewHuurder" type="text" name="Naam" value='' >
                </p>
                <p class="info p">Achternaam 
                <input class="inputNewHuurder" type="text" name="Achternaam" value=''>
                </p>
                <p class="info p">Nr en serie van ID-kaart
                <input class="inputNewHuurder" type="text" name="NrenserievanID-kaart" value='' >
                </p>
                <p class="info p">Telefoon  
                <input class="inputNewHuurder" type="text" name="Telefoon" value='' >
                </p>
                <p class="info p">Geboortedatum  
                <input class="inputNewHuurder" sty type="text" name="Geboortedatum " value='' >
                </p>
			</div>
			<div class="active" id="nieuweadressbedrijf">
                <div class="infoUp">	
				<button id="bedrijftoogler" style="margin-top: 1%; margin-left: 0.8%" class="btn btn-danger mb-2">Bedrijf</button>
                    <p class="info pFirstChildfirst">Bedrijf
                    <input class="inputNewHuurderfirst" type="text" name="text" value='' >
                    </p>
                    <p class="info p">Adres 
                    <input class="inputNewHuurder" type="text" name="Adres" value='' >
                    </p>
                    <p class="info p">Post code
                    <input class="inputNewHuurder" type="text" name="code" value='' >
                    </p>
                    <p class="info p">Stad 
                    <input class="inputNewHuurder" type="text" name="stad" value='' >
                    </p>
                </div>
                <div class="infoDown">
                    <p class="info pFirstChild">KvK 
                    <input class="inputNewHuurder" type="text" name="KvK" value='' >
                    </p>
                    <p class="info p">BTW  
                    <input class="inputNewHuurder" type="text" name="BTW" value='' >
                    </p>
                    <p class="info p">Tel 
                    <input class="inputNewHuurder" type="text" name="Tel" value='' >
                    </p>
				</div>
			</div>									
		</div>
		<div class="bottomHolder">
            <div class="rekaning">
				<div class="RekeningInside">
                    <p class="rekaningText">Email</p>
                    <input type="text" name="Email" value='' >
                </div>
                <div class="RekeningInside">
                    <p class="rekaningText">Rekening</p>
                    <input type="text" name="Rekening" value='' >
                </div>           
            </div>
            <div class="right">


                </div>
        </div>

    </div>
	<?=module_load('FOOTER')?>
	</div>
</body>
</html>