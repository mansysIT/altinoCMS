<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<?=model_load('proformamodel', 'editProforma', '')?>
<?php $getCityId=model_load('mainmodel', 'getCityName', '')?>
<?php $facturaModelData=model_load('proformamodel', 'showdata', '')?>
<?php $getWarforTypes = model_load('mainmodel', 'getWaarvoor', '')?>
<?php $oferten = model_load('mainmodel', 'getOferten', '')?>
<?php $mailhistory=model_load('proformamodel', 'getproformaidbynumer', '')?>

<?php
// if($facturaModelData[0]['data']));
$d = new DateTime($facturaModelData[0]['data']);
?>

<?=add_metatags()?>

<?=add_title("Proforma")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,nieuwe_adress.css,factur.css')?>

<?=javascript_load('main.js,sidebar.js,nieuwe_adress.js,addfileds.js')?> 
    
<?=icon_load("pp_fav.ico")?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="/application/media/js/nieuwe_adress.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

</head>

<body>
 
	<?=module_load('SIDEBAR')?>
    <div class="Mycontainer">
    <h1 class="title">Proforma Bewerken</h1>
    <div class="maincontainer">
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
                                <tr style="display: none" class="nag ">
                                        
                                    <td class="columnAlignText">
                                        <p class="rekaningText alignItem">Waarvoor</p>
                                        <select  id="warfortype" name="warfortype[]" class="form-control selectValid getAllWarfor alignItem">
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
                        <?php echo '<tr style="display: flex" class="">
                                        
                                        <td class="columnAlignText">
                                        <p class="rekaningText alignItem">Waarvoor</p>
                                        <select name="warfortype[]" class="form-control alignItem" id="warfortype" required>
                                        <option value="">KIEZ</option>';
                                        foreach($getWarforTypes as $row){ ?>
                                            <li>
                                                <option id="<?=$row[2]?>" value="<?php echo $row[0]; ?>"<?php if($row[0] == $rows['waarvoor_id']) echo" selected" ?>><?php echo $row[1]." (".$row[2]."%)"; ?></option>
                                            </li>
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
                                        <td class=" del blok_mansys bottomAlign">';
                                        if($facturaModelData[0]['is_factur'] != 1){
                                            echo '<button type="submit" class="warfor_id btn btn-danger mb-2" value="'.$rows["id"].'" onclick="removeWarfor('.$rows["id"].')" name="del-a" >X</button>';
                                        }
                                        echo '</td>
                                        
                                    </tr>';
                                    // $facturaModelData[0]['warforInputId'][] = $rows['id']
                                    // <input style=" width: auto; display:block; margin:0 auto;" value="'.$rows["id"].'" class="btn btn-danger" name="del-a" value="X" >
                                    
                    ?>
                    <?php endforeach; ?>
                    <?='</tbody>
                            </table>
                        </div>';?>
                </div>
                <?php if($facturaModelData[0]['is_factur'] != 1): ?>
                <button type="button" class="btn btn-danger mb-2 btn-small" id="dodaj">Toevoegen + </button>
                <?php endif; ?>
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
                <div class="RekeningInside">
                    <p class="rekaningText">Data Betalen</p>
                    <input class="inputNewHuurder" type="date" name="data_betalen" value="<?php echo $facturaModelData[0]['data_betalen']?>">
                </div>
                <div style="display: none" class="RekeningInside">
                    <p class="rekaningText">Factuurnummer</p>
                    <input class="inputNewHuurder form-control-small" type="number" name="proformaId" value="<?=$facturaModelData[0]['id'] ?>">
                    <input class="inputNewHuurder form-control-small" type="number" name="facturnumer" value="<?=$facturaModelData[0]['proforma_numer'] ?>">
                </div>
                <?php if($facturaModelData[0]['is_factur'] != 1): ?>
                <button type="submit" class="btn btn-danger mb-2 btn-small" name="editwarfor">Opslaan</button>
                <?php endif; ?>
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
        
        </form>
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

});

window.onload = function() {    
    var id_miasto = $(".miasta").val();
    var id_adres = <?=$facturaModelData[0]['adres_id']?>;
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
            url: "administrator/proforma/warforremove",
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