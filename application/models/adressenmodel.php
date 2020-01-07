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
	
	public function __construct()
	{
		$this->__config = registry::register("config");
		$this->__router = registry::register("router");
        $this->__params = $this->__router->getParams();
		$this->__db = registry::register("db");
		
		$this->clearActive();
	}

	public function getAdress()
	{ 
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
		//$this->query = $this->__db->querymy("SELECT * FROM `bouw_adresy` INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id WHERE date BETWEEN '".$od."' AND '".$do."' AND active = ".$active." AND  bouw_city.city LIKE '%".$word."%' ");
		if($city_id != null){
			$this->query = $this->__db->querymy("SELECT bouw_adresy.id, bouw_adresy.adres, bouw_adresy.active, bouw_city.city FROM `bouw_adresy` INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id WHERE active = ".$active." AND  bouw_city.city LIKE '%".$word."%' AND bouw_adresy.city = $city_id ");
		} else {
			$this->query = $this->__db->querymy("SELECT bouw_adresy.id, bouw_adresy.adres, bouw_adresy.active, bouw_city.city FROM `bouw_adresy` INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id WHERE active = ".$active." AND  bouw_city.city LIKE '%".$word."%'");
		}
	


        foreach($this->query->fetch_all() as $q){
            array_push($this->cityArray, $q);
		}
		
       return $this->cityArray;
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

	public function getAllFilesInDirectory() {

		if(isset($this->__params[2])){
			$dir = "application/storage/adres/".$this->__params[1]."/".$this->__params[2];
			if(scandir($dir) != null){
				$files = scandir($dir);
				$foldersArray = array();
				$filesArray = array();
				foreach($files as $file)
				{
					if (strpos($file, '.') == null) {	
						if (strpos($file, '..') == null) {
						}
					} else {
						array_push($filesArray, $file);
					}
				}
				return array($foldersArray, $filesArray);
			} else {
				return array();
			}
		} else {
			$dir = "application/storage/adres/".$this->__params[1];
			if(scandir($dir) != null){
				$files = scandir($dir);
				$foldersArray = array();
				$filesArray = array();
				foreach($files as $file)
				{
					if (strpos($file, '.') == null) {	
						if (strpos($file, '..') == null) {
							array_push($foldersArray, $file);
						}
					} else {
						array_push($filesArray, $file);
					}
				}
				return array($foldersArray, $filesArray);
			}
		}
	}

	public function createNewFolder() {
		if(isset($this->__params['POST']['addfolder']) && isset($this->__params['POST']['foldername']) && $this->__params['POST']['foldername'] != null) {
			$file = $this->__params['POST']['foldername'];
			
			if(!is_dir('application/storage/adres/'.$this->__params[1].'/'.$file.'')){
				mkdir('application/storage/adres/'.$this->__params[1].'/'.$file.'', 0777);
			}
		}
	}

	public function remove() {
		if(isset($this->__params[2])){
			if(isset($this->__params['POST']['removefolder'])) {
				$file = $this->__params['POST']['removefolder'];
				if(is_dir('application/storage/adres/'.$this->__params[1].'/'.$this->__params[2]."/".$file.'')){
					print_r('is');
					rmdir('application/storage/adres/'.$this->__params[1].'/'.$this->__params[2].'/'.$file.'');
				}
			}

			if(isset($this->__params['POST']['removefile'])) {
				$file = $this->__params['POST']['removefile'];
				print_r($file);
				if(file_exists('application/storage/adres/'.$this->__params[1].'/'.$this->__params[2].'/'.$file.'')){
					print_r('isFile');
					unlink('application/storage/adres/'.$this->__params[1].'/'.$this->__params[2].'/'.$file.'');
				}
			}
		} else {
			if(isset($this->__params['POST']['removefolder'])) {
				$file = $this->__params['POST']['removefolder'];
				if(is_dir('application/storage/adres/'.$this->__params[1].'/'.$file.'')){
					print_r('is');
					rmdir('application/storage/adres/'.$this->__params[1].'/'.$file.'');
				}
			}

			if(isset($this->__params['POST']['removefile'])) {
				$file = $this->__params['POST']['removefile'];
				print_r($file);
				if(file_exists('application/storage/adres/'.$this->__params[1].'/'.$file.'')){
					print_r('isFile');
					unlink('application/storage/adres/'.$this->__params[1].'/'.$file.'');
				}
			}
		}
	}

	public function uploadFile() {
		if(isset($this->__params[2])){
			$target_dir = "application/storage/adres/".$this->__params[1]."/".$this->__params[2]."/";
		} else {
			$target_dir = "application/storage/adres/".$this->__params[1]."/";
		}
		
		//if(isset($this->__params['POST']['fileToUpload'])){
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
	//}
	}

	public function getParametrs() {
		if(isset($this->__params[2])) {
			return true;
		}
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
}

?>