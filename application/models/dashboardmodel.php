<?php

class dashboardmodel
{
	private $__config;
    private $__router;
    private $__db;
    private $__params;
	
	public function __construct()
    {
        $this->__config = registry::register("config");
        $this->__router = registry::register("router");
        $this->__db = registry::register("db");
        $this->__params = $this->__router->getParams();
    }
	
	public function getCredentials()
	{
		$q = $this->__db->execute("SELECT * FROM administrator WHERE nick = '".$_SESSION[$this->__config->default_session_admin_auth_var]."' LIMIT 1");
		return $q[0]['imie']." ".$q[0]['nazwisko'];
	}
	
	public function getTranslationsCount()
	{
		$q = $this->__db->execute("SHOW TABLES");
		$bufor = Array();
		
		foreach($q as $val)
		{
			if(substr($val['Tables_in_'.$this->__config->db_name], 0, 3) == "tr_")
			{
				$bufor[] = $val;
			}
		}
		
		return count($bufor);
	}
	
	public function getUsersCount()
	{
		$q = $this->__db->execute("SELECT COUNT(id) as cu FROM users");
		return $q[0]['cu'];
	}
	
	public function getAdminsCount()
	{
		$q = $this->__db->execute("SELECT COUNT(id) as cu FROM administrator");
		return $q[0]['cu'];
	}
	
	public function getAllElements($Array)
	{
		$res = "<ul>";
		
		foreach($Array as $k => $v)
		{
			$res .= "\t<li>{$k}: [".count($v)."]</li>\n";
		}
		
		$res .= "<ul>";
		
		return $res;
	}
}

?>