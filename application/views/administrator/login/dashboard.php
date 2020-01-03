<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Mateusz Manaj - EduWeb" />

<?=add_basehref()?>

<?=stylesheet_load('format.css,style.css,_cfe.css')?>

<?=javascript_load('administrator/_cfe.js,administrator/jquery-1.7.1.min.js,administrator/main.js')?> 
    
<?=icon_load("pp_fav.ico")?>
</head>

<body>
	
<div class="wrapper">
	
	<div class="header">
        <div class="_fLeft"><img src="<?=directory_images()?>main_header_logo.gif" alt="logotype" /></div>
        <div class="_fRight loginInfo"><div class="_auth">ZALOGOWANY JAKO:<br /><span><?=model_load("dashboardmodel", "getCredentials", "")?></span> (<a href="administrator/wylogowanie">Wyloguj</a>)</div></div>
    </div>
	
	<div class="wrapright">
	    <div id="colRight">
            
            <div class="customTable _m5 _fLeft">
                <div class="tableTitle">Statystyka serwisu SuperCMS</div>
                <div class="tableContent">
                    <table class="text">
                        <tr>
                            <td>Ilość stron</td>
                            <td><?=count(directory_map("application/views"))?></td>
                        </tr>
                        <tr>
                            <td>Ilość tłumaczonych stron</td>
                            <td><?=model_load("dashboardmodel", "getTranslationsCount", "")?></td>
                        </tr>
                        <tr>
                            <td>Ilość modułów</td>
                            <td><?=count(directory_map("application/library"))?></td>
                        </tr>
                        <tr>
                            <td>Ilość użytkowników serwisu</td>
                            <td><?=model_load("dashboardmodel", "getUsersCount", "")?></td>
                        </tr>
                        <tr>
                            <td>Ilość administratorów</td>
                            <td><?=model_load("dashboardmodel", "getAdminsCount", "")?></td>
                        </tr>
                    </table>
                </div>
                <div class="tableActionButtons"></div>
            </div>
            
            <div class="customTable _m5 _fLeft">
                <div class="tableTitle">Lista wszystkich stron</div>
                <div class="tableContent">
                    <div class="text">
						<?=model_load("dashboardmodel", "getAllElements", directory_map("application/views"))?>
                    </div>
                </div>
                <div class="tableActionButtons"></div>
            </div>
            
            <div class="customTable _m5 _fLeft">
                <div class="tableTitle">Lista wszystkich modułów</div>
                <div class="tableContent">
                    <div class="text">
						<?=model_load("dashboardmodel", "getAllElements", directory_map("application/library"))?>
                    </div>
                </div>
                <div class="tableActionButtons"></div>
            </div>
            
	    </div>
	</div>
	
	<div id="colLeft">
        <?=module_load("ADMINMENU")?>
    </div>
	
</div>
	
</body>