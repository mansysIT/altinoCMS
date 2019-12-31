<?php

class logowanie extends controller
{
	public function __call($method, $args)
	{
		if(!is_callable($method))
		{
			$this->sgException->errorPage(404);
		}
	}
	
	public function main() { }
	
	public function index()
	{
		$this->model->administrator;
		$this->main->model_helper;
	}
}

?>