<?php

// error_reporting(E_ERROR | E_PARSE);

class ZZPmodel
{
	public $query;
	public $ZZPArray = Array();

	private $__config;
	private $__router;
    public $__params;
	private $__db;
	private $mainModel;

	private $elementsOnPage = 15;
	
	public function __construct()
	{
		$this->__config = registry::register("config");
		$this->__router = registry::register("router");
        $this->__params = $this->__router->getParams();
		$this->__db = registry::register("db");
		
		$this->clearPrivate();

		

		$this->mainModel = new mainmodel;
	}

	public function getZZP() { 
		$this->adressenModel = new adressenmodel();

		if (isset($this->__params['POST']['zoeken'])) {
			$this->word = $this->__params['POST']['word'];
			$_SESSION['word'] = $this->word; 
		} else {
			$this->word = '';
			$this->private = 1;
		}

        $this->clear();
		
		if($this->__params[1]) {
			$pageno = $this->__params[1];
		} else {
			$pageno = 1;
		}

		$offset = ($pageno-1) * $this->elementsOnPage;

		$result = $this->__db->querymy("SELECT COUNT(*) FROM bouw_zzp WHERE private = 0");
		$total_rows = mysqli_fetch_array($result)[0];
		$total_pages = ceil($total_rows / $this->elementsOnPage);

		// unset($_COOKIE['page']);
		// setcookie('page', null, time() - 3600, '/'); 

		setcookie('page',$this->__params[1], 0, "/");

			$private = 0;
		
		return $this->ZZP($this->word , $private, $offset, $pageno, $total_pages); 
	}
	
	private function clear() {
		if(isset($this->__params['POST']['clear'])){

			$this->word = '';
			$this->private = 1;

			unset($this->__params['POST']['word']);
			unset($this->__params['POST']['private']);
			unset($_SESSION['word']);
			unset($_SESSION['private']);
		}
	}

	private function clearPrivate(){
		if(!isset($this->__params['POST']['clear']) && !isset($this->__params['POST']['zoeken']) && !isset($this->__params['POST']['private']))
		{
			unset($this->__params['POST']['private']);
			unset($_SESSION['private']);

			
		}

	}

