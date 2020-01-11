<?php

class factuur extends controller
{
	private $__config;
	private $__router;
    private $__params;
    private $__db;

	public function __construct()
	{
		$this->__config = registry::register("config");
		$this->__router = registry::register("router");
		$this->__db = registry::register("db");
		$this->__params = $this->__router->getParams();
	}
	
	public function main() { }
	

	public function index()
	{
		$this->model->administrator;
		$this->main->model_helper;
	}

	public function sendfactur()
	{
		$this->model->administrator;
		$this->main->model_helper;
	}

}




?>