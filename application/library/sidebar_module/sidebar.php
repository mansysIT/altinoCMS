<?php $sidebarController=model_load('sidebarmodel', 'getCityName', '')?>

<script src="/application/media/js/sidebar.js"></script>

<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">
        <div class="sidebar-header">
        <a class="btn btn-danger" href="wylogowanie/index" role="button">Wyloguj</a>
            <h3>Bootstrap Sidebar</h3>
        </div>

        <ul class="list-unstyled components">
            <li>
                <a href="home/index">Dashboard</a>
            </li>
            <li>
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Adressen</a>
                <ul class="collapse list-unstyled" id="homeSubmenu">
                    <li>
                        <a href="adressen/index">Alle</a>
                    </li>
                    <?php foreach($sidebarController as $row): ?>
                    <li>
                        <a href="#"><?php echo $row[0]; ?></a>
                    </li>
                    <?php endforeach; ?>

                </ul>

            <li>
                <a href="instellingen/stedenlijst">Instellingen</a>
            </li>
            </li>

        </ul>
    </nav>
    <button id="sidebarCollapse" class="btn btn-danger mb-2">X</button>