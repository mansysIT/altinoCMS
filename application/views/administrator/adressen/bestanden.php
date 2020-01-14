<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<?php $nieuweadressmodel=model_load('adressenmodel', 'createAdresFolder', '')?>
<?php $nieuweadressmodel=model_load('mainmodel', 'remove', '')?>
<?php $nieuweadressmodel=model_load('mainmodel', 'uploadFile', '')?>
<?php $nieuweadressmodel=model_load('mainmodel', 'getAllFilesInDirectory', '')?>
<?php $getParametrs=model_load('mainmodel', 'getParametrs', '')?>
<?php $adresMenuGetUrl=model_load('adressenmodel', 'adresMenuGetUrl', '')?>


<?=add_metatags()?>

<?=add_title("Design Klasy biznes - SuperCMS")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,nieuwe_adress.css,adres.css')?>

<?=javascript_load('jQuery.js,script.js,jquery.localscroll-1.2.5.js,coda-slider.js?no_compress,jquery.scrollTo-1.3.3.js,jquery.serialScroll-1.2.1.js,main.js,sidebar.js,nieuwe_adress.js')?> 
    
<?=icon_load("pp_fav.ico")?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="/application/media/js/nieuwe_adress.js"></script>
<link href="/application/media/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
</head>

<body>
 
<?=module_load('SIDEBAR')?>
    <div class="Mycontainer">
    <?=module_load('adresmenu')?>
    <div class="maincontainer">  
		<?php if(!$getParametrs): ?>     
		<form style="justify-content: start; margin: 25px" class="form-inline" method="post" action="">
		<div class="form-group mx-sm-3 mb-2">
		<label class="sr-only">Add Folder</label>
			<input type="text" class="form-control" id="inputPassword2" name="foldername" placeholder="Folder Name">
		</div>
		<button type="submit" class="btn btn-danger mb-2" name="addfolder">Toevoegen</button>
		</form>
		<?php endif; ?>
		<div class="folderContainer">
		<?php if($nieuweadressmodel[0] != null): ?>
			<?php foreach($nieuweadressmodel[0] as $folder): ?>
				<?php if($folder != "." && $folder != ".."): ?>
				<div class="folderDisplayDiv">
				<a href="/administrator/adressen/bestanden/<?php echo $adresMenuGetUrl."/".$folder ?>" class="folderDisplay"><span class="oi oi-folder" title="folder" aria-hidden="true"></span><?=$folder?></span></a>
				<form method="post" action=""><button class="btnCityRemove" type="submit" name="removefolder" 
				value="<?php echo $folder; ?>"><span class="oi oi-trash" title="trash" aria-hidden="true"></span></button></form>
				</div>
				<?php endif;?>
			<?php endforeach; ?>
		<?php endif; ?>
		</div>

		<div class="fileContainer">
			<ul class="list-group list-group-flush">
			<?php if($nieuweadressmodel[1] != null): ?>
			<?php foreach($nieuweadressmodel[1] as $file): ?>
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
    		Select image to upload:
    		<input type="file" name="fileToUpload" id="fileToUpload">
    		<input type="submit" value="Upload Image" name="submit">
		</form>
		</div>
	<?=module_load('FOOTER')?>
	</div>
</body>
</html>
