<?php

class wylogowaniemodel
{
	private $__config;
	
	public function __construct()
	{
		$this->__config = registry::register("config");
		if(isset($_SESSION[$this->__config->default_session_auth_var]))
		{
			unset($_SESSION[$this->__config->default_session_auth_var]);
			unset($_SESSION[$this->__config->default_session_admin_auth_var]);
			header("Location: ".SERVER_ADDRESS."administrator/login/index");
			if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']))
			{
				header("Location: ".SERVER_ADDRESS."administrator/login/index");
			}
			else
			{
				header("Location: ".SERVER_ADDRESS."administrator/login/index");
			}
		}
		else
		header("Location: ".SERVER_ADDRESS."administrator/login/index");
	}
}

?>