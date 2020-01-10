<?php


//ini_set( 'display_errors', 'On' ); 
//error_reporting( E_ALL );




include '../connect.php'; 




class ProformaPdf extends conf{


	public function ProformaMakePdf($id, $betaal = NULL) {
		
		$data_nl = new conf();
		
		$faktura_n = mysql_query("SELECT p.*, a.adres AS adresy_adres, a.miasto AS adresy_miasto FROM `bedrijf_proformy` p 
		LEFT JOIN adresy a ON a.id = p.adres_id

		WHERE p.id = '".$id."'");


		$kwoty_faktura = mysql_fetch_array($faktura_n);

		$warrvoor = $kwoty_faktura['warrvoor'];

		//WAZNE !!! - ustawienie kodowania po?aczenia z MySQL dzieki czemu wyswietlane sa polskie litery
		//mysql_query("SET NAMES 'latin2'");

		mysql_query ("SET NAMES 'latin2'"); //kodowanie znak?w 



		$borg = 0;
			
			$hu = $kwoty_faktura['huur'];
			$ge = $kwoty_faktura['ge'];
			$wa = $kwoty_faktura['water'];
			$in = $kwoty_faktura['internet'];
			$ad = $kwoty_faktura['administratiekosten'];
			$bo = $kwoty_faktura['boete'];
			$borg = $kwoty_faktura['borg'];
			$cala_kwota_incl = $kwoty_faktura['cala_kwota_proforma']; 
			$cala_kwota = $cala_kwota_incl;

		//echo $wsz_wplaty;





		$tabela_vat[$kwoty_faktura['vat_huur']][] = $kwoty_faktura['huur'];
		$tabela_vat[$kwoty_faktura['vat_ge']][] = $kwoty_faktura['ge'];
		$tabela_vat[$kwoty_faktura['vat_water']][] = $kwoty_faktura['water'];
		$tabela_vat[$kwoty_faktura['vat_internet']][] = $kwoty_faktura['internet'];
		$tabela_vat[$kwoty_faktura['vat_admin']][] = $kwoty_faktura['administratiekosten'];
		$tabela_vat[$kwoty_faktura['vat_borg']][] = $kwoty_faktura['vat_borg'];


		/*
		echo '<pre>';
		print_r($tabela_vat);

			foreach($tabela_vat as $k => $stawki_vat){
				echo $k.'vat:';
				
					$dzielnik = $k / 100 + 1;
					
					$kw = 0;
					foreach($stawki_vat as $k2 => $kwoty_vat){
						$kw += $kwoty_vat;
					}
					
					$kwota_vat = round($kw - ($kw / $dzielnik),2) ;
						echo $kwota_vat.'<br>';
			}

		break;

		*/

			// wyswietlany wyniki zapytania
		   
			
				$email= $kwoty_faktura['kto_email'];
			
					
				$imie =$kwoty_faktura['naam'];
				$nazwisko = $kwoty_faktura['achternaam'];
				$data_dod = $kwoty_faktura['data_proformy'];
				$opis = $kwoty_faktura['adresy_adres'].', '.$kwoty_faktura['adresy_miasto'];
				$nr_zamow = $kwoty_faktura['id'];
				
			
				if (strlen($opis) > 30) {
				$opis = substr($opis, 0, 30) . '...';
				}
				
				$faktura_nr = $kwoty_faktura['id'];
				$kwota = $kwoty_faktura['kwota'];






		$pdf = new FPDF();
		$pdf->AddFont('ArialMT','','arial.php');
		$pdf->AddPage();
		$pdf->SetFont('ArialMT','',12);



		$pdf->Image('../themes/admin/img/logo.png',7,10,75);
		if($betaal == 1)
			$pdf->Image('../themes/admin/img/betaligsherinnering.jpg',7,50,200);
		
		if($betaal == 2)
			$pdf->Image('../themes/admin/img/betalingaanmeldingen.jpg',7,50,200);
		
		$pdf->SetX(160);
		
	
		$nr='KH-00'.$id;

		$pdf->SetFont('ArialMT','',14);
		$pdf->Cell(0,0,'Proforma: '.$nr,0,1);
		$pdf->SetY(45);
		$pdf->SetFont('ArialMT','',17);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(0,5,'KH Bemiddeling',0,1);
		$pdf->SetFont('ArialMT','',10);



		$pdf->Cell(0,5,'Tinelstraat 5',0,1);
		$pdf->Cell(0,5,'5654LS Eindhoven',0,1);

		$pdf->Cell(0,5,'Tel: 040 844 50 07',0,1);
		$pdf->Cell(0,5,'info@khbemiddeling.nl',0,1);

		 
		$pdf->Cell(0,5,'KvK: 73523097',0,1);

		$pdf->Cell(0,5,'BTW: NL859557923B01',0,1);
		$pdf->Cell(0,5,'IBAN: NL29RABO0152307478',0,1);


		$pdf->SetXY(130,45);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(0,5,'Proforma voor:',0,1);
		$pdf->SetX(130);

		$pdf->SetFont('ArialMT','',10);
		if($imie || $nazwisko){
			$pdf->Cell(0,5,''.$imie.' '.$nazwisko,0,1);
			$pdf->SetX(130);
		}

		if($kwoty_faktura['bedrijf']){
			$pdf->Cell(0,5,$kwoty_faktura['bedrijf'],0,1);
			$pdf->SetX(130);
		}


		$ulica = $kwoty_faktura['adres'];




		$miasto = $kwoty_faktura['stad'];

		if($ulica){
		$pdf->Cell(0,5,''.$ulica,0,1);
		$pdf->SetX(130);
		}

		if($kwoty_faktura['postcode']){
		$pdf->Cell(0,5,$kwoty_faktura['postcode'],0,1);
		$pdf->SetX(130);
		}

		if($miasto){
			$pdf->Cell(0,5,''.$miasto,0,1);
			$pdf->SetX(130);
		}


		if($kwoty_faktura['kvk']){
			$pdf->Cell(0,5,$kwoty_faktura['kvk'],0,1);
			$pdf->SetX(130);
		}


		if($kwoty_faktura['btw']){
		$pdf->Cell(0,5,$kwoty_faktura['btw'],0,1);
		$pdf->SetX(130);
		}


		if($email){
		$pdf->Cell(0,5,''.$email,0,1);
		}


		$pdf->SetY(120);
		$date=substr ($data_dod, 0, 10) ;


		 
		$wynajem=''; 

		if($kwoty_faktura['miesiac_rok']){
			
			$miesiac = '';
			$ddd = explode("-",$kwoty_faktura['miesiac_rok']); 

				
			switch ($ddd[1]) {
			case 1:
				$miesiac = 'januari';
				break;
			case 2:
				$miesiac = 'februari';
				break;
			case 3:
				$miesiac = 'maart';
				break;
				
			case 4:
				$miesiac = 'april';
				break;
		case 5:
				$miesiac = 'mei';
				break;
		case 6:
				$miesiac = 'juni';
				break;
		case 7:
				$miesiac = 'juli';
				break;
		case 8:
				$miesiac = 'augustus';
				break;
		case 9:
				$miesiac = 'september';
				break;
		case 10:
				$miesiac = 'oktober';
				break;
		case 11:
				$miesiac = 'november';
				break;
		case 12:
				$miesiac = 'december';
				break;
			
		}

		if($kwoty_faktura['miesiac_rok'] != '0000-00-00')
			$wynajem = '('.$miesiac.' '.$ddd[0].')';

		}

		$pdf->SetFont('Arial','',12);

		$pdf->SetFillColor(248, 107, 107);
		$pdf->Cell(0,5,'Proforma: '.$nr.' van '.$data_nl->zmiana_formatu_daty($date).' '.$wynajem,1,1,1,true);


		$pdf->Cell(100,10,'Order: '.$nr_zamow,1,1);

		$pdf->SetXY(110,125);
		$betaalmethode= '7 dagen';
		$pdf->Cell(90,10,'Betalingstermijn: '.$betaalmethode,1,1);


		$cena=$kwota;

		$pdf->SetY(150);

		$pdf->Cell(0,5,'Beschrijving                                                             Prijs                    Aantal     BTW%     Totaal ',T,1,1,true);

			
		$wysokosc = 160;
		$Y1 = $pdf->GetY();
		$pdf->SetY($Y1 + 2);
		$Y1 = $pdf->GetY();
		$X1 = $pdf->GetX();
				


		if ($warrvoor == 1)
		{
			
		$sgl ='SELECT * FROM bedrjf_proforma_warrvoor INNER JOIN waarvoor ON bedrjf_proforma_warrvoor.warrvoor_id = waarvoor.id WHERE bedrjf_proforma_warrvoor.proforma_id ='.$id;	
		$zap1 = mysql_query($sgl);

		while($rows = mysql_fetch_array($zap1))
						{
							$tab1[] = $rows;  
						}

		$Beschrijving ='';
		$Prijs = '';
		$Aantal = '';
		$vat ='';
		$suma=0;

		//echo '<pre>';
		//print_r($tab1);


		unset($tabela_vat);

		if(!empty($tab1)){

				foreach($tab1 as $value){ 
					$Beschrijving .= $value['nazwa']."\n";
					$Prijs .= chr(128).' '.$value['kwota']."\n";
					$Aantal .= "1"."\n";
					$vat .= $value['vat']." %\n";
					$suma += $value['kwota'];
					$tabela_vat[$value['vat']][] = $value['kwota'];
				}
				
				
				

				

		}
		else{
			
					$Beschrijving .= $kwoty_faktura['title']."\n";
					$Prijs .= chr(128).' '.$kwoty_faktura['cala_kwota_proforma']."\n";
					$Aantal .= "1"."\n";
					$vat .= (int)$kwoty_faktura['title_btw']." %\n";
					$suma += $kwoty_faktura['cala_kwota_proforma'];
					$tabela_vat[(int)$kwoty_faktura['title_btw']][] = $kwoty_faktura['cala_kwota_proforma'];
			
		}



		$pdf->MultiCell(0,5, $Beschrijving, 0 , J); 
		$pdf->SetXY($X1+94,$Y1);
		$pdf->MultiCell(0,5, $Prijs, 0 , J); 
		$pdf->SetXY($X1+130,$Y1);
		$pdf->MultiCell(0,5, $Aantal, 0 , J); 
		$pdf->SetXY($X1+150,$Y1);
		$pdf->MultiCell(0,5, $vat, 0 , J); 
		$pdf->SetXY($X1+163,$Y1);
		$pdf->MultiCell(0,5, $Prijs, 0 , J);

		}
		else
		{



		//TO ZMIENIŁEM GDY BYŁ PROBLE Z FAKTURĄ NA KÓREJ BORG BYŁ TJ. HUUR 
		//if($hu > 0 && $borg != $cala_kwota_incl){

		if($hu > 0){
		$pdf->SetY($wysokosc);

		$ilosc_znakow = 0;

		$ilosc_znakow = strlen(number_format($hu,2,',', '.'));

		if($ilosc_znakow == 6)
		$ilosc_znakow +=5;

		if($ilosc_znakow == 5)
		$ilosc_znakow +=8;

		if($ilosc_znakow == 4)
		$ilosc_znakow +=11;

		$pdf->Cell(0,5,'Huur van '.$opis.'',0,1); 
		$pdf->SetXY(92 + $ilosc_znakow,$wysokosc);

		if($hu)

		$pdf->Cell(0,5,chr(128).' '.number_format($hu,2,',', '.').'',0,1);

		$pdf->SetXY(140,$wysokosc);
		$pdf->Cell(0,5,'1',0,1); 
		$pdf->SetXY(155,$wysokosc);
		$pdf->Cell(0,5,'  '.$kwoty_faktura['vat_huur'].' %',0,1);
		$pdf->SetXY(162 + $ilosc_znakow,$wysokosc);

		$pdf->Cell(0,5,chr(128).' '.number_format($hu,2,',', '.').'',0,1);  

		$wysokosc += 5;
		}

		if($borg > 0){

		$pdf->SetY($wysokosc);

		$ilosc_znakow = 0;
		$ilosc_znakow = strlen(number_format($borg,2,',', '.'));
		if($ilosc_znakow == 6)
		$ilosc_znakow +=5;

		if($ilosc_znakow == 5)
		$ilosc_znakow +=8;

		if($ilosc_znakow == 4)
		$ilosc_znakow +=11;

		$pdf->Cell(0,5,'Borg',0,1); 
		$pdf->SetXY(92 + $ilosc_znakow,$wysokosc);
		$pdf->Cell(0,5,chr(128).' '.number_format($borg,2,',', '.').'',0,1);
		$pdf->SetXY(140,$wysokosc);
		$pdf->Cell(0,5,'1',0,1); 
		$pdf->SetXY(155,$wysokosc);
		$pdf->Cell(0,5,'  '.$kwoty_faktura['vat_borg'].' %',0,1);
		$pdf->SetXY(162 + $ilosc_znakow,$wysokosc);
		$pdf->Cell(0,5,chr(128).' '.number_format($borg,2,',', '.').'',0,1);

		$wysokosc += 5;
		}

		//TO ZMIENIŁEM GDY BYŁ PROBLE Z FAKTURĄ NA KÓREJ BORG BYŁ TJ. HUUR 
		//if($ad > 0 && $borg != $cala_kwota_incl){

		if($ad > 0 && $borg != $wsz_wplaty){


		$pdf->SetY($wysokosc);

		$ilosc_znakow = 0;

		$ilosc_znakow = strlen(number_format($ad,2,',', '.'));

		if($ilosc_znakow == 6)
		$ilosc_znakow +=5;

		if($ilosc_znakow == 5)
		$ilosc_znakow +=8;

		if($ilosc_znakow == 4)
		$ilosc_znakow +=11;

		$pdf->Cell(0,5,'Administratiekosten',0,1); 
		$pdf->SetXY(92 + $ilosc_znakow,$wysokosc);


		$pdf->Cell(0,5,chr(128).' '.number_format($ad,2,',', '.').'',0,1);

		$pdf->SetXY(140,$wysokosc);
		$pdf->Cell(0,5,'1',0,1); 
		$pdf->SetXY(155,$wysokosc);
		$pdf->Cell(0,5,$kwoty_faktura['vat_admin'].' %',0,1);
		$pdf->SetXY(162 + $ilosc_znakow,$wysokosc);
		$pdf->Cell(0,5,chr(128).' '.number_format($ad,2,',', '.').'',0,1);  

		$wysokosc += 5;
		}


		//TO ZMIENIŁEM GDY BYŁ PROBLE Z FAKTURĄ NA KÓREJ BORG BYŁ TJ. HUUR 
		//if($ge > 0 && $borg != $cala_kwota_incl){

		if($ge > 0 && $borg != $wsz_wplaty){

		$pdf->SetY($wysokosc);

		$ilosc_znakow = 0;
		$ilosc_znakow = strlen(number_format($ge,2,',', '.'));
		if($ilosc_znakow == 6)
		$ilosc_znakow +=5;

		if($ilosc_znakow == 5)
		$ilosc_znakow +=8;

		if($ilosc_znakow == 4)
		$ilosc_znakow +=11;

		$pdf->Cell(0,5,'GE',0,1); 
		$pdf->SetXY(92 + $ilosc_znakow,$wysokosc);
		$pdf->Cell(0,5,chr(128).' '.number_format($ge,2,',', '.').'',0,1);
		$pdf->SetXY(140,$wysokosc);
		$pdf->Cell(0,5,'1',0,1); 
		$pdf->SetXY(155,$wysokosc);
		$pdf->Cell(0,5,$kwoty_faktura['vat_ge'].' %',0,1);
		$pdf->SetXY(162 + $ilosc_znakow,$wysokosc);
		$pdf->Cell(0,5,chr(128).' '.number_format($ge,2,',', '.').'',0,1);

		$wysokosc += 5;
		}

		//TO ZMIENIŁEM GDY BYŁ PROBLE Z FAKTURĄ NA KÓREJ BORG BYŁ TJ. HUUR 
		//if($in > 0 && $borg != $cala_kwota_incl){{


		if($in > 0 && $borg != $wsz_wplaty){

		$pdf->SetY($wysokosc);

		$ilosc_znakow = 0;
		$ilosc_znakow = strlen(number_format($in,2,',', '.'));
		if($ilosc_znakow == 6)
		$ilosc_znakow +=5;

		if($ilosc_znakow == 5)
		$ilosc_znakow +=8;

		if($ilosc_znakow == 4)
		$ilosc_znakow +=11;

		$pdf->Cell(0,5,'Internet',0,1); 
		$pdf->SetXY(92 + $ilosc_znakow,$wysokosc);
		$pdf->Cell(0,5,chr(128).' '.number_format($in,2,',', '.').'',0,1);
		$pdf->SetXY(140,$wysokosc);
		$pdf->Cell(0,5,'1',0,1); 
		$pdf->SetXY(155,$wysokosc);
		$pdf->Cell(0,5,$kwoty_faktura['vat_internet'].' %',0,1);
		$pdf->SetXY(162 + $ilosc_znakow,$wysokosc);
		$pdf->Cell(0,5,chr(128).' '.number_format($in,2,',', '.').'',0,1);

		$wysokosc += 5;
		}

		//TO ZMIENIŁEM GDY BYŁ PROBLE Z FAKTURĄ NA KÓREJ BORG BYŁ TJ. HUUR 
		//if($wa > 0 && $borg != $cala_kwota_incl){


		if($wa > 0 && $borg != $wsz_wplaty){

		$pdf->SetY($wysokosc);

		$ilosc_znakow = 0;
		$ilosc_znakow = strlen(number_format($wa,2,',', '.'));
		if($ilosc_znakow == 6)
		$ilosc_znakow +=5;

		if($ilosc_znakow == 5)
		$ilosc_znakow +=8;

		if($ilosc_znakow == 4)
		$ilosc_znakow +=11;

		$pdf->Cell(0,5,'Water',0,1); 
		$pdf->SetXY(92 + $ilosc_znakow,$wysokosc);
		$pdf->Cell(0,5,chr(128).' '.number_format($wa,2,',', '.').'',0,1);
		$pdf->SetXY(140,$wysokosc);
		$pdf->Cell(0,5,'1',0,1); 
		$pdf->SetXY(155,$wysokosc);
		$pdf->Cell(0,5,'  '.$kwoty_faktura['vat_water'].' %',0,1);
		$pdf->SetXY(162 + $ilosc_znakow,$wysokosc);
		$pdf->Cell(0,5,chr(128).' '.number_format($wa,2,',', '.').'',0,1);

		$wysokosc += 5;
		}



		//TO ZMIENIŁEM GDY BYŁ PROBLE Z FAKTURĄ NA KÓREJ BORG BYŁ TJ. HUUR 
		//if($borg > 0 && $borg != $cala_kwota_incl){

		}







		$pdf->Line(150,200,200,200);
		$pdf->SetXY(150,200);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(0,10,'Subtotaal',0,1);


		$ilosc_znakow = 0;

		if ($warrvoor == 0)
			$ilosc_znakow = strlen(number_format($cala_kwota,2,',', '.'));
		else
			$ilosc_znakow = strlen(number_format($suma,2,',', '.'));

		if($ilosc_znakow == 6)
		$ilosc_znakow +=5;

		if($ilosc_znakow == 5)
		$ilosc_znakow +=9;

		if($ilosc_znakow == 4)
		$ilosc_znakow +=11;

		$pdf->SetXY(162 + $ilosc_znakow,200);
		if ($warrvoor == 0)
			$pdf->Cell(0,10,chr(128).' '.number_format($cala_kwota, 2,',', '.'),0,1);
		else
			$pdf->Cell(0,10,chr(128).' '.number_format($suma, 2,',', '.'),0,1);



		$y = 230;
		$wys = 0;

		foreach($tabela_vat as $k => $stawki_vat){
			
			
			
			
				if($k !=0){
					

					
					//echo $k.'vat:';
					
					$dzielnik = $k / 100 + 1;
					
					$kw = 0;
					foreach($stawki_vat as $k2 => $kwoty_vat){
						$kw += $kwoty_vat;
						//echo $kwoty_vat;
					
					
					
					
						if($kwoty_vat > 0){
							//echo $kwota_vat;
							
							$kwota_vat = round($kw - ($kw / $dzielnik),2) ;
						
							$pdf->SetX(142);

							$pdf->Cell(0,5, $k.'% BTW over',0,1);
						
							$ilosc_znakow = 0;
							$ilosc_znakow = strlen(number_format($kwota_vat,2,',', '.'));
							

							if($ilosc_znakow == 6)
							$ilosc_znakow +=5;

							if($ilosc_znakow == 5)
							$ilosc_znakow +=9;
			 
							if($ilosc_znakow == 4)
							$ilosc_znakow +=12;
						
						
						$pdf->SetXY(162 + $ilosc_znakow,210+$wys);
						$pdf->Cell(0,5,chr(128).' '.number_format($kwota_vat, 2,',', '.'),0,1);
						
						$wys += 5;
						
						}
					
					}
				}
			} 






		$pdf->SetXY(135,230);

		$pdf->Cell(55,5,'Totaal incl. BTW',T,0,1,true);

		$ilosc_znakow = 0;
		if ($warrvoor == 0)
			$ilosc_znakow = strlen(number_format($cala_kwota_incl,2,',', '.'));
		else
			$ilosc_znakow = strlen(number_format($suma,2,',', '.'));


		if($ilosc_znakow == 6)
		$ilosc_znakow +=5;

		if($ilosc_znakow == 5)
		$ilosc_znakow +=8;

		$pdf->SetXY(162 + $ilosc_znakow,230);
		if ($warrvoor == 0)
			$pdf->Cell(55,5,chr(128).' '.number_format($cala_kwota_incl,2,',', '.').'',T,0,1,true);
		else
			$pdf->Cell(55,5,chr(128).' '.number_format($suma,2,',', '.').'',T,0,1,true);


		//$pdf->Output('proforma-'.$nr.'.pdf','D');
		//$pdf->Output();

		//echo 'jest:'.$nr;
		
		if(!empty($betaal))
			$nr .= '-'.$betaal;
		

		file_put_contents('upload/proformy/'.$nr.'.pdf',$pdf->Output($nr.'-.pdf', 'S')); 
				
				
				
				return 'ala';
				
			}





}






?>