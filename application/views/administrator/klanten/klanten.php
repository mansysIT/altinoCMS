<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<?php $getDataFromKlantens=model_load('klantenmodel', 'getKlantenById', '')?>

<?php $getAllCityName=model_load('mainmodel', 'getCityName', '')?>

<?php model_load('adressenmodel', 'editAdress', '')?>

<?=add_metatags()?>

<?=add_title("Klanten")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,style.css,klanten.css,nieuwe_adress.css')?>

<?=javascript_load('main.js,sidebar.js,nieuwe_adress.js')?> 
    
<?=icon_load("pp_fav.ico")?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>



</head>

<body>
 
<?=module_load('SIDEBAR')?>
<div class="container-fluid">
    <div class="row">
        <h1 class="title">
        <?=$getDataFromKlantens['private_naam']." ".$getDataFromKlantens['private_achternaam']?>
        </h1> 
    </div>
    <div class="row mainContainer">
        <div class="row fullWidth smallMargin <?php if($getDataFromKlantens['private'] != 1) echo "active"; ?>">
            <div class="col-sm-2  my-auto">
                <div class="row">
                    <div class="col-sm columnAlignText my-auto">
                        <button type="button" onclick="bedrijf()" id="privatetoogler" style="margin-top: auto; margin-left: 0.8%" class="btn btn-danger mb-2">Private</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-10 noPadding">
                <div class="row">
                    <div class="col-sm-3 ">
                        <p class="info pFirstChild">Naam</p>  
                        <input class="inputKlanten" type="text" name="private_naam" value='<?=$getDataFromKlantens['private_naam']?>' >
                    </div>
                    <div class="col-sm-3 ">
                        <p class="info p">Achternaam</p>   
                        <input class="inputKlanten" type="text" name="private_achternaam" value='<?=$getDataFromKlantens['private_achternaam']?>'>
                    </div>
                    <div class="col-sm-3 ">
                        <p class="info p">Nr en serie van ID-kaart</p>  
                        <input class="inputKlanten" type="text" name="private_id_kaart" value='<?=$getDataFromKlantens['private_id_kaart']?>' >
                    </div>
                    <div class="col-sm-3 ">
                        <p class="info p">Telefoon</p>  
                        <input class="inputKlanten" type="text" name="private_tel" value='<?=$getDataFromKlantens['private_tel']?>' >
                    </div>
                    <div class="col-sm-3 ">
                        <p class="info p">Geboortedatum</p>
                        <input class="inputKlanten" sty type="date" name="private_geboortedatum" value='<?=$getDataFromKlantens['private_geboortedatum']?>' >
                    </div>
                </div>
            </div>
        </div>
        <div class="row fullWidth smallMargin <?php if($getDataFromKlantens['private'] != 1) echo "active"; ?>">
            <div class="col-sm-2  my-auto">
                <div class="row">
                    <div class="col-sm columnAlignText my-auto">
                        <button type="button" onclick="bedrijf()" id="privatetoogler" style="margin-top: auto; margin-left: 0.8%" class="btn btn-danger mb-2">Private</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-10 noPadding">
                <div class="row">
                    <div class="col-sm-3 ">
                        <p class="info ">Bedrijf</p>  
                        <input class="inputKlanten" type="text" name="private_naam" value='<?=$getDataFromKlantens['private_naam']?>' >
                    </div>
                    <div class="col-sm-3  ">
                        <p class="info p">Adres</p>   
                        <input class="inputKlanten" type="text" name="private_achternaam" value='<?=$getDataFromKlantens['private_achternaam']?>'>
                    </div>
                    <div class="col-sm-3  ">
                        <p class="info p">Post code</p>  
                        <input class="inputKlanten" type="text" name="private_id_kaart" value='<?=$getDataFromKlantens['private_id_kaart']?>' >
                    </div>
                    <div class="col-sm-3  ">
                        <p class="info p">Stad</p>  
                        <input class="inputKlanten" type="text" name="private_tel" value='<?=$getDataFromKlantens['private_tel']?>' >
                    </div>
                    <div class="col-sm-3  ">
                        <p class="info p">KvK</p>
                        <input class="inputKlanten" sty type="date" name="private_geboortedatum" value='<?=$getDataFromKlantens['private_geboortedatum']?>' >
                    </div>
                    <div class="col-sm-3  ">
                        <p class="info p">BTW</p>
                        <input class="inputKlanten" sty type="date" name="private_geboortedatum" value='<?=$getDataFromKlantens['private_geboortedatum']?>' >
                    </div>
                    <div class="col-sm-3  ">
                        <p class="info p">Tel</p>
                        <input class="inputKlanten" sty type="date" name="private_geboortedatum" value='<?=$getDataFromKlantens['private_geboortedatum']?>' >
                    </div>
                </div>
            </div>
        </div>
        <div class="row fullWidth smallMargin">
            <div class="col-sm-2  my-auto">
                <p class="info p">Email</p>
            </div>
            <div class="col-sm-10">
                <input class="inputKlanten" type="text" name="email" value='<?=$getDataFromKlantens['email']?>' >
            </div>
        </div>
        <div class="row fullWidth smallMargin">
            <div class="col-sm-2 my-auto">
                <p class="info p">Rekening</p>
            </div>
            <div class="col-sm-10">
                <input class="inputKlanten" type="text" name="rekening" value='<?=$getDataFromKlantens['rekening']?>' >
            </div>
        </div>
    </div>
