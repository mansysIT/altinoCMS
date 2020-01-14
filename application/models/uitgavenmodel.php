<?php

// error_reporting(E_ERROR | E_PARSE);

class uitgavenmodel  
{
    public $query;
    private $bedrag;
	public $cityArray = Array();

	private $__config;
	private $__router;
    public $__params;
	private $__db;
	
	private $warforQuantiy;
	
	public function __construct()
	{
		$this->__config = registry::register("config");
		$this->__router = registry::register("router");
        $this->__params = $this->__router->getParams();
		$this->__db = registry::register("db");
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

		
		return $this->adres($this->od, $this->do, $this->word);   
	

	}
	
	private function clear() {
		if(isset($this->__params['POST']['clear'])){
			print_r($this->__params['POST']['clear']);
			$d = new DateTime(date("Y-m-d"));
			
			$dOd = new DateTime(date("Y-m-d"));
			$dOd->modify('-12 month');

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



    // SELECT bouw_adresy.id, bouw_adresy.adres, bouw_city.city FROM `bouw_adresy` INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id INNER JOIN bouw_factur ON bouw_factur.adres_id = bouw_adresy.id WHERE bouw_factur.adres_id = 28

    public function adres($od, $do, $word) {

	

		//$this->query = $this->__db->querymy("SELECT * FROM `bouw_adresy` INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id WHERE date BETWEEN '".$od."' AND '".$do."' AND active = ".$active." AND  bouw_city.city LIKE '%".$word."%' ");
		if($word != null){

			$params[0] = 0;
			$params[1] = $word;

			$dod = '';
			$w = model_load('mainmodel', 'getwaarvoor', $params); 
			$waarvoorId = $w[0][0]; 

			if(!empty($waarvoorId))
				$dod = "data BETWEEN '".$od."' AND '".$do."' AND  bouw_uitgaven.waarvoor_id = ".$waarvoorId." OR ";
			
	 
			//echo 'jest'. $w[0][0];

			$this->query = $this->__db->querymy("SELECT bouw_uitgaven.id, bouw_city.city, bouw_adresy.adres, bouw_uitgaven.oferte_numer, bouw_uitgaven.price, bouw_uitgaven.data, bouw_uitgaven.waarvoor_id FROM `bouw_adresy`
             INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id 
             INNER JOIN bouw_uitgaven ON bouw_uitgaven.adres_id = bouw_adresy.id WHERE 
			 data BETWEEN '".$od."' AND '".$do."' AND  bouw_city.city LIKE '%".$word."%' OR
			 data BETWEEN '".$od."' AND '".$do."' AND  bouw_uitgaven.id = ".$word." OR
			 data BETWEEN '".$od."' AND '".$do."' AND  bouw_adresy.adres LIKE '%".$word."%' OR
			 data BETWEEN '".$od."' AND '".$do."' AND  bouw_uitgaven.price LIKE '%".$word."%' OR
			".$dod." 
			 data BETWEEN '".$od."' AND '".$do."' AND  bouw_uitgaven.oferte_numer = ".$word." 

			 ORDER BY bouw_uitgaven.id DESC");
		} else {
			$this->query = $this->__db->querymy("SELECT bouw_uitgaven.id, bouw_city.city, bouw_adresy.adres, bouw_uitgaven.oferte_numer, bouw_uitgaven.price, bouw_uitgaven.data, bouw_uitgaven.waarvoor_id FROM `bouw_adresy`
            INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id 
            INNER JOIN bouw_uitgaven ON bouw_uitgaven.adres_id = bouw_adresy.id 
            WHERE data BETWEEN '".$od."' AND '".$do."'
			ORDER BY bouw_uitgaven.id DESC"); 
		}

        foreach($this->query->fetch_all() as $q){

            array_push($this->cityArray, $q);
         
        }

        // array_push($this->cityArray[0], $this->getBedgar());     

        // $response = array_merge($this->cityArray, $this->getBedgar());
        
       return $this->cityArray;
    }
     
    public function removeUitgaaf(){
		if(isset($this->__params['POST']['uitgaafremove']) && $this->__params['POST']['uitgaafremove'] != null) {
			$this->__db->execute("DELETE FROM bouw_uitgaven WHERE id = '".$this->__params['POST']['uitgaafremove']."'");
			header("Location: ".SERVER_ADDRESS."administrator/uitgaven/index");
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
				echo "<option value='$q[0]'>$q[1]</option>";
			}
		}
	}
	}

	public function addWarfor() { 
		if(isset($this->__params['POST']['action'])) {
		$this->warforQuantiy = $this->__params['POST']['quantity'];
		
		for ($i=0; $i <= $this->warforQuantiy; $i++) { 
			echo "<div><input type='text' name='warforname' value=''></div>";
		}
		$this->warforQuantiy++;
		
		}
	}

	public function saveUitgaaf() 
	{
		if(isset($this->__params[1])) {


		}
		if(isset($this->__params['POST']['savewarfor'])) {


			$d = new DateTime($this->__params['POST']['datum']);
			$data = $d->format('Y-m-d');

			$price = str_replace(",",".",$this->__params['POST']['price']);
			
			if(empty($this->__params[1])){

				$this->__db->execute("INSERT INTO bouw_uitgaven 
				(adres_id, 
				oferte_numer, 
				waarvoor_id, 
				price,
				data
				) 
				VALUES (
				'".$this->__params['POST']['adres']."', 
				'".$this->__params['POST']['oferte_id']."',
				'".$this->__params['POST']['waarvoor']."',
				'".$price."',
				'".$data."' 
				)");
			}
			else{

	
				$this->__db->execute("
				UPDATE `bouw_uitgaven` SET `adres_id`=".$this->__params['POST']['adres'].", 
				`oferte_numer`=".$this->__params['POST']['oferte_id'].", 
				`waarvoor_id`=".$this->__params['POST']['waarvoor'].", 
				`price`=".$price.", 
				`data`= '".$data."'
				WHERE id = ".$this->__params[1]); 

			}

			// UPDATE `bouw_uitgaven` SET 
			// `adres_id`=".$this->__params['POST']['adres'].",
			// `oferte_numer`=".$this->__params['POST']['oferte_id'].",
			// `waarvoor_id`=".$this->__params['POST']['waarvoor'].",
			// `price`=".$this->__params['POST']['price'].",
			// `data`= '2002'  
			// WHERE id = 16


			header("Location: ".SERVER_ADDRESS."administrator/uitgaven/index");
		}
	}
}
  
?>