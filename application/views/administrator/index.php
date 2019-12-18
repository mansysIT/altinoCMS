<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Mateusz Manaj - EduWeb" />
	
<?=add_basehref()?>
    
<?=stylesheet_load('format.css,style.css,_cfe.css')?>
    
<?=javascript_load('administrator/_cfe.js')?>

<?=icon_load("pp_fav.ico")?>

	<title>Panel Administracyjny - SuperCMS</title>
</head>

<body>

<div id="mainSite">

    <div id="loginPanel">
        <div class="_header"></div>
        <div class="_content">
            <img src="<?=directory_images()?>/lp_warn.gif" alt="warning" /><h4 class="loginPanelInfo">Podaj dane dostępu do Panelu Administracyjnego</h4>
            <div class="inputContainer">
                <form method="POST" action="logowanie">
                    <div class="_llbl inputLabel _fLeft">Login</div><input type="text" value="" name="login" class="_fLeft customInput" /><br /><br />
                    <div class="_plbl inputLabel _cb _fLeft">Hasło</div><input type="password" value="" name="password" class="_fLeft customInput" />
                    <input type="submit" value="Zaloguj" class="customBtn loginBtn" />
                </form>
            </div>
        </div>
        <div class="_footer"></div>
    </div>

</div>

</body>
</html>