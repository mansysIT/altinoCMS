<?php
class mt940_mansys {
	
		private $ile61;
		
		public function test()
		{
			echo "<h1 style=\"color:red;\">Class mt940_mansys is working</h1>";
		}

		public function sumaTranzakcji($plikString)
		{
			$suma = 0;
			$tablicaDni = explode(':20:', $plikString);
			$tablica = explode(':61:', $tablicaDni[1]);
			echo '<pre>';
			
			unset($tablica[0]);
			$ileWierszy = count($tablica);
			$tablica[$ileWierszy] = substr($tablica[$ileWierszy],0, strpos($tablica[$ileWierszy], ":62F:"));
			
			foreach($tablica as $wiersz)
			{
				$blok3 = substr($wiersz, 6, 1);
				$blok4 = ltrim(substr($wiersz, 7, 15),'0');	
				
				
				if ($blok3 =="D")
				{
					echo '<br />Suma: -'.$blok4;
					$suma-=$blok4;
				}  
				else
				{
					echo '<br />Suma: '.$blok4;
					$suma+=$blok4;
				}
				
			}
			echo '<br />Razem: '.$suma;
		return ;		
			
		}
		
		public function ileWierszy($szukana, $plik)
		{
			$ciag = fread(fopen($plik, "r"), filesize($plik));
			$ile=substr_count($ciag, $szukana);
			return $ile;
		}
		
		public function tablicaWiersze6186($plik)
		{
			$ciag = fread(fopen($plik, "r"), filesize($plik));
			$tablica = explode(':61:', $ciag);
			$this->ileWierszy(":61:", $tablica);

			unset($tablica[0]);
			return $tablica;
		} 
		
		public function delNewLines($str) {
			$del = array("\r" => '', "\n" => '');
			return strtr($str, $del);
		}	
		
		public function clean($ciag)
		{
			$tablica = preg_split('/:[0-9]{2,3}:/',$ciag); 
			echo '<pre>';
				print_r($tablica);
			
			return;
		}
		
		//Wersja pierwsza nie sprawdzająca daty
		/*
		public function error2($plikString)
		{
			
			$numerTranzakcji=1;
			$tablica = explode("\n", $plikString);
			foreach($tablica as $wiersz)
			{
				if (substr($wiersz, 0, 4)==":61:")
				{
					if (substr($wiersz,26,1)!="N")
						return $numerTranzakcji;
					if ((substr($wiersz,10,1)!="D"))
						if ((substr($wiersz,10,1)!="C"))
							return $numerTranzakcji;
					
				}					
				$numerTranzakcji++;
			}
			return 0;
			
		}
		*/
		
		public function error2($plikString, $date_sek)
		{
			
			$numerTranzakcji=1;
			$tablica = explode("\n", $plikString);
			foreach($tablica as $wiersz)
			{
				if (substr($wiersz, 0, 4)==":61:")
				{
					if (substr($wiersz,26,1)!="N")
					{
						return $numerTranzakcji;
					}
					if ((substr($wiersz,10,1)!="D"))
					{	
						if ((substr($wiersz,10,1)!="C"))
						{
							return $numerTranzakcji;
						}
					}
					$blok2 = '20'.substr($wiersz, 4, 6);
					$blok3 = '20'.substr($wiersz, 4, 6);
					$date_file = new DateTime($blok2);
					$date_limit = new DateTime($date_sek);
					//echo '<br/>$date_file:'.$date_file->format('Y-m-d').'   $date_limit:'.$date_limit->format('Y-m-d');
					if ( $date_file < $date_limit )
					{
						echo 'data:'.$date_file->format('Y-m-d').' < '.$date_limit->format('Y-m-d').'<br />';
						return $numerTranzakcji;
					}
						
					
				}					
				$numerTranzakcji++;
				
			}
			return 0;
			
		}
		
		public function error($plikString)
		{
			
			$numerTranzakcji=0;
			$tablica = explode(':61:', $plikString);
			
			
			unset($tablica[0]);
			$ileWierszy = count($tablica);
			$tablica[$ileWierszy] = substr($tablica[$ileWierszy],0, strpos($tablica[$ileWierszy], ":62F:"));
			
			foreach($tablica as $wiersz)
			{

				$pozycjaN = strpos($wiersz, "N");
				
				if ($pozycjaN != 22)
				{
					return true;
				}
				$pozycjaD = strpos($wiersz, "D");
				$pozycjaC = strpos($wiersz, "C");
				/*
				if (!($pozycjaD == 6))
				{
					return true;
				}
				*/
			}
			return false;
		}
		
