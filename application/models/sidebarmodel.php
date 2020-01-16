<?php

class sidebarmodel {
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
}

?>