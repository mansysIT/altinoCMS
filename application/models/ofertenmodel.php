<?php

error_reporting(E_ERROR | E_PARSE);
require_once($_SERVER['DOCUMENT_ROOT'].'/packages/pdf/fpdf.php');

class ofertenmodel
{
	public $query;
	public $cityArray = Array();

	private $__config;
	private $__router;
    private $__params;
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

    public function getdata($request = null) {
        if($request == null){
            $oferten_numer = $this->__params[1];
        } else {
            $oferten_numer = $request;
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
        oferten.data,
        oferten.oferten_numer,
        oferten.id
        
        FROM bouw_city AS city INNER JOIN bouw_adresy  AS adresy ON city.city_id = adresy.city 
        INNER JOIN bouw_oferten AS oferten ON adresy.id = oferten.adres_id 
        WHERE oferten.oferten_numer = ".$oferten_numer);
        $x = array();
        foreach($data as $q){
            array_push($x, $q);

        }

        $dataWarfor = $this->__db->execute("SELECT 
        warfor.name,
        warfor.btw,
        details.quantity,
        details.price,
        details.opmerkingen
        FROM bouw_oferten_details AS details INNER JOIN bouw_waarvoor AS warfor ON details.waarvoor_id = warfor.id
        WHERE oferten_nr = ".$oferten_numer);

        $y = array();
        foreach($dataWarfor as $q){

            array_push($y, $q);

        }

        $z = array_merge($x, $y);
       
        // print_r($z);

        return $z;

    }

    public function getbtw($nr) {

        $warfor = $this->getdata($nr);
        $x = Array();
        $y = Array();
        $vatarray = Array();
        foreach(array_slice($warfor,1) as $row){
            $z = $row['quantity'] * $row['price'];

            if(!in_array($x, $row['btw']))
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

    public function getoferten()
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

		if(isset($this->__params[1])){
			return $this->adres($this->od, $this->do, $this->word , $this->__params[1]);   
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

        $this->bedrag = $this->__db->querymy("SELECT quantity, price FROM `bouw_oferten_details` WHERE oferten_nr = $id");

        $bedgarSum = 0;

        foreach($this->bedrag->fetch_all() as $q){
            $result = $q[0]*$q[1];
            $bedgarSum += $result;
        }
		// array_push($bedgarSum, $result);
        return $bedgarSum;
    }

    // SELECT bouw_adresy.id, bouw_adresy.adres, bouw_city.city FROM `bouw_adresy` INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id INNER JOIN bouw_factur ON bouw_factur.adres_id = bouw_adresy.id WHERE bouw_factur.adres_id = 28

    public function adres($od, $do, $word = null, $adres_id = null) {
		//$this->query = $this->__db->querymy("SELECT * FROM `bouw_adresy` INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id WHERE date BETWEEN '".$od."' AND '".$do."' AND active = ".$active." AND  bouw_city.city LIKE '%".$word."%' ");
		if($word != null && $adres_id != null){
			$this->query = $this->__db->querymy("SELECT oferten.id, city.city, adres.adres, oferten.data, oferten.status, oferten.oferten_numer, oferten.planned_date, oferten.data_end
            FROM bouw_adresy AS adres 
            INNER JOIN bouw_city AS city ON adres.city = city.city_id 
			INNER JOIN bouw_oferten AS oferten ON oferten.adres_id = adres.id 
            WHERE 
            oferten.data BETWEEN '".$od."' AND '".$do."' AND  city.city LIKE '%".$word."%' AND adres.id  = $adres_id OR
            oferten.data BETWEEN '".$od."' AND '".$do."' AND  oferten.id = '".$word."' AND adres.id  = $adres_id OR
            oferten.data BETWEEN '".$od."' AND '".$do."' AND  adres.adres LIKE '%".$word."%' AND adres.id  = $adres_id OR
            oferten.data BETWEEN '".$od."' AND '".$do."' AND  oferten.oferten_numer = '".$word."' AND adres.id  = $adres_id
            ORDER BY oferten.id DESC");
            
        } else if($adres_id != null){
			$this->query = $this->__db->querymy("SELECT oferten.id, city.city, adres.adres, oferten.data, oferten.status, oferten.oferten_numer, oferten.planned_date, oferten.data_end
            FROM bouw_adresy AS adres 
            INNER JOIN bouw_city AS city ON adres.city = city.city_id 
			INNER JOIN bouw_oferten AS oferten ON oferten.adres_id = adres.id 
            WHERE 
            oferten.data BETWEEN '".$od."' AND '".$do."' AND adres.id  = $adres_id
			ORDER BY oferten.id DESC");
        } else if($word != null){
			$this->query = $this->__db->querymy("SELECT oferten.id, city.city, adres.adres, oferten.data, oferten.status, oferten.oferten_numer, oferten.planned_date, oferten.data_end
            FROM bouw_adresy AS adres 
            INNER JOIN bouw_city AS city ON adres.city = city.city_id 
			INNER JOIN bouw_oferten AS oferten ON oferten.adres_id = adres.id 
            WHERE 
            oferten.data BETWEEN '".$od."' AND '".$do."' AND  city.city LIKE '%".$word."%' OR
            oferten.data BETWEEN '".$od."' AND '".$do."' AND  oferten.id = '".$word."' OR
            oferten.data BETWEEN '".$od."' AND '".$do."' AND  adres.adres LIKE '%".$word."%' OR
            oferten.data BETWEEN '".$od."' AND '".$do."' AND  oferten.oferten_numer = '".$word."'
			ORDER BY oferten.id DESC");
		} else {
			$this->query = $this->__db->querymy("SELECT oferten.id, city.city, adres.adres, oferten.data, oferten.status, oferten.oferten_numer, oferten.planned_date, oferten.data_end
            FROM bouw_adresy AS adres 
            INNER JOIN bouw_city AS city ON adres.city = city.city_id 
			INNER JOIN bouw_oferten AS oferten ON oferten.adres_id = adres.id 
            WHERE oferten.data BETWEEN '".$od."' AND '".$do."'
			ORDER BY oferten.id DESC");
		}

        $i = 0;
        if(!empty($this->query))
        foreach($this->query->fetch_all() as $q){
            array_push($this->cityArray, $q);
			$inkomsten = $this->mainModel->getAllInkomsten('oferten_id', $q[0]);
			$uitgaven = $this->mainModel->getAllUitgaven('oferte_numer', $q[0]);
			$sum = $this->mainModel->winst($inkomsten, $uitgaven);

			array_push($this->cityArray[$i], $inkomsten);
			array_push($this->cityArray[$i], $uitgaven);
            array_push($this->cityArray[$i], $sum);
            
            array_push($this->cityArray[$i], $this->getBedgar($q[5]));  

			$i++;
        }
        
       return $this->cityArray;
    }


    
    public function removeoferten(){
		if(isset($this->__params['POST']['removeoferte'])) {
            $this->__db->execute("DELETE FROM bouw_oferten WHERE oferten_numer = ".$this->__params[1]);
            $this->removewarfor($this->__params[1]);

			header("Location: ".SERVER_ADDRESS."administrator/oferten/index");
		}
    }

    private function getLastofertenNr() {
		$nr = $this->__db->querymy("SELECT oferten_numer FROM `bouw_oferten` ORDER BY oferten_numer DESC LIMIT 1");
		foreach($nr as $q){
			$x = $q['oferten_numer'] + 1;
            return $x;
		}
    }
    
    public function getLastFacturNr() {
		$nr = $this->__db->querymy("SELECT oferten_numer FROM `bouw_oferten` ORDER BY oferten_numer DESC LIMIT 1");
		foreach($nr as $q){
			$x = $q['oferten_numer'] + 1;
            return $x;
		}
	}

    public function saveoferten()
	{

		if(isset($this->__params['POST']['saveoferten'])) {

            $ofertenNumer = $this->getLastFacturNr();

			$this->__db->execute("INSERT INTO bouw_oferten 
			(adres_id, 
			in_progres, 
			status,
            oferten_numer,
			data,
            planned_date
            ) 
			VALUES (
				'".$this->__params['POST']['adres']."',
				0,
				0,
                '".$ofertenNumer."',
				'".$this->__params['POST']['ofertendata']."',
                '".$this->__params['POST']['ofertendataend']."'
				)");
            
        

            $id = $this->__db->getLastInsertedId();

            $oferten_nr = $this->__db->querymy("SELECT oferten_numer FROM `bouw_oferten` WHERE id = ".$id);
            foreach ($oferten_nr->fetch_all() as $row) {
                for ($i=0; $i < 20; $i++) {
                    # code...
                    $price = str_replace(",",".",$this->__params['POST']['warforquantity'][$i]);
                
                        $this->__db->execute("INSERT INTO bouw_oferten_details 
                (oferten_nr, 
                waarvoor_id, 
                quantity,
                price,
                opmerkingen) 
                VALUES (
                ".$row[0].",
                ".$this->__params['POST']['warfortype'][$i].",
                ".$this->__params['POST']['warfortimespend'][$i].",
                ".$price.",
                '".$this->__params['POST']['opmerkingen'][$i]."'
                )");
                }
            }
            // print_r($ofertenNumer);

            $proforma_pdf = 'application/storage/oferten/'.$id.'.pdf';
			
			$proforma1 = file_exists($proforma_pdf); 
            if ($proforma1) {
                unlink($_SERVER['DOCUMENT_ROOT'].'/application/storage/oferten/'.$id.'.pdf');
            }

            $this->createoferten($ofertenNumer);

            header("Location: ".SERVER_ADDRESS."administrator/oferten/index");
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
        adresy.id as adres_id,
        oferten.id,
        oferten.in_progres,
        oferten.status,
        oferten.oferten_numer,
        oferten.data,
        oferten.planned_date,
        oferten.data_end
        
        FROM bouw_city AS city INNER JOIN bouw_adresy  AS adresy ON city.city_id = adresy.city 
        INNER JOIN bouw_oferten AS oferten ON adresy.id = oferten.adres_id 
        WHERE oferten.oferten_numer = ".$this->__params[1]);
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
        oferten_nr,
        waarvoor_id,
        quantity,
        price,
        id,
        opmerkingen
        FROM bouw_oferten_details 
        WHERE oferten_nr = ".$this->__params[1]);

        $y = array();
        foreach($dataWarfor as $q){

            array_push($y, $q);

        }

        return $y;
    }
    

    public function editoferten()
	{
		if(isset($this->__params['POST']['editwarfor'])) {
            $lastFacturId=model_load('inkomstenmodel', 'getLastFacturNr', '');
            $facturWarfor=model_load('facturmodel', 'getAllWarforForAdres', '');

            $adres = $this->__params['POST']['adres'];
            $oferten =$this->__params['POST']['facturnumer'];
            $data = $this->__params['POST']['facturdata'];
            $planedEndData = $this->__params['POST']['planned_date'];
            $endData = $this->__params['POST']['data_end'];

            $status = $this->__params['POST']['status'];
            if($endData != null){
                $this->__db->execute("UPDATE bouw_oferten 
                SET
                adres_id = $adres,
                status = 2,
                oferten_numer = $oferten,
                data = '$data',
                planned_date = '$planedEndData',
                data_end = '$endData'
                WHERE oferten_numer = $oferten
                ");
            } else if($status == 1) {
                $this->__db->execute("UPDATE bouw_oferten 
                SET
                adres_id = $adres,
                status = 1,
                oferten_numer = $oferten,
                data = '$data',
                planned_date = '$planedEndData',
                data_end = '0000-00-00'
                WHERE oferten_numer = $oferten
                ");
            } else {
                $this->__db->execute("UPDATE bouw_oferten 
                SET
                adres_id = $adres,
                oferten_numer = $oferten,
                data = '$data',
                planned_date = '$planedEndData',
                data_end = '0000-00-00'
                WHERE oferten_numer = $oferten
                ");
    
            }


            $i = 1;

            if (count($this->__params['POST']['warforInputId']) >= count($this->getAllWarforForAdres())) {
                foreach (array_slice($this->__params['POST']['warforInputId'], 1) as $row) {
                    $price = str_replace(",",".",$this->__params['POST']['warforquantity'][$i]);
                    $id = $this->__params['POST']['warforInputId'][$i];
                    $allwarfor = $this->getAllWarforForAdres()[$i - 1];
                    if (in_array($id, $allwarfor)) {
                    $r = $this->__db->execute("UPDATE bouw_oferten_details 
                    SET
                        oferten_nr = '".$oferten."',
                        waarvoor_id = '".$this->__params['POST']['warfortype'][$i]."', 
                        quantity = '".$this->__params['POST']['warfortimespend'][$i]."',
                        price = '".$price."',
                        opmerkingen = '".$this->__params['POST']['opmerkingen'][$i]."'
                    WHERE id = '".$this->__params['POST']['warforInputId'][$i]."'
                    ");
                    } else {
                        $this->__db->execute("INSERT INTO bouw_oferten_details 
                        (oferten_nr, 
                        waarvoor_id, 
                        quantity,
                        price,
                        opmerkingen) 
                        VALUES (
                        ".$oferten.",
                        ".$this->__params['POST']['warfortype'][$i].",
                        ".$this->__params['POST']['warfortimespend'][$i].",
                        ".$price.",
                        '".$this->__params['POST']['opmerkingen'][$i]."'
                        )");
                    }
                  
                    $i++;
                    
                }
            }




            $this->createoferten($oferten);

            header("Location: ".SERVER_ADDRESS."administrator/oferten/index");
        }
    }

    public function removewarfor($id) {
            $this->__db->execute("DELETE FROM bouw_oferten_details WHERE oferten_nr = ".$id);
    }

    public function sendoferten($request = null){
        if($request[0] == null || $request[1] == null){
            $oferten_numer = $this->__params[1];
            $oferten_id =  $this->__params[2];
        } else {
            $oferten_numer = $request[1];
            $oferten_id =  $request[0];
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
        oferten.data,
        oferten.oferten_numer,
        adresy.id
        
        FROM bouw_city AS city INNER JOIN bouw_adresy  AS adresy ON city.city_id = adresy.city 
        INNER JOIN bouw_oferten AS oferten ON adresy.id = oferten.adres_id 
        WHERE oferten.oferten_numer = ".$oferten_numer);
        $x = array();
        
        foreach($data as $q){
            
            array_push($x, $q);
        }
        
        $email = $x[0]['email'];
        $id = $oferten_id;
        $betaald = $this->proform_ilosc_maili($id);
        
        $this->proformy_mail_wyslij($email, $oferten_id, $betaald, TRUE, $oferten_numer);

        // $this->wyslij_maila_smtp('kw-53@wp.pl', 'testsmtp', 'testowa tresc wiadomosci',$_SERVER['DOCUMENT_ROOT'].'oferten.pdf');
    }

    public function proform_ilosc_maili($id_oferten) {
		$ilosc_maili = 0;
        $dzis = date('Y-m-d');
        
        $db_query_m = array();

        if (isset($id_oferten)) {
            $db_query_m = $this->__db->execute("SELECT `id` FROM `bouw_oferten_mail` WHERE `oferten_id` =  ".$id_oferten." ");
        } else {
            $db_query_m = $this->__db->execute("SELECT `id` FROM `bouw_oferten_mail` WHERE `oferten_id` =  ".$this->__params[2]." ");
        }
        
        foreach ($db_query_m as $row) {
	
			
				$ilosc_maili++;
	
		}
        
		return $ilosc_maili;
	
    }	

    public function proformy_mail_wyslij($email, $oferten_id, $betaald = null, $wystaw_i_wyslij = null, $oferten_numer = null) {
		
		
            $temat = 'Offerten van AGUIAR BOUW B.V';

            $tresc = '
						Beste <br><br>
						In de bijlage kunt u de offerten inzien en uitprinten.<br /><br />
									
						
						met vriendelijke groet <br />
                        AGUIAR BOUW B.V';
                        
            $oferten_pdf = 'application/storage/oferten/'.$oferten_id.'.pdf';
            
            $oferten1 = file_exists($oferten_pdf);
            if ($oferten1) {
                unlink($_SERVER['DOCUMENT_ROOT'].'/application/storage/oferten/10.pdf');
            }
     
            $this->createoferten(0, $oferten_numer);
            $oferten_pdf = 'application/storage/oferten/'.$oferten_id.'.pdf';
        
            $mail = new smtpmailer();

            //$mail -> wyslij_email(str_replace(' ', '', $email), $temat, $tresc);
            $pocztaKlient = str_replace(' ', '', $email);

            $this->__db->execute("INSERT INTO `bouw_oferten_mail`(`oferten_id`, `data_czas`) VALUES (" . $oferten_id . ", '" . date('Y-m-d H:i:s') . "') ");

            $msg = 'E-mail was verstuurd.';

            print_r('send');

            $mail->wyslij_maila_smtp($pocztaKlient, $temat, $tresc, $oferten_pdf);


        //header('Location:proformy.php?msg=' . $msg);
    }

    public function createoferten($oferten_numer = null) {
        $data = $this->getdata($oferten_numer);
        $btw=model_load('ofertenmodel', 'getbtw', $oferten_numer);
        $total=model_load('ofertenmodel', 'gettotal', $oferten_numer);
        $company=model_load('ofertenmodel', 'getCompanyData', '');

		$pdf = new FPDF();
		$pdf->AddFont('ArialMT','','arial.php');
		$pdf->AddPage();
		$pdf->SetFont('ArialMT','',12);



		$pdf->Image($_SERVER['DOCUMENT_ROOT'].'/application/media/images/logo.png',7,10,75);
		
		$pdf->SetX(160);
		
	
		// $nr='KH-00'.$id;

		$pdf->SetFont('ArialMT','',14);
		$pdf->Cell(0,0,'Offerte: '.$data[0]['oferten_numer'],0,1);
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
		$pdf->Cell(0,5,'Offerte voor:',0,1);
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
                $pdf->Cell(0, 10, 'Offerte: '.$data[0]['oferten_numer'].' van '.$data[0]['data'].' '.$wynajem, T, 1, 1, true);


                $pdf->Cell(100, 10, 'Order: '.$data[0]['id'], 0, 1);

                $pdf->SetXY(110, 125);
                $betaalmethode= '7 dagen';
                $pdf->Cell(90, 20, 'Betalingstermijn: '.$betaalmethode, 0, 1);


                // $cena=$kwota;

                $pdf->SetY(150);
                $pdf->SetFillColor(240, 240, 240);
                $pdf->Cell(0,10,'Beschrijving                 Opmerkingen                            Prijs              Aantal     BTW%           Totaal ',T,1,1,true);

                
                $wysokosc = 160;
                $Y1 = $pdf->GetY();
                $pdf->SetY($Y1 + 2);
                $Y1 = $pdf->GetY();
                $X1 = $pdf->GetX();
                    





                //TO ZMIENIŁEM GDY BYŁ PROBLE Z FAKTURĄ NA KÓREJ BORG BYŁ TJ. HUUR
                //if($hu > 0 && $borg != $cala_kwota_incl){
                    foreach(array_slice($data,1) as $row){
                        // print_r($row['name']);

                            $sum = $row['quantity'] * $row['price'];
                            $pdf->SetY($wysokosc);
        
                           
        
                            $ilosc_znakow_price = strlen(number_format($row['price'], 2, ',', '.'));

                            if ($ilosc_znakow_price == 10) {
                                $ilosc_znakow_price +=0;
                            }
            
                            if ($ilosc_znakow_price == 9) {
                                $ilosc_znakow_price +=3;
                            }
            
                            if ($ilosc_znakow_price == 8) {
                                $ilosc_znakow_price +=6;
                            }
            
                            if ($ilosc_znakow_price == 7) {
                                $ilosc_znakow_price +=3;
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
                                $ilosc_znakow +=0;
                            }
            
                            if ($ilosc_znakow == 9) {
                                $ilosc_znakow +=3;
                            }
            
                            if ($ilosc_znakow == 8) {
                                $ilosc_znakow +=6;
                            }
            
                            if ($ilosc_znakow == 7) {
                                $ilosc_znakow +=3;
                            }
            
                            if ($ilosc_znakow == 6) {
                                $ilosc_znakow +=11;
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
                            $ilename=$pdf->WordWrap($name,25);
                            $pdf->SetFont('Arial','',10);
                            $pdf->SetXY(10 , $wysokosc+3);
                            $pdf->MultiCell(25, 5,$name, 0);
                            $ile=$pdf->WordWrap($text,70);
                            $pdf->SetXY(35 , $wysokosc+3);
                            $pdf->MultiCell(75, 5, $text,0);
                            
                            $pdf->SetXY(107 , $wysokosc);
                            if ($row['price']) {
                                $pdf->MultiCell(0, 10, chr(128).'', 0, 1);
                                $pdf->SetXY(100 + $ilosc_znakow_price, $wysokosc);
                                $pdf->MultiCell(0, 10, number_format($row['price'], 2, ',', '.').'', 0, 1);
                            }
            
                            $pdf->SetXY(140, $wysokosc);
                            $pdf->MultiCell(0, 10, $row['quantity'], 0, 1);
                            $pdf->SetXY(155, $wysokosc);
                            $pdf->MultiCell(0, 10, '  '.$row['btw'].' %', 0, 1);
                            $pdf->SetXY(175, $wysokosc);
                            $pdf->MultiCell(0, 10, chr(128).'', 0, 1);
                            $pdf->SetXY(164 + $ilosc_znakow, $wysokosc);
                            $pdf->MultiCell(0, 10,number_format($sum, 2, ',', '.').'', 0, 1);
            
                            $wysokoscname = 5*$ilename;
                            $wysokoscopmerkingen = 5*$ile;

                            if($wysokoscname > $wysokoscopmerkingen){
                                $wysokosc += $wysokoscname;
                            } else {
                                $wysokosc += $wysokoscopmerkingen;
                            }

                            $wysokosc += 5;
                            if($wysokosc >= 245 && $wysokosc <= 275){
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
                        $pdf->SetFont('Arial','',12);
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
                
                        $pdf->SetXY(171,$wysokosc);
                        $pdf->MultiCell(0, 10, chr(128).'', 0, 1);
                        $pdf->SetXY(161 + $ilosc_znakow,$wysokosc);
                        $pdf->Cell(0,10, number_format($total, 2,',', '.'),0,1);
            
            
            
                $y = 230;
                $wys = 0;
            
                $totalBtW = 0;
                foreach ($btw as $k => $stawki_vat) {
                        
                        // print_r($stawki_vat);
                        
                        
                        if($k !=0){
        
                            // $kwota_vat = round($kw - ($kw / $dzielnik),2) ;
                        
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
                        $pdf->SetXY(171,$wysokosc+8+$wys);
                        $pdf->MultiCell(0, 10, chr(128).'', 0, 1);
                        $pdf->SetXY(161 + $ilosc_znakow,$wysokosc+10+$wys);
                        $pdf->Cell(0,5, number_format($stawki_vat, 2,',', '.'),0,1);
                        
                        $wys += 5;
                        
                        }
                    
                    }
        
                    $pdf->SetXY(135,$wysokosc+30);
                    $ilosc_znakow = 10;
                    $pdf->Cell(55 + $ilosc_znakow,10,'Totaal incl. BTW',T,0,1,true);
        
                    $pdf->SetXY(171,$wysokosc+30);
                    $pdf->MultiCell(0, 10, chr(128).'', 0, 1);
                    $pdf->SetXY(168 + $ilosc_znakow,$wysokosc+30);
                    $pdf->Cell(20,10,number_format($total+$totalBtW,2,',', '.').'',0,1,true);

                $nr = $data[0]['id'];

                    file_put_contents('application/storage/oferten/'.$nr.'.pdf',$pdf->Output($nr.'.pdf', 'S'));

                    // $pdf->Output('oferten-'.$nr.'.pdf', 'D');
                    // $pdf->Output();
                
    }

    }

    public function showoferten() {
        $this->createoferten(false);
    }

    public function getofertenidbynumer() {
        $data = $this->__db->execute("SELECT id FROM `bouw_oferten` WHERE `oferten_numer` = " . $this->__params[1]);

        $x = array();

        foreach($data as $q){
            
            array_push($x, $q);
        }

       return $this->historia_maili($x[0]['id']);
    }

    public function historia_maili($oferten_id) {

        $db_query = $this->__db->execute("SELECT data_czas FROM `bouw_oferten_mail` WHERE `oferten_id` = ".$oferten_id);
        
        $historia_maili = array();

        foreach($db_query as $q){
          
            array_push($historia_maili, $q);
        }
        // print_r($historia_maili);
        return $historia_maili;
    }
}

?>