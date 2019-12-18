<?php

class rejestracjamodel
{
    private $params;
    private $router;
    private $db;
	
	public function __construct()
	{
        $this->router = registry::register("router");
		$this->params = $this->router->getParams();
		$this->db = registry::register("db");
	}
	
	public function getAllYears()
	{
		$res = "";
		
		for($i = 1940; $i <= 1990; $i++)
		{
			$res .= "<option value=\"{$i}\">{$i}</option>";
		}
		
		return $res;
	}
	
	public function getAllDays()
	{
		$res = "";
		
		for($i = 1; $i <= 31; $i++)
		{
			if($i < 10)
			{
				$res .= "<option value=\"0{$i}\">0{$i}</option>";
			}
			else
			{
				$res .= "<option value=\"{$i}\">{$i}</option>";
			}
		}
		
		return $res;
	}
	
	public function saveNewUser()
	{
		if(isset($this->params['POST']['name']))
		{
			$fullname = $this->params['POST']['name'].' '.$this->params['POST']['surname'];
			$uname = addslashes($this->params['POST']['nick']);
			$birth = $this->params['POST']['year'].'-'.$this->params['POST']['month'].'-'.$this->params['POST']['day'];
			$pass = ($this->params['POST']['pass1'] == $this->params['POST']['pass2']) ? md5($this->params['POST']['pass2']) : false;
			
			if(!$pass) return false;
			
			$res = $this->db->execute("INSERT INTO users VALUES (NULL, '{$fullname}', '{$uname}', '{$pass}', '{$this->params['POST']['mail']}', '{$birth}')");
			
			if($res) return true;
		}
		
		return false;
	}
}

?>