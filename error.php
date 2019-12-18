<?php
if(!isset($_SESSION)) session_start();

echo "OBSŁUGA BŁĘDÓW!<br />";

echo "<pre>";
print_r($_SESSION);
echo "</pre><br /><hr /><br />";

if(isset($_SESSION['debug']))
{
	echo base64_decode($_SESSION['debug']);
}

?>