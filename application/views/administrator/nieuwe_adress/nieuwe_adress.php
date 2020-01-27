<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<?php $sidebarController=model_load('mainmodel', 'getCityName', '')?>
<?php $getAllKlanten=model_load('mainmodel', 'getAllClanten', '')?>

<?=add_metatags()?>

<?=add_title("Nieuwe Adress")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,nieuwe_adress.css')?>

<?=javascript_load('main.js,sidebar.js,nieuwe_adress.js')?> 
    
<?=icon_load("pp_fav.ico")?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>



</head>

<body>
 
<?=module_load('SIDEBAR')?>
    <div class="Mycontainer">
    <h1>Nieuw adres</h1>
    <?=module_load('nieuweadressmenu')?>
    <div class="maincontainer">
            <form action="administrator/nieuwe_adress/savenieuwe_adress" method="post">
            <div class="bottomHolder">
            <div class="rekaning">
				<div class="RekeningInside">
                    <p class="rekaningText">Adres</p>
                    <input class="inputNewHuurder" type="text" name="adres" value='' >
                </div>
                <div class="RekeningInside">
                    <p class="rekaningText">Postcode</p>
                    <input class="inputNewHuurder" type="text" name="postcode" value=''>
                </div>       
                <div class="RekeningInside">
                    <p class="rekaningText">City</p>
                    <select name="city" class="form-control" id="exampleFormControlSelect1">
                    <?php foreach($sidebarController as $row): ?>
                    <li>
                    <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                    </li>
                    <?php endforeach; ?>
                    </select>
                </div> 
                <div class="RekeningInside">
                    <p class="rekaningText">Klanten</p>
                    <select name="klanten" class="form-control" id="exampleFormControlSelect1">
                    <?php foreach($getAllKlanten as $row): ?>
                        <option value="<?php echo $row[0]; ?>" <?php if($row[0] == $getDataFromAdres['klanten_id']) echo" selected" ?>><?php if(!empty($row[1]) && !empty($row[2])){ echo $row[0]." ".$row[1]." ".$row[2];} else if(!empty($row[6])) {echo $row[0]." ".$row[6];} else {echo $row[0];} ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>  
                <button type="submit" class="btn btn-danger mb-2 btn-small" style="margin-left: 0.8%; margin-top: 30px;" name="adresbtn">Toevoegen</button>      
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
