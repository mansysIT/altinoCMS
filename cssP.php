<?php
header("Content-type: text/css");
ob_start();

if(isset($_GET['file']))
{
	include_once("core/config/configs.php");
    include_once($configs['library_path']."CSS/CssMin.php");
	
	$raw = str_replace("__", "/", $_GET['file']);
	$raw = base64_decode($raw);
	$flags = false;
	
	if(strpos($raw, "?") !== false)
	{
		$raw_a = explode("?", $raw);
		$raw = $raw_a[0];
		$flags = array_pop($raw_a);
	}
	
	if(!file_exists($configs['app_stylesheet_path'].$raw))
	{
		echo "body:before { content: \"<h1>Brak arkusza styli CSS!</h1>\" }";
	}
	else
	{
		$res = file_get_contents($configs['app_stylesheet_path'].$raw);
		if($configs['cscript_comressor_enabled'])
		{
			if($flags !== false && $flags == "no_compress")
			{
				echo makeDirRelative($res, "../".$configs['app_images_path']);
			}
			else
			{
				$filters = array("ImportImports"                => $configs['cscript_filter_import_imports'],
                                "RemoveComments"                => $configs['cscript_filter_remove_comments'], 
                                "RemoveEmptyRulesets"           => $configs['cscript_filter_remove_empty_rulesets'],
                                "RemoveEmptyAtBlocks"           => $configs['cscript_filter_remove_empty_at_blocks'],
                                "ConvertLevel3AtKeyframes"      => $configs['cscript_filter_convert_level_3at_keyframes'],
                                "ConvertLevel3Properties"       => $configs['cscript_filter_convert_level_3properties'],
                                "Variables"                     => $configs['cscript_filter_variables'],
                                "RemoveLastDelarationSemiColon" => $configs['cscript_filter_remove_last_delaration_semi_colon']);
                                
                $plugins = array("Variables"                    => $configs['cscript_plugin_variables'],
                                "ConvertFontWeight"             => $configs['cscript_plugin_convert_font_weight'],
                                "ConvertHslColors"              => $configs['cscript_plugin_convert_hsl_colors'],
                                "ConvertRgbColors"              => $configs['cscript_plugin_convert_rgb_colors'],
                                "ConvertNamedColors"            => $configs['cscript_plugin_convert_named_colors'],
                                "CompressColorValues"           => $configs['cscript_plugin_compress_color_values'],
                                "CompressUnitValues"            => $configs['cscript_plugin_compress_unit_values'],
                                "CompressExpressionValues"      => $configs['cscript_plugin_compress_expression_values']);
								
				$res = CssMin::minify(makeDirRelative($res, "../".$configs['app_images_path']), $filters, $plugins);
				
				echo $res;
			}
		}
		else
		{
			echo makeDirRelative($res, "../".$configs['app_images_path']);
		}
	}
}
else
{
	echo "body:before { content: \"<h1>Brak arkusza styli CSS!</h1>\" }";
}
			
function makeDirRelative($code, $newDir)
{
	if(strpos($code, "/* ###") !== false && strpos($code, "### */") !== false)
	{
		$_begin = strpos($code, "/* ###");
		$_end = strpos($code, "### */");
		
		$_path = substr($code, $_begin, $_end - $_begin);
		$_path = trim($_path, "/*#\t\n\r ");
		
		if(strpos($_path, ":: APP CONTROLLER :: MAKE IMAGE DIR RELATIVE ::") !== false)
		{
			$_pathArr = explode("::", $_path);
			if(!empty($_pathArr[3]))
			{
				return str_replace(trim($_pathArr[3]), $newDir, $code);
			}
			else
			{
				return $code;
			}
		}
		else
		{
			return $code;
		}
	}
	else
	{
		return $code;
	}
}

?>