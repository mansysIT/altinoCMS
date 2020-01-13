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

    public function getWaarvoor($params=null){

        $waarvoorArray = array();

       // $waarvoor_id = 1;

        $dod = '';
         if($params[0] != 0)
              $dod = 'WHERE id = '.$params[0];

        if(isset($params[1]))
            $dod = "WHERE name LIKE '".$params[1]."'"; 

		$this->query = $this->__db->querymy("SELECT * FROM `bouw_waarvoor` ".$dod);
        
        foreach($this->query->fetch_all() as $q){
            array_push($waarvoorArray, $q);
        }

        
      

       return $waarvoorArray;   
    } 

}
  
?>