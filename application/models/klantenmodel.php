<?php

// error_reporting(E_ERROR | E_PARSE);

class klantenmodel
{
	public $query;
	public $klantenArray = Array();

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
		
		$this->clearPrivate();

		$this->mainModel = new mainmodel;
	}

	public function getKlanten() { 
		$this->adressenModel = new adressenmodel();

		if (isset($this->__params['POST']['zoeken']) || isset($this->__params['POST']['private'])) {
			$this->word = $this->__params['POST']['word'];
			if(isset($this->__params['POST']['private'])){
				$this->private = $this->__params['POST']['private'];
			} else if(isset($_SESSION['private'])) {
				$this->private = $_SESSION['private'];
				$this->__params['POST']['private'] = $_SESSION['private'];
			} else {
				$this->private = 1;		
			}
			$_SESSION['word'] = $this->word; 
			$_SESSION['private'] = $this->private; 
		} else {
			$this->word = '';
			$this->private = 1;
		}

        $this->clear();
        
		return $this->klanten($this->word , $this->private);   

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

    public function klanten( $word, $private){
        if($private == 1){
            if($word != null){
                $this->query = $this->__db->querymy("SELECT id, private_naam, private_achternaam, private_id_kaart, private_tel, email, adres, stad, postcode
                FROM bouw_klanten
                WHERE 
                private = ".$private." AND private_naam LIKE '%".$word."%' OR 
                private = ".$private." AND private_achternaam LIKE '%".$word."%' OR
                private = ".$private." AND private_id_kaart LIKE '%".$word."%' OR
                private = ".$private." AND private_tel LIKE '%".$word."%' OR
                private = ".$private." AND email LIKE '%".$word."%'
                ORDER BY id DESC");
            } else {
                $this->query = $this->__db->querymy("SELECT id, private_naam, private_achternaam, private_id_kaart, private_tel, email, adres, stad, postcode
                FROM bouw_klanten
                WHERE private = '".$private."'
                ORDER BY id DESC");
            }
        } else {
            if($word != null){
                $this->query = $this->__db->querymy("SELECT id, bedrijf_bedrijf, bedrijf_kvk, bedrijf_btw, bedrijf_tel, email, adres, stad, postcode 
                FROM bouw_klanten
                WHERE 
                private = ".$private." AND bedrijf_bedrijf LIKE '%".$word."%' OR 
                private = ".$private." AND bedrijf_adres LIKE '%".$word."%' OR
                private = ".$private." AND bedrijf_stad LIKE '%".$word."%' OR
                private = ".$private." AND bedrijf_tel LIKE '%".$word."%' OR
                private = ".$private." AND email LIKE '%".$word."%'
                ORDER BY id DESC");
            } else {
                $this->query = $this->__db->querymy("SELECT id, bedrijf_bedrijf, bedrijf_kvk, bedrijf_btw, bedrijf_tel, email, adres, stad, postcode 
                FROM bouw_klanten
                WHERE private = ".$private."
                ORDER BY id DESC");
            }
        }
        array_push($this->klantenArray, $this->getKlantenTableName($private));
        foreach($this->query->fetch_all() as $q){
            array_push($this->klantenArray, $q);
            
		}

       return $this->klantenArray;
    }
    
    private function getKlantenTableName($private) {
        if($private == 1) {
            return array('NAAM', 'ACHTERNAAM', 'ID-KAART');
        } else {
            return array('BEDRIJF', 'BEDRIJF KVK', 'BEDRIJF BTW');
        }

    }

    public function getKlantenById() {
		$data = $this->__db->execute("SELECT * FROM bouw_klanten WHERE id = ".$this->__params[1]);

		return $data[0];
	}

	public function klantenActionType() {
		if(isset($this->__params['POST']['toevoegen'])) {
			if(isset($this->__params[1])) {
				$this->editKlanten();
			} else {
				$this->saveNewKlanten();
			}
		}
	}

	private function editKlanten(){


		$private_naam = $this->__params['POST']['private_naam'];
		$private_achternaam = $this->__params['POST']['private_achternaam'];
		$private_id_kaart = $this->__params['POST']['private_id_kaart'];
		$private_tel = $this->__params['POST']['private_tel'];
		$private_geboortedatum = $this->__params['POST']['private_geboortedatum'];

		$bedrijf_bedrijf = $this->__params['POST']['bedrijf_bedrijf'];
		$adres = $this->__params['POST']['adres'];
		$postcode = $this->__params['POST']['postcode'];
		$stad = $this->__params['POST']['stad'];
		$bedrijf_kvk = $this->__params['POST']['bedrijf_kvk'];
		$bedrijf_btw = $this->__params['POST']['bedrijf_btw'];
		$bedrijf_tel = $this->__params['POST']['bedrijf_tel'];

		$email = $this->__params['POST']['email'];
		$rekening = $this->__params['POST']['rekening'];

		$badrijfPrivateToogler = $this->__params['POST']['privateBedrijfToogler'];

		$_SESSION['id'] =  $this->__params['POST']['id'];

		if($badrijfPrivateToogler == 'private') {
			
			$x = $this->__db->execute("UPDATE bouw_klanten 
			SET
			private_naam = '".$private_naam."',
			private_achternaam = '".$private_achternaam."',
			private_id_kaart = '".$private_id_kaart."',
			private_tel = '".$private_tel."',
			private_geboortedatum = '".$private_geboortedatum."',
			bedrijf_bedrijf = '',
			bedrijf_kvk = '',
			bedrijf_btw = '',
			bedrijf_tel = '',
			adres = '".$adres."',
			postcode = '".$postcode."',
			stad = '".$stad."',
			email = '".$email."',
			rekening = '".$rekening."',
			private = 1
			WHERE id = ".$this->__params[1]);
		} else {
			
			$y = $this->__db->execute("UPDATE bouw_klanten  
			SET
			private_naam = '',
			private_achternaam = '',
			private_id_kaart = '',
			private_tel = '',
			private_geboortedatum = '',
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

		header("Location: ".SERVER_ADDRESS."administrator/klanten/index/");
	}

	private function saveNewKlanten(){

		$private_naam = $this->__params['POST']['private_naam'];
		$private_achternaam = $this->__params['POST']['private_achternaam'];
		$private_id_kaart = $this->__params['POST']['private_id_kaart'];
		$private_tel = $this->__params['POST']['private_tel'];
		$private_geboortedatum = $this->__params['POST']['private_geboortedatum'];

		$bedrijf_bedrijf = $this->__params['POST']['bedrijf_bedrijf'];
		$adres = $this->__params['POST']['adres'];
		$postcode = $this->__params['POST']['postcode'];
		$stad = $this->__params['POST']['stad'];
		$bedrijf_kvk = $this->__params['POST']['bedrijf_kvk'];
		$bedrijf_btw = $this->__params['POST']['bedrijf_btw'];
		$bedrijf_tel = $this->__params['POST']['bedrijf_tel'];

		$email = $this->__params['POST']['email'];
		$rekening = $this->__params['POST']['rekening'];

		$badrijfPrivateToogler = $this->__params['POST']['privateBedrijfToogler'];

		if($badrijfPrivateToogler == 'private') {
			$this->__db->execute("INSERT INTO bouw_klanten (
				private_naam, private_achternaam, private_id_kaart, private_tel, private_geboortedatum, bedrijf_bedrijf, adres, postcode, stad, 
				bedrijf_kvk, bedrijf_btw, bedrijf_tel, email, rekening, private) VALUES ('$private_naam' , '$private_achternaam' , '$private_id_kaart' , '$private_tel' , '$private_geboortedatum' ,
					'' , '$adres' , '$postcode' , '$stad' , '' , '' , '' , '$email' , '$rekening', 1)");
		} else {
			$this->__db->execute("INSERT INTO bouw_klanten (
				private_naam, private_achternaam, private_id_kaart, private_tel, private_geboortedatum, bedrijf_bedrijf, adres, postcode, stad, 
				bedrijf_kvk, bedrijf_btw, bedrijf_tel, email, rekening, private) VALUES ('' , '' , '' , '' , '' ,
					'$bedrijf_bedrijf' , '$adres' , '$postcode' , '$stad' , '$bedrijf_kvk' , '$bedrijf_btw' , '$bedrijf_tel' , '$email' , '$rekening', 0)");
		}
		header("Location: ".SERVER_ADDRESS."administrator/klanten/klanten/".$this->__db->getLastInsertedId()."");
	}
}

?>