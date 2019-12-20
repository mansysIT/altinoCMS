<?php

include_once($_SERVER['DOCUMENT_ROOT']."/application/providers/db_provider.php");
use Providers\database as DB;

class homemodel
{
	private $config;
	public $query;
    public $cityArray = Array();
	
	public function __construct()
	{
		$this->config = registry::register("config");
	}
	
	public function getLoginPanelTitle()
	{
		return (isset($_SESSION[$this->config->default_session_auth_var]) && !empty($_SESSION[$this->config->default_session_auth_var])) ? $_SESSION[$this->config->default_session_auth_var] : "Panel logowania";
	}
	
	public function addLogoutBtn()
	{
		return (isset($_SESSION[$this->config->default_session_auth_var]) && !empty($_SESSION[$this->config->default_session_auth_var])) ? "<li><a id=\"logged\" href=\"wylogowanie/index\">Wyloguj</a></li>" : "";
	}

    public function getAdress($od, $do){
        DB::db();
        $this->query = DB::$__db->querymy("SELECT * FROM `bedrijf_adresy` WHERE date BETWEEN '2019-12-01' AND '2019-12-10'");
        foreach($this->query->fetch_all() as $q){
            array_push($this->cityArray, $q);
        }
       return $this->cityArray;
    }
}

?>