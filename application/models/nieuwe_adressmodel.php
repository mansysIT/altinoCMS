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

	public function saveNewAdress(){
		if(isset($this->__params['POST']['adresbtn']))
		{	
			echo "<pre>";
			print_r($this->__params['POST']);
			$adres = $this->__params['POST']['adres'];
			$postcode = $this->__params['POST']['postcode'];
			$city = $this->__params['POST']['city'];
			$klanten = $this->__params['POST']['klanten'];


			$this->__db->execute("INSERT INTO bouw_adresy (
			city, adres, postcode, klanten_id) VALUES ('$city', '$adres', '$postcode' , '$klanten')");



			$this->createAdresDirectory($this->__db->getLastInsertedId());
			header("Location: ".SERVER_ADDRESS."administrator/adressen/adres/".$this->__db->getLastInsertedId()."");
		}
	}
	
	private function createAdresDirectory($adres_id) {
		if(!is_dir('application/storage/adres/'.$adres_id.'')){
			mkdir('application/storage/adres/'.$adres_id.'', 0777);
		}
	}

}

?>