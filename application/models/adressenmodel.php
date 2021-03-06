<?php

error_reporting(E_ERROR | E_PARSE);

class adressenmodel
{
	public $query;
	public $cityArray = Array();

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
		
		$this->clearActive();

		$this->mainModel = new mainmodel;
	}

	public function getAdress() { 
		$this->adressenModel = new adressenmodel();

		if (isset($this->__params['POST']['vanaf'])) {
			$this->od = $this->__params['POST']['vanaf'];
			$this->do = $this->__params['POST']['tot'];
			$this->word = $this->__params['POST']['word'];
			if(isset($this->__params['POST']['active'])){
				$this->active = $this->__params['POST']['active'];
			} else if(isset($_SESSION['active'])) {
				$this->active = $_SESSION['active'];
				$this->__params['POST']['active'] = $_SESSION['active'];
			} else {
				$this->active = 1;		
			}
			$_SESSION['vanaf'] = $this->od; 
			$_SESSION['tot'] = $this->do; 
			$_SESSION['word'] = $this->word; 
			$_SESSION['active'] = $this->active; 
		} else if(isset($_SESSION['vanaf']) && $_SESSION['vanaf'] != null) {
			$this->od = $_SESSION['vanaf'];
            $this->do = $_SESSION['tot'];
			$this->word = $_SESSION['word'];
			if(isset($this->__params['POST']['active'])){
				$this->active = $this->__params['POST']['active'];
			} else {
				$this->active = 1;
			} 
		} else {
			$d = new DateTime(date("Y-m-d"));
			$dOd = new DateTime(date("Y-m-d"));
			$dOd->modify('-12 month');

			$this->od = $dOd->format('Y-m-d');
			$this->do = $d->format('Y-m-d');
			$this->word = '';
			$this->active = 1;
		}

		$this->clear();
		if(isset($this->__params[2])){
			return $this->adressenModel->adres($this->od, $this->do, $this->word , $this->active, $this->__params[2]);   
		} else {
			return $this->adressenModel->adres($this->od, $this->do, $this->word , $this->active, null);   
		}

	}
	
	private function clear() {
		if(isset($this->__params['POST']['clear'])){
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
			unset($this->__params['POST']['active']);
			unset($_SESSION['vanaf']);
			unset($_SESSION['tot']);
			unset($_SESSION['word']);
			unset($_SESSION['active']);
		}
	}

	private function clearActive(){
		if(!isset($this->__params['POST']['clear']) && !isset($this->__params['POST']['zoeken']) && !isset($this->__params['POST']['active']))
		{
			unset($this->__params['POST']['active']);
			unset($_SESSION['active']);
		}

	}

    public function adres($od, $do, $word, $active, $city_id = null){
		if($city_id != null){
			$this->query = $this->__db->querymy("SELECT bouw_adresy.id, bouw_adresy.adres, bouw_adresy.active, bouw_city.city
			FROM `bouw_adresy` INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id 
			WHERE active = ".$active." AND  bouw_city.city LIKE '%".$word."%' AND bouw_adresy.city = $city_id 
			ORDER BY bouw_adresy.id DESC");
		} else {
			$this->query = $this->__db->querymy("SELECT bouw_adresy.id, bouw_adresy.adres, bouw_adresy.active, bouw_city.city 
			FROM `bouw_adresy` INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id
			WHERE active = ".$active." AND  bouw_city.city LIKE '%".$word."%'
			ORDER BY bouw_adresy.id DESC");
		}
	

		$i = 0;
        foreach($this->query->fetch_all() as $q){
			array_push($this->cityArray, $q);

			$inkomsten = $this->mainModel->getAllInkomsten('adres_id', $q[0]);
			$uitgaven = $this->mainModel->getAllUitgaven('adres_id', $q[0]);
			$sum = $this->mainModel->winst($inkomsten, $uitgaven);

			array_push($this->cityArray[$i], $inkomsten);
			array_push($this->cityArray[$i], $uitgaven);
			array_push($this->cityArray[$i], $sum);

			$i++;
		}

       return $this->cityArray;
	}
	
	public function getAdressById() {
		$data = $this->__db->execute("SELECT *, bouw_adresy.city AS adres_city_id FROM `bouw_adresy` INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id WHERE id = ".$this->__params[1]);
		setcookie('aaa',$data[0]['id'], 0, "/");
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



	public function setActive() {
		if(isset($this->__params['POST']['active'])){
		$this->__db->execute("UPDATE bouw_adresy SET active = 0  WHERE id = ".$this->__params['POST']['active']);
		header("Location: ".SERVER_ADDRESS."administrator/adressen/index");
		}else {
			
		$this->__db->execute("UPDATE bouw_adresy SET active = 1  WHERE id = ".$this->__params['POST']['noactive']);
		header("Location: ".SERVER_ADDRESS."administrator/adressen/index");
	}
	}

	public function createAdresFolder() {
        if (isset($this->__params['POST']['addfolder']) && isset($this->__params['POST']['foldername']) && $this->__params['POST']['foldername'] != null) {
			$dir = 'application/storage/adres/'.$this->__params[1];
			$dirName = $this->__params['POST']['foldername'];	
			$this->mainModel->createNewFolder($dir, $dirName);	
        }			
	} 

	public function getAllFiles() {
        if (isset($this->__params[2])) {
            $dir = "application/storage/adres/".$this->__params[1]."/".$this->__params[2];
        } else {
			$dir = 'application/storage/adres/'.$this->__params[1];
		}
		
		return $this->mainModel->getAllFilesInDirectory($dir);
	} 

	public function uploadFiles() {
        if (isset($this->__params['POST']['fileUpload'])) {
            if (isset($this->__params[2])) {
                $dir = "application/storage/adres/".$this->__params[1]."/".$this->__params[2].'/';
            } else {
                $dir = 'application/storage/adres/'.$this->__params[1].'/';
			}
			return $this->mainModel->uploadFile($dir);
        }	
	} 

	public function remove() {
        if (isset($this->__params['POST']['removefolder']) || isset($this->__params['POST']['removefile'])) {
            if (isset($this->__params[2])) {
                $dir = "application/storage/adres/".$this->__params[1]."/".$this->__params[2].'/';
            } else {
                $dir = 'application/storage/adres/'.$this->__params[1].'/';
			}
			$this->mainModel->remove($dir);
        }	
	} 

	public function editAdress(){
		if(isset($this->__params['POST']['editadres']))
		{	
			echo "<pre>";
			print_r($this->__params['POST']);
			$adres = $this->__params['POST']['adres'];
			$postcode = $this->__params['POST']['postcode'];
			$city = $this->__params['POST']['city'];
			$klanten = $this->__params['POST']['klanten'];

			$this->__db->execute("UPDATE bouw_adresy 
			SET
			city = '".$city."',
			adres = '".$adres."', 
			postcode = '".$postcode."',
			klanten_id = '".$klanten."'
			WHERE id = ".$this->__params[1]);

			$this->createAdresDirectory($this->__params[1]);
			header("Location: ".SERVER_ADDRESS."administrator/adressen/index/");
		}
	}

	private function createAdresDirectory($adres_id) {
		if(!is_dir('application/storage/adres/'.$adres_id.'')){
			mkdir('application/storage/adres/'.$adres_id.'', 0777);
		}
	}

	private function getBtwData() {

        $dataWarfor = $this->__db->execute("SELECT 
        warfor.btw,
        details.quantity,
        details.price,
		warfor.name,
		warfor.id
        FROM bouw_factur_details AS details 
		INNER JOIN bouw_waarvoor AS warfor ON details.waarvoor_id = warfor.id
		INNER JOIN bouw_factur AS factur ON details.factur_nr = factur.factur_numer
		WHERE factur.adres_id = ".$this->__params[1]."
		ORDER BY warfor.btw
		");

        $y = array();
        foreach($dataWarfor as $q){
            array_push($y, $q);

        }

        return $y;

	}

	private function getBtwDataUitgaven() {

        $dataWarfor = $this->__db->execute("SELECT 
        warfor.btw,
        uitgaven.price,
		warfor.name
        FROM bouw_uitgaven AS uitgaven 
		INNER JOIN bouw_waarvoor AS warfor ON uitgaven.waarvoor_id = warfor.id
		WHERE uitgaven.adres_id = ".$this->__params[1]."
		ORDER BY warfor.btw
		");

        $y = array();
        foreach($dataWarfor as $q){
            array_push($y, $q);

        }

        return $y;

    }
	
	public function AllWaarfoor() {
		return $this->mainModel->getAllWaarvoor($this->getBtwData());
	}

	public function AllWaarfoorUitgaven() {
		return $this->mainModel->getAllWaarvoorUitgaven($this->getBtwDataUitgaven());
	}
	
}

?>