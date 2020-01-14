<?php

class adressen extends controller
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
		$this->model->administrator;
		
		$this->addSubpage(__FUNCTION__, "stad");
	
		$this->main->metatags_helper;
		$this->main->head_helper;
		$this->main->loader_helper;
		$this->main->module_helper;
		$this->main->model_helper;
		$this->main->directory_helper;
		$this->main->translate_helper;
	}

	public function adres()
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

	public function bestanden()
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

	public function setAdresActive()
	{
		$this->addHook($this->i18n->languageDetector()); 
		
		$this->main->model_helper;
	}	
}




?>