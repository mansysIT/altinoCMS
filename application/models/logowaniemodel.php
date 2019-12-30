<?php

class logowaniemodel
{
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
	
	private function isExist($LOGIN, $PASSWORD)
	{
		$query = $this->__db->execute("SELECT * FROM users WHERE username = '{$LOGIN}' AND password = '{$PASSWORD}' LIMIT 1");
		return $query;
	}
	
	private function _login($LOGIN, $PASSWORD)
	{
		//$PASSWORD = md5($PASSWORD);

		if($this->isExist($LOGIN, $PASSWORD) && count($this->isExist($LOGIN, $PASSWORD)) > 0)
		{
			$_SESSION[$this->__config->default_session_auth_var] = $LOGIN;
			return $LOGIN;
		}
		else
		{
			return false;
		}
	}
	
	public function login()
	{
		if(isset($this->__params['POST']['login']) && isset($this->__params['POST']['password']))
		{
			if($this->_login($this->__params['POST']['login'], $this->__params['POST']['password']))
			{
				if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']))
				{
					header("Location: ".SERVER_ADDRESS."administrator/home/index");	
				}
				else
				{
					header("Location: ".SERVER_ADDRESS."administrator/home/index");
				}
				
			}
			else
			{
				die("Przekierowanie na stronę błędu");
			}
		}
		else
		{
			if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']))
			{
				header("Location: ".$_SERVER['HTTP_REFERER']);
			}
			else
			{
				header("Location: ".SERVER_ADDRESS."home/index");
			}
		}
	}
}

?>