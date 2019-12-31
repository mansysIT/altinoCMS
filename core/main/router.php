<?php

class router
{
	private $controller;
	private $action;
	private $isAdmin;
	private $params;
	
	public function __construct()
	{
		$config = registry::register("config");
		
		if(!isset($_GET['page']))
		{
			$path = $config->default_controller;
		}
		else
		{
			$path = $_GET['page'];
		}
		// localhost//administrator/instellingen/stedenlijst

		$routParts = explode("/", $path);

		if($routParts[0] == 'administrator')
		{
			$this->isAdmin = 1;
			$this->controller = $routParts[1];
			$this->action = isset($routParts[2]) ? $routParts[2] : "index";
		} else {
			$this->isAdmin = 0;
			$this->controller = $routParts[0];
			$this->action = isset($routParts[1]) ? $routParts[1] : "index";
		}

		array_shift($routParts);
		array_shift($routParts);
		
		$this->params = $routParts;
	}
	
	public function getController()
	{
		return $this->controller;
	}
	
	public function getAction()
	{
		return $this->action;
	}

	public function getIsAdmin()
	{
		return $this->isAdmin;
	}
	
	public function getParams()
	{
		if(isset($_POST) && count($_POST) > 0)
		{
			foreach($_POST as $key => $val)
			{
				$this->params['POST'][$key] = $val;
			}
		}
		
		return $this->params;
	}

	public function getParamsGet()
	{
		if(isset($_GET) && count($_GET) > 0)
		{
			foreach($_GET as $key => $val)
			{
				$this->params['GET'][$key] = $val;
			}
		}
		
		return $this->params;
	}
}

?>