</div>
    <div class="Mycontainer" style="display: none">
    <h1 class="title">
    <?=$getDataFromKlantens['private_naam']." ".$getDataFromKlantens['private_achternaam']?>
    </h1> 
    <div class="maincontainer" >
        <form action="" method="post">
        <div class="info">										
            <div class="infoUp <?php if($getDataFromKlantens['private'] != 1) echo "active"; ?>" id="nieuweadressprivate">	
				<button type="button" onclick="bedrijf()" id="privatetoogler" style="margin-top: auto; margin-left: 0.8%" class="btn btn-danger mb-2">Private</button>									
                <p class="info pFirstChild">Naam
                <input class="inputNewHuurder" type="text" name="private_naam" value='<?=$getDataFromKlantens['private_naam']?>' >
                </p>
                <p class="info p">Achternaam 
                <input class="inputNewHuurder" type="text" name="private_achternaam" value='<?=$getDataFromKlantens['private_achternaam']?>'>
                </p>
                <p class="info p">Nr en serie van ID-kaart
                <input class="inputNewHuurder" type="text" name="private_id_kaart" value='<?=$getDataFromKlantens['private_id_kaart']?>' >
                </p>
                <p class="info p">Telefoon  
                <input class="inputNewHuurder" type="text" name="private_tel" value='<?=$getDataFromKlantens['private_tel']?>' >
                </p>
                <p class="info p">Geboortedatum  
                <input class="inputNewHuurder" sty type="date" name="private_geboortedatum" value='<?=$getDataFromKlantens['private_geboortedatum']?>' >
                </p>
			</div>
			<div class="<?php if($getDataFromKlantens['private'] != 0) echo "active"; ?>" id="nieuweadressbedrijf">
                <div class="infoUp">	
				<button type="button" onclick="private()" id="bedrijftoogler" style="margin-top: auto; margin-left: 0.8%" class="btn btn-danger mb-2">Bedrijf</button>
                    <p class="info pFirstChildfirst">Bedrijf
                    <input class="inputNewHuurderfirst" type="text" name="bedrijf_bedrijf" value='<?=$getDataFromKlantens['bedrijf_bedrijf']?>' >
                    </p>
                    <p class="info p">Adres 
                    <input class="inputNewHuurder" type="text" name="bedrijf_adres" value='<?=$getDataFromKlantens['bedrijf_adres']?>' >
                    </p>
                    <p class="info p">Post code
                    <input class="inputNewHuurder" type="text" name="bedrijf_postcode" value='<?=$getDataFromKlantens['bedrijf_postcode']?>' >
                    </p>
                    <p class="info p">Stad 
                    <input class="inputNewHuurder" type="text" name="bedrijf_stad" value='<?=$getDataFromKlantens['bedrijf_stad']?>' >
                    </p>
                </div>
                <div class="infoDown">
                    <p class="info pFirstChild">KvK 
                    <input class="inputNewHuurder" type="text" name="bedrijf_kvk" value='<?=$getDataFromKlantens['bedrijf_kvk']?>' >
                    </p>
                    <p class="info p">BTW  
                    <input class="inputNewHuurder" type="text" name="bedrijf_btw" value='<?=$getDataFromKlantens['bedrijf_btw']?>' >
                    </p>
                    <p class="info p">Tel 
                    <input class="inputNewHuurder" type="text" name="bedrijf_tel" value='<?=$getDataFromKlantens['bedrijf_tel']?>' >
                    </p>
				</div>
			</div>									
        </div>
        <input style="display: none" id="toogler"  type="text" name="privateBedrijfToogler" value='private' >
		<div class="bottomHolder">
            <div class="rekaning">
				<div class="RekeningInside">
                    <p class="rekaningText">Email</p>
                    <input type="text" name="email" value='<?=$getDataFromKlantens['email']?>' >
                </div>
                <div class="RekeningInside">
                    <p class="rekaningText">Rekening</p>
                    <input type="text" name="rekening" value='<?=$getDataFromKlantens['rekening']?>' >
                </div>   
                <button type="submit" class="btn btn-danger mb-2 btn-small" style="margin-left: 0.8%; margin-top: 10px;" name="editadres">Toevoegen</button>        
            </div>
            <div class="right">


                </div>
                
        </div>							

                
            </form>		

        
       
    </div>
	<?=module_load('FOOTER')?>
	</div>
</body>
</html>
<script>

function bedrijf() {
    document.getElementById("toogler").value = "bedrijf";
};

function private() {
    document.getElementById("toogler").value = "private";
};

</script>