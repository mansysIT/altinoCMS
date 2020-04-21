<?php
//ini_set( 'display_errors', 'On' ); 
//error_reporting( E_ALL );
require_once($_SERVER['DOCUMENT_ROOT'].'/packages/import_940/mt940_mansys.class.php');
$max_mkti = mktime(1,1,1,1,1,1900);
$max_mkti2 = mktime(1,1,1,1,1,1900);	
$max_mktime = 0;	
$dir = $_SERVER['DOCUMENT_ROOT'].'/application/storage/plik_940/';
foreach (new DirectoryIterator($dir) as $fileInfo) 
	{

		$e = $fileInfo->getFilename();
		if (substr($e, 0, 1) == "+")
		{
			$rokStart = substr($e,1,4);
			$miesiacStart = substr($e,6,2);
			$dzienstart = substr($e,9,2);
			$aktu_mktime = mktime(1,1,1,$miesiacStart,$dzienstart,$rokStart); 
			
			$rokStop = substr($e,12,4);
			$miesiacStop = substr($e,17,2);
			$dzienStop = substr($e,20,2);
			
			$aktu_mktime = mktime(1,1,1,$miesiacStart,$dzienstart,$rokStart); 
			
			
			
			if ( $aktu_mktime > $max_mktime )
			{
				$max_mktime = $aktu_mktime; 
				$aktu2_mktime = mktime(1,1,1,$miesiacStop,$dzienStop,$rokStop);
			}
			
			
		}
	}
$tmp_name = $_FILES["pictures"]["tmp_name"];
$name = $_FILES["pictures"]["name"];


$nowaNazwaPliku = $dir.date("Y-m-d-H_i_s-").$name;

move_uploaded_file($tmp_name, $nowaNazwaPliku);

$o61_86 = new mt940_mansys;	
$wrongData = array();
foreach($o61_86->tablica61Asoc($nowaNazwaPliku) as $row) {
    $x = array();
    if ($row['blok3'] == "D") {
        if ("20".substr($row['blok2'], 0, 2)."-".substr($row['blok2'], 2, 2)."-".substr($row['blok2'], 4, 6) < date('Y-m-d', $aktu2_mktime)) {
            array_push($x, "20".substr($row['blok2'], 0, 2)."-".substr($row['blok2'], 2, 2)."-".substr($row['blok2'], 4, 6));
            array_push($x, $row['blok10']);
            array_push($x, $row['blok4']);

            array_push($wrongData, $x);
        }
    }
	
}
foreach($wrongData as $row) {
echo "<li style='padding: 5px;'>Datum: ".$row[0]." Titel: ".$row[1]." Bedrag: € ".$row[2]."</li>";
}

?>