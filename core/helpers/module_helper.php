<?php
define("MODULE", true);

function module_load($module)
{
	$config = registry::register("config");
	$module = strtolower($module);
	$module_path = $config->module_path.$module.'_module'."/";
	
	if(!file_exists($module_path.$module.'.php'))
	{
		return "<script type=\"text/javascript\">alert(\"UWAGA!\\nNie znaleziono plików modułu '".$module."'\");</script>"; 
	}
	
	include_once($module_path.$module.'.php'); 
	return ;
}

?>