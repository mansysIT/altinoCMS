<?php

class i18n
{
	private $language = '';
    private $languages;
    private $user_agent;
	private $_config;
	
	public function __construct()
	{
		$this->_config = registry::register("config");
	}
	
	private function isLanguageSet()
	{
		return (isset($_SESSION[$this->_config->default_session_var]) && !empty($_SESSION[$this->_config->default_session_var]));
	}
	
	private function getClientLanguage()
	{
		if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
		{
			$this->languages = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
			$this->language = substr($this->languages, 0, 2);
			return $this->language;
		}
		else if(isset($_SERVER['HTTP_USER_AGENT']))
		{
			// Mozilla/5.0 (Windows; U; Windows NT 6.0; pl-PL) AppleWebKit/533.16 (KHTML, like Gecko) Version/5.0 Safari/533.16
			
			$this->user_agent = explode(";", $_SERVER['HTTP_USER_AGENT']);
			
			foreach($this->user_agent as $key => $val)
			{
				$this->languages = explode("-", $val);
				if(count($this->languages) == 2)
				{
					if(strlen(trim($this->languages[0])) == 2)
					{
						$size = count($this->language);
						$this->language[$size] = trim($this->languages[0]);
					}
				}
			}
			
			return $this->language[0];
		}
		else
		{
			$this->language = $this->_config->default_lang;
			return $this->language;
		}
	}
	
	private function setClientLanguage($lang = '')
	{
		if(empty($lang)) $lang = $this->_config->default_lang;
		$_SESSION[$this->_config->default_session_var] = $lang;
	}
	
	public function getDefaultLanguage()
	{
		return ($this->isLanguageSet() ? $_SESSION[$this->_config->default_session_var] : $this->getClientLanguage());
	}
	
	public function languageDetector()
	{
		if(isset($_GET[$this->_config->default_session_var]) && !empty($_GET[$this->_config->default_session_var]))
		{
			$_SESSION[$this->_config->default_session_var] = $_GET[$this->_config->default_session_var];
		}
	}
	
	public function setMainLanguage()
	{
		if(!$this->isLanguageSet()) $this->setClientLanguage($this->getClientLanguage());
	}
}

?>