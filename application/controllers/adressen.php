<?php

class adressen extends controller
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
		$this->__params = $this->__router->getParamsGet();
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
		$this->addHook($this->i18n->languageDetector());
		
		$this->main->metatags_helper;
		$this->main->head_helper;
		$this->main->loader_helper;
		$this->main->module_helper;
		$this->main->model_helper;
		$this->main->directory_helper;
		$this->main->translate_helper;
	}

	public function getAdress()
	{ 
        $this->sidebarModal = new adressenmodel;
        if (isset($this->__params['GET']['vanaf'])) {
            if ($this->__params['GET']['vanaf'] != null) {
                $od = $this->__params['GET']['vanaf'];
                $do = $this->__params['GET']['tot'];
                $word = $this->__params['GET']['word'];
                $active = $this->__params['GET']['active'];
            }
        } else {
                $od = '2019-12-01';
                $do = '2019-12-31';
                $word = '';
                $active = 1;
            }
            return $this->sidebarModal->getAdress($od, $do, $word, $active);   
    }
}




?>