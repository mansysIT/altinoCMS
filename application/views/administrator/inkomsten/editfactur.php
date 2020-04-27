<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl"> 

<head>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<?=model_load('facturmodel', 'editFactura', '')?>
<?php $getCityId=model_load('mainmodel', 'getCityName', '')?>
<?php $facturaModelData=model_load('facturmodel', 'showdata', '')?>
<?php $getWarforTypes = model_load('mainmodel', 'getWaarvoor', '')?>
<?php $oferten = model_load('mainmodel', 'getOferten', '')?>
<?php $mailhistory=model_load('facturmodel', 'getfacturidbynumer', '')?>
<?php model_load('facturmodel', 'uploadFacturFiles', '')?>
<?php model_load('facturmodel', 'removeFileFromFactur', $facturaModelData[0]['id'])?>
<?php $files = model_load('facturmodel', 'getAllFilesFromFactur', $facturaModelData[0]['id'])?>

<?php
// if($facturaModelData[0]['data']));
$d = new DateTime($facturaModelData[0]['data']);
?>

<?=add_metatags()?>

<?=add_title("Factur")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,nieuwe_adress.css,factur.css')?>

<?=javascript_load('main.js,sidebar.js,nieuwe_adress.js,addfileds.js')?> 
    
<?=icon_load("pp_fav.ico")?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<link href="/application/media/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">

</head>

