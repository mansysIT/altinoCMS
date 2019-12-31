<?php

class adressenmodel
{
	public $query;
	public $cityArray = Array();

	private $__config;
	private $__router;
    private $__params;
    private $__db;
	
	public function __construct()
	{
		$this->__config = registry::register("config");
		$this->__router = registry::register("router");
        $this->__params = $this->__router->getParams();
        $this->__db = registry::register("db");
	}
	
	public function getLoginPanelTitle()
	{
		return (isset($_SESSION[$this->config->default_session_auth_var]) && !empty($_SESSION[$this->config->default_session_auth_var])) ? $_SESSION[$this->config->default_session_auth_var] : "Panel logowania";
	}
	
	public function addLogoutBtn()
	{
		return (isset($_SESSION[$this->config->default_session_auth_var]) && !empty($_SESSION[$this->config->default_session_auth_var])) ? "<li><a id=\"logged\" href=\"wylogowanie/index\">Wyloguj</a></li>" : "";
	}

	public function getAdress()
	{ 
		$this->adressenModel = new adressenmodel();

		if (isset($this->__params['POST']['vanaf'])) {
			$this->od = $this->__params['POST']['vanaf'];
			$this->do = $this->__params['POST']['tot'];
			$this->word = $this->__params['POST']['word'];
			if(isset($this->__params['POST']['active'])){
				$this->active = $this->__params['POST']['active'];
			} else if(isset($_SESSION['active'])) {
				$this->active = $_SESSION['active'];
				$this->__params['POST']['active'] = $_SESSION['active'];
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
			$d = new DateTime(date("Y-m-d"));
			$dOd = new DateTime(date("Y-m-d"));
			$dOd->modify('-12 month');

			$this->od = $dOd->format('Y-m-d');
			$this->do = $d->format('Y-m-d');
			$this->word = '';
			$this->active = 1;
		}

		$this->clear();

        return $this->adressenModel->adres($this->od, $this->do, $this->word , $this->active);   
	}
	
	private function clear() {
		if(isset($this->__params['POST']['clear'])){
			print_r($this->__params['POST']['clear']);
			$d = new DateTime(date("Y-m-d"));
			
			$dOd = new DateTime(date("Y-m-d"));
			$dOd->modify('-12 month');

			$this->od = $dOd->format('Y-m-d');
			$this->do = $d->format('Y-m-d');
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

    public function adres($od, $do, $word, $active){
		//$this->query = $this->__db->querymy("SELECT * FROM `bouw_adresy` INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id WHERE date BETWEEN '".$od."' AND '".$do."' AND active = ".$active." AND  bouw_city.city LIKE '%".$word."%' ");
		$this->query = $this->__db->querymy("SELECT bouw_adresy.id, bouw_adresy.adres, bouw_adresy.active, bouw_city.city FROM `bouw_adresy` INNER JOIN bouw_city ON bouw_adresy.city = bouw_city.city_id WHERE active = ".$active." AND  bouw_city.city LIKE '%".$word."%' ");
        foreach($this->query->fetch_all() as $q){
            array_push($this->cityArray, $q);
        }
       return $this->cityArray;
    }
}

?>