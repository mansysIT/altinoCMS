<?php

ob_start();

require_once("core/init.php");					// __autoload()

$router = registry::register("router");
dispatcher::dispatch($router);


$i18n = registry::register("i18n");
$i18n->setMainLanguage();

ob_end_flush();

?>