<body>
 
	<?=module_load('SIDEBAR')?>
    <div class="Mycontainer">
    <h1 class="title">Factuur Bewerken</h1>
    <div class="maincontainer">
    <form action="" method="post" id="myForm" enctype="multipart/form-data">
        <input style="display: none" type="text" name="id" value="<?=$facturaModelData[0]['id']?>">
            <div class="bottomHolder">
            <div class="rekaning facturRekering">
                <div class="RekeningInside">
                    <p class="rekaningText">Stad</p>
                    <select name="city" class="miasta form-control" id="exampleFormControlSelect1">
                    
                    <?php foreach($getCityId as $row): ?>
                        <li>
                            <option value="<?php echo $row[0]; ?>"<?php if($row[0] == $facturaModelData[0]['city_id']) echo" selected" ?>><?php echo $row[1]; ?></option>
                        </li> 
                    <?php endforeach; ?>
                    </select>
                </div>  
                <div class="RekeningInside">
                    <p class="rekaningText">Adres</p>
                    <select name="adresId" class="adresy form-control" id="exampleFormControlSelect1">
                    </select>
                </div>

                <div id="externalData">
                    <div class="row fullWidth smallMarginBottom <?php if($facturaModelData[0]['private'] != 1) echo "active"; ?>" id="nieuweadressprivate">
                        <div class="col-sm-2  my-auto">
                            <div class="row ">
                                <div class="col-sm ">
                                    <button type="button" onclick="bedrijf()" id="privatetoogler" class="btn btn-danger mb-2">Private</button>	
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-10 noPadding text-center">
                            <div class="row facturDataRowEdit">
                                <div class="col-sm-3 colWidth facturData">
                                    <p class="info pFirstChild text-center">Naam</p>  
                                    <input class="inputKlanten" type="text" name="private_naam" value='<?php echo $facturaModelData[0]['private_naam']?>' >
                                </div>
                                <div class="col-sm-3 colWidth facturData">
                                    <p class="info p text-center">Achternaam</p>   
                                    <input class="inputKlanten" type="text" name="private_achternaam" value='<?php echo $facturaModelData[0]['private_achternaam']?>'>
                                </div>
                                <!-- <div class="col-sm-3 colWidth facturData">
                                    <p class="info p">ID-kaart</p>  
                                    <input class="inputKlanten" type="text" name="private_id_kaart" value='<?php //if(!empty($getDataFromKlantens['id'])) echo $getDataFromKlantens['private_id_kaart']?>' >
                                </div> -->
                                <div class="col-sm-3 colWidth facturData">
                                    <p class="info p">Telefoon</p>  
                                    <input class="inputKlanten" type="text" name="private_tel" value='<?php echo $facturaModelData[0]['private_tel']?>' >
                                </div>
                                <div class="col-sm-3 colWidth facturData" style="visibility: hidden">
                                    <p class="info p">Telefoon</p>  
                                    <input  type="text" >
                                </div>
                                <!-- <div class="col-sm-3 colWidth facturData">
                                    <p class="info p">Geboortedatum</p>
                                    <input class="inputKlanten" sty type="date" name="private_geboortedatum" value='<?php //if(!empty($getDataFromKlantens['id'])) echo $getDataFromKlantens['private_geboortedatum']?>' >
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="row fullWidth smallMarginBottom <?php if($facturaModelData[0]['private'] != 0) echo "active"; ?>"  id="nieuweadressbedrijf">
                        <div class="col-sm-2  my-auto">
                            <div class="row">
                                <div class="col-sm  my-auto">
                                <button type="button" onclick="private()" id="bedrijftoogler" style="margin-top: auto; margin-left: 0.8%" class="btn btn-danger mb-2">Bedrijf</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-10 noPadding text-center">
                            <div class="row facturDataRowBedrijfEdit">
                                <div class="col-sm-3 colWidth facturData">
                                    <p class="info ">Bedrijf</p>  
                                    <input class="inputKlanten" type="text" name="bedrijf_bedrijf" value='<?php echo $facturaModelData[0]['bedrijf_bedrijf']?>'>
                                </div>
                                <div class="col-sm-3 colWidth facturData">
                                    <p class="info p">KvK</p>
                                    <input class="inputKlanten" sty type="text" name="bedrijf_kvk" value='<?php echo $facturaModelData[0]['bedrijf_kvk']?>' >
                                </div>
                                <div class="col-sm-3 colWidth facturData">
                                    <p class="info p">BTW</p>
                                    <input class="inputKlanten" sty type="text" name="bedrijf_btw" value='<?php echo $facturaModelData[0]['bedrijf_btw']?>' >
                                </div>
                                <div class="col-sm-3 colWidth facturData">
                                    <p class="info p">Tel</p>
                                    <input class="inputKlanten" sty type="text" name="bedrijf_tel" value='<?php echo $facturaModelData[0]['bedrijf_tel']?>' >
                                </div>
                            </div>
                        </div>
                    </div>
                    <input style="display: none" id="toogler"  type="text" name="privateBedrijfToogler" value='<?php if($facturaModelData[0]['private'] == 0) echo "bedrijf"; else echo "private"; ?>' >
                    <div class="row fullWidth">
                        <div class="col-sm-2 my-auto ">
                            <p class="info p">Adres</p>     
                        </div>
                        <div class="col-sm-10 noPadding">
                            <div class="col-sm-3 colWidth text-center facturDataRowBedrijfEdit">
                                <input class="inputKlanten" type="text" name="adres" value='<?php echo $facturaModelData[0]['adresadres']?>'>
                            </div>
                        </div>
                    </div>
                    <div class="row fullWidth">
                        <div class="col-sm-2 my-auto ">
                            <p class="info p">Stad</p> 
                        </div>
                        <div class="col-sm-10 noPadding">
                            <div class="col-sm-3 colWidth text-center facturDataRowBedrijfEdit">
                                <input class="inputKlanten" type="text" name="stad" value='<?php echo $facturaModelData[0]['stad']?>' >
                            </div>
                        </div>
                    </div>
                    <div class="row fullWidth">
                        <div class="col-sm-2 my-auto ">
                            <p class="info p">Post code</p>  
                        </div>
                        <div class="col-sm-10 noPadding">
                            <div class="col-sm-3 colWidth text-center facturDataRowBedrijfEdit">
                                <input class="inputKlanten" type="text" name="postcode" value='<?php echo $facturaModelData[0]['postcode']?>' >
                            </div>
                        </div>
                    </div>
                    <div class="row fullWidth">
                        <div class="col-sm-2 my-auto ">
                            <p class="info p">Email</p>
                        </div>
                        <div class="col-sm-10 noPadding ">
                            <div class="col-sm-3 colWidth text-center facturDataRowBedrijfEdit">
                                <input class="inputKlanten" type="text" name="email" value='<?php echo $facturaModelData[0]['email']?>' >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="RekeningInside">
                    <p class="rekaningText">Offerten</p> 
                    <select name="oferten" class="oferty form-control wybor_liczb" id="exampleFormControlSelect1">
                    <option value="0">KIEZ</option>
                    </select>
                </div>  
                
                
                <div class="RekeningInside">
                    <?='
                        <div>
                            <table id="kopia_wiersz" class="container"> 
                                <tbody class="warforadd">
                                <tr style="display: none" class="nag warforCenter">
                                        
                                <td class="columnAlignText">
                                    <p class="rekaningText alignItem">Waarvoor</p>
                                        <select name="warfortype[]" class="form-control selectValid" id="warfortype">
                                        <option value="">KIEZ</option>';
                                        foreach($getWarforTypes as $row){ ?>
                                            <li>
                                                <option id="<?=$row[2]?>" value="<?php echo $row[0]; ?>"><?php echo $row[1]." (".$row[2]."%)"; ?></option>
                                            </li>
                                        <?php };

                                           echo'</select>
                                        </td>
                                        <td class="columnAlignText">
                                            <p class="rekaningText alignItem">Opmerkingen</p>
                                            <textarea name="opmerkingen[]" class="inputNewHuurder warforTextArea alignItem" cols="30" rows="10"></textarea>
                                        </td>
                                        <td class="columnAlignText">
                                            <p class="rekaningText">Aantal</p>
                                            <input id="num1" class="form-control form-control-small getAllWarfor alignItem" placeholder="0" name="warfortimespend[]" value="">
                                        </td>
                                        <td class="columnAlignText">
                                        <p class="rekaningText">PRIJS EXCL. BTW</p>
                                            <input id="num2" class="form-control form-control-small getAllWarfor alignItem" placeholder="0" name="warforquantity[]" value="">
                                            <input style="display: none;"name="warforInputId[]" value="" >
                                        </td>
                                        <td class="columnAlignText">
                                            <p class="rekaningText">PRIJS INCL. BTW</p>
                                            <input id="sumfield" class="form-control form-control-small alignItem" type="text" readonly>
                                        </td>
                                        <td class=" del blok_mansys bottomAlign">
                                            <button type="submit" class="warfor_id btn btn-danger mb-2" value="'.$rows["id"].'" onclick="removeWarfor('.$rows["id"].')" name="del-a" >X</button>
                                            
                                        </td>
                                        
                                    </tr>';?>
                    <?php 
                    $x = 0;
                     foreach(array_slice($facturaModelData, 1)  as $rows): ?>
                <?php echo '<tr style="display: flex" class="warforCenter">
                                        
                                    <td class="columnAlignText">
                                        <p class="rekaningText alignItem">Waarvoor</p>
                                        <select id="warfortype" name="warfortype[]" class="form-control alignItem" required>
                                        <option value="">KIEZ</option>';
                                        foreach($getWarforTypes as $row){ ?>
                                                <option id="<?=$row[2]?>" value="<?php echo $row[0]; ?>"<?php if($row[0] == $rows['waarvoor_id']) echo" selected" ?>><?php echo $row[1]." (".$row[2]."%)"; ?></option>
                                        <?php };

                                           echo'</select>
                                        </td>
                                        <td class="columnAlignText">
                                            <p class="rekaningText alignItem">Opmerkingen</p>
                                            <textarea name="opmerkingen[]" class="inputNewHuurder warforTextArea alignItem" cols="30" rows="10">'.$rows["opmerkingen"].'</textarea>
                                        </td>
                                        <td class="columnAlignText">
                                            <p class="rekaningText">Aantal</p>
                                            <input id="num1" class="form-control form-control-small getAllWarfor alignItem" placeholder="0" name="warfortimespend[]" value="'.$rows["quantity"].'">
                                        </td>
                                        <td class="columnAlignText">
                                            <p class="rekaningText">PRIJS EXCL. BTW</p>
                                            <input id="num2" class="form-control form-control-small getAllWarfor alignItem" placeholder="0" name="warforquantity[]" value="'.$rows["price"].'">
                                            <input style="display: none;"name="warforInputId[]" value="'.$rows["id"].'" >
                                        </td>
                                        <td class="columnAlignText">
                                            <p class="rekaningText">PRIJS INCL. BTW</p>
                                            <input id="sumfield" class="form-control form-control-small alignItem" type="text" readonly>
                                        </td>
                                        <td class=" del blok_mansys bottomAlign">
                                            <button type="submit" class="warfor_id btn btn-danger mb-2" value="'.$rows["id"].'" onclick="removeWarfor('.$rows["id"].')" name="del-a" >X</button>
                                            
                                        </td>
                                        
                                    </tr>';


               
          
                    ?>
                    <?php endforeach; ?>
                    <?='</tbody>
                            </table>
                        </div>';?>
                </div>
                <button type="button" class="btn btn-danger mb-2 btn-small" id="dodaj">Toevoegen + </button>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-4 columnAlignText">
                            <h3>TOTAAL EXCL.BTW:</h3>
                        </div>
                        <div class="col-sm-2 columnAlignText">
                            <h3 class="sumValue"></h3>
                        </div>
                        <div class="col-sm-4 columnAlignText">
                            <h3>TOTAAL INCL.BTW:</h3>
                        </div>
                        <div class="col-sm-2 columnAlignText">
                            <h3 class="sumBtwValue"></h3>
                        </div>
                    </div>
                </div>
				<div class="RekeningInside">
                    <p class="rekaningText">Data</p>
                    <input class="inputNewHuurder" type="date" name="facturdata" value="<?php echo $facturaModelData[0]['data']?>">
                </div>
                <div style="display: none" class="RekeningInside">
                    <p class="rekaningText">Factuurnummer</p>
                    <input  class="inputNewHuurder form-control-small" type="number" name="facturId" value="<?=$facturaModelData[0]['facturId'] ?>">
                    <input  class="inputNewHuurder form-control-small" type="number" name="facturnumer" value="<?=$facturaModelData[0]['factur_numer'] ?>">
                </div>

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
                                <li class="list-group-item"><a href="application/storage/factur/<?=$facturaModelData[0]['id']?>/<?=$file?>"><?=$file?></a>
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
                            <input style="display: none;"name="id_factur" value="<?=$facturaModelData[0]['id']; ?>" >
                        </div>
                    </div> 
                <div class="row">
                        <div class="col-sm">
                            <button type="submit" class="btn btn-danger mb-2 btn-small" name="editwarfor">Opslaan</button> 
                        </div>
                </div> 
                <div class="row">
                    <div class="col-sm-6 columnAlignText">
                        <h3 style="margin: 15px 0 15px 0;">Email Geschiedenis</h3>
                    </div>
                    </div> 
                    <div class="col-sm-4 addFiles">
                        <ul class="list-group list-group-flush">
                        <?php foreach($mailhistory as $rows): ?>
                            <li style="background-color: #eee; padding: 0.75rem 0;" class="list-group-item"><?php echo $rows['data_czas']; ?></li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                </div> 
            </div>
            </form>
            </div>
    </div>


            </div>
                </div>
            
        </div>
        
        
    </div>
	<?=module_load('FOOTER')?>
	</div>
