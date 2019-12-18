<?php
define("MODEL", true);

function model_load($model, $method = '', $params = Array())
{
	$model = registry::register($model);
	
	if(!empty($method))
	{
		$method = $model->$method($params);
	}
	
	return $method;
}

?>