<?php
if(!isset($_SESSION)) session_start();

include_once("../../../core/config/configs.php");

if(isset($_POST['chlang']))
{
    $_SESSION[$configs['default_session_var']] = $_POST['lang'];
}
else
{
    die("Dostęp z zewnątrz zabroniony!");
}

?>