		public function tablica6186($plik, $id, $blok)
		{
			$numerTranzakcji=0;
			$ciag = fread(fopen($plik, "r"), filesize($plik));
			$tablica = explode(':61:', $ciag);
			
			unset($tablica[0]);
			$ileWierszy = count($tablica);
			$tablica[$ileWierszy] = substr($tablica[$ileWierszy],0, strpos($tablica[$ileWierszy], ":62F:"));

			foreach($tablica as $wiersz)
			{
				$blok1 = substr($wiersz, 0, 6);
				$blok2 = substr($wiersz, 0, 6);
				$blok3 = substr($wiersz, 6, 1);
				$blok4 = ltrim(substr($wiersz, 7, 15),'0');
				$blok5 = substr($wiersz, 22, 4);
					
				$tab=explode("\n", $wiersz);
				$blok6=$tab[1];
					
				$wiersz = strtr($wiersz, array("\r" => '', "\n" => ''));
				$wiersz = preg_replace('/\s{2,}/',' ',$wiersz);
					
				if (strpos ($wiersz,"/ADDR/"))
					{
						$blok8 = substr($wiersz, strpos($wiersz, "/NAME/")+6, strpos($wiersz, "/ADDR/")-strpos($wiersz, "/NAME/")-6);
						$blok9 = substr($wiersz, strpos($wiersz, "/ADDR/")+6, strpos($wiersz, "/REMI/")-strpos($wiersz, "/ADDR/")-6);
					} 
				else
					{
						$blok8 = substr($wiersz, strpos($wiersz, "/NAME/")+6, strpos($wiersz, "/REMI/")-strpos($wiersz, "/NAME/")-6);
						$blok9 = "null";
					}	
					 
				$blok10 = substr($wiersz, strpos($wiersz, "/REMI/")+6,  strlen($wiersz)-strpos($wiersz, "/REMI/")-6);
				$blok7 = 0;
				$wynik[$numerTranzakcji] = array("blok1"=>$blok1,"blok2"=>$blok2,"blok3"=>$blok3,"blok4"=>$blok4,"blok5"=>$blok5,"blok6"=>$blok6,"blok7"=>$blok7,"blok8"=>$blok8,"blok9"=>$blok9,"blok10"=>$blok10);

				$numerTranzakcji++;
				/*
				echo '<br />'.$numerTranzakcji.'<br/>'. 
					'Rente datum: '.substr($blok2,0,2).'.'.substr($blok2,2,2).'.'.substr($blok2,4,2).'<br />'.
					'Debet/Credit: '.$blok3.'<br />'.
					'Bedrag: '.$blok4.'<br />'.
					'typ: '.$blok5.'<br />'.
					'konto: '.$blok6.'<br />'.
					'Naam: '.$blok8.'<br />'.
					'ADDR: '.$blok9.'<br />'.
					'REMI: '.$blok10.'<br />';
				*/
			}
  
		return $wynik[$id][$blok];		
		}
	
	public function tablica61Asoc($plik)
		{
			$numerTranzakcji=0;
			$ciag = fread(fopen($plik, "r"), filesize($plik));
			$tablica = explode(':61:', $ciag);
			
			unset($tablica[0]);
			$ileWierszy = count($tablica);
			//$tablica[$ileWierszy] = substr($tablica[$ileWierszy],0, strpos($tablica[$ileWierszy], ":62F:"));
			 
			foreach($tablica as $wiersz)
			{
				if (strpos($wiersz, ":62F:") > 0 )
				{
					$wiersz = substr($wiersz, 0, strpos($wiersz, ":62F:"));
				}
				$blok2 = substr($wiersz, 0, 6);
				$blok3 = substr($wiersz, 10, 1);
				$x = preg_replace("/[^0-9]+/", "", substr($wiersz, 11, 12));
				$blok4 = substr($x,0,-2).','.substr($x."0",-3,-1);
				//$time = substr($time,0,2).':'.substr($time,2,2);
				$blok5 = substr($wiersz, 22, 4);
					
				$tab=explode("\n", $wiersz);
				$blok6=$tab[1];
					
				$wiersz = strtr($wiersz, array("\r" => '', "\n" => ''));
				$wiersz = preg_replace('/\s{2,}/',' ',$wiersz);
					
				if (strpos($wiersz, "/CNTP/"))
					{	 
						$blok8 = substr($wiersz, strpos($wiersz, "/CNTP/")+6,  strlen($wiersz)-strpos($wiersz, "/CNTP/")-6);
					}
				else 
					{
						$blok8 = "null";
					}
				if (strpos($wiersz, "/USTD/"))
					{	 
						$blok10 = substr($wiersz, strpos($wiersz, "/USTD/")+6,  strlen($wiersz)-strpos($wiersz, "/USTD/")-6);
					}
				else 
					{
						$blok10 = "null";
					}

					$blok9 = 0;
				
				$wynik[$numerTranzakcji] = array("blok2"=>$blok2,"blok3"=>$blok3,"blok4"=>$blok4,"blok5"=>$blok5,"blok6"=>$blok6,"blok8"=>$blok8,"blok9"=>$blok9,"blok10"=>$blok10);

				$numerTranzakcji++;
				/*
				echo '<br />'.$numerTranzakcji.'<br/>'. 
					'Rente datum: '.substr($blok2,0,2).'.'.substr($blok2,2,2).'.'.substr($blok2,4,2).'<br />'.
					'Debet/Credit: '.$blok3.'<br />'.
					'Bedrag: '.$blok4.'<br />'.
					'typ: '.$blok5.'<br />'.
					'konto: '.$blok6.'<br />'.
					'Naam: '.$blok8.'<br />'.
					'ADDR: '.$blok9.'<br />'.
					'REMI: '.$blok10.'<br />';
				*/
			}
  
		return $wynik;		
		}
}
?>