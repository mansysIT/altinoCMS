<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> 

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<?php $sidebarController=model_load('mainmodel', 'getCityName', '')?>
<?php $uitgavenModelData=model_load('uitgaafmodel', 'showdata', '')?> 
<?php $oferten = model_load('mainmodel', 'getOferten', '')?>
<?php model_load('uitgavenmodel', 'removeFileFromUitgaven', $uitgavenModelData[0]['uitgaven_id'])?>
<?php $files = model_load('uitgavenmodel', 'getAllFilesFromUitgaven', $uitgavenModelData[0]['uitgaven_id'])?>

<?=add_metatags()?>

<?=add_title("Uitgaaf")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,nieuwe_adress.css,factur.css')?>

<?=javascript_load('main.js,sidebar.js,nieuwe_adress.js')?> 
     
<?=icon_load("pp_fav.ico")?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link href="/application/media/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">

<body>
 
<?php
$waarvoor = array();
$waarvoor = model_load('mainmodel', 'getWaarvoor', ''); 
model_load('uitgavenmodel', 'saveUitgaaf', ''); 
?>    
 
    <?=module_load('SIDEBAR')?>
   

    <div class="Mycontainer"> 
    <h1>Uitgaaf</h1>
    <div class="maincontainer">
    <form action="" method="post" enctype="multipart/form-data">
            <div class="bottomHolder">
            <div class="rekaning">
                <div class="RekeningInside">
                    <p class="rekaningText">City</p>
                    <select name="city" class="miasta form-control" id="exampleFormControlSelect1">
                    <option value="">SELECT CITY</option>
                    <?php foreach($sidebarController as $row): ?>
                        <li> 
                        <option value="<?php echo $row[0]; ?>"<?php if(!empty($uitgavenModelData) && $row[0] == $uitgavenModelData[0]['city_id']) echo "selected" ?>><?php echo $row[1]; ?></option>
                        </li>
                    <?php endforeach; ?> 
                    </select>
                </div>  
                <div class="RekeningInside"> 
                    <p class="rekaningText">Adres</p>
                    <select name="adres" class="adresy form-control" id="exampleFormControlSelect1">
                        <option value="999">SELECT ADRES</option>
                        <option value="999222">SELECT ADRES2</option>
                    </select>
                </div>
                <div class="RekeningInside">
                    <p class="rekaningText">Waarvoor</p> 
                    <select name="waarvoor" class="form-control" id="exampleFormControlSelect1">
                    <option value="">KIEZ</option>
                    <?php foreach($waarvoor as $row): ?> 
                        <li>
                            <option value="<?php echo $row[0]; ?>"<?php if(!empty($uitgavenModelData) && $row[0] == $uitgavenModelData[0]['waarvoor_id']) echo 'selected'; ?>><?php echo $row[1]; ?></option>
                        </li>
                    <?php endforeach; ?> 
                    </select>
                </div>
                
                <div class="RekeningInside">
                    <p class="rekaningText">Oferten</p> 
                    <select name="oferte_id" class="oferty form-control" id="exampleFormControlSelect1">
                    <option value="0">KIEZ</option>
                   
                    <?php foreach($oferten as $row): ?> 
                        <li>
                            <option value="<?php echo $row[1]; ?>"<?php if(!empty($uitgavenModelData) && $row[0] == $uitgavenModelData[0]['oferte_id']) echo 'selected'; ?>><?php echo $row[1]; ?></option>
                        </li>
                    <?php endforeach; ?> 
                    </select>
                </div>  
                
				<div class="RekeningInside">
                    <p class="rekaningText">Bedrag</p>
                    <input class="inputPrice" type="text" name="price" value="<?php if(!empty($uitgavenModelData)) echo $uitgavenModelData[0]['price']; ?>" >
                </div>
                <div class="RekeningInside">
                    <p class="rekaningText">Datum</p>
                    <input class="inputNewHuurder" type="date" name="datum" value="<?=date("Y-m-d");?>">
                </div>       
                
            
            <?php if($uitgavenModelData[0] != null): ?>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6 columnAlignText">
                            <h3 style="margin: 15px 0 15px 0;">Bestanden</h3>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="fileContainer col-sm-6">
                            <ul class="list-group list-group-flush">
                            <?php if($files[1] != null): ?>
                            <?php foreach($files[1] as $file): ?>
                                <li class="list-group-item"><a href="application/storage/uitgaven/<?=$uitgavenModelData[0]['uitgaven_id']?>/<?=$file?>"><?=$file?></a>
                                    <form method="post" action="">
                                    <button style="width: 10%; float: right; padding: 0;" class="btnCityRemove" type="submit" name="removefile" value="<?php echo $file; ?>"><span class="oi oi-delete" title="delete" aria-hidden="true">
                                    </span></button></form>
                                </li>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </ul>
                        </div>
                    </div>                
                    <div class="row">
                        <div class="col-sm-4 addFiles">
                            <input type="file" name="fileToUpload" id="fileToUpload">
                            <input style="display: none;"name="id_factur" value="<?=$uitgavenModelData[0]['uitgaven_id']; ?>" >
                        </div>
                    </div> 
                <?php else: ?>
                    <div class="row">
                        <div class="col-sm-6 columnAlignText">
                            <h3 style="margin: 15px 0 15px 0;">Bestanden</h3>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-sm-4 addFiles">
                            <input type="file" name="fileToUpload" id="fileToUpload">
                            <input style="display: none;"name="id_factur" value="" >
                        </div>
                    </div> 
                <?php endif; ?>
                <div class="row">
                        <div class="col-sm">
                            <button type="submit" class="btn btn-danger mb-2 btn-small" name="savewarfor">Toevoegen</button>
                        </div>
                </div> 
            </div>
            </form>
            </div>
            
            </div>
        
    </div>
	<?=module_load('FOOTER')?>
	</div>
