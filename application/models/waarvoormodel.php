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

}
  
?>