<?php

// error_reporting(E_ERROR | E_PARSE);

class inkomstenmodel
{
    public $query;
    private $bedrag;
	public $cityArray = Array();
	public $adresArray = Array();

	private $__config;
	private $__router;
    public $__params;
	private $__db;
	
	private $warforQuantiy;

	private $mainModel;
	private $facturModel;
	
	public function __construct()
	{
		$this->__config = registry::register("config");
		$this->__router = registry::register("router");
        $this->__params = $this->__router->getParams();
		$this->__db = registry::register("db");

		$this->mainModel = new mainmodel;
		$this->facturModel = new facturmodel;
	}

	public function getFactur()
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
			if($this->__params[1] == "statistiek") {
				return $this->adres($this->od, $this->do, $this->word, null, null, $this->__params[2]);
			} else if($this->__params[1] == "waarvoor") {
				return $this->adres($this->od, $this->do, $this->word, $this->__params[2], null,null,  $this->__params[2]);
			} else {
                if (isset($this->__params[2])) {
                    return $this->adres($this->od, $this->do, $this->word, $this->__params[1], $this->__params[2]);
                } else {
                    return $this->adres($this->od, $this->do, $this->word, $this->__params[1]);
                }
            }
		} else {
			return $this->adres($this->od, $this->do, $this->word , null);   
		}	

	}
	
	private function clear() {
		if(isset($this->__params['POST']['clear'])){
			print_r($this->__params['POST']['clear']);
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

        $this->bedrag = $this->__db->querymy("SELECT bouw_factur_details.quantity, bouw_factur_details.price, bouw_waarvoor.btw 
		FROM 
		`bouw_factur_details` 
		INNER JOIN bouw_waarvoor ON bouw_waarvoor.id = bouw_factur_details.waarvoor_id 
		WHERE bouw_factur_details.factur_nr = $id");

        $bedgarSum = 0;

        foreach($this->bedrag->fetch_all() as $q){
			$sum = $q[0]*$q[1];
			$btw = ($q[0]*$q[1]) * ($q[2] * 0.01);
			$result = $sum + $btw;
            $bedgarSum += $result;
        }
		// array_push($bedgarSum, $result);
        return $bedgarSum;
    }

    public function adres($od, $do, $word = null, $id = null, $oferten_id = null, $warvoorBTW = null, $waarvoor = null) {

		if($waarvoor != null){
			$type = 'waarvoor.id';
		} else if($oferten_id != null){
			$type = 'bouw_factur.oferten_id';
		} else {
			$type = 'bouw_factur.adres_id';
		}
		

		if($word != null && $id != null) {
			$this->query = $this->__db->querymy("SELECT bouw_factur.id, bouw_city.city, bouw_adresy.adres, oferten.oferten_numer, bouw_factur.factur_numer, bouw_factur.data, bouw_factur.proforma_nr
			FROM `bouw_adresy`
             INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id 
			 INNER JOIN bouw_factur ON bouw_factur.adres_id = bouw_adresy.id 
			 LEFT JOIN bouw_oferten AS oferten ON oferten.id = bouw_factur.oferten_id 
			 INNER JOIN bouw_factur_details AS factur_details ON bouw_factur.factur_numer = factur_details.factur_nr
			 INNER JOIN  bouw_waarvoor AS waarvoor ON factur_details.waarvoor_id = waarvoor.id
			 WHERE 
			bouw_factur.data BETWEEN '".$od."' AND '".$do."' AND  bouw_city.city LIKE '%".$word."%' AND ".$type." = '".$id."' OR
            bouw_factur.data BETWEEN '".$od."' AND '".$do."' AND  bouw_factur.id = '".$word."' AND ".$type." = '".$id."' OR
            bouw_factur.data BETWEEN '".$od."' AND '".$do."' AND  bouw_adresy.adres LIKE '%".$word."%' AND ".$type." = '".$id."' OR
            bouw_factur.data BETWEEN '".$od."' AND '".$do."' AND  oferten.oferten_numer = '".$word."' AND ".$type." = '".$id."' OR
            bouw_factur.data BETWEEN '".$od."' AND '".$do."' AND  bouw_factur.factur_numer = '".$word."' AND ".$type." = '".$id."' 
			ORDER BY bouw_factur.id DESC");
		} else if($word != null && $warvoorBTW != null) {
			$this->query = $this->__db->querymy("SELECT bouw_factur.id, bouw_city.city, bouw_adresy.adres, oferten.oferten_numer, bouw_factur.factur_numer, bouw_factur.data, bouw_factur.proforma_nr
			FROM `bouw_adresy`
             INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id 
			 INNER JOIN bouw_factur ON bouw_factur.adres_id = bouw_adresy.id 
			 LEFT JOIN bouw_oferten AS oferten ON oferten.id = bouw_factur.oferten_id 
			 INNER JOIN bouw_factur_details AS factur_details ON bouw_factur.factur_numer = factur_details.factur_nr
			 INNER JOIN  bouw_waarvoor AS waarvoor ON factur_details.waarvoor_id = waarvoor.id
			 WHERE 
			bouw_factur.data BETWEEN '".$od."' AND '".$do."' AND  bouw_city.city LIKE '%".$word."%' AND waarvoor.btw = '".$warvoorBTW."' OR
            bouw_factur.data BETWEEN '".$od."' AND '".$do."' AND  bouw_factur.id = '".$word."' AND waarvoor.btw = '".$warvoorBTW."' OR
            bouw_factur.data BETWEEN '".$od."' AND '".$do."' AND  bouw_adresy.adres LIKE '%".$word."%' AND waarvoor.btw = '".$warvoorBTW."' OR
            bouw_factur.data BETWEEN '".$od."' AND '".$do."' AND  oferten.oferten_numer = '".$word."' AND waarvoor.btw = '".$warvoorBTW."' OR
            bouw_factur.data BETWEEN '".$od."' AND '".$do."' AND  bouw_factur.factur_numer = '".$word."' AND waarvoor.btw = '".$warvoorBTW."'
			ORDER BY bouw_factur.id DESC");
		}
		else if($warvoorBTW != null){
			$this->query = $this->__db->querymy("SELECT bouw_factur.id, bouw_city.city, bouw_adresy.adres, oferten.oferten_numer, bouw_factur.factur_numer, bouw_factur.data, bouw_factur.proforma_nr
			FROM `bouw_adresy`
             INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id 
			 INNER JOIN bouw_factur ON bouw_factur.adres_id = bouw_adresy.id 
			 LEFT JOIN bouw_oferten AS oferten ON oferten.id = bouw_factur.oferten_id 
			 INNER JOIN bouw_factur_details AS factur_details ON bouw_factur.factur_numer = factur_details.factur_nr
			 INNER JOIN  bouw_waarvoor AS waarvoor ON factur_details.waarvoor_id = waarvoor.id
			 WHERE 
            bouw_factur.data BETWEEN '".$od."' AND '".$do."' AND waarvoor.btw = '".$warvoorBTW."' 
			ORDER BY bouw_factur.id DESC");
		}else if($word != null){
			$this->query = $this->__db->querymy("SELECT bouw_factur.id, bouw_city.city, bouw_adresy.adres, oferten.oferten_numer, bouw_factur.factur_numer, bouw_factur.data, bouw_factur.proforma_nr
			FROM `bouw_adresy`
             INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id 
			 INNER JOIN bouw_factur ON bouw_factur.adres_id = bouw_adresy.id 
			 LEFT JOIN bouw_oferten AS oferten ON oferten.id = bouw_factur.oferten_id 
			 WHERE 
			bouw_factur.data BETWEEN '".$od."' AND '".$do."' AND  bouw_city.city LIKE '%".$word."%' OR
            bouw_factur.data BETWEEN '".$od."' AND '".$do."' AND  bouw_factur.id = '".$word."' OR
            bouw_factur.data BETWEEN '".$od."' AND '".$do."' AND  bouw_adresy.adres LIKE '%".$word."%' OR
            bouw_factur.data BETWEEN '".$od."' AND '".$do."' AND  oferten.oferten_numer = '".$word."' OR
            bouw_factur.data BETWEEN '".$od."' AND '".$do."' AND  bouw_factur.factur_numer = '".$word."' 
			ORDER BY bouw_factur.id DESC");
		} else if($id != null) {
			$this->query = $this->__db->querymy("SELECT bouw_factur.id, bouw_city.city, bouw_adresy.adres, oferten.oferten_numer, bouw_factur.factur_numer, bouw_factur.data, bouw_factur.proforma_nr
			FROM `bouw_adresy`
             INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id 
			 INNER JOIN bouw_factur ON bouw_factur.adres_id = bouw_adresy.id 
			 LEFT JOIN bouw_oferten AS oferten ON oferten.id = bouw_factur.oferten_id 
			 INNER JOIN bouw_factur_details AS factur_details ON bouw_factur.factur_numer = factur_details.factur_nr
			 INNER JOIN  bouw_waarvoor AS waarvoor ON factur_details.waarvoor_id = waarvoor.id
			 WHERE 
			bouw_factur.data BETWEEN '".$od."' AND '".$do."' AND  ".$type." = '".$id."'
			ORDER BY bouw_factur.id DESC");
		} else {
			$this->query = $this->__db->querymy("SELECT bouw_factur.id, bouw_city.city, bouw_adresy.adres, oferten.oferten_numer, bouw_factur.factur_numer, bouw_factur.data, bouw_factur.proforma_nr
			FROM `bouw_adresy`
            INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id 
            INNER JOIN bouw_factur ON bouw_factur.adres_id = bouw_adresy.id 
			LEFT JOIN bouw_oferten AS oferten ON oferten.id = bouw_factur.oferten_id 
			WHERE bouw_factur.data BETWEEN '".$od."' AND '".$do."'
			ORDER BY bouw_factur.id DESC");
		}

        $x = 0;
        foreach($this->query->fetch_all() as $q){

            array_push($this->cityArray, $q);
            array_push($this->cityArray[$x], $this->getBedgar($q[4]));      
            $x++;
        }

        // array_push($this->cityArray[0], $this->getBedgar());     

        // $response = array_merge($this->cityArray, $this->getBedgar());
        
       return $this->cityArray;
    }
    
    public function removeFactur(){
		if(isset($this->__params['POST']['facturremove']) && $this->__params['POST']['facturremove'] != null) {
			$this->__db->execute("DELETE FROM bouw_factur WHERE factur_numer = '".$this->__params['POST']['facturremove']."'");
			$this->removewarforById($this->__params['POST']['facturremove']);
			header("Location: ".SERVER_ADDRESS."administrator/inkomsten/index");
		}
	}
	
	private function removewarforById($id) {
            $this->__db->execute("DELETE FROM bouw_factur_details WHERE factur_nr = ".$id);
    }

	public function adresMenuPageName() {
		if(isset($this->__params[0]))
		return $this->__params[0];
	}

	public function getAdresByCity() {
	if(isset($this->__params['POST']['action'])){
		if($this->__params['POST']['action'] == 'miasta') {
			$adresy = $this->__db->querymy("SELECT id, adres FROM `bouw_adresy` WHERE city = ".$this->__params['POST']['id_miasto']);
			
			echo "<option value='0'>Kiez een adres</option>";
			foreach($adresy->fetch_all() as $q){
				// array_push($this->adresArray, $q);
				if(isset($this->__params['POST']['id_adres'])){
				echo "<option value='$q[0]'"; 
				if($q[0] == $this->__params['POST']['id_adres'])
				{ echo "selected"; }
				echo ">$q[1]</option>";
				} else {
				echo "<option value='$q[0]'>$q[1]</option>";
				}
			}
			// echo $this->adresArray;
			return $this->__params['POST']['id_adres'];
		}
	}
	}

	public function getAllWarforType() {
		$arr = Array();
		$type = $this->__db->querymy("SELECT * FROM `bouw_waarvoor`");
        foreach($type->fetch_all() as $q){
            array_push($arr, $q);
        }
       return $arr;
	}

	public function getLastFacturNr() {
		$nr = $this->__db->querymy("SELECT factur_numer FROM `bouw_factur` ORDER BY factur_numer DESC LIMIT 1");
		foreach($nr as $q){
			$x = $q['factur_numer'] + 1;
            return $x;
		}
	}

	public function saveFactura()
	{
		if(isset($this->__params['POST']['savewarfor'])) {
			// print_r($this->__params['POST']['adres']);
			if($this->__params['POST']['privateBedrijfToogler'] == "private")
			{
				$x = 1;
			} else {
				$x = 0;
			}

			$facturNr = $this->getLastFacturNr();
			if($x == 1)
			{

				$this->__db->execute("INSERT INTO bouw_factur 
				(adres_id, 
				oferten_id, 
				factur_numer,
				data,
				private_naam,
				private_achternaam,
				private_tel,
				bedrijf_bedrijf,
				adres,
				postcode,
				stad,
				bedrijf_kvk,
				bedrijf_btw,
				bedrijf_tel,
				email,
				private
				) 
				VALUES (
					'".$this->__params['POST']['adresId']."',
					'".$this->__params['POST']['oferten']."',
					'".$facturNr."',
					'".$this->__params['POST']['facturdata']."',
					'".$this->__params['POST']['private_naam']."',
					'".$this->__params['POST']['private_achternaam']."',
					'".$this->__params['POST']['private_tel']."',
					'',
					'".$this->__params['POST']['adres']."',
					'".$this->__params['POST']['postcode']."',
					'".$this->__params['POST']['stad']."',
					'',
					'',
					'',
					'".$this->__params['POST']['email']."',
					'".$x."'
					)");

			} else {

				$this->__db->execute("INSERT INTO bouw_factur 
				(adres_id, 
				oferten_id, 
				factur_numer,
				data,
				private_naam,
				private_achternaam,
				private_tel,
				bedrijf_bedrijf,
				adres,
				postcode,
				stad,
				bedrijf_kvk,
				bedrijf_btw,
				bedrijf_tel,
				email,
				private
				) 
				VALUES (
					'".$this->__params['POST']['adresId']."',
					'".$this->__params['POST']['oferten']."',
					'".$facturNr."',
					'".$this->__params['POST']['facturdata']."',
					'',
					'',
					'',
					'".$this->__params['POST']['bedrijf_bedrijf']."',
					'".$this->__params['POST']['adres']."',
					'".$this->__params['POST']['postcode']."',
					'".$this->__params['POST']['stad']."',
					'".$this->__params['POST']['bedrijf_kvk']."',
					'".$this->__params['POST']['bedrijf_btw']."',
					'".$this->__params['POST']['bedrijf_tel']."',
					'".$this->__params['POST']['email']."',
					'".$x."'
					)");

			}
			

            
        

            $id = $this->__db->getLastInsertedId();

            $factur_nr = $this->__db->querymy("SELECT factur_numer FROM `bouw_factur` WHERE id = ".$id);
            foreach ($factur_nr->fetch_all() as $row) {
                for ($i=0; $i < 20; $i++) {
                    # code...

                $price = str_replace(",",".",$this->__params['POST']['warforquantity'][$i]);
                
                $this->__db->execute("INSERT INTO bouw_factur_details 
				(factur_nr, 
				waarvoor_id, 
				quantity,
				price,
				opmerkingen
				) 
				VALUES (
				".$row[0].",
				".$this->__params['POST']['warfortype'][$i].",
				".$this->__params['POST']['warfortimespend'][$i].",
				".$price.",
				'".$this->__params['POST']['opmerkingen'][$i]."'
				)");
            }
            }
		}

		$this->facturModel->uploadFacturFiles($id);
		
		$proforma_pdf = 'application/storage/proformy/'.$id.'.pdf';
			
		$dir = $_SERVER['DOCUMENT_ROOT'].'/application/storage/factur';
		$dirname = $id;

		$this->mainModel->createNewFolder($dir, $dirname);

		$proforma1 = file_exists($proforma_pdf); 
		if ($proforma1) {
			unlink($_SERVER['DOCUMENT_ROOT'].'/application/storage/proformy/'.$id.'.pdf');
		}
 
		$facturModel = New facturmodel();
		$facturModel->createfactur($facturNr);
		$proforma_pdf = 'application/storage/proformy/'.$id.'.pdf';

		header("Location: ".SERVER_ADDRESS."administrator/inkomsten/index");
	}
	
	public function getdata($request = null) {

		if($request == null){
            
            $proforma_numer = $this->__params[1];
        } else {
            $proforma_numer = $request;
        }

		

        $data = $this->__db->execute("SELECT 
        city.city_id,
        klanten.stad,
        klanten.adres, 
        klanten.postcode,
        klanten.private_naam,
        klanten.private_achternaam,
        klanten.private_id_kaart,
        klanten.private_tel,
        klanten.private_geboortedatum,
        klanten.bedrijf_bedrijf,
        klanten.bedrijf_kvk,
        klanten.bedrijf_btw,
        klanten.bedrijf_tel,
        klanten.email,
        klanten.rekening,
        factur.data,
        factur.factur_numer,
        factur.id,
		factur.proforma_nr
        
        FROM bouw_city AS city INNER JOIN bouw_adresy  AS adresy ON city.city_id = adresy.city 
        INNER JOIN bouw_factur AS factur ON adresy.id = factur.adres_id 
		INNER JOIN bouw_klanten AS klanten ON klanten.id = adresy.klanten_id 
		WHERE factur.factur_numer = ".$proforma_numer);

		if($data == null)
		{
			$data = $this->__db->execute("SELECT 
			city.city_id,
			factur.stad,
			factur.adres, 
			factur.postcode,
			factur.private_naam,
			factur.private_achternaam,
			factur.private_tel,
			factur.bedrijf_bedrijf,
			factur.bedrijf_kvk,
			factur.bedrijf_btw,
			factur.bedrijf_tel,
			factur.email,
			factur.data,
			factur.factur_numer,
			factur.id,
			factur.proforma_nr
			
			FROM bouw_city AS city INNER JOIN bouw_adresy  AS adresy ON city.city_id = adresy.city 
			INNER JOIN bouw_factur AS factur ON adresy.id = factur.adres_id 
			WHERE factur.factur_numer = ".$proforma_numer);
		}

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
        FROM bouw_factur_details AS details INNER JOIN bouw_waarvoor AS warfor ON details.waarvoor_id = warfor.id
        WHERE factur_nr = ".$proforma_numer);

        $y = array();
        foreach($dataWarfor as $q){

            array_push($y, $q);

        }

        $z = array_merge($x, $y);
       
        // print_r($z);

        return $z;

    }

    public function getbtw($nr) {

        return $this->mainModel->getBTW($this->getdata($nr));

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

}

?>