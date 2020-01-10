<?php

class inkomsten extends controller
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

	public function __call($method, $args)
	{
		if(!is_callable($method))
		{
			$this->sgException->errorPage(404);
		}
	}
	
	public function main() { }
	
	public function addFactura()
	{

		$this->model->administrator;

		$this->addHook($this->i18n->languageDetector());
		
		$this->main->metatags_helper;
		$this->main->head_helper;
		$this->main->loader_helper;
		$this->main->module_helper;
		$this->main->model_helper;
		$this->main->directory_helper;
		$this->main->translate_helper;
    }
    
    public function index()
	{

		$this->model->administrator;

		$this->addHook($this->i18n->languageDetector());
		
		$this->main->metatags_helper;
		$this->main->head_helper;
		$this->main->loader_helper;
		$this->main->module_helper;
		$this->main->model_helper;
		$this->main->directory_helper;
		$this->main->translate_helper;
	}

	public function inkomstenajax()
	{
		$this->model->administrator;
		$this->main->model_helper;
	}

	public function addWarforajax()
	{
		$this->model->administrator;
		$this->main->model_helper;
	}

	public function savefactur()
	{
		$this->model->administrator;
		$this->main->model_helper;
	}

	public function createfactur()
	{
		$this->model->administrator;
		$this->main->model_helper;
	}

	public function editfactur()
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

	public function warforremove()
	{
		$this->model->administrator;
		$this->main->model_helper;
	}
	
}




?>