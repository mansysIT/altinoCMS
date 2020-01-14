<?php

class nieuwe_adressmodel
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

	public function saveNewAdress()
	{
		if(isset($this->__params['POST']['adresbtn']))
		{	
			echo "<pre>";
			print_r($this->__params['POST']);
			$adres = $this->__params['POST']['adres'];
			$postcode = $this->__params['POST']['postcode'];
			$city = $this->__params['POST']['city'];

			$private_naam = $this->__params['POST']['private_naam'];
			$private_achternaam = $this->__params['POST']['private_achternaam'];
			$private_id_kaart = $this->__params['POST']['private_id_kaart'];
			$private_tel = $this->__params['POST']['private_tel'];
			$private_geboortedatum = $this->__params['POST']['private_geboortedatum'];

			$bedrijf_bedrijf = $this->__params['POST']['bedrijf_bedrijf'];
			$bedrijf_adres = $this->__params['POST']['bedrijf_adres'];
			$bedrijf_postcode = $this->__params['POST']['bedrijf_postcode'];
			$bedrijf_stad = $this->__params['POST']['bedrijf_stad'];
			$bedrijf_kvk = $this->__params['POST']['bedrijf_kvk'];
			$bedrijf_btw = $this->__params['POST']['bedrijf_btw'];
			$bedrijf_tel = $this->__params['POST']['bedrijf_tel'];

			$email = $this->__params['POST']['email'];
			$rekening = $this->__params['POST']['rekening'];

			$this->__db->execute("INSERT INTO bouw_adresy (
				city, adres, postcode, private_naam, private_achternaam, private_id_kaart, private_tel, private_geboortedatum, bedrijf_bedrijf, bedrijf_adres, bedrijf_postcode, bedrijf_stad, 
				bedrijf_kvk, bedrijf_btw, bedrijf_tel, email, rekening) VALUES ('$city', '$adres', '$postcode' , '$private_naam' , '$private_achternaam' , '$private_id_kaart' , '$private_tel' , '$private_geboortedatum' ,
				 '$bedrijf_bedrijf' , '$bedrijf_adres' , '$bedrijf_postcode' , '$bedrijf_stad' , '$bedrijf_kvk' , '$bedrijf_btw' , '$bedrijf_tel' , '$email' , '$rekening')");

			$this->createAdresDirectory($this->__db->getLastInsertedId());
			header("Location: ".SERVER_ADDRESS."administrator/adressen/adres/".$this->__db->getLastInsertedId()."");
		}
	}
	
	private function createAdresDirectory($adres_id) {
		if(!is_dir('application/storage/adres/'.$adres_id.'')){
			mkdir('application/storage/adres/'.$adres_id.'', 0666);
		}
	}

}

?>