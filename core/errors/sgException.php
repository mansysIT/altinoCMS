<?php
if(!isset($_SESSION)) session_start();

class sgException
{
	private $transportType =        "session";
    private $encodingType =         "base64";
    private $errorRedirection =     "error/";
    private $errorIdentifier =      "debug";
    private $productionState =      0;
    
    private $errorFilesDir =      "core/errors/";
    private $errorFilesExt =       ".php";
	
	public function __set($name, $value)
	{
		$this->$name = $value;
	}
	
	public function __get($name)
	{
		return $this->$name;
	}
	
	protected function _encode_exception($data)
	{
		switch($this->encodingType)
		{
			default:
			case "base64":
			$data = base64_encode($data);
			break;
		}
		
		return $data;
	}
	
	protected function _url_exception($data)
	{
		if(substr($this->errorRedirection, -1, 1) == "/")
		{
			$this->errorRedirection .= $data;
		}
		elseif(is_file($this->errorRedirection))
		{
			$this->errorRedirection .= "?".$this->errorIdentifier."=".$data;
		}
		else
		{
			$this->errorRedirection .= "/".$data;
		}
	}
	
	protected function _parse_exception($data)
	{
		$data = $this->_encode_exception($data);
		switch($this->transportType)
		{
			default;
			case "session":
			$_SESSION[$this->errorIdentifier] = $data;
			break;
			
			case "url";
			$this->_url_exception($data);
			break;
		}
	}
	
	protected function _send_exception()
	{
		header("Location: ".SERVER_ADDRESS.$this->errorRedirection, true);
		exit();
	}
	
	public function throwException($data = "")
	{
		if($data != "") $this->_parse_exception($data);
		$this->_send_exception();
	}
	
	public function errorPage($codename = 404)
	{
		if(!is_int($codename) || !file_exists($this->errorFilesDir.$codename.$this->errorFilesExt))
		{
			$this->throwException("Nie znaleziono pliku błędu!");
		}
		else
		{
			$this->errorRedirection = $this->errorFilesDir.$codename.$this->errorFilesExt;
			$this->_send_exception();
		}
	}
}

?>