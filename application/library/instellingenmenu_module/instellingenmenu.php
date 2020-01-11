<?php

function ActiveClassIfRequestMatches($requestUri)
{
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");

    if ($current_file_name == $requestUri)
        echo 'class="active"';
}

?>

</head>
  <nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
      <div id="navbar" class="navbar-collapse collapseinsteligen">
        <ul class="nav navbar-nav">
          <li><a <?php ActiveClassIfRequestMatches('stedenlijst')?> href="administrator/instellingen/stedenlijst">Stedenlijst</a></li>
          <li><a <?php ActiveClassIfRequestMatches('addwarfor')?> href="administrator/instellingen/addwarfor">Waarvoor</a></li>
          <li><a <?php ActiveClassIfRequestMatches('example2')?> href="administrator/instellingen/example2">Example2</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">

        </ul>
      </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
  </nav>
