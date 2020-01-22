<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<?php $sidebarController=model_load('mainmodel', 'getCityName', '')?>
<?php $getWarforTypes = model_load('mainmodel', 'getWaarvoor', '')?>
<?=model_load('ofertenmodel', 'saveoferten', '')?>

<?=add_metatags()?>

<?=add_title("Oferten")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,nieuwe_adress.css,factur.css')?>

<?=javascript_load('sidebar.js')?> 
    
<?=icon_load("pp_fav.ico")?>

<?php
$d = new DateTime(date("Y-m-d"));
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">



<script src="/application/media/js/addfileds.js"></script>




</head>



<body>
 
	<?=module_load('SIDEBAR')?>
    <div class="Mycontainer">
    <h1 class="title">Offerte Aanmaken</h1>
    <div class="maincontainer">  
    <form action="" method="post" id="myForm">
            <div class="bottomHolder">
            <div class="rekaning">
                <div class="RekeningInside">
                    <p class="rekaningText">City</p>
                    <select name="city" class="miasta form-control" id="exampleFormControlSelect1">
                    <option value="">SELECT CITY</option>
                    <?php foreach($sidebarController as $row): ?>
                        <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
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
                </div>  
                <div class="RekeningInside">
                <?php
                		echo '
                        <div>
                            <table id="kopia_wiersz" class="container"> 
                                <tbody class="warforadd">                             
                                    <tr style="display: none" class="nag warforCenter" id="count">
                                        <td class="">
                                        <p class="rekaningText">Waarvoor</p>
                                        </td>
                                        <td class="">
                                        <select name="warfortype[]" class="form-control">';
                                        foreach($getWarforTypes as $row): ?>
                                            <option value="<?php echo $row[0]; ?>"><?php echo $row[1]." (".$row[2]."%)"; ?></option>
                                        <?php endforeach;

                                           echo'</select>
                                        </td>
                                        <td class="">
                                            <textarea name="opmerkingen[]" class="inputNewHuurder warforTextArea" cols="30" rows="10">'.$rows["opmerkingen"].'</textarea>
                                        </td>
                                        <td class="">
                                        <p class="rekaningText">Aantal</p>
                                        </td>
                                        <td class="">
                                            <input id="num1" class="form-control form-control-small getAllWarfor" placeholder="0" name="warfortimespend[]" value="">
                                        </td>
                                        <td class="">
                                        <p class="rekaningText">Prijs</p>
                                        </td>
                                        <td class="">
                                            <input id="num2" class="form-control form-control-small getAllWarfor" placeholder="0" name="warforquantity[]" value="">
                                        </td>
                                        <td class=" del blok_mansys">
                                            <input style=" width: auto; display:block; margin:0 auto; height: auto;" class="btn btn-danger remove" name="del-a" type="submit" value="X" >
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
                        <div class="col-sm-11 columnAlignText">
                        </div>
                        <div class="col-sm-1 columnAlignText">
                            <h2 class="sumValue"></h2>
                        </div>
                    </div>
                </div>
				<div class="RekeningInside">
                    <p class="rekaningText">Start Datum</p>
                    <input class="inputNewHuurder" type="date" name="ofertendata" value='<?=$d->format('Y-m-d')?>' >
                </div>

                <div class="RekeningInside">
                    <p class="rekaningText">Geplande</p>
                    <input class="inputNewHuurder" type="date" name="ofertendataend" value='<?=$d->format('Y-m-d')?>' >
                </div>
                <button type="submit" class="btn btn-danger mb-2 btn-small" name="saveoferten">Opslaan</button>
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