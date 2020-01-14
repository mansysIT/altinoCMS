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
        -- adresy.private_naam,
        -- adresy.private_achternaam,
        -- adresy.private_id_kaart,
        -- adresy.private_tel,
        -- adresy.private_geboortedatum,
        -- adresy.bedrijf_bedrijf,
        -- adresy.bedrijf_adres,
        -- adresy.bedrijf_postcode,
        -- adresy.bedrijf_stad,
        -- adresy.bedrijf_kvk,
        -- adresy.bedrijf_btw,
        -- adresy.bedrijf_tel,
        -- adresy.email,
        -- adresy.rekening,
        factur.data,
        factur.factur_numer,
        adresy.id,
        factur.oferten_id,
        factur.id
        
        FROM bouw_city AS city INNER JOIN bouw_adresy  AS adresy ON city.city_id = adresy.city 
        INNER JOIN bouw_factur AS factur ON adresy.id = factur.adres_id 
        WHERE factur.factur_numer = ".$this->__params[1]);
        $x = array();
        foreach($data as $q){
            array_push($x, $q);

        }

        
        $y = $this->getAllWarforForAdres();

        $z = array_merge($x, $y);
       
        // print_r($z);

        return $z;

    } 

    public function getAllWarforForAdres() {
        $dataWarfor = $this->__db->execute("SELECT 
        factur_nr,
        waarvoor_id,
        quantity,
        price,
        id
        FROM bouw_factur_details 
        WHERE factur_nr = ".$this->__params[1]);

        $y = array();
        foreach($dataWarfor as $q){

            array_push($y, $q);
            // print_r($q);

        }

        return $y;
    }

    public function editFactura()
	{
		if(isset($this->__params['POST']['editwarfor'])) {

            $adres = $this->__params['POST']['adres'];
            $factur =$this->__params['POST']['facturnumer'];
            $data = $this->__params['POST']['facturdata'];
            $oferten = $this->__params['POST']['oferten'];
            $facturId = $this->__params['POST']['facturId'];


			$this->__db->execute("UPDATE bouw_factur 
            SET
			adres_id = $adres,
			oferten_id = $oferten, 
			factur_numer = $factur,
			data = '$data' 
            WHERE factur_numer = $factur
            ");

            $i = 1;

            if (count($this->__params['POST']['warforInputId']) >= count($this->getAllWarforForAdres())) {
                foreach (array_slice($this->__params['POST']['warforInputId'], 1) as $row) {
                    $id = $this->__params['POST']['warforInputId'][$i];
                    $allwarfor = $this->getAllWarforForAdres()[$i - 1];
                    if (in_array($id, $allwarfor)) {
                    $r = $this->__db->execute("UPDATE bouw_factur_details 
                    SET
                    factur_nr = '".$factur."',
                    waarvoor_id = '".$this->__params['POST']['warfortype'][$i]."', 
                    quantity = '".$this->__params['POST']['warfortimespend'][$i]."',
                    price = '".$this->__params['POST']['warforquantity'][$i]."'
                    WHERE id = '".$this->__params['POST']['warforInputId'][$i]."'
                    ");
                        // print_r(" [ ".$r." / ");
                        } else {
                            $this->__db->execute("INSERT INTO bouw_factur_details 
                        (factur_nr, 
                        waarvoor_id, 
                        quantity,
                        price) 
                        VALUES (
                        ".$factur.",
                        ".$this->__params['POST']['warfortype'][$i].",
                        ".$this->__params['POST']['warfortimespend'][$i].",
                        ".$this->__params['POST']['warforquantity'][$i]."
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
        adresy.private_naam,
        adresy.private_achternaam,
        adresy.private_id_kaart,
        adresy.private_tel,
        adresy.private_geboortedatum,
        adresy.bedrijf_bedrijf,
        adresy.bedrijf_adres,
        adresy.bedrijf_postcode,
        adresy.bedrijf_stad,
        adresy.bedrijf_kvk,
        adresy.bedrijf_btw,
        adresy.bedrijf_tel,
        adresy.email,
        adresy.rekening,
        factur.data,
        factur.factur_numer,
        adresy.id,
        factur.oferten_id
        
        FROM bouw_city AS city INNER JOIN bouw_adresy  AS adresy ON city.city_id = adresy.city 
        INNER JOIN bouw_factur AS factur ON adresy.id = factur.adres_id 
        WHERE factur.factur_numer = ".$proforma_numer);
        $x = array();

        foreach($data as $q){
            
            array_push($x, $q);
        }

        $email = $x[0]['email'];
        $id = $this->__params[2];

        $this->factur_mail_wyslij($email, $proforma_id, TRUE, $proforma_numer);

        // $this->wyslij_maila_smtp('kw-53@wp.pl', 'testsmtp', 'testowa tresc wiadomosci',$_SERVER['DOCUMENT_ROOT'].'proforma.pdf');
    }

    public function factur_ilosc_maili($id_factur) {
		
        $dzis = date('Y-m-d');
        
        $db_query_m = array();

        if (isset($this->__params[2])) {
            $db_query_m = $this->__db->execute("SELECT `id` FROM `bouw_factur_mail` WHERE `factur_id` =  ".$this->__params[2]." ");
        } else {
            $db_query_m = $this->__db->execute("SELECT `id` FROM `bouw_factur_mail` WHERE `factur_id` =  ".$id_factur." ");
        }
        // print_r($db_query_m);

        foreach ($db_query_m as $row) {
	
			
				$this->ilosc_maili++;
	
		}
		// print_r($this->ilosc_maili);
		return $this->ilosc_maili;
	
    }	

    public function factur_mail_wyslij($email, $factur_id, $wystaw_i_wyslij = null, $factur_numer = null) {
		
		
			$temat = 'Factuur van KH Bemiddeling';

			$tresc = '
						Beste <br><br>
						In de bijlage kunt u de factuur inzien en uitprinten.<br /><br />
									
						
						met vriendelijke groet <br />
                        KHBemiddeling';
                        
	 
            $proforma_pdf = 'application/storage/proformy/'.$factur_id.'.pdf';
			
			$proforma1 = file_exists($proforma_pdf); 
            if ($proforma1) {
                unlink($_SERVER['DOCUMENT_ROOT'].'/application/storage/proformy/'.$factur_id.'.pdf');
            }

            $dir = 'application/storage/factur';
            $dirname = $factur_id;
    
            $this->mainModel->createNewFolder($dir, $dirname);
     
            $this->createfactur($factur_numer);
            $proforma_pdf = 'application/storage/proformy/'.$factur_id.'.pdf';
		
			$mail = new smtpmailer();

			//$mail -> wyslij_email(str_replace(' ', '', $email), $temat, $tresc);
			$pocztaKlient = str_replace(' ', '', $email);
			
		
		
		
		
		
        
		


        $this->__db->execute("INSERT INTO `bouw_factur_mail`(`factur_id`, `data_czas`) VALUES (" . $factur_id . ", '" . date('Y-m-d H:i:s') . "') ");

        $msg = 'E-mail was verstuurd.';

        $mail->wyslij_maila_smtp($pocztaKlient, $temat, $tresc, $proforma_pdf);
        //header('Location:proformy.php?msg=' . $msg);
    
    }

    public function createfactur($factur_numer = null) {


        $data=model_load('inkomstenmodel', 'getdata', $factur_numer);
        $btw=model_load('inkomstenmodel', 'getbtw', $factur_numer);
        $total=model_load('inkomstenmodel', 'gettotal', $factur_numer);
        $company=model_load('proformamodel', 'getCompanyData', '');
        // echo"<pre>";
        // print_r($btw);
        
        $pdf = new FPDF();


                $pdf->AddFont('ArialMT','','arial.php');
                $pdf->AddPage();
                $pdf->SetFont('ArialMT','',12);
        
                $pdf->Image($_SERVER['DOCUMENT_ROOT'].'/application/media/images/logo.png',7,10,75);

        
		
		        $pdf->SetX(160);
                
            
                // $nr='KH-00'.$id;
        
                $pdf->SetFont('ArialMT','',14);
                $pdf->Cell(0,0,'Factuur: '.$data[0]['factur_numer'],0,1);
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
                $pdf->Cell(0,5,'Factuur voor:',0,1);
                $pdf->SetX(130);
        
                $pdf->SetFont('ArialMT','',10);
                if(!empty($data[0]['bedrijf_bedrijf'])){
                    // echo"aaaaaaaaa";
                if($data[0]['bedrijf_bedrijf']){
                    $pdf->Cell(0,5,''.$data[0]['bedrijf_bedrijf'],0,1);
                    $pdf->SetX(130);
                }
        
                if($data['bedrijf']){
                    $pdf->Cell(0,5,$data['bedrijf'],0,1);
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
                $pdf->SetX(130);
                }
                
                if($data[0]['private_tel']){
                    $pdf->Cell(0,5,''.$data[0]['private_tel'],0,1);
                    $pdf->SetX(130);
                }
            }
        
                $pdf->SetY(120);
                // $date=substr ($data_dod, 0, 10) ;
        
        
                 
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
        
                // if($kwoty_faktura['miesiac_rok'] != '0000-00-00')
                //     $wynajem = '('.$miesiac.' '.$ddd[0].')';
        
                // }
        
                $pdf->SetFont('Arial','',12);
        
                $pdf->SetFillColor(240, 240, 240);
                $pdf->Cell(0,10,'Factuur: '.$data[0]['factur_numer'].' van '.$data[0]['data'].' ',T,1,1,true);
        
        
                $pdf->Cell(100,10,'Order: '.$data[0]['id'],0,1);
        
                $pdf->SetXY(110,125);
                $betaalmethode= '7 dagen';
                $pdf->Cell(90,20,'Betalingstermijn: '.$betaalmethode,0,1);
        
        
                // $cena=$kwota;
        
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
                            $sum = $row['quantity'] * $row['price'];
                            $pdf->SetY($wysokosc);
        
                           
        
                            $ilosc_znakow = strlen(number_format($sum, 2, ',', '.'));

 

                            if ($ilosc_znakow == 6) {
                                $ilosc_znakow +=5;
                            }
        
                            if ($ilosc_znakow == 5) {
                                $ilosc_znakow +=3;
                            }
        
                            if ($ilosc_znakow == 4) {
                                $ilosc_znakow +=5;
                            }

                            $ilosc_znakow += 7;
        
                            $pdf->Cell(0, 10, ''.$row['name'].'', 0, 1);
                            $pdf->SetXY(92 + $ilosc_znakow, $wysokosc);
        
                            if ($row['price']) {
                                $pdf->Cell(0, 10, chr(128).' '.number_format($row['price'], 2, ',', '.').'', 0, 1);
                            }
        
                            $pdf->SetXY(140, $wysokosc);
                            $pdf->Cell(0, 10, $row['quantity'], 0, 1);
                            $pdf->SetXY(155, $wysokosc);
                            $pdf->Cell(0, 10, '  '.$row['btw'].' %', 0, 1);
                            $pdf->SetXY(162 + $ilosc_znakow, $wysokosc);
        
                            $pdf->Cell(0, 10, chr(128).' '.number_format($sum, 2, ',', '.').'', 0, 1);
        
                            
        
                        $wysokosc += 5;
                        }
                        $wysokosc += 5;
                $pdf->Line(150,$wysokosc,200,$wysokosc);
                $pdf->SetXY(150,$wysokosc);
                $pdf->SetFont('Arial','',12);
                $pdf->Cell(0,10,'Subtotaal',0,1);
        
        
                $ilosc_znakow = 0;
        
                $ilosc_znakow = strlen(number_format($total,2,',', '.'));
        
                if($ilosc_znakow == 6)
                $ilosc_znakow +=5;
        
                if($ilosc_znakow == 5)
                $ilosc_znakow +=9;
        
                if($ilosc_znakow == 4)
                $ilosc_znakow +=10;
        
                $pdf->SetXY(169 + $ilosc_znakow,$wysokosc);

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

                $pdf->Cell(20,10,chr(128).' '.number_format($total,2,',', '.').'',0,1,true);

            $nr = $data[0]['id'];

                    file_put_contents('application/storage/factur/'.$nr.'.pdf',$pdf->Output($nr.'.pdf', 'S'));

                // $pdf->Output('factur-'.$nr.'.pdf', 'D');
                // $pdf->Output();
             
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
        // print_r($historia_maili);
        return $historia_maili;
    }

    public function uploadFacturFiles() {
        
        if (isset($this->__params['POST']['facturFiles'])) {
			$dir = 'application/storage/factur';
			$dirName = $this->__params['POST']['id_factur'];	
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