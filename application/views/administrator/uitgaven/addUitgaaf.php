<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>


<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<?php $sidebarController=model_load('nieuwe_adressmodel', 'getCityName', '')?>
<?php $uitgavenModelData=model_load('uitgaafmodel', 'showdata', '')?> 

<?=add_metatags()?>

<?=add_title("addUitgaaf")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,nieuwe_adress.css')?>

<?=javascript_load('main.js,sidebar.js,nieuwe_adress.js')?> 
     
<?=icon_load("pp_fav.ico")?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


<body>
 
<?php
$waarvoor = array();
$waarvoor = model_load('waarvoormodel', 'getWaarvoor', ''); 
model_load('uitgavenmodel', 'saveUitgaaf', ''); 


?>    
 
    <?=module_load('SIDEBAR')?>
   

    <div class="Mycontainer"> 
    <h1>Uitgaaf</h1>
    <div class="maincontainer">
    <form action="" method="post">
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
                    <select name="oferte_id" class="form-control" id="exampleFormControlSelect1">
                    <option value="">KIEZ</option>
                    <option value="1">oferta 1</option>
                    <!-- <?php foreach($offerten as $row): ?> 
                        <li>
                            <option value="<?php echo $row[0]; ?>"<?php if(!empty($uitgavenModelData) && $row[0] == $uitgavenModelData[0]['oferte_id']) echo 'selected'; ?>><?php echo $row[1]; ?></option>
                        </li>
                    <?php endforeach; ?>  -->
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
   
            </div>
            <div class="right">


            </div>
            
        </div>
        <button type="submit" class="btn btn-danger mb-2" name="savewarfor">Toevoegen</button>
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