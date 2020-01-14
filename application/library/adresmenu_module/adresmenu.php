
<?php

$getAdresId = model_load('adressenmodel', 'adresMenuGetUrl', '');

function ActiveClassIfRequestMatches($requestUri)
{  
    // $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
    $getPage = model_load('adressenmodel', 'adresMenuPageName', '');

    if ($getPage == $requestUri)
        echo 'class="active"';
}
?>

<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
      <div id="navbar" class="navbar-collapse" id="navbarSupportedContent">
        <ul class="nav navbar-nav">
          <li><a <?php ActiveClassIfRequestMatches('adres')?> href="administrator/adressen/adres/<?php echo $getAdresId ?>">ADRESS</a></li>
          <li><a <?php ActiveClassIfRequestMatches('bestanden')?> href="administrator/adressen/bestanden/<?php echo $getAdresId ?>">BESTANDEN</a></li>
          <li><a <?php ActiveClassIfRequestMatches('offerten')?> href="administrator/oferten/index/<?php echo $getAdresId ?>">OFERTEN</a></li>
        </ul>	
        <ul class="nav navbar-nav navbar-right">

        </ul>
      </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
  </nav>