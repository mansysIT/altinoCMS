<?php

class dispatcher
{
	public static function dispatch($router)
	{
		ob_start();
		$config = registry::register("config");
		$sgException = registry::register("sgException");
		
		if($router instanceof router)
		{
			$controller     = $router->getController();
			$action         = $router->getAction();
			$admin			= $router->getIsAdmin();
            $params         = $router->getParams();
		}
		else
		{
			$sgException->throwException("Router nie został znaleziony lub nie jest instancją tej klasy.");
		}
		
		$controllerfile = $config->controller_path.$controller.".php";
		
		if(!file_exists($controllerfile))
		{
			$sgException->throwException("Kontroler '".$controller."' nie został znaleziony w systemie!");
		}
		
		include_once($controllerfile);
		$sys = new $controller($params);
		$sys->$action();
		
		ob_start();
		
		$view = registry::register("view");
		
		if(!empty($sys->template)) $view->setTemplate($sys->template);
		
		$template = $view->getTemplate($action);
		
		main::_templateLoader($controller, $template, $admin);
	}
}

?>