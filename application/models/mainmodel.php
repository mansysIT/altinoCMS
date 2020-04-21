<?php

error_reporting(E_ERROR | E_PARSE);

class mainmodel
{
    public $query;
    public $cityArray = array();
    public $klantenArray = array();
    public $ZZPArray = array();

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

    public function getCityName()
    {
        $this->query = $this->__db->querymy("SELECT city_id, city FROM bouw_city");
        foreach ($this->query->fetch_all() as $q) {
            array_push($this->cityArray, $q);
        }
        return $this->cityArray;
    }

    public function getAllClanten()
    {
        $this->query = $this->__db->querymy("SELECT * FROM bouw_klanten");
        foreach ($this->query->fetch_all() as $q) {
            array_push($this->klantenArray, $q);
        }
        return $this->klantenArray;
    }

    public function getAllZZP()
    {
        $this->query = $this->__db->querymy("SELECT * FROM bouw_zzp");
        foreach ($this->query->fetch_all() as $q) {
            array_push($this->ZZPArray, $q);
        }
        return $this->ZZPArray;
    }
    
    public function getAllFilesInDirectory($dir)
    {
        if (scandir($dir) != null) {
            $files = scandir($dir);
            $foldersArray = array();
            $filesArray = array();
            foreach ($files as $file) {
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

    public function createNewFolder($dir, $dirName)
    {
        if (!is_dir($dir.'/'.$dirName.'')) {
            mkdir($dir.'/'.$dirName.'', 0777);
        }
    }

    public function remove($dir)
    {
        if (isset($this->__params['POST']['removefolder'])) {
            $file = $this->__params['POST']['removefolder'];
            if (is_dir('application/storage/adres/'.$this->__params[1].'/'.$file.'')) {
                print_r('is');
                rmdir('application/storage/adres/'.$this->__params[1].'/'.$file.'');
            }
        }

        if (isset($this->__params['POST']['removefile'])) {
            $file = $this->__params['POST']['removefile'];
            if (file_exists($dir.'/'.$file.'')) {
                unlink($dir.'/'.$file.'');
            }
        }
    }

    public function uploadFile($target_dir)
    {

        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]); 
        $uploadOk = 1;
        $message = '';

        // Check if file already exists
        if (file_exists($target_file)) {
            $message = "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 5000000) {
            $message = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            
            // $message = "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $message = "The file <strong>". basename($_FILES["fileToUpload"]["name"]). " </strong>has been uploaded.";
            } else {
                $message = "Sorry, there was an error uploading your file.";
            }
        }
        
        return $message;
        //}
    }

    public function getParametrs()
    {
        if (isset($this->__params[2])) {
            return true;
        }
    }

    public function getFirstParametrs()
    {
        if (isset($this->__params[1])) {
            return $this->__params[1];
        }
    }

    public function getSecoundParametrs()
    {
        if (isset($this->__params[2])) {
            return $this->__params[2];
        }
    }

    public function getWaarvoor($params=null)
    {
        $waarvoorArray = array();

        // $waarvoor_id = 1;
        $dod = '';
        if ($params != 0) {
            $dod = 'WHERE id = '.$params;
        }


        // if(isset($params[1]))
        // $dod = "WHERE name LIKE '".$params[1]."'";

        $this->query = $this->__db->querymy("SELECT * FROM `bouw_waarvoor` ".$dod);
        
        foreach ($this->query->fetch_all() as $q) {
            array_push($waarvoorArray, $q);
        }

        return $waarvoorArray;
    }
    
    public function getOferten()
    {
        $oferten = array();
        $query = $this->__db->querymy("SELECT id, oferten_numer FROM bouw_oferten");
        
        foreach ($query->fetch_all() as $q) {
            array_push($oferten, $q);
        }
        return $oferten;
    }
    
