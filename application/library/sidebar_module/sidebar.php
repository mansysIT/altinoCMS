<?php $sidebarController=model_load('sidebarmodel', 'getCityName', '')?>

<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">
        <div class="sidebar-header">
        <a class="btn btn-danger" href="wylogowanie/index" role="button">Wyloguj</a>
            <h3 style="text-align: center">Aguiar Bouw</h3>
        </div>

        <ul class="list-unstyled components">
            <li>
                <a href="administrator/home/index">Dashboard</a>
            </li>
            <li>
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Adressen</a>
                
                <ul class="collapse list-unstyled" id="homeSubmenu">
                    <li>
                        <a href="administrator/adressen/index">Alle</a>
                    </li>
                    <?php foreach($sidebarController as $row): ?>
                    <li>
                    <?=" <a href='administrator/adressen/index/stad/$row[0]'> $row[1]</a>" ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
           </li>
            <li>
                <a href="administrator/inkomsten/index">Inkomsten</a>
            </li>
            <li>
                <a href="administrator/uitgaven/index">Uitgaven</a> 
            </li>
            <li>
                <a href="administrator/proforma/proforma">Proforma</a> 
            </li>
            <li>
                <a href="administrator/instellingen/stedenlijst">Instellingen</a>
            </li>
        </ul>
    </nav>
    <button id="sidebarCollapse" class="btn btn-danger mb-2">X</button>