<?php 

function ActiveClassIfRequestMatches($requestUri)
{
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");

    if ($current_file_name == $requestUri)
        echo 'class="active"';
}

?>

<?=include_once('sidebar.php');
$sidebarController = new sidebar();
?>


</head>
  <nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <li><a <?php ActiveClassIfRequestMatches('stedenlijst')?> href="instellingen/stedenlijst">Stedenlijst</a></li>
          <li><a <?php ActiveClassIfRequestMatches('example1')?> href="instellingen/example1">Example1</a></li>
          <li><a <?php ActiveClassIfRequestMatches('example2')?> href="instellingen/example2">Example2</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">

        </ul>
      </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
  </nav>
