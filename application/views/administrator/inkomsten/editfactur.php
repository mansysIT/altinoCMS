<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>

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

<?=add_title("Edit Factur")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,nieuwe_adress.css,factur.css')?>

<?=javascript_load('jQuery.js,script.js,jquery.localscroll-1.2.5.js,coda-slider.js?no_compress,jquery.scrollTo-1.3.3.js,jquery.serialScroll-1.2.1.js,main.js,sidebar.js,nieuwe_adress.js')?> 
    
<?=icon_load("pp_fav.ico")?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="/application/media/js/nieuwe_adress.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<link href="/application/media/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">

<script src="/application/media/js/addfileds.js"></script>

</head>

<body>
 
	<?=module_load('SIDEBAR')?>
    <div class="Mycontainer">
    <div class="maincontainer">
    <h1>Factuur Bewerken</h1>
    <form action="" method="post" id="myForm">
            <div class="bottomHolder">
            <div class="rekaning">
                <div class="RekeningInside">
                    <p class="rekaningText">City</p>
                    <select name="city" class="miasta form-control" id="exampleFormControlSelect1">
                    <option value="">SELECT CITY</option>
                    
                    <?php foreach($getCityId as $row): ?>
                        <li>
                            <option value="<?php echo $row[0]; ?>"<?php if($row[0] == $facturaModelData[0]['city_id']) echo" selected" ?>><?php echo $row[1]; ?></option>
                        </li> 
                    <?php endforeach; ?>
                    </select>
                </div>  
                <div class="RekeningInside">
                    <p class="rekaningText">Adres</p>
                    <select name="adres" class="adresy form-control" id="exampleFormControlSelect1">
                        <option>SELECT ADRES</option>
                    </select>
                </div>

                <div class="RekeningInside">
                    <p class="rekaningText">Oferten</p>
                    <select name="oferten" class="oferten form-control" id="exampleFormControlSelect1">
                    <option value="">SELECT OFERTEN</option>
                    
                    <?php foreach($oferten as $row): ?>
                        <li>
                            <option value="<?php echo $row[0]; ?>"<?php if($row[0] == $facturaModelData[0]['oferten_id']) echo" selected" ?>><?php echo $row[1]; ?></option>
                        </li> 
                    <?php endforeach; ?>
                    </select>
                </div> 
                
                <div class="RekeningInside">
                    <?='
                        <div>
                            <table id="kopia_wiersz" class="container"> 
                                <tbody class="warforadd">
                                <tr style="display: none" class="nag ">
                                        
                                        <td class="">
                                        <p class="rekaningText">Warvoor</p>
                                        </td>
                                        <td class="">
                                        <select name="warfortype[]" class="form-control">';
                                        foreach($getWarforTypes as $row){ ?>
                                            <li>
                                                <option value="<?php echo $row[0]; ?>"><?php echo $row[1]." (".$row[2]."%)"; ?></option>
                                            </li>
                                        <?php };

                                           echo'</select>
                                        </td>
                                        <td class="">
                                        <p class="rekaningText">Aantal</p>
                                        </td>
                                        <td class="">
                                            <input class="form-control form-control-small" name="warfortimespend[]" value="">
                                        </td>
                                        <td class="">
                                        <p class="rekaningText">Prijs</p>
                                        </td>
                                        <td class="">
                                            <input class="form-control form-control-small" name="warforquantity[]" value="">
                                            <input style="display: none;"name="warforInputId[]" value="" >
                                        </td>
                                        <td class=" del blok_mansys">
                                            <button type="submit" class="warfor_id btn btn-danger mb-2" value="'.$rows["id"].'" onclick="removeWarfor('.$rows["id"].')" name="del-a" >X</button>
                                            
                                        </td>
                                        
                                    </tr>';?>
                    <?php 
                    $x = 0;
                     foreach(array_slice($facturaModelData, 1)  as $rows): ?>
                <?php echo '<tr style="display: flex" class="">
                                        
                                        <td class="">
                                        <p class="rekaningText">Warvoor</p>
                                        </td>
                                        <td class="">
                                        <select name="warfortype[]" class="form-control">';
                                        foreach($getWarforTypes as $row){ ?>
                                            <li>
                                                <option value="<?php echo $row[0]; ?>"<?php if($row[0] == $rows['waarvoor_id']) echo" selected" ?>><?php echo $row[1]." (".$row[2]."%)"; ?></option>
                                            </li>
                                        <?php };

                                           echo'</select>
                                        </td>
                                        <td class="">
                                        <p class="rekaningText">Aantal</p>
                                        </td>
                                        <td class="">
                                            <input id="aaa" class="form-control form-control-small" name="warfortimespend[]" value="'.$rows["quantity"].'">
                                        </td>
                                        <td class="">
                                        <p class="rekaningText">Prijs</p>
                                        </td>
                                        <td class="">
                                            <input class="form-control form-control-small" name="warforquantity[]" value="'.$rows["price"].'">
                                            <input style="display: none;"name="warforInputId[]" value="'.$rows["id"].'" >
                                        </td>
                                        <td class=" del blok_mansys">
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
				<div class="RekeningInside">
                    <p class="rekaningText">Data</p>

                    <input class="inputNewHuurder" type="date" name="facturdata" value="<?php echo $facturaModelData[0]['data']?>">
                </div>
                <div style="display: none" class="RekeningInside">
                    <p class="rekaningText">Factuurnummer</p>
                    <input  class="inputNewHuurder form-control-small" type="number" name="facturId" value="<?=$facturaModelData[0]['facturId'] ?>">
                    <input  class="inputNewHuurder form-control-small" type="number" name="facturnumer" value="<?=$facturaModelData[0]['factur_numer'] ?>">
                </div>
                <button type="submit" class="btn btn-danger mb-2 btn-small" name="editwarfor">Toevoegen</button>
                </form>
                <h3 style="margin: 15px 0 15px 0;">Bestanden</h3>
                <div class="fileContainer">
                    <ul class="list-group list-group-flush">
                    <?php if($files[1] != null): ?>
                    <?php foreach($files[1] as $file): ?>
                        <li class="list-group-item"><?php echo $file; ?>
                            <form style="width: 10%; float: right; padding: 0;" method="post" action="">
                            <button class="btnCityRemove" type="submit" name="removefile" value="<?php echo $file; ?>"><span class="oi oi-delete" title="delete" aria-hidden="true">
                            </span></button></form>
                        </li>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </ul>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    Select file to upload:
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <input type="submit" name="facturFiles" value="facturFiles" name="submit">
                    <input style="display: none;"name="id_factur" value="<?=$facturaModelData[0]['id']; ?>" >
                </form>

                <h3 style="margin: 15px 0 15px 0;">Email Geschiedenis</h3>
                <ul class="list-group list-group-flush">
                <?php foreach($mailhistory as $rows): ?>
                    <li style="background-color: #eee; padding: 0.75rem 0;" class="list-group-item"><?php echo $rows['data_czas']; ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
            <div class="right">

            
            </div>
            
        </div>
        
        
    </div>
	<?=module_load('FOOTER')?>
	</div>
</body>
</html>

<script type="text/javascript" >
var res = "";
$(document).ready(function()
{
    $(".miasta").change(
        function() {    
    var id_miasto = $(this).val();
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


});

window.onload = function() {    
    var id_miasto = $(".miasta").val();
    var id_adres = <?=$facturaModelData[0]['id']?>;
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