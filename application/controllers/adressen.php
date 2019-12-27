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
		$this->sidebarModal = new adressenmodel();

		if (isset($this->__params['POST']['vanaf'])) {
			$this->od = $this->__params['POST']['vanaf'];
			$this->do = $this->__params['POST']['tot'];
			$this->word = $this->__params['POST']['word'];
			if(isset($this->__params['POST']['active'])){
				$this->active = $this->__params['POST']['active'];
			} else if(isset($_SESSION['active'])) {
				$this->active = $_SESSION['active'];
			} else {
				$this->active = 1;		
			}
			$_SESSION['vanaf'] = $this->od; 
			$_SESSION['tot'] = $this->do; 
			$_SESSION['word'] = $this->word; 
			$_SESSION['active'] = $this->active; 
		} else if(isset($_SESSION['vanaf']) && $_SESSION['vanaf'] != null) {
			$this->od = $_SESSION['vanaf'];
            $this->do = $_SESSION['tot'];
			$this->word = $_SESSION['word'];
			if(isset($this->__params['POST']['active'])){
				$this->active = $this->__params['POST']['active'];
			} else {
				$this->active = 1;
			} 
		} else {
			$this->od = '2019-12-01';
			$this->do = '2019-12-31';
			$this->word = '';
			$this->active = 1;
		}

		$this->clear();

        return $this->sidebarModal->getAdress($this->od, $this->do, $this->word , $this->active);   
	}
	
	private function clear() {
		if(isset($this->__params['POST']['clear'])){
			print_r($this->__params['POST']['clear']);
			$this->od = '01-01-2019';
			$this->do = '31-12-2019';
			$this->word = '';
			$this->active = 1;

			unset($this->__params['POST']['vanaf']);
			unset($this->__params['POST']['tot']);
			unset($this->__params['POST']['word']);
			unset($this->__params['POST']['active']);
			unset($_SESSION['vanaf']);
			unset($_SESSION['tot']);
			unset($_SESSION['word']);
			unset($_SESSION['active']);
		}
	}
}




?>