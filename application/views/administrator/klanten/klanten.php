<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<?php $getDataFromKlantens=model_load('klantenmodel', 'getKlantenById', '')?>

<?php $getAllCityName=model_load('mainmodel', 'getCityName', '')?>

<?php model_load('klantenmodel', 'klantenActionType', '')?>

<?php if(empty($getDataFromKlantens)) {
$getDataFromKlantens['private'] = 1;
} ?>

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
        <?php if(!empty($getDataFromKlantens['private_naam'])){ echo $getDataFromKlantens['private_naam']." ".$getDataFromKlantens['private_achternaam']; } 
        else if(!empty($getDataFromKlantens['bedrijf_bedrijf']) ){ echo $getDataFromKlantens['bedrijf_bedrijf']; }
        else {echo "Nieuwe Klanten";}?>
        </h1> 
    </div>
    <div class="row mainContainer"> 
    <form action="" method="post">
        <div class="row fullWidth smallMarginBottom <?php if($getDataFromKlantens['private'] != 1) echo "active"; ?>" id="nieuweadressprivate">
            <div class="col-sm-2  my-auto">
                <div class="row">
                    <div class="col-sm ">
                        <button type="button" onclick="bedrijf()" id="privatetoogler" class="btn btn-danger mb-2">Private</button>	
                    </div>
                </div>
            </div>
            <div class="col-sm-10 noPadding text-center">
                <div class="row">
                    <div class="col-sm-3 colWidth">
                        <p class="info pFirstChild">Naam</p>  
                        <input class="inputKlanten" type="text" name="private_naam" value='<?php if(!empty($getDataFromKlantens['id'])) echo $getDataFromKlantens['private_naam']?>' >
                    </div>
                    <div class="col-sm-3 colWidth">
                        <p class="info p">Achternaam</p>   
                        <input class="inputKlanten" type="text" name="private_achternaam" value='<?php if(!empty($getDataFromKlantens['id'])) echo $getDataFromKlantens['private_achternaam']?>'>
                    </div>
                    <div class="col-sm-3 colWidth">
                        <p class="info p">ID-kaart</p>  
                        <input class="inputKlanten" type="text" name="private_id_kaart" value='<?php if(!empty($getDataFromKlantens['id'])) echo $getDataFromKlantens['private_id_kaart']?>' >
                    </div>
                    <div class="col-sm-3 colWidth">
                        <p class="info p">Telefoon</p>  
                        <input class="inputKlanten" type="text" name="private_tel" value='<?php if(!empty($getDataFromKlantens['id'])) echo $getDataFromKlantens['private_tel']?>' >
                    </div>
                    <div class="col-sm-3 colWidth">
                        <p class="info p">Geboortedatum</p>
                        <input class="inputKlanten" sty type="date" name="private_geboortedatum" value='<?php if(!empty($getDataFromKlantens['id'])) echo $getDataFromKlantens['private_geboortedatum']?>' >
                    </div>
                </div>
            </div>
        </div>
        <div class="row fullWidth smallMarginBottom <?php if($getDataFromKlantens['private'] != 0) echo "active"; ?>"  id="nieuweadressbedrijf">
            <div class="col-sm-2  my-auto">
                <div class="row">
                    <div class="col-sm  my-auto">
                    <button type="button" onclick="private()" id="bedrijftoogler" style="margin-top: auto; margin-left: 0.8%" class="btn btn-danger mb-2">Bedrijf</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-10 noPadding text-center">
                <div class="row">
                    <div class="col-sm-3 colWidth">
                        <p class="info ">Bedrijf</p>  
                        <input class="inputKlanten" type="text" name="bedrijf_bedrijf" value='<?php if(!empty($getDataFromKlantens['id'])) echo $getDataFromKlantens['bedrijf_bedrijf']?>'>
                    </div>
                    <div class="col-sm-3 colWidth">
                        <p class="info p">Adres</p>   
                        <input class="inputKlanten" type="text" name="bedrijf_adres" value='<?php if(!empty($getDataFromKlantens['id'])) echo $getDataFromKlantens['bedrijf_adres']?>'>
                    </div>
                    <div class="col-sm-3 colWidth">
                        <p class="info p">Post code</p>  
                        <input class="inputKlanten" type="text" name="bedrijf_postcode" value='<?php if(!empty($getDataFromKlantens['id'])) echo $getDataFromKlantens['bedrijf_postcode']?>' >
                    </div>
                    <div class="col-sm-3 colWidth">
                        <p class="info p">Stad</p>  
                        <input class="inputKlanten" type="text" name="bedrijf_stad" value='<?php if(!empty($getDataFromKlantens['id'])) echo $getDataFromKlantens['bedrijf_stad']?>' >
                    </div>
                    <div class="col-sm-3 colWidth">
                        <p class="info p">KvK</p>
                        <input class="inputKlanten" sty type="text" name="bedrijf_kvk" value='<?php if(!empty($getDataFromKlantens['id'])) echo $getDataFromKlantens['bedrijf_kvk']?>' >
                    </div>
                    <div class="col-sm-3 colWidth">
                        <p class="info p">BTW</p>
                        <input class="inputKlanten" sty type="text" name="bedrijf_btw" value='<?php if(!empty($getDataFromKlantens['id'])) echo $getDataFromKlantens['bedrijf_btw']?>' >
                    </div>
                    <div class="col-sm-3 colWidth">
                        <p class="info p">Tel</p>
                        <input class="inputKlanten" sty type="text" name="bedrijf_tel" value='<?php if(!empty($getDataFromKlantens['id'])) echo $getDataFromKlantens['bedrijf_tel']?>' >
                    </div>
                </div>
            </div>
        </div>
        <input style="display: none" id="toogler"  type="text" name="privateBedrijfToogler" value='<?php if($getDataFromKlantens['private'] == 0) echo "bedrijf"; else echo "private"; ?>' >
        <div class="row fullWidth ">
            <div class="col-sm-2 my-auto ">
                <p class="info p">Email</p>
            </div>
            <div class="col-sm-10 noPadding">
                <div class="col-sm-3 colWidth text-center ">
                    <input class="inputKlanten" type="text" name="email" value='<?php if(!empty($getDataFromKlantens)) echo $getDataFromKlantens['email']?>' >
                </div>
            </div>
        </div>
        <div class="row fullWidth ">
            <div class="col-sm-2 my-auto">
                <p class="info p">Rekening</p>
            </div>
            <div class="col-sm-10 noPadding">
                <div class="col-sm-3 colWidth text-center">
                    <input class="inputKlanten" type="text" name="rekening" value='<?php if(!empty($getDataFromKlantens)) echo $getDataFromKlantens['rekening']?>' >
                </div>
            </div>
        </div>
        <div class="row fullWidth">
            <div class="col-sm-2 my-auto">
                <button type="submit" class="btn btn-danger mb-2 btn-small" style="margin-left: 0.8%; margin-top: 10px;" name="toevoegen">Opslaan</button>
            </div>
        </div>
    </form>
    </div>
    <div class="row justify-content-center">
        <?=module_load('FOOTER')?>
    </div>
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