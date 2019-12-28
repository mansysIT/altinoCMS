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
        $this->query = $this->__db->querymy("SELECT city FROM bouw_city");
        foreach($this->query->fetch_all() as $q){
            array_push($this->cityArray, $q);
        }
       return $this->cityArray;
	}
	
	public function stedenlijstAddCity(){
		if(isset($this->__params['POST']['addCity'])){
			if(isset($this->__params['POST']['cityname']) && $this->__params['POST']['cityname'] != null) {
				$this->__db->execute("INSERT INTO bouw_city (city) VALUES ('".$this->__params['POST']['cityname']."')");
				header("Location: ".SERVER_ADDRESS."instellingen/stedenlijst");
			}
		}
	}
	
	public function stedenlijstRemoveCity(){
		if(isset($this->__params['POST']['cityName']) && $this->__params['POST']['cityName'] != null) {
			$this->__db->execute("DELETE FROM bouw_city WHERE city = '".$this->__params['POST']['cityName']."'");
			header("Location: ".SERVER_ADDRESS."instellingen/stedenlijst");
		}
    }
}

?>