<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>

<?=add_metatags()?>

<?=add_title("Design Klasy biznes - SuperCMS - Przypomnienie hasła")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css')?>

<?=javascript_load('jQuery.js,jquery.validate.js,jquery.MetaData.js,main.js,main.lost_password.js')?> 
    
<?=icon_load("pp_fav.ico")?>

</head>

<body>
 
<div id="header">
    <?=module_load('LOGINPANEL')?>
    <?=module_load('MENU')?>
</div>

<div id="slogan" class="artykuly">
    <div class="content">
        <div id="motto" class="motto-artykuly"><a href="#">Business Design</a></div>
    </div>
</div>

<div id="main">
  <div class="content">
  		<?=model_load('przypomnienie_haslamodel', 'getContent', '')?>
  </div>
</div>

<?=module_load('FOOTER')?>

</body>
</html>