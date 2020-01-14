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
	
	public function __construct()
	{
		$this->__config = registry::register("config");
		$this->__router = registry::register("router");
        $this->__params = $this->__router->getParams();
		$this->__db = registry::register("db");

		$this->mainModel = new mainmodel;
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
			$dOd->modify('-12 month');

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

        $this->bedrag = $this->__db->querymy("SELECT quantity, price FROM `bouw_factur_details` WHERE factur_nr = $id");

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
			$this->query = $this->__db->querymy("SELECT bouw_factur.id, bouw_city.city, bouw_adresy.adres, bouw_factur.oferten_id, bouw_factur.factur_numer, bouw_factur.data FROM `bouw_adresy`
             INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id 
			 INNER JOIN bouw_factur ON bouw_factur.adres_id = bouw_adresy.id 
			 WHERE 
			bouw_factur.data BETWEEN '".$od."' AND '".$do."' AND  bouw_city.city LIKE '%".$word."%' OR
            bouw_factur.data BETWEEN '".$od."' AND '".$do."' AND  bouw_factur.id = $word OR
            bouw_factur.data BETWEEN '".$od."' AND '".$do."' AND  bouw_adresy.adres LIKE '%".$word."%' OR
            bouw_factur.data BETWEEN '".$od."' AND '".$do."' AND  bouw_factur.oferten_id = $word OR
            bouw_factur.data BETWEEN '".$od."' AND '".$do."' AND  bouw_factur.factur_numer = $word 
			 ORDER BY bouw_factur.id DESC");
		} else {
			$this->query = $this->__db->querymy("SELECT bouw_factur.id, bouw_city.city, bouw_adresy.adres, bouw_factur.oferten_id, bouw_factur.factur_numer, bouw_factur.data FROM `bouw_adresy`
            INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id 
            INNER JOIN bouw_factur ON bouw_factur.adres_id = bouw_adresy.id 
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
			$this->__db->execute("DELETE FROM bouw_factur WHERE id = '".$this->__params['POST']['facturremove']."'");
			header("Location: ".SERVER_ADDRESS."administrator/inkomsten/index");
		}
    }
	
	public function getAdressById() {
		$data = $this->__db->execute("SELECT *, bouw_adresy.city AS adres_city_id FROM `bouw_adresy` INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id WHERE id = ".$this->__params[1]);

		return $data[0];
	}

	public function adresMenuGetUrl() {
		if(isset($this->__params[1]))
		return $this->__params[1];
	}

	public function adresMenuPageName() {
		if(isset($this->__params[0]))
		return $this->__params[0];
	}

	public function getAdresByCity() {
		if(isset($this->__params['POST']['action'])){
		if($this->__params['POST']['action'] == 'miasta') {
			$adresy = $this->__db->querymy("SELECT id, adres FROM `bouw_adresy` WHERE city = ".$this->__params['POST']['id_miasto']);
			
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
			return $this->adresArray;
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
			$facturNr = $this->getLastFacturNr();
			$this->__db->execute("INSERT INTO bouw_factur 
			(adres_id, 
			oferten_id, 
			factur_numer,
			data) 
			VALUES (
				'".$this->__params['POST']['adres']."',
				'".$this->__params['POST']['oferten']."',
				'".$facturNr."',
				'".$this->__params['POST']['facturdata']."'
				)");
            
        

            $id = $this->__db->getLastInsertedId();

            $factur_nr = $this->__db->querymy("SELECT factur_numer FROM `bouw_factur` WHERE id = ".$id);
            foreach ($factur_nr->fetch_all() as $row) {
                for ($i=0; $i < 20; $i++) {
                    # code...

                
                $this->__db->execute("INSERT INTO bouw_factur_details 
				(factur_nr, 
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
		}
		
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
        factur.id
        
        FROM bouw_city AS city INNER JOIN bouw_adresy  AS adresy ON city.city_id = adresy.city 
        INNER JOIN bouw_factur AS factur ON adresy.id = factur.adres_id 
        WHERE factur.factur_numer = ".$proforma_numer);
        $x = array();
        foreach($data as $q){
            array_push($x, $q);

        }

        $dataWarfor = $this->__db->execute("SELECT 
        warfor.name,
        warfor.btw,
        details.quantity,
        details.price
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

        $warfor = $this->getdata($nr);
        $x = Array();

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

}

?>