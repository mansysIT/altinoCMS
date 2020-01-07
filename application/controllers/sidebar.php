<?php

class sidebar extends controller
{
    private $sidebarModal;
    public $test;
	public function __call($method, $args)
	{
		if(!is_callable($method))
		{
			$this->sgException->errorPage(404);
		}
	}
	
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
		$this->main->model_helper;
	}
}

?>