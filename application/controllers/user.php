<?php

class user extends controller
{
	private $__config;
	private $__router;
    public $__params;
	private $__db;
	public $od;
	public $do;
	public $word;
	public $active;

	public function __construct()
	{
		$this->__config = registry::register("config");
		$this->__router = registry::register("router");
		$this->__db = registry::register("db");
		$this->__params = $this->__router->getParams();
	}

	public function __call($method, $args)
	{
		if(!is_callable($method))
		{
			$this->sgException->errorPage(404);
		}
	}
	
	public function main() { }
	
	public function index()
	{
		$this->main->directory_helper;
	}

	
}

?>