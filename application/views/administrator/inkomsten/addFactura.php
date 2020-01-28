<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl"> 

<head>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<?php $sidebarController=model_load('mainmodel', 'getCityName', '')?>
<?php $getWarforTypes = model_load('mainmodel', 'getWaarvoor', '')?>


<?=add_metatags()?>

<?=add_title("Factur")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,nieuwe_adress.css,factur.css')?>

<?=javascript_load('sidebar.js,addfileds.js')?> 
    
<?=icon_load("pp_fav.ico")?>

<?php
$d = new DateTime(date("Y-m-d"));
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<!-- <script src="/application/media/js/addfileds.js"></script> -->

</head>

<body>
 
	<?=module_load('SIDEBAR')?>
    <div class="Mycontainer">
    <h1 class="title">Factuur Aanmaken</h1>
    <div class="maincontainer">
    <form action="administrator/inkomsten/savefactur" method="post"  id="myForm" enctype="multipart/form-data">
            <div class="bottomHolder">
            <div class="rekaning">
                <div class="RekeningInside">
                    <p class="rekaningText">Stad</p>
                    <select name="city" class="miasta form-control" id="exampleFormControlSelect1">
                    <option value="">KIES EEN STAD</option>
                    <?php foreach($sidebarController as $row): ?>
                        <li>
                            <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                        </li>
                    <?php endforeach; ?>
                    </select>
                </div>  
                <div class="RekeningInside">
                    <p class="rekaningText">Adres</p>
                    <select name="adres" class="adresy form-control" id="exampleFormControlSelect1">
                        <option>KIES EEN ADRES</option>
                    </select>
                </div>

                <div class="RekeningInside">
                    <p class="rekaningText">Offerten</p> 
                    <select name="oferten" class="oferty form-control wybor_liczb" id="exampleFormControlSelect1">


                    <option value="0">KIEZ</option>
                   
                   
                    </select>
                </div>  
                <!-- <p class="rekaningText">Warvoor</p> -->
                
                <div class="RekeningInside">
                <?php
                		echo '
                        <div>
                            <table id="kopia_wiersz" class="container"> 
                                <tbody class="warforadd">                             
                                    <tr style="display: none" class="nag warforCenter">
                                    <td class="">
                                        <p class="alignItem rekaningText columnAlignText">Waarvoor</p>
                                        <select id="warfortype" name="warfortype[]" class="form-control selectValid">
                                        <option value="">KIEZ</option>';
                                        foreach($getWarforTypes as $row): ?>
                                            <li>
                                                <option id="<?=$row[2]?>" value="<?php echo $row[0]; ?>"><?php echo $row[1]." (".$row[2]."%)"; ?></option>
                                            </li>
                                        <?php endforeach;

                                           echo'</select>
                                        </td>
                                        <td class="">
                                            <p class="alignItem rekaningText columnAlignText">Opmerkingen</p>
                                            <textarea name="opmerkingen[]" class="inputNewHuurder warforTextArea alignItem" cols="30" rows="30"></textarea>
                                        </td>
                                        <td class="">
                                            <p class="alignItem rekaningText columnAlignText">Aantal</p>
                                            <input id="num1" class="form-control form-control-small getAllWarfor alignItem" name="warfortimespend[]" placeholder="0" value="">
                                        </td>
                                        <td class="">
                                            <p class="alignItem rekaningText columnAlignText">PRIJS EXCL. BTW</p>
                                            <input id="num2" class="form-control form-control-small getAllWarfor alignItem" name="warforquantity[]" placeholder="0" value="">
                                        </td>
                                        <td class="columnAlignText">
                                            <p class="rekaningText">PRIJS INCL. BTW</p>
                                            <input id="sumfield" class="form-control form-control-small alignItem" type="text" readonly>
                                        </td>
                                        <td class=" del blok_mansys bottomAlign">
                                            <input style=" width: auto; display:block; margin:0 auto; height: auto;" class="btn btn-danger" name="del-a" type="submit" value="X" >
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>';
                                    
					?>
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
                    <input class="inputNewHuurder" type="date" name="facturdata" value='<?=$d->format('Y-m-d')?>' >
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6 columnAlignText">
                            <h3 style="margin: 15px 0 15px 0;">Bestanden</h3>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-sm-4 addFiles">
                            <input type="file" name="fileToUpload" id="fileToUpload">
                            <input style="display: none;"name="id_factur" value="<?=$uitgavenModelData[0]['uitgaven_id']; ?>" >
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-sm">
                            <button type="submit" class="btn btn-danger mb-2 btn-small" name="savewarfor">Opslaan</button>
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


    $(".adresy").change(function()
    {
        
        var id_adres = $(this).val();
        var dataString = {
            action: "oferty",
            id_adres: id_adres
           
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

var quan = 0;
function addWarfor() {
        
            var quantity = quan;
            // var ile = $(".ile"+quan).val();
            // alert(".ile"+quan)
            var dataString = {
            action: "warfor",
            quantity: quantity,
            // ile0: ile
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