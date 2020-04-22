<?php

//ini_set( 'display_errors', 'On' ); 
//error_reporting( E_ALL );

require_once($_SERVER['DOCUMENT_ROOT'].'/packages/import_940/mt940_mansys.class.php');

class importmodel
{
	public $query;
	public $cityArray = Array();

	private $__config;
	private $__router;
    private $__params;
	private $__db;
	private $mainModel;
	private $max_mktime;
	private $aktu2_mktime;
	private $dataStart;
	private $dataStop;

	
	public function __construct()
	{
		$this->__config = registry::register("config");
		$this->__router = registry::register("router");
        $this->__params = $this->__router->getParams();
		$this->__db = registry::register("db");
		
		$this->mainModel = new mainmodel;
	}

	public function getCurrentData()
	{
		$dir = 'application/storage/plik_940/';
		$x = array();
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

                if ($aktu_mktime > $this->max_mktime) {
					
					$this->max_mktime = $aktu_mktime; 
					$this->aktu2_mktime = mktime(1,1,1,$miesiacStop,$dzienStop,$rokStop);

					
                }
			}
		}
		array_push($x, $this->max_mktime);
		array_push($x, $this->aktu2_mktime);
		return $x;
	}

	public function importen()
	{

			//Nazwa strony
			$title = 'Impoteren';
			$dir = 'application/storage/plik_940/';
			
			
			$zm = new mainmodel();	
			
					$this->max_mktime = mktime(1,1,1,1,1,1900);
					$max_mkti2 = mktime(1,1,1,1,1,1900);
					;		
					
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
							
							
							
							if ( $aktu_mktime > $this->max_mktime )
							{
								// return $aktu_mktime." - ".mktime(1,1,1,$miesiacStop,$dzienStop,$rokStop); 
								
							}
							
							
						}
					}

				if ($_FILES["fileToUpload"]['error'] == 0) 
				{
					
					
					$tmp_name = $_FILES["fileToUpload"]["tmp_name"];
					$name = $_FILES["fileToUpload"]['name'];
					$nowaNazwaPliku = $dir.date("Y-m-d-H_i_s-").$name;
					$fileName = basename($name);
					$this->mainModel->uploadFile($dir, $fileName);
					
					foreach (new DirectoryIterator($dir) as $fileInfo) 
					{
						$e = $fileInfo->getFilename();
							if ($e == basename($name))
							{
								$newName = (string)date("Y-m-d-H_i_s-").$e;
								rename($dir.$e, $dir.$newName);
							}
					}
					//var_dump($nowaNazwaPliku);
					$plik=fread(fopen($nowaNazwaPliku, "r"), filesize($nowaNazwaPliku));

					$o61_86 = new mt940_mansys;	
				//	$konta ;
					
					
						
						$ile61 = substr_count($plik, ':61:');
						//$rekeningBazaTab = $konta->rekening_baza_load();
						$DanePlikAsoc = $o61_86->tablica61Asoc($nowaNazwaPliku);
						
						$numerD = 0;
					
						for($numer=0;$numer<$ile61;$numer++)
						{	
							
							if ($DanePlikAsoc[$numer]['blok3']=='D')
							{
								$konto = 0;
								$konto = $DanePlikAsoc[$numer]['blok6'];
							
								$konto = preg_replace('/\s{1,}/','',$konto);


								
								$tytul = $DanePlikAsoc[$numer]['blok10'];
									
								$tytul = str_replace("'", "", $tytul);

								
								
								$blok8 = $DanePlikAsoc[$numer]['blok8'];
									
								$blok8 = str_replace("'", "", $blok8);

								$konto = substr($blok8 , 0, 18);

								//  var_dump($konto);
								//  die;

								if(strpos($tytul, "HOMBACH") || strpos($tytul, "Hombach") || strpos($tytul, "hombach"))
								{
									$waarvoorId = 27;
								}else if(strpos($tytul, "BOUWMAAT") || strpos($tytul, "Bouwmaat") || strpos($tytul, "bouwmaat"))
								{
									$waarvoorId = 28;
								}else if(strpos($tytul, "EKC") || strpos($tytul, "Ekc") || strpos($tytul, "ekc"))
								{
									$waarvoorId = 26;
								} else 
								// if(strpos($blok8, "HOMBACH") || strpos($blok8, "Hombach") || strpos($blok8, "hombach"))
								// {
								// 	$waarvoorId = 27;
								// }else if(strpos($blok8, "BOUWMAAT") || strpos($blok8, "Bouwmaat") || strpos($blok8, "bouwmaat"))
								// {
								// 	$waarvoorId = 28;
								// }else if(strpos($blok8, "EKC") || strpos($blok8, "Ekc") || strpos($blok8, "ekc"))
								// {
								// 	$waarvoorId = 26;
								// } else 
								{
									$waarvoorId = 25;
								}

								$x = $this->__db->execute("SELECT * FROM bouw_zzp");

                                foreach ($x as $row) {          
                                    if ($konto == preg_replace('/\s+/', '', $row['rekening'])&& $row['rekening'] !=null) {
                                        if ($row['id'] == null) {
                                            $zzpId = 0;
                                        } else {
											$zzpId = $row['id'];
										break;
                                        }
                                    } else {
										$zzpId = 0;
									}
                                }


								$kwota = $DanePlikAsoc[$numer]['blok4'];
								
								$kwota = $zm->zmiana_przecinka($kwota);
								
								
								$data_cala = $DanePlikAsoc[$numer]['blok2'];
								$data = '20'.substr($data_cala,0,2).'-'.substr($data_cala,2,2).'-'.substr($data_cala,4,2);

								$tytul = substr($tytul, 1, -1);

								$this->__db->execute("INSERT INTO bouw_uitgaven (adres_id, price, oferte_numer, waarvoor_id, data, zzp_id, description) VALUES (0, ".$kwota.", 0, ".$waarvoorId.", '".$data."', ".$zzpId.", '".$tytul."')");

								if ($numerD ==0 )
								{
									$this->dataStart = $data;
								}
								
							
									$this->dataStop = $data;
									

									//return data
								
								$numerD++;
								//echo '<br />data0 = '.$this->dataStart;
								//	echo '<br />data0 = '.$this->dataStop;
								$tytul_male = strtolower($tytul);

							//	$adres_id = $konta->konta_pokaz_id($konto,$rekeningBazaTab);
						
								
							//	if ($konta->konta_pokaz_id($konto,$rekeningBazaTab) > 0)
							//		{

													
							//		}
			

							} 
							else 
							{
								
							
								
							}

					
						
					
			
					
					}
						$zmianaNazwyPliku = $dir.'+'.$this->dataStart.'_'.$this->dataStop.'_'.date("Y-m-d-H_i_s-").$name;
						rename($nowaNazwaPliku,$zmianaNazwyPliku);
						
						//header('Location:import_940.php?msg='.$msg);	
						
				
			



						
			}	

			
		//require_once('../themes/admin/header_artur.php'); 
		//echo '<div id="content" class="import_940">';
		//	require_once('../themes/admin/import_940.php'); 
		//echo '</div>';
		if($_POST["importen"])
		{
			header("Location: ".SERVER_ADDRESS."/administrator/import/index");
		}
		ob_end_flush();		
	}
	
}

?>