    public function ZZP( $word, $private, $offset, $pageno, $total_pages){
        if($private == 1){
        } else {
            if($word != null){
                $this->query = $this->__db->querymy("SELECT id, bedrijf_bedrijf, bedrijf_kvk, bedrijf_btw, bedrijf_tel, email, adres, stad, postcode 
                FROM bouw_zzp
                WHERE 
                private = ".$private." AND bedrijf_bedrijf LIKE '%".$word."%' OR 
                private = ".$private." AND bedrijf_adres LIKE '%".$word."%' OR
                private = ".$private." AND bedrijf_stad LIKE '%".$word."%' OR
                private = ".$private." AND bedrijf_tel LIKE '%".$word."%' OR
                private = ".$private." AND email LIKE '%".$word."%'
				ORDER BY id DESC
				LIMIT $offset, $this->elementsOnPage");
            } else {
                $this->query = $this->__db->querymy("SELECT id, bedrijf_bedrijf, bedrijf_kvk, bedrijf_btw, bedrijf_tel, email, adres, stad, postcode 
                FROM bouw_zzp
                WHERE private = ".$private."
				ORDER BY id DESC
				LIMIT $offset, $this->elementsOnPage");
            }
		}
		
		$paginateParams = array($pageno, $total_pages, $this->__params[1]);

		array_push($this->ZZPArray, $this->getZZPTableName($private));
        array_push($this->ZZPArray, $paginateParams);
        $x = 2;
        foreach($this->query->fetch_all() as $q){
            array_push($this->ZZPArray, $q);
            array_push($this->ZZPArray[$x], $this->getBedgar($q[0])); 
            $x++;
		}

       return $this->ZZPArray;
    }

    private function getBedgar($id) {

        $bedrag = $this->__db->querymy("SELECT price
		FROM `bouw_uitgaven`
		WHERE zzp_id = $id");

        $bedgarSum = 0;

        foreach($bedrag->fetch_all() as $q){
			$sum = $q[0];
            $bedgarSum += $sum;
        }
		// array_push($bedgarSum, $result);
        return $bedgarSum;
    }
    
    private function getZZPTableName($private) {
        if($private == 1) {
        } else {
            return array('BEDRIJF', 'BEDRIJF KVK', 'BEDRIJF BTW');
        }

    }

    public function getZZPById() {
		$data = $this->__db->execute("SELECT * FROM bouw_zzp WHERE id = ".$this->__params[1]);

		setcookie('aaa',$data[0]['id'], 0, "/");
		return $data[0];
	}

	public function ZZPActionType() {
		if(isset($this->__params['POST']['toevoegen'])) {
			if(isset($this->__params[1])) {
				$this->editZZP();
			} else {
				$this->saveNewZZP();
			}
		}
	}

	private function editZZP(){

		$adres = $this->__params['POST']['adres'];
		$postcode = $this->__params['POST']['postcode'];
        $stad = $this->__params['POST']['stad'];
        $bedrijf_bedrijf = $this->__params['POST']['bedrijf_bedrijf'];
		$bedrijf_kvk = $this->__params['POST']['bedrijf_kvk'];
		$bedrijf_btw = $this->__params['POST']['bedrijf_btw'];
		$bedrijf_tel = $this->__params['POST']['bedrijf_tel'];
		$email = $this->__params['POST']['email'];
		$rekening = $this->__params['POST']['rekening'];

		$badrijfPrivateToogler = $this->__params['POST']['privateBedrijfToogler'];

		if($badrijfPrivateToogler == 'private') {
		} else {
			
			$y = $this->__db->execute("UPDATE bouw_zzp  
			SET
			bedrijf_bedrijf = '".$bedrijf_bedrijf."',
			bedrijf_kvk = '".$bedrijf_kvk."',
			bedrijf_btw = '".$bedrijf_btw."',
			bedrijf_tel = '".$bedrijf_tel."',
			adres = '".$adres."',
			postcode = '".$postcode."',
			stad = '".$stad."',
			email = '".$email."',
			rekening = '".$rekening."',
			private = 0
			WHERE id = ".$this->__params[1]);
		}

		header("Location: ".SERVER_ADDRESS."administrator/ZZP/index/".$_COOKIE['page']);
	}

	private function saveNewZZP(){
		
		$adres = $this->__params['POST']['adres'];
		$postcode = $this->__params['POST']['postcode'];
        $stad = $this->__params['POST']['stad'];
        $bedrijf_bedrijf = $this->__params['POST']['bedrijf_bedrijf'];
		$bedrijf_kvk = $this->__params['POST']['bedrijf_kvk'];
		$bedrijf_btw = $this->__params['POST']['bedrijf_btw'];
		$bedrijf_tel = $this->__params['POST']['bedrijf_tel'];

		$email = $this->__params['POST']['email'];
		$rekening = $this->__params['POST']['rekening'];

		$badrijfPrivateToogler = $this->__params['POST']['privateBedrijfToogler'];

		if($badrijfPrivateToogler == 'private') {
		} else {
			$this->__db->execute("INSERT INTO bouw_zzp (
				bedrijf_bedrijf, adres, postcode, stad, bedrijf_kvk, bedrijf_btw, bedrijf_tel, email, rekening, private) 
                VALUES (
				'$bedrijf_bedrijf' , '$adres' , '$postcode' , '$stad' , '$bedrijf_kvk' , '$bedrijf_btw' , '$bedrijf_tel' , '$email' , '$rekening', 0)");
		}
		header("Location: ".SERVER_ADDRESS."administrator/ZZP/ZZP/".$this->__db->getLastInsertedId()."");
	}
}

?>