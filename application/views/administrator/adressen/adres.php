<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<?php $getDataFromAdres=model_load('adressenmodel', 'getAdressById', '')?>

<?php $getAllCityName=model_load('mainmodel', 'getCityName', '')?>

<?=add_metatags()?>

<?=add_title("Design Klasy biznes - SuperCMS")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,nieuwe_adress.css')?>

<?=javascript_load('jQuery.js,script.js,jquery.localscroll-1.2.5.js,coda-slider.js?no_compress,jquery.scrollTo-1.3.3.js,jquery.serialScroll-1.2.1.js,main.js,sidebar.js,nieuwe_adress.js')?> 
    
<?=icon_load("pp_fav.ico")?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="/application/media/js/nieuwe_adress.js"></script>
</head>



</head>

<body>
 
<?=module_load('SIDEBAR')?>
    <div class="Mycontainer">
    <h1>
    <?=$getDataFromAdres['city']." ".$getDataFromAdres['adres']?>
    </h1> 
    <?=module_load('adresmenu')?>
    <div class="maincontainer">
            <form action="administrator/nieuwe_adress/savenieuwe_adress" method="post">
            <div class="bottomHolder">
            <div class="rekaning">
				<div class="RekeningInside">
                    <p class="rekaningText">Adres</p>
                    <input class="inputNewHuurder" type="text" name="adres" value='<?=$getDataFromAdres['adres']?>' >
                </div>
                <div class="RekeningInside">
                    <p class="rekaningText">Postcode</p>
                    <input class="inputNewHuurder" type="text" name="postcode" value='<?=$getDataFromAdres['postcode']?>'>
                </div>       
                <div class="RekeningInside">
                    <p class="rekaningText">City</p>
                    <select name="city" class="form-control" id="exampleFormControlSelect1">
                    <?php foreach($getAllCityName as $row): ?>
                    <li>
                    <option value="<?php echo $row[0]; ?>" <?php if($row[0] == $getDataFromAdres['city_id']) echo" selected" ?>><?php echo $row[1]; ?></option>
                    </li>
                    <?php endforeach; ?>
                    </select>
                </div>      
            </div>
            <div class="right">


            </div>
            
        </div>
        <div class="info">										
            <div class="infoUp" id="nieuweadressprivate">	
				<button type="button" id="privatetoogler" style="margin-top: 1%; margin-left: 0.8%" class="btn btn-danger mb-2">Private</button>									
                <p class="info pFirstChild">Naam
                <input class="inputNewHuurder" type="text" name="private_naam" value='<?=$getDataFromAdres['private_naam']?>' >
                </p>
                <p class="info p">Achternaam 
                <input class="inputNewHuurder" type="text" name="private_achternaam" value='<?=$getDataFromAdres['private_achternaam']?>'>
                </p>
                <p class="info p">Nr en serie van ID-kaart
                <input class="inputNewHuurder" type="text" name="private_id_kaart" value='<?=$getDataFromAdres['private_id_kaart']?>' >
                </p>
                <p class="info p">Telefoon  
                <input class="inputNewHuurder" type="text" name="private_tel" value='<?=$getDataFromAdres['private_tel']?>' >
                </p>
                <p class="info p">Geboortedatum  
                <input class="inputNewHuurder" sty type="date" name="private_geboortedatum" value='<?=$getDataFromAdres['private_geboortedatum']?>' >
                </p>
			</div>
			<div class="active" id="nieuweadressbedrijf">
                <div class="infoUp">	
				<button type="button" id="bedrijftoogler" style="margin-top: 1%; margin-left: 0.8%" class="btn btn-danger mb-2">Bedrijf</button>
                    <p class="info pFirstChildfirst">Bedrijf
                    <input class="inputNewHuurderfirst" type="text" name="bedrijf_bedrijf" value='<?=$getDataFromAdres['bedrijf_bedrijf']?>' >
                    </p>
                    <p class="info p">Adres 
                    <input class="inputNewHuurder" type="text" name="bedrijf_adres" value='<?=$getDataFromAdres['bedrijf_adres']?>' >
                    </p>
                    <p class="info p">Post code
                    <input class="inputNewHuurder" type="text" name="bedrijf_postcode" value='<?=$getDataFromAdres['bedrijf_postcode']?>' >
                    </p>
                    <p class="info p">Stad 
                    <input class="inputNewHuurder" type="text" name="bedrijf_stad" value='<?=$getDataFromAdres['bedrijf_stad']?>' >
                    </p>
                </div>
                <div class="infoDown">
                    <p class="info pFirstChild">KvK 
                    <input class="inputNewHuurder" type="text" name="bedrijf_kvk" value='<?=$getDataFromAdres['bedrijf_kvk']?>' >
                    </p>
                    <p class="info p">BTW  
                    <input class="inputNewHuurder" type="text" name="bedrijf_btw" value='<?=$getDataFromAdres['bedrijf_btw']?>' >
                    </p>
                    <p class="info p">Tel 
                    <input class="inputNewHuurder" type="text" name="bedrijf_tel" value='<?=$getDataFromAdres['bedrijf_tel']?>' >
                    </p>
				</div>
			</div>									
		</div>
		<div class="bottomHolder">
            <div class="rekaning">
				<div class="RekeningInside">
                    <p class="rekaningText">Email</p>
                    <input type="text" name="email" value='<?=$getDataFromAdres['email']?>' >
                </div>
                <div class="RekeningInside">
                    <p class="rekaningText">Rekening</p>
                    <input type="text" name="rekening" value='<?=$getDataFromAdres['rekening']?>' >
                </div>           
            </div>
            <div class="right">


                </div>
        </div>							

                <button type="submit" class="btn btn-danger mb-2" style="margin-left: 0.8%;" name="adresbtn">Toevoegen</button>
            </form>		

        
       
    </div>
	<?=module_load('FOOTER')?>
	</div>
</body>
</html>