</body>
</html>

<script type="text/javascript" >

$(document).ready(function()
{
 
    $(".miasta").change(function()
    {
        
        var id_miasto = $(this).val();
        var dataString = {
            action: "miasta",
            id_miasto: id_miasto
            };
            
            $.ajax
            ({
                type: "POST",
                url: "administrator/inkomsten/inkomstenajax",
                data: dataString,
                cache: false,
                success: function(html)
                {
                    $(".adresy").html(html);
                }
            });
    });

});
</script>

<?php 

if($uitgavenModelData){

    echo '<script type="text/javascript" >
    window.onload = function() {    
        var id_miasto = $(".miasta").val();
        var id_adres = '.$uitgavenModelData[0]["id"].'
        var dataString = {
            action: "miasta",
            id_miasto: id_miasto,
            id_adres: id_adres
            };
            // alert(res);
            $.ajax
            ({
                type: "POST",
                url: "administrator/inkomsten/inkomstenajax",
                data: dataString,
                cache: false,
                success: function(html)
                {
                    res = html;
                    $(".adresy").html(html);
                }
            });
            };

            </script>';


  }   
?> 
<script type="text/javascript" >

$(".adresy").change(function()
    {
       
        var id_adres1 = $(this).val();
        var dataString = {
            action: "oferty",
            id_adres: id_adres1
            };
            
            $.ajax
            ({
                type: "POST",
                url: "administrator/all/allmodelofertenajax",
                data: dataString,
                cache: false,
                success: function(html)
                {
                    $(".oferty").html(html);
                }
            });
    });

</script>

<script type="text/javascript" >
var quan = 0;
function addWarfor() {      
        var quantity = quan;
        var dataString = {
        action: "warfor",
        quantity: quantity
        
        };
        $.ajax
        ({
            type: "POST",
            url: "administrator/inkomsten/addWarforajax",
            data: dataString,
            cache: false,
            success: function(html)
            {
                quan++;

                $(".warfor").html(html);
            }
        });
};

</script>