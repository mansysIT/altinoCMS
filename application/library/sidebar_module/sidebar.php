<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>


<?=add_metatags()?>
<?=include_once($_SERVER['DOCUMENT_ROOT'].'/application/controllers/sidebar.php');
$sidebarController = new sidebar();
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>

<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">
        <div class="sidebar-header">
        <a class="btn btn-danger" href="wylogowanie/index" role="button">Wyloguj</a>
            <h3>Bootstrap Sidebar</h3>
        </div>

        <ul class="list-unstyled components">
            <li>
                <a href="#">Dashboard</a>
            </li>
            <li class="active">
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Adressen</a>
                <ul class="collapse list-unstyled" id="homeSubmenu">
                    <?php foreach($sidebarController->getAdress() as $row): ?>
                    <li>
                        <a href="#"><?php echo $row; ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Page Content  -->

<script>$(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });
});</script>
<!-- TABS PRESENTATION // -->