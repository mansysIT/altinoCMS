<?php

// error_reporting(E_ERROR | E_PARSE);

class uitgavennmodel 
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
			'9',
			'8',
			'2019-02-02'
			)");
			header("Location: ".SERVER_ADDRESS."administrator/uitgaven/index");
		}
	}
}
 
?>