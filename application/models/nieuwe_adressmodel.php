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
			$adres = $this->__params['POST']['adres'];
			$postcode = $this->__params['POST']['postcode'];
			$city = $this->__params['POST']['city'];
			$this->__db->execute("INSERT INTO bouw_adresy (city, adres, postcode) VALUES ('$city', '$adres', '$postcode')");
			header("Location: ".SERVER_ADDRESS."nieuwe_adress/nieuwe_adress");
		}
	}

}

?>