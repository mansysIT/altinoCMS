<?php

include_once("../../../core/main/registry.php");
include_once("../../../core/config/configs.php");
include_once("../../../core/main/config.php");
include_once("../../../core/main/controller.php");
include_once("../../../core/drivers/db.php");
include_once("../../../core/library/Utils/FilesystemUtil.php");
include_once("../../../core/library/Utils/ReflectionUtil.php");

$db = new db($configs['db_host'], $configs['db_user'], $configs['db_pass'], $configs['db_name']);

if(isset($_POST['addNewPage']))
{
	if(!file_exists("../../../".$configs['controller_path'].$_POST['pagename'].".php"))
	{
		$_newController = "<?php\n\nclass {$_POST['pagename']} extends controller\n{\n\tpublic function __call(\$method, \$args)\n\t{\n\t\tif(!is_callable(\$method))\n\t\t{\n\t\t\t\$this->sgException->errorPage(404);\t\t\t
        }\n\t}\n\n\tpublic function main()\t{ }\n\n\tpublic function index()\n\t{\n\t\t\$this->addHook(\$this->i18n->languageDetector(), 1);\n\t\t\$this->main->metatags_helper;\t\t
        \$this->main->head_helper;\n\t\t\$this->main->loader_helper;\n\t\t\$this->main->module_helper;\n\t\t\$this->main->model_helper;\n\t\t\$this->main->directory_helper;\n\t\t\$this->main->translate_helper;\n\t\t}\n\n}\n\n?>";
		
		$_newView = "<!DOCTYPE html>\n<html>\n<head>\n<?=add_metatags()?>\n\n<?=add_title(\"Nowa strona - {$_POST['pagename']}\")?>\n\n<?=add_basehref()?>\n\n<?=stylesheet_load('screen.css')?>
        \n<?=javascript_load('jQuery.js,main.js')?>\n\n<?=icon_load(\"pp_fav.ico\")?>\n\n</head>\n\n<body>\n\nHello World!\n\n</body>\n\n</html>";
		
		$saveController = FilesystemUtil::saveFile($_newController, "../../../".$configs['controller_path'].$_POST['pagename'].".php", false);
		
		if(!file_exists("../../../".$configs['view_path'].$_POST['pagename'])) mkdir("../../../".$configs['view_path'].$_POST['pagename']);
		
		$saveView = FilesystemUtil::saveFile($_newView, "../../../".$configs['view_path'].$_POST['pagename']."/index.php", false);
		
		if(!$saveController || !$saveView)
        {
            echo "Wystąpił błąd! Nie wszystkie pliki zostały zapisane.";
        }
        else
        {
            echo "true";
        }
	}
	else
	{
		echo "Taka strona już istnieje!";
	}
	
}
elseif(isset($_POST['removePage']))
{
	if(file_exists("../../../".$configs['controller_path'].$_POST['pagename'].".php"))
	{
		$_delController = unlink("../../../".$configs['controller_path'].$_POST['pagename'].".php");
		$_delView = unlink("../../../".$configs['view_path'].$_POST['pagename']."/index.php");
		$_delView_cat = rmdir("../../../".$configs['view_path'].$_POST['pagename']);
		
		if(!$_delController || !$_delView)
        {
            echo "Wystąpił błąd podczas usuwania strony!";
        }
        else
        {
            echo "true";
        }
	}
	else
	{
		echo "Nie ma takiej strony!";
	}
}
elseif(isset($_POST['saveMethod']))
{
	include_once("../../../".$configs['controller_path'].$_POST['controller'].".php");
	$_err = "";
	$_newMethods = "";
	
	if(ReflectionUtil::isMethodExists($_POST['controller'], $_POST['method']))
	{
		if(!empty($_POST['hook']))
		{
			$h = explode(", ", $_POST['hook']);
			foreach($h as $hk => $hv)
			{
				$_h = explode("#", $hv);
				$_newMethods .= "\t\t\$this->addHook(\$this->{$_h[0]}->{$_h[1]}());\n";
			}
			
			$_newMethods .= "\n";
		}
		
		if(!empty($_POST['model']))
        {
            $model = explode(", ", $_POST['model']);
            foreach($model as $modelk => $modelv)
            {
                $_newMethods .= "\t\t\$this->model->$modelv;\n";
            }
            
            $_newMethods .= "\n";
        }
        
        $m = explode(", ", $_POST['main']);
        foreach($m as $val)
        {
            $_newMethods .= "\t\t\$this->main->$val;\n";
        }
		
		$_method = ReflectionUtil::getClassMethodInfo($_POST['controller'], $_POST['method']);
		
		$_startLine = $_method['startLine'];
		$_endLine = $_method['endLine'];
		
		$controller_file = FilesystemUtil::getSource($_method['filename'], true);
		
		$_part1 = array_slice($controller_file, 0, $_startLine+1);
		$_part2 = array_slice($controller_file, $_endLine-1, count($controller_file));
		$_newController = implode($_part1).$_newMethods.implode($_part2);
		
		$saveController = FilesystemUtil::saveFile($_newController, $_method['filename']);
	}
	else
	{
		$_err .= $method.", ";
	}
	
	if($saveController && empty($_err))
    {
        echo "true";
    }
    else
    {
        echo "Nie wszystkie pliki zostały zaktualizowane!\n".$_err;
    }
}
elseif(isset($_POST['saveMethodSource']))
{
	include_once("../../../".$configs['controller_path'].$_POST['controller'].".php");
    $_err = "";
	
	if(ReflectionUtil::isMethodExists($_POST['controller'], $_POST['method']))
    {
    	$_method = ReflectionUtil::getClassMethodInfo($_POST['controller'], $_POST['method']);
		
		$_startLine = $_method['startLine'];
        $_endLine = $_method['endLine'];
		
		$controller_file = FilesystemUtil::getSource($_method['filename'], true);
		
		$_part1 = array_slice($controller_file, 0, $_startLine-1);
        $_part2 = array_slice($controller_file, $_endLine, count($controller_file));
		$_newController = implode($_part1).$_POST['code'].implode($_part2);
		
		$saveController = FilesystemUtil::saveFile($_newController, $_method['filename']);
	}
	else
	{
		$_err .= $method.", ";
	}
	
	if($saveController && empty($_err))
    {
        echo "true";
    }
    else
    {
        echo "Nie wszystkie pliki zostały zaktualizowane!\n".$_err;
    }
}
elseif(isset($_POST['saveUserPage']))
{
	$filename = "../../../".$configs['view_path'].$_POST['controller']."/".$_POST['method'].".php";
	if(file_exists($filename))
	{
		$file = FilesystemUtil::getSource($filename);
		$_content1 = substr($file, 0, strpos($file, "<body>") + 6);
		$_content2 = substr($file, strpos($file, "</body>"));
		
		if(strpos($_content1, "add_title") !== false)
		{
			$_content1 = preg_replace('/add_title?\\((\'|")([a-zA-Z0-9\-\s\ł\ę\ó\ł\ą\ś\ł\ż\ź\ć\ń]+)(\'|")/', "add_title(\"".$_POST['pageTitle']."\"", $_content1);
		}
		else
		{
			$h1 = substr($_content1, 0, strpos($_content1, "<head>") + 6);
			$h2 = substr($_content1, strpos($_content1, "<head>") + 6);
			
			$_content1 = $h1."\n<?=add_title(\"".$_POST['pageTitle']."\")?>\n".$h2;
		}
		
		$content = $_content1.htmlspecialchars_decode($_POST['content']).$_content2;
		
		$content = preg_replace('/\[sTr\]([a-zA-Z0-9\-\s\ł\ę\ó\ł\ą\ś\ł\ż\ź\ć\ń]+)\[eTr\]/', '<?=add_tr("$1")?>', $content);
        $content = str_replace('<!--?', '<?', $content);
        $content = str_replace('?-->', '?>', $content);
		
		// Automatyczna aktualizacja bazy danych tłumaczeń
		$tr = preg_match_all('/\[sTr\]([a-zA-Z0-9\-\w]+)\[eTr\]/', $_POST['content'], $m);
		if(!empty($m))
		{
			$tablename = "tr_".$_POST['controller']."_".$_POST['method'];
			
			// Sprawdzenie czy istnieje tabela tłumaczeń w bazie
			$tbl = $db->execute("SELECT * FROM {$tablename}");
			
			if(empty($tbl) || !$tbl)
			{
				$instbl = $db->execute("CREATE TABLE {$tablename} (id INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY, lang VARCHAR( 10 ) NOT NULL) 
		                                ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_polish_ci");
			}
			
			foreach($m[1] as $col)
			{
				$check = $db->execute("SELECT {$col} FROM {$tablename}");
				if(empty($check))
				{
					$alter = $db->execute("ALTER TABLE {$tablename} ADD {$col} LONGTEXT NOT NULL");
				}
			}
			
			// Sprawdzenie istnienia jakichkolwiek wierszy
			$check_ins = $db->execute("SELECT lang FROM {$tablename}");
			if(empty($check_ins))
			{
				// Listening wszystkich kolumn z tabeli $tablename
				$cols = $db->execute("SHOW COLUMNS FROM {$tablename}");
				if(!empty($cols))
				{
					$columnFields = "";
					
					foreach($cols as $column)
					{
						$columnFields .= ($column['Field'] != "id" && $column['Filed'] != "lang") ? "'', " : "";
					}
					
					$columnFields = rtrim($columnFields, ", ");
					
					// Wstawienie nowego wiersza do tabeli $tablename
					$ins = $db->execute("INSERT INTO {$tablename} VALUES (NULL, 'pl', {$colmunFields})");
				}
			}
			else
			{
				// Ponowna iteracja znalezionych [sTr]..[eTr]
				foreach($m[1] as $col)
				{
					$ins = "";
					$check_upd = $db->execute("SELECT {$col} FROM {$tablename} WHERE lang = 'pl'");
					
					// W przypadku wykrycia wcześniej zapisanych danych w kolumnie $col musimy je przepisać aby nic nie stracić
					if(!empty($check_upd)) $ins = $check_upd[$col];
					
					// Ostateczne zapytanie wpisujące do kolumny $col pusty ciąg lub poprzednią zawartość tej komórki
					$upd = $db->execute("UPDATE {$tablename} SET {$col} = {$ins} WHERE lang = 'pl'");
				}
			}
		}

		$saveUserPage = FilesystemUtil::saveFile($content, $filename);
        if($saveUserPage)
        {
            echo "true";
        }
        else
        {
            echo "Wystąpił błąd podczas zapisu strony! Sprawdź czy masz odpowiednie uprawnienia do pliku.";
        }
	}
	else
	{
		echo "Wystąpił błąd podczas zapisu strony! Sprawdź czy masz odpowiednie uprawnienia do pliku oraz czy ten plik istnieje.";
	}
}
elseif(isset($_POST['removeSubpage']))
{
	include_once("../../../".$configs['controller_path'].$_POST['controller'].".php");
    $_err = "";
    
    $methods = explode(", ", $_POST['pages']);
    foreach($methods as $method)
    {
        if(ReflectionUtil::isMethodExists($_POST['controller'], $method))
        {
            $_method = ReflectionUtil::getClassMethodInfo($_POST['controller'], $method);
            
            $_startLine = $_method['startLine'];
            $_endLine = $_method['endLine'];
            
            $controller_file = FilesystemUtil::getSource($_method['filename'], true);
            $_part1 = array_slice($controller_file, 0, $_startLine-1);
            $_part2 = array_slice($controller_file, $_endLine+1, count($controller_file));
            $_newController = implode($_part1).implode($_part2);
            
            $saveController[] = FilesystemUtil::saveFile($_newController, $_method['filename']);
            $deleteView[] = unlink("../../../".$configs['view_path'].$_POST['controller']."/".$method.".php");
        }
        else
        {
            $_err .= $method.", ";
        }
    }
    
    if(!in_array(false, $saveController, true) && !in_array(false, $deleteView, true) && empty($_err))
    {
        echo "true";
    }
    else
    {
        echo "Nie wszystkie pliki zostały zaktualizowane!\n".$_err;
    }
}
elseif(isset($_POST['addNewSubpage']))
{
	include_once("../../../".$configs['controller_path'].$_POST['controller'].".php");
	
	$_newController = "\n\tpublic function {$_POST['pagename']}()\n\t{\n\n\t\$this->main->head_helper;\n\n\t}\n";
	$_newView = "<!DOCTYPE html>\n<html>\n<head>\n\n<?=add_title(\"Nowa strona - {$_POST['pagename']}\")?>\n\n</head>";
    $_newView .= "\n\n<body>\n\nHello World!\n\n</body>\n\n</html>";
	
	if(!ReflectionUtil::isMethodExists($_POST['controller'], $_POST['pagename']))
	{
		$isValid = preg_match('/^([a-z][a-zA-Z0-9_]+)$/m', $_POST['pagename']);
		
		if($isValid > 0)
		{
			$methods = ReflectionUtil::getClassMethods($_POST['controller']);
			$lastMethod = ReflectionUtil::getClassMethodInfo($_POST['controller'], end($methods));
			
			$_startLine = $lastMethod['startLine'];
			$_endLine = $lastMethod['endLine'];
			
			$controller_file = FilesystemUtil::getSource($lastMethod['filename'], true);
			
			$_pstart = array_slice($controller_file, 0, $_endLine);
            $_pend = array_slice($controller_file, $_endLine);
			
			$_pstart[] = $_newController;
			$controller_file = array_merge($_pstart, $_pend);
			$controller_file = implode($controller_file);
			
			$saveController = FilesystemUtil::saveFile($controller_file, $lastMethod['filename']);
            $saveView = FilesystemUtil::saveFile($_newView, "../../../".$configs['view_path'].$_POST['controller']."/".$_POST['pagename'].".php");
			
			if($saveController && $saveView)
            {
                echo "true";
            }
            else
            {
                echo "Nie wszystkie pliki zostały zaktualizowane!";
            }
		}
		else
		{
			echo "Podana nazwa podstrony ma nieprawidłowy format!";
		}
	}
	else
	{
		echo "Podstrona '{$_POST['pagename']}' już istnieje!";
	}
}
elseif(isset($_POST['saveController']))
{
	$result = FilesystemUtil::saveFile($_POST['content'], "../../../".$configs['controller_path'].$_POST['controller'].".php");
	echo ($result) ? "true" : "Wystąpił błąd podczas zapisu pliku. Sprawdź czy masz odpowiednie uprawnienia.";
}
elseif(isset($_POST['addNewModule']))
{
	if(!file_exists("../../../".$configs['module_path'].$_POST['module']."_module/".$_POST['module'].".php"))
	{
		if(!file_exists("../../../".$configs['module_path'].$_POST['module']."_module")) mkdir("../../../".$configs['module_path'].$_POST['module']."_module");
		
		$_newModule = "<div style=\"border: 1px solid #dedede; padding: 3px;\">\n\t<strong>Hello World!</strong>\n</div>";
		
		$saveModule = FilesystemUtil::saveFile($_newModule, "../../../".$configs['module_path'].$_POST['module']."_module/".$_POST['module'].".php", false);
		
		if(!$saveModule)
        {
            echo "Wystąpił błąd! Nie wszystkie pliki zostały zapisane.";
        }
        else
        {
            echo "true";
        }
	}
	else
	{
		echo "Taka strona już istnieje!";
	}
}
elseif(isset($_POST['saveModule']))
{
	$result = FilesystemUtil::saveFile($_POST['content'], "../../../".$configs['module_path'].$_POST['module']."_module/".$_POST['module'].".php");
	echo ($result) ? "true" : "Wystąpił błąd podczas zapisu pliku. Sprawdź czy masz odpowiednie uprawnienia.";
}
elseif(isset($_POST['removeModule']))
{
	if(file_exists("../../../".$configs['module_path'].$_POST['module']."_module/".$_POST['module'].".php"))
	{
		$_delModule = unlink("../../../".$configs['module_path'].$_POST['module']."_module/".$_POST['module'].".php");
		$_delCat = rmdir("../../../".$configs['module_path'].$_POST['module']."_module");
		
		if(!$_delModule || !$_delCat)
        {
            echo "Wystąpił błąd podczas usuwania modułu!";
        }
        else
        {
            echo "true";
        }
	}
	else
	{
		echo "Nie ma takiego modułu!";
	}
}
elseif(isset($_POST['saveArticle']))
{
	if($_POST['saveArticle'] == "new")
	{
		$q = $db->execute("INSERT INTO articles VALUES (NULL, '{$_POST['title']}', '{$_POST['text']}', '{$_POST['date']}', '{$_POST['author']}')");
	}
	else
	{
		$q = $db->execute("UPDATE articles SET title = '{$_POST['title']}', text = '{$_POST['text']}', date = '{$_POST['date']}', author = '{$_POST['author']}' WHERE id = '{$_POST['saveArticle']}'");
	}

	if(!$q)
	{
		echo "Wystąpił błąd podczas aktualizacji artykułów!";
	}
	else
	{
		echo "true";
	}
	
}
elseif(isset($_POST['removeArticle']))
{
	$q1 = $db->execute("DELETE FROM articles WHERE id = '{$_POST['id']}'");
	$q2 = $db->execute("DELETE FROM votes WHERE id_artykul = '{$_POST['id']}'");
	echo ($q1 && $q2) ? "true" : "Wystąpił błąd podczas usuwania artykułu!";
}
else
{
	die("Dostęp do tej strony został zablokowany przez administratora!");
}





















?>