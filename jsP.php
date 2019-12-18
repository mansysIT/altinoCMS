<?php
header("Content-type: application/x-javascript");
ob_start();

if(isset($_GET['file']))
{
	include_once("core/config/configs.php");
    include_once($configs['library_path']."JavaScript/JShrink.php");
	
	$raw = str_replace("__", "/", $_GET['file']);
	$raw = base64_decode($raw);
	$flags = false;
	
	if(strpos($raw, "?") !== false)
	{
		$raw_a = explode("?", $raw);
		$raw = $raw_a[0];
		$flags = array_pop($raw_a);
	}
	
	if(!file_exists($configs['app_javascript_path'].$raw))
	{
		echo "alert(\"SYSTEM!\\nBrak pliku o nazwie '{$raw}'!\");";
	}
	else
	{
		$_relativeImgDir = $configs['app_images_path'];
        $_relativeJsDir = $configs['app_javascript_path'];
		
		$res = file_get_contents($configs['app_javascript_path'].$raw);
		if($configs['jscript_comressor_enabled'])
		{
			if($flags !== false && $flags == "no_compress")
			{
				echo makeDirRelative($res, $_relativeImgDir);
			}
			else
			{
				switch(strtoupper($configs['jscript_comressor_type']))
				{
					case "JAVASCRIPTPACKER":
						$packer = new JavaScriptPacker(makeDirRelative($res, $_relativeImgDir), $configs['jscript_encoding'], $configs['jscript_fast_decode'], $configs['jscript_special_chars']);
						$packed = $packer->pack();
						echo $packed;
					break;
					
					default:
						$res = JShrink::minify($res);
						echo makeDirRelative($res, $_relativeImgDir);
				}
			}
		}
		else
		{
			echo makeDirRelative($res, $_relativeImgDir);
		}
	}
}
else
{
	echo "alert(\"SYSTEM!\nBrak pliku JS\");";
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