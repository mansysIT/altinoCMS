
<?php

function ActiveClassIfRequestMatches($requestUri)
{
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");

    if ($current_file_name == $requestUri)
        echo 'class="active"';
}

?>


<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
      <div id="navbar" class="navbar-collapse" id="navbarSupportedContent">
        <ul class="nav navbar-nav">
          <li><a <?php ActiveClassIfRequestMatches('nieuwe_adress')?> href="administrator/nieuwe_adress/nieuwe_adress">NIEUWE ADRESS</a></li>
        </ul>	
        <ul class="nav navbar-nav navbar-right">

        </ul>
      </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
  </nav>