<?php

error_reporting(E_ERROR | E_PARSE);
require_once($_SERVER['DOCUMENT_ROOT'].'/packages/pdf/fpdf.php');

class proformamodel
{

    public $query;
    private $bedrag;
	public $cityArray = Array();
    public $adresArray = Array();

	private $__config;
	private $__router;
    public $__params;
	private $__db;
	
	public function __construct()
	{
		$this->__config = registry::register("config");
		$this->__router = registry::register("router");
        $this->__params = $this->__router->getParams();
		$this->__db = registry::register("db");
    }
    
    public function getdata($request = null) {
        
        if($request == null){
            
            $proforma_numer = $this->__params[1];
        } else {
            $proforma_numer = $request;
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
        proforma.data,
        proforma.proforma_numer,
        proforma.id
        
        FROM bouw_city AS city INNER JOIN bouw_adresy  AS adresy ON city.city_id = adresy.city 
        INNER JOIN bouw_proforma AS proforma ON adresy.id = proforma.adres_id 
        WHERE proforma.proforma_numer = ".$proforma_numer);
        $x = array();
        
        foreach($data as $q){
            array_push($x, $q);

        }

        $dataWarfor = $this->__db->execute("SELECT 
        warfor.name,
        warfor.btw,
        details.quantity,
        details.price
        FROM bouw_proforma_details AS details INNER JOIN bouw_waarvoor AS warfor ON details.waarvoor_id = warfor.id
        WHERE proforma_nr = ".$proforma_numer);

        $y = array();
        foreach($dataWarfor as $q){

            array_push($y, $q);

        }

        $z = array_merge($x, $y);

        return $z;

    }

    public function getbtw($nr) {

        $warfor = $this->getdata($nr);
        $x = Array();
        $y = Array();
        $vatarray = Array();
        foreach(array_slice($warfor,1) as $row){
            $z = $row['quantity'] * $row['price'];

            if(!in_array($row['btw'], $x))
            $x += array($row['btw'] => 0) ;

            foreach($x as $rows=>$val){
                if($rows == $row['btw']){
                    $x[$rows] += $z * ((int)$rows * 0.01);
                }

            }

        }



        return $x;

    }

    public function gettotal($nr){
        $warfor = $this->getdata($nr);
        $total = 0;
        foreach(array_slice($warfor,1) as $row){
            $z = $row['quantity'] * $row['price'];

            $total += $z;
        }

        return $total;
    } 

    public function getproforma()
	{ 
		$this->adressenModel = new adressenmodel();

		if (isset($this->__params['POST']['vanaf'])) {
			$this->od = $this->__params['POST']['vanaf'];
			$this->do = $this->__params['POST']['tot'];
			$this->word = $this->__params['POST']['word'];

			$_SESSION['vanaf'] = $this->od; 
			$_SESSION['tot'] = $this->do; 
			$_SESSION['word'] = $this->word; 
		} else if(isset($_SESSION['vanaf']) && $_SESSION['vanaf'] != null) {
			$this->od = $_SESSION['vanaf'];
            $this->do = $_SESSION['tot'];
			$this->word = $_SESSION['word'];
		} else {
			$d = new DateTime(date("Y-m-d"));
			$dOd = new DateTime(date("Y-m-d"));
			$dOd->modify('first day of this month'); 

			$this->od = $dOd->format('Y-m-d');
			$this->do = $d->format('Y-m-d');
			$this->word = '';
		}

        $this->clear();

		if(isset($this->__params[2])){
			return $this->adres($this->od, $this->do, $this->word , $this->__params[2]);   
		} else {
			return $this->adres($this->od, $this->do, $this->word , null);   
		}

	}
	
	private function clear() {
		if(isset($this->__params['POST']['clear'])){
			$d = new DateTime(date("Y-m-d"));
			
			$dOd = new DateTime(date("Y-m-d"));
			$dOd->modify('first day of this month'); 

			$this->od = $dOd->format('Y-m-d');
			$this->do = $d->format('Y-m-d');
			$this->word = '';
			$this->active = 1;

			unset($this->__params['POST']['vanaf']);
			unset($this->__params['POST']['tot']);
			unset($this->__params['POST']['word']);
			unset($_SESSION['vanaf']);
			unset($_SESSION['tot']);
			unset($_SESSION['word']);
		}
	}

    private function getBedgar($id) {

        $this->bedrag = $this->__db->querymy("SELECT quantity, price FROM `bouw_proforma_details` WHERE proforma_nr = $id");

        $bedgarSum = 0;

        foreach($this->bedrag->fetch_all() as $q){
            $result = $q[0]*$q[1];
            $bedgarSum += $result;
        }
		// array_push($bedgarSum, $result);
        return $bedgarSum;
    }

    // SELECT bouw_adresy.id, bouw_adresy.adres, bouw_city.city FROM `bouw_adresy` INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id INNER JOIN bouw_factur ON bouw_factur.adres_id = bouw_adresy.id WHERE bouw_factur.adres_id = 28

    public function adres($od, $do, $word = null, $city_id = null) {
		//$this->query = $this->__db->querymy("SELECT * FROM `bouw_adresy` INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id WHERE date BETWEEN '".$od."' AND '".$do."' AND active = ".$active." AND  bouw_city.city LIKE '%".$word."%' ");
		if($word != null){
			$this->query = $this->__db->querymy("SELECT proforma.id, city.city, adres.adres, proforma.oferten_id, proforma.proforma_numer, proforma.data, proforma.is_factur 
            FROM bouw_adresy AS adres 
            INNER JOIN bouw_city AS city ON adres.city = city.city_id 
			INNER JOIN bouw_proforma AS proforma ON proforma.adres_id = adres.id 
            WHERE 
            proforma.data BETWEEN '".$od."' AND '".$do."' AND  city.city LIKE '%".$word."%' OR
            proforma.data BETWEEN '".$od."' AND '".$do."' AND  proforma.id = $word OR
            proforma.data BETWEEN '".$od."' AND '".$do."' AND  adres.adres LIKE '%".$word."%' OR
            proforma.data BETWEEN '".$od."' AND '".$do."' AND  proforma.oferten_id = $word OR
            proforma.data BETWEEN '".$od."' AND '".$do."' AND  proforma.proforma_numer = $word
			ORDER BY proforma.id DESC");
		} else {
			$this->query = $this->__db->querymy("SELECT proforma.id, city.city, adres.adres, proforma.oferten_id, proforma.proforma_numer, proforma.data, proforma.is_factur  
            FROM bouw_adresy AS adres 
            INNER JOIN bouw_city AS city ON adres.city = city.city_id 
			INNER JOIN bouw_proforma AS proforma ON proforma.adres_id = adres.id 
            WHERE proforma.data BETWEEN '".$od."' AND '".$do."'
			ORDER BY proforma.id DESC");
		}

        $x = 0;

        if(!empty($this->query))
        foreach($this->query->fetch_all() as $q){

            array_push($this->cityArray, $q);
            array_push($this->cityArray[$x], $this->getBedgar($q[4]));      
            $x++;
        }

        // array_push($this->cityArray[0], $this->getBedgar());     

        // $response = array_merge($this->cityArray, $this->getBedgar());
        
       return $this->cityArray;
    }
    
    public function removeproforma(){
		if(isset($this->__params['POST']['proformremove']) && $this->__params['POST']['proformremove'] != null) {
			$this->__db->execute("DELETE FROM bouw_proforma WHERE id = '".$this->__params['POST']['proformremove']."'");
			header("Location: ".SERVER_ADDRESS."administrator/proforma/index");
		}
    }

    private function getLastProformaNr() {
		$nr = $this->__db->querymy("SELECT proforma_numer FROM `bouw_proforma` ORDER BY proforma_numer DESC LIMIT 1");
		foreach($nr as $q){
			$x = $q['proforma_numer'] + 1;
            return $x;
		}
	}

    public function saveproforma()
	{

		if(isset($this->__params['POST']['saveproforma'])) {
            $proformaNr = $this->getLastProformaNr();
			$this->__db->execute("INSERT INTO bouw_proforma 
			(adres_id, 
			oferten_id, 
			proforma_numer,
			data) 
			VALUES (
				'".$this->__params['POST']['adres']."',
				'".$this->__params['POST']['oferten']."',
				'".$proformaNr."',
				'".$this->__params['POST']['proformadata']."'
				)");
            
        

            $id = $this->__db->getLastInsertedId();

            $proforma_nr = $this->__db->querymy("SELECT proforma_numer FROM `bouw_proforma` WHERE id = ".$id);
            foreach ($proforma_nr->fetch_all() as $row) {
                for ($i=0; $i < 20; $i++) {
                    # code...

                
                    $this->__db->execute("INSERT INTO bouw_proforma_details 
			(proforma_nr, 
			waarvoor_id, 
			quantity,
			price) 
			VALUES (
			".$row[0].",
			".$this->__params['POST']['warfortype'][$i].",
			".$this->__params['POST']['warfortimespend'][$i].",
			".$this->__params['POST']['warforquantity'][$i]."
			)");
                }
            }

            $proforma_pdf = 'application/storage/proformy/'.$id.'.pdf';
			
			$proforma1 = file_exists($proforma_pdf); 
            if ($proforma1) {
                unlink($_SERVER['DOCUMENT_ROOT'].'/application/storage/proformy/'.$id.'.pdf');
            }
     
            $this->createproforma(0, $proformaNr);
            $proforma_pdf = 'application/storage/proformy/'.$id.'.pdf';

            // header("Location: ".SERVER_ADDRESS."administrator/proforma/index");
        }
		
    }

    public function getCompanyData() {
        $x = Array();
        $que = $this->__db->querymy("SELECT * FROM bouw_insteligen_company_data");
        foreach($que->fetch_assoc() as $row) {
            array_push($x, $row);
        }

        return $x;
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
        proforma.data,
        proforma.proforma_numer,
        adresy.id,
        proforma.oferten_id,
        proforma.data_betalen,
        proforma.is_factur,
        proforma.id
        
        FROM bouw_city AS city INNER JOIN bouw_adresy  AS adresy ON city.city_id = adresy.city 
        INNER JOIN bouw_proforma AS proforma ON adresy.id = proforma.adres_id 
        WHERE proforma.proforma_numer = ".$this->__params[1]);
        $x = array();
        foreach($data as $q){
            array_push($x, $q);

        }

        
        $y = $this->getAllWarforForAdres();

        $z = array_merge($x, $y);
       


        return $z;

    } 

    private function getAllWarforForAdres() {
        $dataWarfor = $this->__db->execute("SELECT 
        proforma_nr,
        waarvoor_id,
        quantity,
        price,
        id
        FROM bouw_proforma_details 
        WHERE proforma_nr = ".$this->__params[1]);

        $y = array();
        foreach($dataWarfor as $q){

            array_push($y, $q);

        }

        return $y;
    }
    

    public function editProforma()
	{
		if(isset($this->__params['POST']['editwarfor'])) {
            $lastFacturNumer=model_load('inkomstenmodel', 'getLastFacturNr', '');
            $facturWarfor=model_load('facturmodel', 'getAllWarforForAdres', '');

            $adres = $this->__params['POST']['adres'];
            $factur =$this->__params['POST']['facturnumer'];
            $data = $this->__params['POST']['facturdata'];
            $oferten = $this->__params['POST']['oferten'];
            $data_betalen = $this->__params['POST']['data_betalen'];
            $proformaId = $this->__params['POST']['proformaId'];

            if($data_betalen != null){
                $this->__db->execute("UPDATE bouw_proforma 
                SET
                adres_id = $adres,
                oferten_id = $oferten, 
                proforma_numer = $factur,
                data = '$data',
                data_betalen = '$data_betalen',
                is_factur = 1
                WHERE proforma_numer = $factur
                ");

                $this->__db->execute("INSERT INTO bouw_factur 
                (adres_id, 
                oferten_id, 
                factur_numer,
                data) 
                VALUES (
                    '".$adres."',
                    '".$oferten."',
                    '".$lastFacturNumer."',
                    '".$data_betalen."'
                    )");


            } else {
                $this->__db->execute("UPDATE bouw_proforma 
                SET
                adres_id = $adres,
                oferten_id = $oferten, 
                proforma_numer = $factur,
                data = '$data',
                data_betalen = null
                WHERE proforma_numer = $factur
                ");
    
            }

            $i = 1;

            if (count($this->__params['POST']['warforInputId']) >= count($this->getAllWarforForAdres())) {
                foreach (array_slice($this->__params['POST']['warforInputId'], 1) as $row) {
                    $id = $this->__params['POST']['warforInputId'][$i];
                    $allwarfor = $this->getAllWarforForAdres()[$i - 1];
                    if (in_array($id, $allwarfor)) {
                    $r = $this->__db->execute("UPDATE bouw_proforma_details 
                    SET
                    proforma_nr = '".$factur."',
                    waarvoor_id = '".$this->__params['POST']['warfortype'][$i]."', 
                    quantity = '".$this->__params['POST']['warfortimespend'][$i]."',
                    price = '".$this->__params['POST']['warforquantity'][$i]."'
                    WHERE id = '".$this->__params['POST']['warforInputId'][$i]."'
                    ");
                        } else {
                            $this->__db->execute("INSERT INTO bouw_proforma_details 
                        (proforma_nr, 
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

            if($data_betalen != null){
                $x = 1;

                if (count($this->__params['POST']['warforInputId']) >= count($facturWarfor)) {
                    foreach (array_slice($this->__params['POST']['warforInputId'], 1) as $row) {
                        $id = $this->__params['POST']['warforInputId'][$x];
                        $allwarfor = $facturWarfor[$x - 1];

                        $this->__db->execute("INSERT INTO bouw_factur_details 
                            (factur_nr, 
                            waarvoor_id, 
                            quantity,
                            price) 
                            VALUES (
                            ".$lastFacturNumer.",
                            ".$this->__params['POST']['warfortype'][$x].",
                            ".$this->__params['POST']['warfortimespend'][$x].",
                            ".$this->__params['POST']['warforquantity'][$x]."
                        )");

                        $x++;
                        
                        $facturModel = new facturmodel();

                        $idFactur = $this->__db->getLastInsertedId();

                        $factur_pdf = 'application/storage/factur/'.$idFactur.'.pdf';

                        $proforma1 = file_exists($factur_pdf); 
                        if ($proforma1) {
                            unlink($_SERVER['DOCUMENT_ROOT'].'/application/storage/factur/'.$idFactur.'.pdf');
                        }

                        $facturModel->createfactur($lastFacturNumer);        

                    }
                }
            }

            $proforma_pdf = 'application/storage/proformy/'.$proformaId.'.pdf';
			
			$proforma1 = file_exists($proforma_pdf); 
            if ($proforma1) {
                unlink($_SERVER['DOCUMENT_ROOT'].'/application/storage/proformy/'.$proformaId.'.pdf');
            }
     
            $this->createproforma(0, $factur);
	 
            header("Location: ".SERVER_ADDRESS."administrator/proforma/index");
        }
    }

    public function removewarfor() {
        if ($this->__params['POST']['action'] == 'removewarfor') {
            $this->__db->execute("DELETE FROM bouw_proforma_details WHERE id = ".$this->__params['POST']['warfor_id']);
        }

    }

    public function sendproforma($request = null){
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
        proforma.data,
        proforma.proforma_numer,
        adresy.id,
        proforma.oferten_id
        
        FROM bouw_city AS city INNER JOIN bouw_adresy  AS adresy ON city.city_id = adresy.city 
        INNER JOIN bouw_proforma AS proforma ON adresy.id = proforma.adres_id 
        WHERE proforma.proforma_numer = ".$proforma_numer);
        $x = array();

        foreach($data as $q){
            
            array_push($x, $q);
        }

        $email = $x[0]['email'];
        $id = $proforma_id;
        $betaald = $this->proform_ilosc_maili($id);

        $this->proformy_mail_wyslij($email, $proforma_id, $betaald, TRUE, $proforma_numer);

        // $this->wyslij_maila_smtp('kw-53@wp.pl', 'testsmtp', 'testowa tresc wiadomosci',$_SERVER['DOCUMENT_ROOT'].'proforma.pdf');
    }

    public function proform_ilosc_maili($id_proforma) {
		$ilosc_maili = 0;
        $dzis = date('Y-m-d');
        
        $db_query_m = array();

        if (isset($id_proforma)) {
            $db_query_m = $this->__db->execute("SELECT `id` FROM `bouw_proforma_mail` WHERE `proforma_id` =  ".$id_proforma." ");
        } else {
            $db_query_m = $this->__db->execute("SELECT `id` FROM `bouw_proforma_mail` WHERE `proforma_id` =  ".$this->__params[2]." ");
        }

        foreach ($db_query_m as $row) {
	
			
				$ilosc_maili++;
	
		}
		return $ilosc_maili;
	
    }	

    public function proformy_mail_wyslij($email, $proforma_id, $betaald = null, $wystaw_i_wyslij = null, $proforma_numer = null) {
		
		
		if(!empty($betaald)){
			

			
			if($betaald == 1){
				$temat = 'BETALINGSHERINNERING - proforma factuur van KH Bemiddeling';

				$tresc = '
							Beste <br><br>
							In de bijlage kunt u de proforma factuur inzien en uitprinten.<br /><br />
										
							
							met vriendelijke groet <br />
							KHBemiddeling';
		 
				
				
                $proforma_pdf = 'application/storage/proformy/'.$proforma_id.'-1.pdf';
                $proforma1 = file_exists($proforma_pdf); 

                if (!$proforma1 && $wystaw_i_wyslij){
                    
                    $this->createproforma(1, $proforma_numer);
                    $proforma_pdf = 'application/storage/proformy/'.$proforma_id.'-1.pdf';
                }
			}
			
			if($betaald == 2){
				$temat = 'AANMANING - proforma factuur van KH Bemiddeling'; 

				$tresc = '
							Beste <br><br>
							In de bijlage kunt u de proforma factuur inzien en uitprinten.<br /><br />
										
							
							met vriendelijke groet <br />
							KHBemiddeling';
		 
				
				
                $proforma_pdf = 'application/storage/proformy/'.$proforma_id.'-2.pdf';
                $proforma1 = file_exists($proforma_pdf); 

                if (!$proforma1 && $wystaw_i_wyslij){
                    $this->createproforma(2, $proforma_numer);
                    
                    $proforma_pdf = 'application/storage/proformy/'.$proforma_id.'-2.pdf';
                }
			}
		
		
		} else{
		
	
			$temat = 'proforma Factuur van KH Bemiddeling';

			$tresc = '
						Beste <br><br>
						In de bijlage kunt u de proforma factuur inzien en uitprinten.<br /><br />
									
						
						met vriendelijke groet <br />
                        KHBemiddeling';
                        
			$proforma_pdf = 'application/storage/proformy/'.$proforma_id.'.pdf';
			
			$proforma1 = file_exists($proforma_pdf); 
            if ($proforma1) {
                unlink($_SERVER['DOCUMENT_ROOT'].'/application/storage/proformy/'.$proforma_id.'.pdf');
            }
     
            $this->createproforma(0, $proforma_numer);
            $proforma_pdf = 'application/storage/proformy/'.$proforma_id.'.pdf';
	 
		}
		
			$mail = new smtpmailer();

			//$mail -> wyslij_email(str_replace(' ', '', $email), $temat, $tresc);
			$pocztaKlient = str_replace(' ', '', $email);
			
		
		
		
		
		
        
		


        $this->__db->execute("INSERT INTO `bouw_proforma_mail`(`proforma_id`, `data_czas`) VALUES (" . $proforma_id . ", '" . date('Y-m-d H:i:s') . "') ");

        $msg = 'E-mail was verstuurd.';

        print_r('send');

        //$mail->wyslij_maila_smtp($pocztaKlient, $temat, $tresc, $proforma_pdf);


        //header('Location:proformy.php?msg=' . $msg);
    
    }

    public function createproforma($ilemaili = null, $proforma_numer = null) {
$data = $this->getdata($proforma_numer);
$btw=model_load('proformamodel', 'getbtw', $proforma_numer);
$total=model_load('proformamodel', 'gettotal', $proforma_numer);
$company=model_load('proformamodel', 'getCompanyData', '');
$ilemail=model_load('proformamodel', 'proform_ilosc_maili', '');

		$pdf = new FPDF();
		$pdf->AddFont('ArialMT','','arial.php');
		$pdf->AddPage();
		$pdf->SetFont('ArialMT','',12);



		$pdf->Image($_SERVER['DOCUMENT_ROOT'].'/application/media/images/logo.png',7,10,75);
        if ($ilemail == 1 || $ilemaili == 1) {
            $pdf->Image($_SERVER['DOCUMENT_ROOT'].'/application/media/images/betaligsherinnering.jpg',7,50,200);
        }
		
        if ($ilemail == 2 || $ilemaili == 2) {
            $pdf->Image($_SERVER['DOCUMENT_ROOT'].'/application/media/images/betalingaanmeldingen.jpg',7,50,200);
        }
		
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
			$pdf->SetX(130);
            }
            
            if($data[0]['bedrijf_tel']){
				$pdf->Cell(0,5,''.$data[0]['private_tel'],0,1);
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

        if ($data[0]['data']) {
            $miesiac = '';
            $ddd = explode("-", $data[0]['data']);

                
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
            // 	$wynajem = '('.$miesiac.' '.$ddd[0].')';

            // }

            $pdf->SetFont('Arial', '', 12);

            $pdf->SetFillColor(240, 240, 240);
            $pdf->Cell(0, 10, 'Proforma: '.$data[0]['proforma_numer'].' van '.$data[0]['data'].' '.$wynajem, T, 1, 1, true);


            $pdf->Cell(100, 10, 'Order: '.$data[0]['id'], 0, 1);

            $pdf->SetXY(110, 125);
            $betaalmethode= '7 dagen';
            $pdf->Cell(90, 20, 'Betalingstermijn: '.$betaalmethode, 0, 1);


            // $cena=$kwota;

            $pdf->SetY(150);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->Cell(0, 10, 'Beschrijving                                                             Prijs                    Aantal     BTW%     Totaal ', T, 1, 1, true);

            
            $wysokosc = 160;
            $Y1 = $pdf->GetY();
            $pdf->SetY($Y1 + 2);
            $Y1 = $pdf->GetY();
            $X1 = $pdf->GetX();
                





            //TO ZMIENIŁEM GDY BYŁ PROBLE Z FAKTURĄ NA KÓREJ BORG BYŁ TJ. HUUR
            //if($hu > 0 && $borg != $cala_kwota_incl){
            foreach (array_slice($data, 1) as $row) {
                if ($wysokosc >= 270 && $wysokosc <= 275) {
                    $pdf->AddPage();
                    $wysokosc = 5;
                }
                $sum = $row['quantity'] * $row['price'];
                $pdf->SetY($wysokosc);

                $ilosc_znakow = 0;

                $ilosc_znakow = strlen(number_format($row['price'],2,',', '.'));

                if ($ilosc_znakow == 6) {
                    $ilosc_znakow +=8;
                }

                if ($ilosc_znakow == 5) {
                    $ilosc_znakow +=12;
                }

                if ($ilosc_znakow == 4) {
                    $ilosc_znakow +=14;
                }

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
            $pdf->Line(150, $wysokosc, 200, $wysokosc);
            $pdf->SetXY(150, $wysokosc);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 10, 'Subtotaal', 0, 1);
        
        
            $ilosc_znakow = 0;


            $ilosc_znakow = strlen(number_format($total, 2, ',', '.'));
        
            if ($ilosc_znakow == 6) {
                $ilosc_znakow +=5;
            }
        
            if ($ilosc_znakow == 5) {
                $ilosc_znakow +=9;
            }
        
            if ($ilosc_znakow == 4) {
                $ilosc_znakow +=10;
            }
        
            $pdf->SetXY(169 + $ilosc_znakow, $wysokosc);

            $pdf->Cell(0, 10, chr(128).' '.number_format($total, 2, ',', '.'), 0, 1);
        
        
        
            $y = 230;
            $wys = 0;
        
            $totalBtW = 0;
            foreach ($btw as $k => $stawki_vat) {
  
                if ($k !=0) {
        
                                    // $kwota_vat = round($kw - ($kw / $dzielnik),2) ;
                                
                    $pdf->SetX(142);
        
                    $pdf->Cell(0, 5, $k.'% BTW over', 0, 1);
                                
                    $ilosc_znakow = 0;
                    $ilosc_znakow = strlen(number_format($stawki_vat, 2, ',', '.'));
                                    
        
                    if ($ilosc_znakow == 6) {
                        $ilosc_znakow +=5;
                    }
        
                    if ($ilosc_znakow == 5) {
                        $ilosc_znakow +=9;
                    }
                     
                    if ($ilosc_znakow == 4) {
                        $ilosc_znakow +=12;
                    }
                                
                    $totalBtW += $stawki_vat;
                    $pdf->SetXY(169 + $ilosc_znakow, $wysokosc+10+$wys);
                    $pdf->Cell(0, 5, chr(128).' '.number_format($stawki_vat, 2, ',', '.'), 0, 1);
                                
                    $wys += 5;
                }
            }
        
        
        
        
        
        
            $pdf->SetXY(135, $wysokosc+30);
            $ilosc_znakow = 10;
            $pdf->Cell(55 + $ilosc_znakow, 10, 'Totaal incl. BTW', T, 0, 1, true);
        
        
        
        
            $pdf->SetXY(169 + $ilosc_znakow, $wysokosc+30);

            $pdf->Cell(20, 10, chr(128).' '.number_format($total, 2, ',', '.').'', 0, 1, true);

            $nr = $data[0]['id'];
            
            if ($ilemaili == 0) {
                file_put_contents('application/storage/proformy/'.$nr.'.pdf',$pdf->Output($nr.'.pdf', 'S'));
            }

            if ($ilemaili == 1) {
                file_put_contents('application/storage/proformy/'.$nr.'-1.pdf',$pdf->Output($nr.'-1.pdf', 'S'));
            }
            
            if ($ilemaili == 2) {
                file_put_contents('application/storage/proformy/'.$nr.'-2.pdf',$pdf->Output($nr.'-2.pdf', 'S'));
            }
            
            // $pdf->Output('proforma-'.$nr.'.pdf', 'D');
            // $pdf->Output(); 
    }

    }

    public function showproforma() {
        $this->createproforma(false);
    }

    public function getproformaidbynumer() {
        $data = $this->__db->execute("SELECT id FROM `bouw_proforma` WHERE `proforma_numer` = " . $this->__params[1]);

        $x = array();

        foreach($data as $q){
            
            array_push($x, $q);
        }

       return $this->historia_maili($x[0]['id']);
    }

    public function historia_maili($proforma_id) {

        $db_query = $this->__db->execute("SELECT data_czas FROM `bouw_proforma_mail` WHERE `proforma_id` = ".$proforma_id);
        
        $historia_maili = array();

        foreach($db_query as $q){
          
            array_push($historia_maili, $q);
        }
        return $historia_maili;
    }

    public function getProformaForCron() {
        $db_query = $this->__db->execute("SELECT id, proforma_numer  FROM bouw_proforma WHERE `is_factur` =  0");

        $cronProformyId = array();

        foreach($db_query as $q){
          
            array_push($cronProformyId, $q);
        }
        return $cronProformyId;
    }
 
}

?>