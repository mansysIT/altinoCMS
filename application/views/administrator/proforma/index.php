<?php
error_reporting(E_ERROR | E_PARSE);
require_once($_SERVER['DOCUMENT_ROOT'].'/packages/pdf/fpdf.php');
$data=model_load('proformamodel', 'getdata', '');
$btw=model_load('proformamodel', 'getbtw', '');
$total=model_load('proformamodel', 'gettotal', '');
$company=model_load('proformamodel', 'getCompanyData', '');
// echo"<pre>";
// print_r($company);

$pdf = new FPDF();
		$pdf->AddFont('ArialMT','','arial.php');
		$pdf->AddPage();
		$pdf->SetFont('ArialMT','',12);



		// $pdf->Image('../themes/admin/img/logo.png',7,10,75);
		if($betaal == 1)
			// $pdf->Image('../themes/admin/img/betaligsherinnering.jpg',7,50,200);
		
		if($betaal == 2)
			// $pdf->Image('../themes/admin/img/betalingaanmeldingen.jpg',7,50,200);
		
		$pdf->SetX(160);
		
	
		// $nr='KH-00'.$id;

		$pdf->SetFont('ArialMT','',14);
		$pdf->Cell(0,0,'Proforma: '.$data[0]['proforma_numer'],0,1);
		$pdf->SetY(45);
		$pdf->SetFont('ArialMT','',17);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(0,5,$company[1],0,1);
		$pdf->SetFont('ArialMT','',10);



		$pdf->Cell(0,5,$company[4],0,1);
		$pdf->Cell(0,5,$company[3].$company[2],0,1);

		$pdf->Cell(0,5,'Tel: '.$company[5],0,1);
		$pdf->Cell(0,5,$company[6],0,1);

		 
		$pdf->Cell(0,5,'KvK: '.$company[8],0,1);

		$pdf->Cell(0,5,'BTW: '.$company[7],0,1);
		$pdf->Cell(0,5,'IBAN: '.$company[10],0,1);


		$pdf->SetXY(130,45);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(0,5,'Proforma voor:',0,1);
		$pdf->SetX(130);

        $pdf->SetFont('ArialMT','',10);
        if(!empty($data[0]['bedrijf_bedrijf'])){
            // echo"aaaaaaaaa";
		if($data[0]['bedrijf_bedrijf']){
			$pdf->Cell(0,5,''.$data[0]['bedrijf_bedrijf'],0,1);
			$pdf->SetX(130);
		}

		if($kwoty_faktura['bedrijf']){
			$pdf->Cell(0,5,$kwoty_faktura['bedrijf'],0,1);
			$pdf->SetX(130);
        }
        
		if($data[0]['bedrijf_adres']){
            $pdf->Cell(0,5,''.$data[0]['bedrijf_adres'],0,1);
            $pdf->SetX(130);
            }
    
            if($data[0]['bedrijf_postcode']){
            $pdf->Cell(0,5,$data[0]['bedrijf_postcode'],0,1);
            $pdf->SetX(130);
            }
    
            if($data[0]['bedrijf_stad']){
                $pdf->Cell(0,5,''.$data[0]['bedrijf_stad'],0,1);
                $pdf->SetX(130);
            }

            if($data[0]['bedrijf_kvk']){
                $pdf->Cell(0,5,''.$data[0]['bedrijf_kvk'],0,1);
                $pdf->SetX(130);
            }

            if($data[0]['bedrijf_btw']){
                $pdf->Cell(0,5,''.$data[0]['bedrijf_btw'],0,1);
                $pdf->SetX(130);
            }
    
            if($data[0]['email']){
            $pdf->Cell(0,5,''.$data[0]['email'],0,1);
            }
            
            if($data[0]['bedrijf_tel']){
                $pdf->Cell(0,5,''.$data[0]['private_tel'],0,1);
            }
    } else {
        // echo"bbbbb";

        if($data[0]['private_naam'] || $data[0]['private_achternaam']){
			$pdf->Cell(0,5,''.$data[0]['private_naam'].' '.$data[0]['private_achternaam'],0,1);
			$pdf->SetX(130);
		}

		if($data[0]['adres']){
		$pdf->Cell(0,5,''.$data[0]['adres'],0,1);
		$pdf->SetX(130);
		}

		if($data[0]['postcode']){
		$pdf->Cell(0,5,$data[0]['postcode'],0,1);
		$pdf->SetX(130);
		}

		if($data[0]['city']){
			$pdf->Cell(0,5,''.$data[0]['city'],0,1);
			$pdf->SetX(130);
		}

		if($data[0]['email']){
		$pdf->Cell(0,5,''.$data[0]['email'],0,1);
        }
        
        if($data[0]['private_tel']){
            $pdf->Cell(0,5,''.$data[0]['private_tel'],0,1);
        }
    }

		$pdf->SetY(120);
		$date=substr ($data_dod, 0, 10) ;


		 
		$wynajem=''; 

		if($data[0]['data']){
			
			$miesiac = '';
			$ddd = explode("-",$data[0]['data']); 

				
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

		$pdf->SetFillColor(240, 240, 240);
		$pdf->Cell(0,10,'Proforma: '.$data[0]['proforma_numer'].' van '.$data[0]['data'].' '.$wynajem,T,1,1,true);


		$pdf->Cell(100,10,'Order: '.$data[0]['id'],0,1);

		$pdf->SetXY(110,125);
		$betaalmethode= '7 dagen';
		$pdf->Cell(90,20,'Betalingstermijn: '.$betaalmethode,0,1);


		$cena=$kwota;

		$pdf->SetY(150);
        $pdf->SetFillColor(240, 240, 240);
		$pdf->Cell(0,10,'Beschrijving                                                             Prijs                    Aantal     BTW%     Totaal ',T,1,1,true);

			
		$wysokosc = 160;
		$Y1 = $pdf->GetY();
		$pdf->SetY($Y1 + 2);
		$Y1 = $pdf->GetY();
		$X1 = $pdf->GetX();
				





		//TO ZMIENIŁEM GDY BYŁ PROBLE Z FAKTURĄ NA KÓREJ BORG BYŁ TJ. HUUR 
		//if($hu > 0 && $borg != $cala_kwota_incl){
			foreach(array_slice($data,1) as $row){
				// print_r($row['name']);
				if($wysokosc >= 270 && $wysokosc <= 275){
					$pdf->AddPage();
					$wysokosc = 5;
				}
                // print_r($row['name']);
                $sum = $row['quantity'] * $row['price'];
                $pdf->SetY($wysokosc);

                $ilosc_znakow = 0;

                $ilosc_znakow = strlen(number_format($hu,2,',', '.'));

                if($ilosc_znakow == 6)
                $ilosc_znakow +=5;

                if($ilosc_znakow == 5)
                $ilosc_znakow +=8;

                if($ilosc_znakow == 4)
                $ilosc_znakow +=11;

                $pdf->Cell(0,10,''.$row['name'].'',0,1); 
                $pdf->SetXY(92 + $ilosc_znakow,$wysokosc);

                if($row['price'])

                $pdf->Cell(0,10,chr(128).' '.number_format($row['price'],2,',', '.').'',0,1);

                $pdf->SetXY(140,$wysokosc);
                $pdf->Cell(0,10,$row['quantity'],0,1); 
                $pdf->SetXY(155,$wysokosc);
                $pdf->Cell(0,10,'  '.$row['btw'].' %',0,1);
                $pdf->SetXY(162 + $ilosc_znakow,$wysokosc);

                $pdf->Cell(0,10,chr(128).' '.number_format($sum,2,',', '.').'',0,1);  

                $wysokosc += 5;
                }
				$wysokosc += 5;
				$pdf->Line(150,$wysokosc,200,$wysokosc);
				$pdf->SetXY(150,$wysokosc);
				$pdf->SetFont('Arial','',12);
				$pdf->Cell(0,10,'Subtotaal',0,1);
		
		
				$ilosc_znakow = 0;

				if ($warrvoor == 0)
					$ilosc_znakow = strlen(number_format($total,2,',', '.'));
				else
					$ilosc_znakow = strlen(number_format($total,2,',', '.'));
		
				if($ilosc_znakow == 6)
				$ilosc_znakow +=5;
		
				if($ilosc_znakow == 5)
				$ilosc_znakow +=9;
		
				if($ilosc_znakow == 4)
				$ilosc_znakow +=10;
		
				$pdf->SetXY(169 + $ilosc_znakow,$wysokosc);
				if ($warrvoor == 0)
					$pdf->Cell(0,10,chr(128).' '.number_format($total, 2,',', '.'),0,1);
				else
					$pdf->Cell(0,10,chr(128).' '.number_format($total, 2,',', '.'),0,1);
		
		
		
				$y = 230;
				$wys = 0;
		
				$totalBtW = 0;
				foreach($btw as $k => $stawki_vat){
					
					// print_r($stawki_vat);
					
					
						if($k !=0){
		
									// $kwota_vat = round($kw - ($kw / $dzielnik),2) ;
								
									$pdf->SetX(142);
		
									$pdf->Cell(0,5, $k.'% BTW over',0,1);
								
									$ilosc_znakow = 0;
									$ilosc_znakow = strlen(number_format($stawki_vat,2,',', '.'));
									
		
									if($ilosc_znakow == 6)
									$ilosc_znakow +=5;
		
									if($ilosc_znakow == 5)
									$ilosc_znakow +=9;
					 
									if($ilosc_znakow == 4)
									$ilosc_znakow +=12;
								
									$totalBtW += $stawki_vat;
								$pdf->SetXY(169 + $ilosc_znakow,$wysokosc+10+$wys);
								$pdf->Cell(0,5,chr(128).' '.number_format($stawki_vat, 2,',', '.'),0,1);
								
								$wys += 5;
								
								}
							
							}
		
		
		
		
		
		
				$pdf->SetXY(135,$wysokosc+30);
				$ilosc_znakow = 10;
				$pdf->Cell(55 + $ilosc_znakow,10,'Totaal incl. BTW',T,0,1,true);
		
		
		
		
				$pdf->SetXY(169 + $ilosc_znakow,$wysokosc+30);
				if ($warrvoor == 0)
					$pdf->Cell(20,10,chr(128).' '.number_format($total,2,',', '.').'',0,1,true);
				else
					$pdf->Cell(20,10,chr(128).' '.number_format($total,2,',', '.').'',0,1,true);

// file_put_contents('admin/upload/proformy/'.$nr.'.pdf',$pdf->Output($nr.'-.pdf', 'S')); 


$pdf->Output('proforma-.pdf','D');
$pdf->Output();


?>