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

    public function getAdress($od, $do, $word, $active){
		$this->query = $this->__db->querymy("SELECT * FROM `bouw_adresy` WHERE date BETWEEN '".$od."' AND '".$do."' AND active = ".$active." AND  miasto LIKE '%".$word."%' ");
        foreach($this->query->fetch_all() as $q){
            array_push($this->cityArray, $q);
        }
       return $this->cityArray;
    }
}

?>