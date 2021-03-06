<?php

error_reporting(E_ERROR | E_PARSE);
require_once($_SERVER['DOCUMENT_ROOT'].'/packages/pdf/fpdf.php');

class facturmodel
{

	private $__config;
	private $__router;
    public $__params;
    private $__db;

    private $mainModel;
	
	public function __construct()
	{
		$this->__config = registry::register("config");
		$this->__router = registry::register("router");
        $this->__params = $this->__router->getParams();
        $this->__db = registry::register("db");
        
        $this->mainModel = new mainmodel;
    }
    
    public function showdata() {

        $data = $this->__db->execute("SELECT 
        city.city_id,
        city.city,
        adresy.adres, 
        adresy.postcode,
        factur.data,
        factur.factur_numer,
        adresy.id as adres_id,
        factur.oferten_id,
        factur.id,
        factur.stad,
        factur.adres as adresadres, 
        factur.postcode,
        factur.private_naam,
        factur.private_achternaam,
        factur.private_tel,
        factur.bedrijf_bedrijf,
        factur.bedrijf_kvk,
        factur.bedrijf_btw,
        factur.bedrijf_tel,
        factur.email,
        factur.private
        
        FROM bouw_city AS city INNER JOIN bouw_adresy  AS adresy ON city.city_id = adresy.city 
        INNER JOIN bouw_factur AS factur ON adresy.id = factur.adres_id 
        WHERE factur.factur_numer = ".$this->__params[1]);
        $x = array();
        foreach($data as $q){
            array_push($x, $q);

        }

        

        
        $y = $this->getAllWarforForAdres();

        $z = array_merge($x, $y);
        setcookie('aaa',$z[0]['id'], 0, "/");
        return $z;

    } 

    public function getAllWarforForAdres() {
        $dataWarfor = $this->__db->execute("SELECT 
        factur_nr,
        waarvoor_id,
        quantity,
        price,
        id,
        opmerkingen
        FROM bouw_factur_details 
        WHERE factur_nr = ".$this->__params[1]);

        $y = array();
        foreach($dataWarfor as $q){

            array_push($y, $q);

        }

        return $y;
    }

    public function editFactura()
	{
		if(isset($this->__params['POST']['editwarfor'])) {

            $adres = $this->__params['POST']['adresId'];
            $factur =$this->__params['POST']['facturnumer'];
            $data = $this->__params['POST']['facturdata'];
            $oferten = $this->__params['POST']['oferten'];
            $facturId = $this->__params['POST']['facturId'];
            $opmerkingen = $this->__params['POST']['opmerkingen'];
            
            if($this->__params['POST']['privateBedrijfToogler'] == "private")
			{
				$x = 1;
			} else {
				$x = 0;
			}
            
            // $_SESSION['id'] =  $this->__params['POST']['id'];

            if($oferten == null) {
                $oferten = 0;
            }

            if($x == 1)
            {

                $this->__db->execute("UPDATE bouw_factur 
                SET
                adres_id = $adres,
                oferten_id = $oferten, 
                factur_numer = $factur,
                data = '$data',
                private_naam = '".$this->__params['POST']['private_naam']."',
                private_achternaam = '".$this->__params['POST']['private_achternaam']."',
                private_tel = '".$this->__params['POST']['private_tel']."',
                bedrijf_bedrijf = '',
                adres = '".$this->__params['POST']['adres']."',
                postcode = '".$this->__params['POST']['postcode']."',
                stad = '".$this->__params['POST']['stad']."',
                bedrijf_kvk = '',
                bedrijf_btw = '',
                bedrijf_tel = '',
                email = '".$this->__params['POST']['email']."',
                private = $x
                WHERE factur_numer = $factur
                ");

            } else {
                
                $this->__db->execute("UPDATE bouw_factur 
                SET
                adres_id = $adres,
                oferten_id = $oferten, 
                factur_numer = $factur,
                data = '$data',
                private_naam = '',
                private_achternaam = '',
                private_tel = '',
                bedrijf_bedrijf = '".$this->__params['POST']['bedrijf_bedrijf']."',
                adres = '".$this->__params['POST']['adres']."',
                postcode = '".$this->__params['POST']['postcode']."',
                stad = '".$this->__params['POST']['stad']."',
                bedrijf_kvk = '".$this->__params['POST']['bedrijf_kvk']."',
                bedrijf_btw = '".$this->__params['POST']['bedrijf_btw']."',
                bedrijf_tel = '".$this->__params['POST']['bedrijf_tel']."',
                email = '".$this->__params['POST']['email']."',
                private = $x
                WHERE factur_numer = $factur
                ");

            }



            $i = 1;

            if (count($this->__params['POST']['warforInputId']) >= count($this->getAllWarforForAdres())) {
                foreach (array_slice($this->__params['POST']['warforInputId'], 1) as $row) {
                    $id = $this->__params['POST']['warforInputId'][$i];
                    $allwarfor = $this->getAllWarforForAdres()[$i - 1];
                    $price = str_replace(",",".",$this->__params['POST']['warforquantity'][$i]);
                    if (in_array($id, $allwarfor)) {
                        $r = $this->__db->execute("UPDATE bouw_factur_details 
                        SET
                        factur_nr = '".$factur."',
                        waarvoor_id = '".$this->__params['POST']['warfortype'][$i]."', 
                        quantity = '".$this->__params['POST']['warfortimespend'][$i]."',
                        price = '".$price."',
                        opmerkingen = '".$this->__params['POST']['opmerkingen'][$i]."'
                        WHERE id = '".$this->__params['POST']['warforInputId'][$i]."'
                        ");
                    } else {
                        $this->__db->execute("INSERT INTO bouw_factur_details 
                        (factur_nr, 
                        waarvoor_id, 
                        quantity,
                        price,
                        opmerkingen) 
                        VALUES (
                        ".$factur.",
                        ".$this->__params['POST']['warfortype'][$i].",
                        ".$this->__params['POST']['warfortimespend'][$i].",
                        ".$price.",
                        '".$this->__params['POST']['opmerkingen'][$i]."'
                        )");
                    }
                  
                    $i++;
                    
                }
            }

            $proforma_pdf = 'application/storage/proformy/'.$facturId.'.pdf';
			
			$proforma1 = file_exists($proforma_pdf); 
            if ($proforma1) {
                unlink($_SERVER['DOCUMENT_ROOT'].'/application/storage/proformy/'.$facturId.'.pdf');
            }
     

            $dir = $_SERVER['DOCUMENT_ROOT'].'/application/storage/factur';
            $dirname = $facturId;
    
            $this->mainModel->createNewFolder($dir, $dirname);

            $this->createfactur($factur);
            $proforma_pdf = 'application/storage/proformy/'.$facturId.'.pdf';

            header("Location: ".SERVER_ADDRESS."administrator/inkomsten/index");
        }
    }

    public function removewarfor() {
        if ($this->__params['POST']['action'] == 'removewarfor') {
            $this->__db->execute("DELETE FROM bouw_factur_details WHERE id = ".$this->__params['POST']['warfor_id']);
        }

    }
    
    public function sendfactur($request = null){

        if($request[0] == null || $request[1] == null){
            $proforma_numer = $this->__params[1];
            $proforma_id =  $this->__params[2];
        } else {
            $proforma_numer = $request[1];
            $proforma_id =  $request[0];
        }


        $data = $this->__db->execute("SELECT 
        city.city_id,
        city.city,
        adresy.adres, 
        adresy.postcode,
        klanten.private_naam,
        klanten.private_achternaam,
        klanten.private_id_kaart,
        klanten.private_tel,
        klanten.private_geboortedatum,
        klanten.bedrijf_bedrijf,
        klanten.adres,
        klanten.postcode,
        klanten.stad,
        klanten.bedrijf_kvk,
        klanten.bedrijf_btw,
        klanten.bedrijf_tel,
        klanten.email,
        klanten.rekening,
        factur.data,
        factur.factur_numer,
        adresy.id,
        factur.oferten_id
        
        FROM bouw_city AS city INNER JOIN bouw_adresy  AS adresy ON city.city_id = adresy.city 
        INNER JOIN bouw_factur AS factur ON adresy.id = factur.adres_id 
        INNER JOIN bouw_klanten AS klanten ON klanten.id = adresy.klanten_id 
        WHERE factur.factur_numer = ".$proforma_numer);
        $x = array();

        foreach($data as $q){
            
            array_push($x, $q);
        }

        $email = $x[0]['email'];
        $id = $this->__params[2];

        $this->factur_mail_wyslij($email, $proforma_id, TRUE, $proforma_numer);

        header("Location: ".SERVER_ADDRESS."administrator/inkomsten/index");
    }

    public function factur_ilosc_maili($id_factur) {
		
        $dzis = date('Y-m-d');
        
        $db_query_m = array();

        if (isset($this->__params[2])) {
            $db_query_m = $this->__db->execute("SELECT `id` FROM `bouw_factur_mail` WHERE `factur_id` =  ".$this->__params[2]." ");
        } else {
            $db_query_m = $this->__db->execute("SELECT `id` FROM `bouw_factur_mail` WHERE `factur_id` =  ".$id_factur." ");
        }

        foreach ($db_query_m as $row) {
	
			
				$this->ilosc_maili++;
	
		}
		return $this->ilosc_maili;
	
    }	

    public function factur_mail_wyslij($email, $factur_id, $wystaw_i_wyslij = null, $factur_numer = null) {
		
		
			$temat = 'Factuur van AGUIAR BOUW B.V';

			$tresc = '
						Beste <br><br>
						In de bijlage kunt u de factuur inzien en uitprinten.<br /><br />
									
						
						met vriendelijke groet <br />
                        AGUIAR BOUW B.V';
                        
	 
            $proforma_pdf = 'application/storage/factur/'.$factur_id.'.pdf';
			
			$proforma1 = file_exists($proforma_pdf); 
            if ($proforma1) {
                unlink($_SERVER['DOCUMENT_ROOT'].'/application/storage/factur/'.$factur_id.'.pdf');
            }

            $dir = 'application/storage/factur';
            $dirname = $factur_id;
    
            $this->mainModel->createNewFolder($dir, $dirname);
     
            $this->createfactur($factur_numer);
            $proforma_pdf = 'application/storage/factur/'.$factur_id.'.pdf';
		
            $mail = new smtpmailer();
            
			$pocztaKlient = str_replace(' ', '', $email);

        $mail->wyslij_maila_smtp($pocztaKlient, $temat, $tresc, $proforma_pdf);

        $this->__db->execute("INSERT INTO `bouw_factur_mail`(`factur_id`, `data_czas`) VALUES (" . $factur_id . ", '" . date('Y-m-d H:i:s') . "') ");

        $msg = 'E-mail was verstuurd.';

    
    }

    public function createfactur($factur_numer = null) {
        $data=model_load('inkomstenmodel', 'getdata', $factur_numer);
        $btw=model_load('inkomstenmodel', 'getbtw', $factur_numer);
        $total=model_load('inkomstenmodel', 'gettotal', $factur_numer);
        $company=model_load('proformamodel', 'getCompanyData', '');
        
        $pdf = new FPDF();


                $pdf->AddFont('ArialMT','','arial.php');
                $pdf->AddPage();
                $pdf->SetFont('ArialMT','',10);
        
                $pdf->Image($_SERVER['DOCUMENT_ROOT'].'/application/media/images/logo.png',10,10,50);

		        $pdf->SetX(160);
        
                $pdf->SetFont('ArialMT','',12);
                $pdf->Cell(0,0,'Factuur: '.$data[0]['factur_numer'],0,1);
                $pdf->SetY(45);
                $pdf->SetFont('ArialMT','',15);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(0,5,$company[1],0,1);
                $pdf->SetFont('ArialMT','',8);
        
                $pdf->Cell(0,5,$company[4],0,1);
                $pdf->Cell(0,5,$company[3].$company[2],0,1);
        
                $pdf->Cell(0,5,'Tel: '.$company[5],0,1);
                $pdf->Cell(0,5,$company[6],0,1);
                 
                $pdf->Cell(0,5,'KvK: '.$company[8],0,1);
        
                $pdf->Cell(0,5,'BTW: '.$company[7],0,1);
                $pdf->Cell(0,5,'IBAN: '.$company[10],0,1);
        
                $pdf->SetXY(130,45);
                $pdf->SetFont('Arial','',10);
                $pdf->Cell(0,5,'Factuur voor:',0,1);
                $pdf->SetX(130);
        
                $pdf->SetFont('ArialMT','',8);
                if(!empty($data[0]['bedrijf_bedrijf'])){
                if($data[0]['bedrijf_bedrijf']){
                    $pdf->Cell(0,5,''.$data[0]['bedrijf_bedrijf'],0,1);
                    $pdf->SetX(130);
                }
        
                if($data['bedrijf']){
                    $pdf->Cell(0,5,$data['bedrijf'],0,1);
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
                    if($data[0]['adres'] && $data[0]['stad']){
                        $pdf->Cell(0,5,''.$data[0]['adres'].' '.$data[0]['stad'],0,1);
                        $pdf->SetX(130);
                    }
            
                    if($data[0]['postcode']){
                    $pdf->Cell(0,5,$data[0]['postcode'],0,1);
                    $pdf->SetX(130);
                    }
            
                    if($data[0]['email']){
                    $pdf->Cell(0,5,''.$data[0]['email'],0,1);
                    $pdf->SetX(130);
                    }
                    
                    if($data[0]['bedrijf_tel']){
                        $pdf->Cell(0,5,''.$data[0]['bedrijf_tel'],0,1);
                        $pdf->SetX(130);
                    }
            } else {
        
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
            
                    if($data[0]['stad']){
                        $pdf->Cell(0,5,''.$data[0]['stad'],0,1);
                        $pdf->SetX(130);
                    }
        
                if($data[0]['email']){
                $pdf->Cell(0,5,''.$data[0]['email'],0,1);
                $pdf->SetX(130);
                }
                
                if($data[0]['private_tel']){
                    $pdf->Cell(0,5,''.$data[0]['private_tel'],0,1);
                    $pdf->SetX(130);
                }
            }
        
                $pdf->SetY(90);
                 
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

                $d = new DateTime($data[0]['data']);

                $pdf->SetFont('Arial','',10);
        
                $pdf->SetFillColor(240, 240, 240);
                $pdf->Cell(0,10,'Factuur: '.$data[0]['factur_numer'].' van '.$d->format('d-m-Y').' ',T,1,1,true);
        
                if(!empty($data[0]['proforma_nr']))
                $pdf->Cell(100,10,'Order: '.$data[0]['id']." (Proforma nr: ".$data[0]['proforma_nr'].")",0,1);
                else
                $pdf->Cell(100,10,'Order: '.$data[0]['id'],0,1);
        
                $pdf->SetXY(110,95);
                $betaalmethode= '7 dagen';
                $pdf->Cell(90,20,'Betalingstermijn: '.$betaalmethode,0,1);

                $pdf->SetY(115);
                $pdf->SetFillColor(240, 240, 240);
                $pdf->Cell(0,10,'Beschrijving                                Opmerkingen                                                Prijs              Aantal     BTW%         Totaal ',T,1,1,true);

                
                $wysokosc = 125;
                $Y1 = $pdf->GetY();
                $pdf->SetY($Y1 + 2);
                $Y1 = $pdf->GetY();
                $X1 = $pdf->GetX();

                    foreach(array_slice($data,1) as $row){

                            $sum = $row['quantity'] * $row['price'];
                            $pdf->SetY($wysokosc);
        
                           
        
                            $ilosc_znakow_price = strlen(number_format($row['price'], 2, ',', '.'));

                            if ($ilosc_znakow_price == 10) {
                                $ilosc_znakow_price +=3;
                            }
            
                            if ($ilosc_znakow_price == 9) {
                                $ilosc_znakow_price +=5;
                            }
            
                            if ($ilosc_znakow_price == 8) {
                                $ilosc_znakow_price +=7;
                            }
            
                            if ($ilosc_znakow_price == 7) {
                                $ilosc_znakow_price +=10;
                            }
            
                            if ($ilosc_znakow_price == 6) {
                                $ilosc_znakow_price +=11;
                            }
            
                            if ($ilosc_znakow_price == 5) {
                                $ilosc_znakow_price +=14;
                            }
            
                            if ($ilosc_znakow_price == 4) {
                                $ilosc_znakow_price +=16;
                            }
            
            
                            $ilosc_znakow = strlen(number_format($sum, 2, ',', '.'));
            
                            if ($ilosc_znakow == 10) {
                                $ilosc_znakow +=3;
                            }
            
                            if ($ilosc_znakow == 9) {
                                $ilosc_znakow +=5;
                            }
            
                            if ($ilosc_znakow == 8) {
                                $ilosc_znakow +=8;
                            }
            
                            if ($ilosc_znakow == 7) {
                                $ilosc_znakow +=8;
                            }
            
                            if ($ilosc_znakow == 6) {
                                $ilosc_znakow +=12;
                            }
            
                            if ($ilosc_znakow == 5) {
                                $ilosc_znakow +=14;
                            }
            
                            if ($ilosc_znakow == 4) {
                                $ilosc_znakow +=16;
                            }
            
                            $ilosc_znakow += 4;
        
                            $text=$row['opmerkingen'];
                            $name = $row['name'];
                            $ilename=$pdf->WordWrap($name,40);
                            $pdf->SetFont('Arial','',7);
                            $pdf->SetXY(10 , $wysokosc+3);
                            $pdf->MultiCell(40, 5,$name, 0);
                            $ile=$pdf->WordWrap($text,85);
                            $pdf->SetXY(50 , $wysokosc+3);
                            $pdf->MultiCell(85, 5, $text,0);
                            
                            $pdf->SetXY(125 , $wysokosc);
                            if ($row['price']) {
                                $pdf->MultiCell(0, 10, chr(128).'', 0, 1);
                                $pdf->SetXY(129, $wysokosc);
                                $pdf->MultiCell(15, 10, number_format($row['price'], 2, ',', '.').'', 0, R);
                            }
            
                            $pdf->SetXY(154, $wysokosc);
                            $pdf->MultiCell(0, 10, $row['quantity'], 0, 1);
                            $pdf->SetXY(165, $wysokosc);
                            $pdf->MultiCell(0, 10, '  '.$row['btw'].' %', 0, 1);
                            $pdf->SetXY(180, $wysokosc);
                            $pdf->MultiCell(0, 10, chr(128).'', 0, 1);
                            $pdf->SetXY(185, $wysokosc);
                            $pdf->MultiCell(15, 10,number_format($sum, 2, ',', '.').'', 0, R);
            
                            $wysokoscname = 5*$ilename;
                            $wysokoscopmerkingen = 5*$ile;

                            if($wysokoscname > $wysokoscopmerkingen){
                                $wysokosc += $wysokoscname;
                            } else {
                                $wysokosc += $wysokoscopmerkingen;
                            }

                            $wysokosc += 0;
                            if($wysokosc >= 265 && $wysokosc <= 275){
                                $pdf->AddPage();
                                $wysokosc = 5;
                            }
                        }
                        $wysokosc += 5;
                        if($wysokosc >= 240 && $wysokosc <= 280){
                            $pdf->AddPage();
                            $wysokosc = 5;
                        }
                        $pdf->Line(134,$wysokosc,200,$wysokosc);
                        $pdf->SetXY(134,$wysokosc);
                        $pdf->SetFont('Arial','',10);
                        $pdf->Cell(0,10,'Subtotaal',0,1);
                
                
                        $ilosc_znakow = 0;
                
                        $ilosc_znakow = strlen(number_format($total,2,',', '.'));
                
                        if($ilosc_znakow == 10)
                        $ilosc_znakow +=4;
            
                        if($ilosc_znakow == 9)
                        $ilosc_znakow +=7;
            
                        if($ilosc_znakow == 8)
                        $ilosc_znakow +=10;
            
                        if($ilosc_znakow == 7)
                        $ilosc_znakow +=13;
            
                        if($ilosc_znakow == 6)
                        $ilosc_znakow +=16;
                
                        if($ilosc_znakow == 5)
                        $ilosc_znakow +=19;
                
                        if($ilosc_znakow == 4)
                        $ilosc_znakow +=22;
                
                        $pdf->SetXY(174,$wysokosc);
                        $pdf->MultiCell(0, 10, chr(128).'', 0, 1);
                        $pdf->SetXY(161 + $ilosc_znakow,$wysokosc);
                        $pdf->Cell(0,10, number_format($total, 2,',', '.'),0,1,R);
            
            
            
                $y = 230;
                $wys = 0;
            
                $totalBtW = 0;
                foreach ($btw as $k => $stawki_vat) {
                        
                        if($k !=0){
                        
                            $pdf->SetX(134);
        
                            $pdf->Cell(0,5, $k.'% BTW over',0,1);
                        
                            $ilosc_znakow = 0;
                            $ilosc_znakow = strlen(number_format($stawki_vat,2,',', '.'));
                            
        
                            if($ilosc_znakow == 10)
                            $ilosc_znakow +=4;
            
                            if($ilosc_znakow == 9)
                            $ilosc_znakow +=7;
            
                            if($ilosc_znakow == 8)
                            $ilosc_znakow +=10;
            
                            if($ilosc_znakow == 7)
                            $ilosc_znakow +=13;
            
                            if($ilosc_znakow == 6)
                            $ilosc_znakow +=16;
                    
                            if($ilosc_znakow == 5)
                            $ilosc_znakow +=19;
                    
                            if($ilosc_znakow == 4)
                            $ilosc_znakow +=22;
        
                            if($ilosc_znakow == 3)
                            $ilosc_znakow +=25;
                        
                            $totalBtW += $stawki_vat;
                        $pdf->SetXY(174,$wysokosc+8+$wys);
                        $pdf->MultiCell(0, 10, chr(128).'', 0, 1);
                        $pdf->SetXY(161 + $ilosc_znakow,$wysokosc+10+$wys);
                        $pdf->Cell(0,5, number_format($stawki_vat, 2,',', '.'),0,1,R);
                        
                        $wys += 5;
                        
                        }
                    
                    }
        
                    $pdf->SetXY(135,$wysokosc+30);
                    $ilosc_znakow = 10;
                    $pdf->Cell(55 + $ilosc_znakow,10,'Totaal incl. BTW',T,0,1,true);
        
                    $pdf->SetXY(174,$wysokosc+30);
                    $pdf->MultiCell(0, 10, chr(128).'', 0, 1);
                    $pdf->SetXY(168 + $ilosc_znakow,$wysokosc+30);
                    $pdf->Cell(0,10,number_format($total+$totalBtW,2,',', '.').'',0,1,R,true);

            $nr = $data[0]['id'];

                    file_put_contents('application/storage/factur/'.$nr.'.pdf',$pdf->Output($nr.'.pdf', 'S'));
             
        }

    }

    public function showfactur() {
        $this->createfactur(false);
    }

    public function getfacturidbynumer() {
        $data = $this->__db->execute("SELECT id FROM `bouw_factur` WHERE `factur_numer` = " . $this->__params[1]);

        $x = array();

        foreach($data as $q){
            
            array_push($x, $q);
        }

       return $this->historia_maili($x[0]['id']);
    }

    public function historia_maili($factur_id) {

        $db_query = $this->__db->execute("SELECT data_czas FROM `bouw_factur_mail` WHERE `factur_id` = ".$factur_id);
        
        $historia_maili = array();

        foreach($db_query as $q){
          
            array_push($historia_maili, $q);
        }
        return $historia_maili;
    }

    public function uploadFacturFiles($id = null) {
        if (isset($this->__params['POST']['editwarfor']) || isset($this->__params['POST']['savewarfor'])) {
            $dir = 'application/storage/factur';
            if($id != null){
                $dirName = $id; 
            } else {
                $dirName = $this->__params['POST']['id_factur'];
            }
            $this->mainModel->createNewFolder($dir, $dirName);
            $x = $dir."/".$dirName.'/';
            $this->mainModel->uploadFile($x);		
        }			
    }
    
    public function getAllFilesFromFactur($id) {
        if ($id != null) {
            $dir = 'application/storage/factur/'.$id.'/';
            return $this->mainModel->getAllFilesInDirectory($dir);
        }
    }
    
    public function removeFileFromFactur($id) {
        if(isset($this->__params['POST']['removefile']) && $this->__params['POST']['removefile'] != null){
            $dir = 'application/storage/factur/'.$id.'/';
            $this->mainModel->remove($dir);	
        }
    }
}

?>