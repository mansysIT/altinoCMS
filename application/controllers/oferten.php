<?php

class oferten extends controller
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
		
		$this->main->metatags_helper;
		$this->main->head_helper;
		$this->main->loader_helper;
		$this->main->module_helper;
		$this->main->model_helper;
		$this->main->directory_helper;
		$this->main->translate_helper;
	}

	public function addoferten()
	{
		$this->model->administrator;
		
		$this->main->metatags_helper;
		$this->main->head_helper;
		$this->main->loader_helper;
		$this->main->module_helper;
		$this->main->model_helper;
		$this->main->directory_helper;
		$this->main->translate_helper;
	}

	public function editoferten()
	{
		$this->model->administrator;
		
		$this->main->metatags_helper;
		$this->main->head_helper;
		$this->main->loader_helper;
		$this->main->module_helper;
		$this->main->model_helper;
		$this->main->directory_helper;
		$this->main->translate_helper;
	}
	
	public function sendoferten()
	{
		$this->model->administrator;
		$this->main->model_helper;
	}	

	public function warforremove()
	{
		$this->model->administrator;
		$this->main->model_helper;
	}	
	
}




?>