</body>
</html>

<script type="text/javascript" >

function bedrijf() {
    document.getElementById("toogler").value = "bedrijf";
};

function private() {
    document.getElementById("toogler").value = "private";
};

var res = "";
$(document).ready(function()
{
    var id_adres1;
    $(".miasta").change(
        function() {    
    var id_miasto = $(this).val();
    if(id_miasto == 0)
        {
            id_adres1 = 0;
            if(id_adres1 != 0)
            {
            document.getElementById("externalData").style.display = "none";
            } else {
            document.getElementById("externalData").style.display = "block";
            }
        }
    var dataString = {
        action: "miasta",
        id_miasto: id_miasto
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
        }); 
        
        
        $(".adresy").change(function()
        {
       
        id_adres1 = $(this).val();
        if(id_adres1 != 0)
        {
            document.getElementById("externalData").style.display = "none";
        } else {
            document.getElementById("externalData").style.display = "block";
        }
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


});

window.onload = function() {    
    var id_miasto = $(".miasta").val();
    var id_adres = <?=$facturaModelData[0]['adres_id']?>;
    var dataString = {
        action: "miasta",
        id_miasto: id_miasto,
        id_adres: id_adres
        };
        
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
        if(id_adres != 0)
        {
            document.getElementById("externalData").style.display = "none";
        }
        sum();
  
        var id_adres = <?=$facturaModelData[0]["adres_id"]?>;
        var oferte_id = <?=$facturaModelData[0]["oferten_id"]?>;
        var dataString = {
            action: "oferty",
            id_adres: id_adres,
            oferte_id: oferte_id
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


        };

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

var warfor_id = 0;
function removeWarfor(id) {      
    warfor_id =id
    var dataString = {
        action: "removewarfor",
        warfor_id: warfor_id
        };

        $.ajax
        ({
            type: "POST",
            url: "administrator/inkomsten/warforremove",
            data: dataString,
            cache: false,
            success: function(res)
            {
                alert('Waarvoor Verwijderd');
                // $(".adresy").html(html);
            }
        });
};

</script>
<?php
   echo "<script>document.writeln(res);</script>"[0];
?>