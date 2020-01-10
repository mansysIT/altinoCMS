<?php

// error_reporting(E_ERROR | E_PARSE);

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
    
    public function getdata() {

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
        WHERE proforma.proforma_numer = ".$this->__params[1]);
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
        WHERE proforma_nr = ".$this->__params[1]);

        $y = array();
        foreach($dataWarfor as $q){

            array_push($y, $q);

        }

        $z = array_merge($x, $y);
       
        // print_r($z);

        return $z;

    }

    public function getbtw() {

        $warfor = $this->getdata();
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

    public function gettotal(){
        $warfor = $this->getdata();
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

    public function adres($od, $do, $word, $city_id = null) {
		//$this->query = $this->__db->querymy("SELECT * FROM `bouw_adresy` INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id WHERE date BETWEEN '".$od."' AND '".$do."' AND active = ".$active." AND  bouw_city.city LIKE '%".$word."%' ");
		if($city_id != null){
			$this->query = $this->__db->querymy("SELECT proforma.id, city.city, adres.adres, proforma.oferten_id, proforma.proforma_numer, proforma.data 
            FROM bouw_adresy AS adres 
            INNER JOIN bouw_city AS city ON adres.city = city.city_id 
			INNER JOIN bouw_proforma AS proforma ON proforma.adres_id = adres.id 
            WHERE proforma.data BETWEEN '".$od."' AND '".$do."' AND  city.city LIKE '%".$word."%' 
			ORDER BY proforma.id DESC");
		} else {
			$this->query = $this->__db->querymy("SELECT proforma.id, city.city, adres.adres, proforma.oferten_id, proforma.proforma_numer, proforma.data 
            FROM bouw_adresy AS adres 
            INNER JOIN bouw_city AS city ON adres.city = city.city_id 
			INNER JOIN bouw_proforma AS proforma ON proforma.adres_id = adres.id 
			WHERE proforma.data BETWEEN '".$od."' AND '".$do."' AND  city.city LIKE '%".$word."%' 
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
			header("Location: ".SERVER_ADDRESS."administrator/proforma/proforma");
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
			$this->__db->execute("INSERT INTO bouw_proforma 
			(adres_id, 
			oferten_id, 
			proforma_numer,
			data) 
			VALUES (
				'".$this->__params['POST']['adres']."',
				'".$this->__params['POST']['oferten']."',
				'".$this->getLastProformaNr()."',
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
        }
		header("Location: ".SERVER_ADDRESS."administrator/proforma/proforma");
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
        proforma.oferten_id
        
        FROM bouw_city AS city INNER JOIN bouw_adresy  AS adresy ON city.city_id = adresy.city 
        INNER JOIN bouw_proforma AS proforma ON adresy.id = proforma.adres_id 
        WHERE proforma.proforma_numer = ".$this->__params[1]);
        $x = array();
        foreach($data as $q){
            array_push($x, $q);

        }

        
        $y = $this->getAllWarforForAdres();

        $z = array_merge($x, $y);
       
        // print_r($z);

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
            // print_r($q);

        }

        return $y;
    }

    public function editProforma()
	{
		if(isset($this->__params['POST']['editwarfor'])) {

            $adres = $this->__params['POST']['adres'];
            $factur =$this->__params['POST']['facturnumer'];
            $data = $this->__params['POST']['facturdata'];
            $oferten = $this->__params['POST']['oferten'];

			$this->__db->execute("UPDATE bouw_proforma 
            SET
			adres_id = $adres,
			oferten_id = $oferten, 
			proforma_numer = $factur,
			data = '$data' 
            WHERE proforma_numer = $factur
            ");

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
                        // print_r(" [ ".$r." / ");
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
            header("Location: ".SERVER_ADDRESS."administrator/proforma/proforma");
        }
    }

    public function removewarfor() {
        if ($this->__params['POST']['action'] == 'removewarfor') {
            $this->__db->execute("DELETE FROM bouw_proforma_details WHERE id = ".$this->__params['POST']['warfor_id']);
        }

    }
}

?>