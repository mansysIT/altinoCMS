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

    public function adres($od, $do, $word, $city_id = null) {
		//$this->query = $this->__db->querymy("SELECT * FROM `bouw_adresy` INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id WHERE date BETWEEN '".$od."' AND '".$do."' AND active = ".$active." AND  bouw_city.city LIKE '%".$word."%' ");
		if($city_id != null){
			$this->query = $this->__db->querymy("SELECT bouw_factur.id, bouw_city.city, bouw_adresy.adres, bouw_factur.oferten_id, bouw_factur.factur_numer, bouw_factur.data FROM `bouw_adresy`
             INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id 
             INNER JOIN bouw_factur ON bouw_factur.adres_id = bouw_adresy.id WHERE data BETWEEN '".$od."' AND '".$do."' AND  bouw_city.city LIKE '%".$word."%' ");
		} else {
			$this->query = $this->__db->querymy("SELECT bouw_factur.id, bouw_city.city, bouw_adresy.adres, bouw_factur.oferten_id, bouw_factur.factur_numer, bouw_factur.data FROM `bouw_adresy`
            INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id 
            INNER JOIN bouw_factur ON bouw_factur.adres_id = bouw_adresy.id 
            WHERE data BETWEEN '".$od."' AND '".$do."' AND  bouw_city.city LIKE '%".$word."%' ");
		}

        $x = 0;
        foreach($this->query->fetch_all() as $q){

            array_push($this->cityArray, $q);
            array_push($this->cityArray[$x], $this->getBedgar($q[0]));      
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

	public function getParametrs() {
		if(isset($this->__params[2])) {
			return true;
		}
	}

	public function getAdresByCity() {
		if(isset($this->__params['POST']['action'])){
		if($this->__params['POST']['action'] == 'miasta') {
			$adresy = $this->__db->querymy("SELECT id, adres FROM `bouw_adresy` WHERE city = ".$this->__params['POST']['id_miasto']);
			
			foreach($adresy->fetch_all() as $q){
				// array_push($this->adresArray, $q);
				echo "<option value='$q[0]'>$q[1]</option>";
			}
			// echo $this->adresArray;
			return $this->adresArray;
		}
	}
	}

	public function getAllWarforType() {
		$type = $this->__db->querymy("SELECT * FROM `bouw_waarvoor`");
		print_r($type);
		return $type;
	}

	public function addWarfor() {
		if(isset($this->__params['POST']['action'])) {
		$this->warforQuantiy = $this->__params['POST']['quantity'];
		
		for ($i=0; $i <= $this->warforQuantiy; $i++) { 
			echo "<li style='display: flex; margin: 5px;'>
			<p style='margin: 5px'>Waarvoor</p>
			<select name='warforname$i' class='miasta form-control' id='exampleFormControlSelect1'>";
			foreach($this->getAllWarforType()->fetch_all() as $row) {
				echo "<option value=".$row[0].">".$row[1]."</option>";
			}
			echo"</select>
			<p>Quantity</p>
			<input type='text' value='' class='form-control' name='ile$i' placeholder='quantity'>
			<p>Price</p>
			<input type='text' class='form-control' name='cena$i' placeholder='price'>
			</li>";

		}
		$this->warforQuantiy++;
		
		}
	}

	private function getLastFacturNr() {
		$nr = $this->__db->querymy("SELECT factur_numer FROM `bouw_factur` ORDER BY factur_numer DESC LIMIT 1");
		foreach($nr as $q){
			$x = $q['factur_numer'] + 1;
            return $x;
		}
	}

	public function saveFactura()
	{

		if(isset($this->__params['POST']['savewarfor'])) {
			$this->__db->execute("INSERT INTO bouw_factur 
			(adres_id, 
			oferten_id, 
			factur_numer,
			data) 
			VALUES (
				'".$this->__params['POST']['adres']."',
				'6',
				'".$this->getLastFacturNr()."',
				'2019-02-02'
				)");
            
        

            $id = $this->__db->getLastInsertedId();

            $factur_nr = $this->__db->querymy("SELECT factur_numer FROM `bouw_factur` WHERE id = ".$id);
            foreach ($factur_nr->fetch_all() as $row) {
                for ($i=0; $i < 20; $i++) {
                    # code...
                
					print_r($i);
					
                
                    $this->__db->execute("INSERT INTO bouw_factur_details 
			(factur_nr, 
			waarvoor_id, 
			quantity,
			price) 
			VALUES (
			".$row[0].",
			".$this->__params['POST']['warforname'.$i].",
			".$this->__params['POST']['ile'.$i].",
			".$this->__params['POST']['cena'.$i]."
			)");
                }
            }
        }
		header("Location: ".SERVER_ADDRESS."administrator/inkomsten/index");
    }
}

?>