    public function getAllInkomsten($colName, $id)
    {
        $query = $this->__db->querymy("SELECT details.quantity, details.price, waarvoor.btw
		FROM bouw_factur_details AS details 
        INNER JOIN bouw_factur AS factur ON details.factur_nr = factur.factur_numer 
        INNER JOIN bouw_waarvoor AS waarvoor ON waarvoor.id = details.waarvoor_id 
		WHERE factur.".$colName." = ".$id);
      
        foreach ($query->fetch_all() as $q) {
            $sum = $q[0] * $q[1];
            $btw = $sum * ((int)$q[2] * 0.01);
			$total += ($sum + $btw);
        }

        return $total;
    }

    public function getAllUitgaven($colName, $id)
    {
        $query = $this->__db->querymy("SELECT price FROM bouw_uitgaven WHERE ".$colName." = ".$id);
        foreach ($query->fetch_all() as $q) {
            $sum += $q[0];
        }
        return $sum;
    }

    public function winst($inkomsten, $uitgaven)
    {
        return $inkomsten - $uitgaven;
    }

    public function getScroolPosition()
    {
        if (isset($_COOKIE['aaa'])) {
			$id = $_COOKIE['aaa'];
			unset($_COOKIE['aaa']);
			setcookie('aaa', null, time() - 3600, '/'); 
            return $id;
        } else {
            return null;
        }
    }

    public function getBTW($data) {

		$warfor = $data;
		
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

    public function getAllWaarvoorUitgaven($data) {

		$warfor = $data;
		
        $x = Array();
        $y = Array();
        $vatarray = Array();
        foreach($warfor as $row){
			
            $z = $row['price'];
			
            if(!in_array($x, $row['name'])) 
            $x += array($row['name']." (".$row['btw']."%)" => 0) ;
            // $x += array('id' => $row['id']) ;
            if ($this->__params[1] == null) {
                if (!in_array($row['id'], $x)) {
                    array_push($x, $row['id']);
                }
            }

            foreach($x as $rows=>$val){
				
                if ($rows[0]) {
                    if ($rows == $row['name']." (".$row['btw']."%)") {
                        // $x[$rows] += $z * ((int)$rows * 0.01);
                        $btw = $z * ((int)$row['btw'] * 0.01);
                        $x[$rows] += $z;
                    }
                }
            }

            
		}
        return $x;

    }

    public function getAllWaarvoor($data) {

		$warfor = $data;
		
        $x = Array();
        $y = Array();
        $vatarray = Array();
        foreach($warfor as $row){
			
            $z = $row['quantity'] * $row['price'];
			
            if (!in_array($row['name'], $x)) {
                $x += array($row['name']." (".$row['btw']."%)" => 0) ;
                // $x += array('id' => $row['id']) ;
                // array_push($x, $row['id']);
            }

            if ($this->__params[1] == null) {
                if (!in_array($row['id'], $x)) {
                    array_push($x, $row['id']);
                }
            }
			
            foreach($x as $rows=>$val){
                
                if ($rows[0]) {
                    if ($rows == $row['name']." (".$row['btw']."%)") {
                        // $x[$rows] += $z * ((int)$rows * 0.01);
                        $btw = $z * ((int)$row['btw'] * 0.01);
                        $x[$rows] += ($z + $btw);
                    }
                }
            }

            
        }
        
        

        return $x;

    }

    public function getOffertenActive() {  

		//echo 'jest';
		if(isset($this->__params['POST']['action'])){
			if($this->__params['POST']['action'] == 'oferty') {
					$adresy = $this->__db->querymy("SELECT id, oferten_numer FROM bouw_oferten WHERE data_end = '0000-00-00' AND `adres_id` = ".$this->__params['POST']['id_adres']);
					//$adresy = $this->__db->querymy("SELECT id, oferten_numer FROM bouw_oferten WHERE `adres_id` = 32");
					//echo 'numer'.$adresy->num_rows;
					if($adresy->num_rows > 0){  
						foreach($adresy->fetch_all() as $q){ 
							// array_push($this->adresArray, $q);
							if(isset($this->__params['POST']['oferte_id'])){
							echo "<option value='$q[0]'"; 
							if($q[0] == $this->__params['POST']['oferte_id'])
							{ echo "selected"; }
							echo ">$q[1]</option>"; 
							} else {
							echo "<option value='$q[0]'>$q[1]</option>";
							}
						}
					}
					else
						echo "<option value=''>Geen offerten</option>";


					//echo $this->adresArray;
					return $this->adresArray;
			}
		}
    } 
    
    function zmiana_przecinka($liczba) {

        if (strstr($liczba, ",") !== False)
            $kwota = str_replace(",", ".", $liczba);
        else
            $kwota = $liczba;

        return $kwota;
    }

}

?>