<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>

<?php 

function ActiveClassIfRequestMatches($requestUri)
{
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");

    if ($current_file_name == $requestUri)
        echo 'class="active"';
}

?>

<?=add_metatags()?>
<?=stylesheet_load('screen.css,sidebar.css,table.css,style.css,all.css,instellingen.css,instellingenmenu.css')?>
<?=javascript_load('table.js,jQuery.js,script.js,jquery.localscroll-1.2.5.js,coda-slider.js?no_compress,jquery.scrollTo-1.3.3.js,jquery.serialScroll-1.2.1.js,main.js,sidebar.js,menu.js')?>
<?=include_once('sidebar.php');
$sidebarController = new sidebar();
?>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<nav class="navbar navbar-dark bg-primary">
        <div class="container-fluid">
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a <?php ActiveClassIfRequestMatches('stedenlijst')?> href="instellingen/stedenlijst">Stedenlijst</a></li>
              <li><a <?php ActiveClassIfRequestMatches('stedenlijst')?> href="instellingen/stedenlijst">About</a></li>
              <li><a <?php ActiveClassIfRequestMatches('stedenlijst')?> href="#">Contact</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">

            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
      <script type="text/javascript">
$('.nav li a').on('click', function() {
    alert('clicked');
    $(this).parent().parent().find('.active').removeClass('active');
    $(this).parent().addClass('active');
});
</script>