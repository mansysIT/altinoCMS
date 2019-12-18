<?php

include($_SERVER['DOCUMENT_ROOT'].'/application/models/sidebarmodel.php');

use Modal\sidebarModal as modal;

class sidebar extends controller
{
    private $sidebarModal;
    public $test;
	public function __call($method, $args)
	{
		if(!is_callable($method))
		{
			$this->sgException->errorPage(404);
		}
	}
	
	public function main() { }
	
	public function getAdress()
	{
        $this->sidebarModal = new modal;
        return $this->sidebarModal->getCityName();
	}
}

?>