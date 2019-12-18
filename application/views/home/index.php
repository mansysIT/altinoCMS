<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>

<?=add_metatags()?>

<?=add_title("Design Klasy biznes - SuperCMS")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css')?>

<?=javascript_load('jQuery.js,script.js,jquery.localscroll-1.2.5.js,coda-slider.js?no_compress,jquery.scrollTo-1.3.3.js,jquery.serialScroll-1.2.1.js,main.js')?> 
    
<?=icon_load("pp_fav.ico")?>

</head>

<body>
 
<div id="header">
    <div id="lang-changer">Język witryny: <a href="javascript:void(0);" onclick="changeLangTo('pl');"><img src="<?=directory_images()?>pl.png" alt="PL" /></a><a href="javascript:void(0);" onclick="changeLangTo('en');"><img src="<?=directory_images()?>gb.png" alt="GB" /></a></div>
    <?=module_load('LOGINPANEL')?>
    <?=module_load('MENU')?>
</div>

<div id="slogan">
    <div class="content">
        <div id="motto"><a href="#">Business Design</a></div>
    </div>
</div>

<div id="main">
  <div class="content">
        	<div class="column">
                <div class="box szary">
               	    <?=add_tr('tekst1')?>
                </div>
                <div class="box firma">
               	    <?=add_tr('slider')?>
                </div>
         </div>
         
         <div class="column">
        	<div class="box kwalifikacje">
        	   <?=add_tr('kwalifikacje')?>            
            </div>
            <div class="box biznes">
           	    <?=add_tr('rozwoj')?>
            </div>
         </div>
         
  </div>
</div>

<?=module_load('FOOTER')?>

</body>
</html>