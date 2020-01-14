<?php

error_reporting(E_ERROR | E_PARSE);

class mainmodel
{
	public $query;
	public $cityArray = Array();

	private $__config;
	private $__router;
    private $__params;
    private $__db;
	
	public function __construct()
	{
		$this->__config = registry::register("config");
		$this->__router = registry::register("router");
        $this->__params = $this->__router->getParams();
        $this->__db = registry::register("db");
	}

	public function getCityName(){
        $this->query = $this->__db->querymy("SELECT city_id, city FROM bouw_city");
        foreach($this->query->fetch_all() as $q){
            array_push($this->cityArray, $q);
        }
       return $this->cityArray;
	}
    
    public function getAllFilesInDirectory($dir) {

		// if(isset($this->__params[2])){
		// 	$dir = "application/storage/adres/".$this->__params[1]."/".$this->__params[2];
		// 	if(scandir($dir) != null){
		// 		$files = scandir($dir);
		// 		$foldersArray = array();
		// 		$filesArray = array();
		// 		foreach($files as $file)
		// 		{
		// 			if (strpos($file, '.') == null) {	
		// 				if (strpos($file, '..') == null) {
		// 				}
		// 			} else {
		// 				array_push($filesArray, $file);
		// 			}
		// 		}
		// 		return array($foldersArray, $filesArray);
		// 	} else {
		// 		return array();
		// 	}
		// } else {
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
		// }
	}

	public function createNewFolder($dir, $dirName) {
		if(!is_dir($dir.'/'.$dirName.'')){
			mkdir($dir.'/'.$dirName.'', 0777);
		}
	}

	public function remove($dir) {
		// if(isset($this->__params[2])){
		// 	if(isset($this->__params['POST']['removefolder'])) {
		// 		$file = $this->__params['POST']['removefolder'];
		// 		if(is_dir('application/storage/adres/'.$this->__params[1].'/'.$this->__params[2]."/".$file.'')){
		// 			print_r('is');
		// 			rmdir('application/storage/adres/'.$this->__params[1].'/'.$this->__params[2].'/'.$file.'');
		// 		}
		// 	}

		// 	if(isset($this->__params['POST']['removefile'])) {
		// 		$file = $this->__params['POST']['removefile'];
		// 		print_r($file);
		// 		if(file_exists('application/storage/adres/'.$this->__params[1].'/'.$this->__params[2].'/'.$file.'')){
		// 			print_r('isFile');
		// 			unlink('application/storage/adres/'.$this->__params[1].'/'.$this->__params[2].'/'.$file.'');
		// 		}
		// 	}
		// } else {
		// 	if(isset($this->__params['POST']['removefolder'])) {
		// 		$file = $this->__params['POST']['removefolder'];
		// 		if(is_dir('application/storage/adres/'.$this->__params[1].'/'.$file.'')){
		// 			print_r('is');
		// 			rmdir('application/storage/adres/'.$this->__params[1].'/'.$file.'');
		// 		}
		// 	}

		// 	if(isset($this->__params['POST']['removefile'])) {
		// 		$file = $this->__params['POST']['removefile'];
		// 		print_r($file);
		// 		if(file_exists('application/storage/adres/'.$this->__params[1].'/'.$file.'')){
		// 			print_r('isFile');
		// 			unlink('application/storage/adres/'.$this->__params[1].'/'.$file.'');
		// 		}
		// 	}
		// }

		if(isset($this->__params['POST']['removefile'])) {
			$file = $this->__params['POST']['removefile'];
			if(file_exists($dir.'/'.$file.'')){
				unlink($dir.'/'.$file.'');
			}
		}
	}

	public function uploadFile($target_dir) {
		// if(isset($this->__params[2])){
		// 	$target_dir = "application/storage/adres/".$this->__params[1]."/".$this->__params[2]."/";
		// } else {
		// 	$target_dir = "application/storage/adres/".$this->__params[1]."/";
		// }
		
		//if(isset($this->__params['POST']['fileToUpload'])){
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1; 
		
		// Check if file already exists
		if (file_exists($target_file)) {
			//echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			//echo "Sorry, your file was not uploaded.";
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

	public function getWaarvoor($params=null){

        $waarvoorArray = array();

       // $waarvoor_id = 1;

        $dod = '';
         if($params[0] != 0)
              $dod = 'WHERE id = '.$params[0];

        if(isset($params[1]))
            $dod = "WHERE name LIKE '".$params[1]."'"; 

		$this->query = $this->__db->querymy("SELECT * FROM `bouw_waarvoor` ".$dod);
        
        foreach($this->query->fetch_all() as $q){
            array_push($waarvoorArray, $q);
        }

       return $waarvoorArray;   
	} 
	
	public function getOferten(){
        $oferten = Array();
        $query = $this->__db->querymy("SELECT id, oferten_numer FROM bouw_oferten");
        
        foreach($query->fetch_all() as $q){
            array_push($oferten, $q);
        }
       return $oferten;
    }

}

?>