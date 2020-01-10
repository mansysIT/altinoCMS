<?php

// error_reporting(E_ERROR | E_PARSE);

class waarvoormodel 
{
  
    
 
	private $__config;
	private $__router;
    public $__params;
	private $__db;
	

	public function __construct() 
	{
		$this->__config = registry::register("config");
		$this->__router = registry::register("router");
        $this->__params = $this->__router->getParams();
        $this->__db = registry::register("db");
	}

    public function getWaarvoor($waarvoor_id=null){

        $waarvoorArray = array();

        $dod = '';
        if($waarvoor_id != 0)
            $dod = 'WHERE id = '.$waarvoor_id;

		$this->query = $this->__db->querymy("SELECT * FROM `bouw_waarvoor` ".$dod."");
        
        foreach($this->query->fetch_all() as $q){
            array_push($waarvoorArray, $q);
        }

       return $waarvoorArray;   
    }
}
  
?>