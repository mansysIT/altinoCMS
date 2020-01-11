<?php

class instellingenmodel
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
	
	public function stedenlijstGetCityName(){
        $this->query = $this->__db->querymy("SELECT city, city_id FROM bouw_city");
        foreach($this->query->fetch_all() as $q){
            array_push($this->cityArray, $q);
        }
       return $this->cityArray;
	}
	
	public function stedenlijstAddCity(){
		if(isset($this->__params['POST']['addCity'])){
			if(isset($this->__params['POST']['cityname']) && $this->__params['POST']['cityname'] != null) {
				$this->__db->execute("INSERT INTO bouw_city (city) VALUES ('".$this->__params['POST']['cityname']."')");
				header("Location: ".SERVER_ADDRESS."administrator/instellingen/stedenlijst");
			}
		}
	}
	
	public function stedenlijstRemoveCity(){
		if(isset($this->__params['POST']['cityName']) && $this->__params['POST']['cityName'] != null) {
			$this->__db->execute("UPDATE bouw_adresy SET city = 0 WHERE city = '".$this->__params['POST']['cityName']."'");
			$this->__db->execute("DELETE FROM bouw_city WHERE city_id = '".$this->__params['POST']['cityName']."'");	
			header("Location: ".SERVER_ADDRESS."administrator/instellingen/stedenlijst");
		}
	}
	
	public function getwarfortype(){
		$query = $this->__db->querymy("SELECT id, name, btw FROM bouw_waarvoor");
		$warfor = array();
        foreach($query->fetch_all() as $q){
            array_push($warfor, $q);
        }
       return $warfor;
	}

	public function addwarfor(){
		if(isset($this->__params['POST']['addwarfor'])){
			if(isset($this->__params['POST']['name']) && $this->__params['POST']['name'] != null) {
				$this->__db->execute("INSERT INTO bouw_waarvoor (name, btw) VALUES ('".$this->__params['POST']['name']."', '".$this->__params['POST']['btw']."')");
				header("Location: ".SERVER_ADDRESS."administrator/instellingen/addwarfor");
			}
		}
	}
	
}

?>