<?php

class administratormodel
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
		
		if(isset($this->__params['POST']['login']))
		{
			$q = $this->__db->execute("SELECT * FROM administrator WHERE nick = '".addslashes($this->__params['POST']['login'])."' AND pass = '".md5($this->__params['POST']['password'])."' LIMIT 1");
			if(!empty($q))
			{
				$_SESSION[$this->__config->default_session_admin_auth_var] = $this->__params['POST']['login'];
				$_SESSION[$this->__config->default_session_admin_priv_var] = $q[0]['privileges'];
			}
		}

		if(!isset($_SESSION[$this->__config->default_session_admin_auth_var]))
		{
			
			if($this->__router->getAction() == "index" && $this->__router->getController() == "administrator")
			{
				
			} else {
				if(isset($_SESSION[$this->__config->default_session_auth_var]))
				header("Location: ".SERVER_ADDRESS."user/index");
				else
				header("Location: ".SERVER_ADDRESS."administrator/login/index");
			}
		}

	}

	public function logout()
	{
		if(isset($_SESSION[$this->__config->default_session_admin_auth_var])) unset($_SESSION[$this->__config->default_session_admin_auth_var]);
        if(isset($_SESSION[$this->__config->default_session_admin_priv_var])) unset($_SESSION[$this->__config->default_session_admin_priv_var]);
		header("Location: ".SERVER_ADDRESS."administrator/login/index");
	}
}

?>