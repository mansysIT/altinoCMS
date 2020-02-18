<?php $cityList=model_load('sidebarmodel', 'getCityName', '')?>

<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">
        <div class="sidebar-header">
        <a class="btn logoutbutton" href="wylogowanie/index" role="button">Wyloguj</a>
            <img src="/application/media/images/logo.png">
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
                    <?php foreach($cityList as $row): ?>
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
                <a href="administrator/proforma/index">Proforma</a> 
            </li>
            <li>
                <a href="administrator/oferten/index">Offerten</a>
            </li>
            <li>
                <a href="administrator/klanten/index/1">Klanten</a>
            </li>
            <?php if(true): ?>
            <li>
                <a href="administrator/ZZP/index/1">ZZP-res</a>
            </li>
            <?php endif; ?>
            <li>
                <a href="administrator/instellingen/stedenlijst">Instellingen</a>
            </li>   
        </ul>
    </nav>
    <button id="sidebarCollapse" class="btn  mb-2 sidebarGray"><p>X</p></button>