<?php
 
$id_order=$_GET['id'];
if ($id_order){
include("faktura.php");
}
else
{
echo 'Faktura nie istnieje !!!';
}
?>