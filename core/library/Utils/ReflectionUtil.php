<?php

class ReflectionUtil
{
	public static function getClassInfo($CLASS, $IGNORE_EXTENDING = TRUE)
	{
		if(!$CLASS instanceof ReflectionClass)
		{
			$CLASS = new ReflectionClass($CLASS);
		}
		
		$_temp = Array();
		
		$result['name'] = $CLASS->getName();
		$result['modifiers'] = implode(' ', Reflection::getModifierNames($CLASS->getModifiers()));
		
		foreach($CLASS->getProperties() as $key => $val)
		{
			$modifier = "unknown";
			
			if($val->isPublic())    $modifier = "public";
			if($val->isPrivate())   $modifier = "private";
            if($val->isProtected()) $modifier = "protected";
            if($val->isStatic())    $modifier = "static";
			
			if($IGNORE_EXTENDING)
			{
				if($val->class == $CLASS->getName())
				{
					$_temp[] = Array("modifier" => $modifier, "property" => $val->name);
				}
			}
			else
			{
				$_temp[] = Array("modifier" => $modifier, "property" => $val->name);
			}
		}
		
		$result['properties'] = $_temp;
		$result['filename'] = $CLASS->getFileName();
		$result['startLine'] = $CLASS->getStartLine();
		$result['endLine'] = $CLASS->getEndLine();
		
		return $result;
	}

	public static function getClassMethodInfo($CLASS, $METHOD)
	{
		$method = new ReflectionMethod($CLASS, $METHOD);
		
		$result['declaringClass']   = $method->getDeclaringClass()->name;
        $result['modifiers']        = implode(' ', Reflection::getModifierNames($method->getModifiers()));
        $result['name']             = $method->getName();
        $result['parameters']       = $method->getParameters();
        $result['filename']         = $method->getFileName();
        $result['startLine']        = $method->getStartLine();
        $result['endLine']          = $method->getEndLine();
		
		return $result;
	}
	
	public static function getFileFunctions($FILENAME)
	{
		$file = FilesystemUtil::getSource($FILENAME);
		$w = preg_match_all('/function\s([a-zA-Z1-9_]+)\(/', $file, $m);
		
		return $m;
	}
	
	public static function getClassSource($CLASS)
	{
		$CLASS = static::getClassInfo($CLASS);
		
		$path = $CLASS['filename'];
		$lines = file($path);
		$from = $CLASS['startLine'];
		$to = $CLASS['endLine'];
		$len = $to - $from + 1;
		
		return implode(array_slice($lines, $from - 1, $len));
	}
	
	public static function getClassMethodSource($CLASS, $METHOD)
	{
		$METHOD = static::getClassMethodInfo($CLASS, $METHOD);
		
		$path   = $METHOD['filename'];
        $lines  = file($path);
        $from   = $METHOD['startLine'];
        $to     = $METHOD['endLine'];
        $len    = $to - $from + 1;
        
        return implode(array_slice($lines, $from - 1, $len));
	}
	
	public static function getClassMethods($CLASS, $IGNORE_EXTENDING = TRUE)
	{
		if(!$CLASS instanceof ReflectionClass)
        {
            $CLASS = new ReflectionClass($CLASS);
        }
		
		foreach($CLASS->getMethods() as $key => $val)
		{
			if($IGNORE_EXTENDING)
			{
				if($val->class == $CLASS->getName())
				$result[] = $val->name;
			}
			else
			{
				$result[] = Array("class" => $val->class, "method" => $val->name);
			}
		}
		
		return $result;
	}
	
	public static function getMethodReferencesProperties($CLASS, $METHOD, $REFERENCE)
	{
		$METHOD = self::getClassMethodInfo($CLASS, $METHOD);
		
		$path   = $METHOD['filename'];
        $lines  = file($path);
        $from   = $METHOD['startLine'];
        $to     = $METHOD['endLine'];
        $len    = $to - $from + 1;
		
		$lines = array_slice($lines, $from - 1, $len);
		$result = Array();
		
		foreach($lines as $line)
		{
			$w = preg_match('/\\$this->'.$REFERENCE.'->([^"();]+?)[;-]/', trim($line), $m);
			if(!empty($m)) $result[] = $m[1];
		}
		
		return (empty($result)) ? Array() : $result;
	}
	
	public static function getMethodHookProperties($CLASS, $METHOD, $HOOK = 'addHook')
	{
		$METHOD = self::getClassMethodInfo($CLASS, $METHOD);
		
		$path   = $METHOD['filename'];
        $lines  = file($path);
        $from   = $METHOD['startLine'];
        $to     = $METHOD['endLine'];
        $len    = $to - $from + 1;
		
		$lines = array_slice($lines, $from - 1, $len);
		$result = Array();
		$_temp = Array();
		
		foreach($lines as $line)
		{
			$w = preg_match('/\\$this->'.$HOOK.'\(\$this->([a-z0-9A-Z]+)->([a-z0-9A-Z]+)\(\)\);/', trim($line), $m);
            if(!empty($m))
            {
                $_temp[] = $m[1];
                $_temp[] = $m[2];
            }
		}
		
		$result = $_temp;
		
		return (empty($result)) ? Array() : $result;
	}
	
	public static function getMethodReferencesFunction($CLASS, $METHOD, $REFERENCE)
	{
		$METHOD = self::getClassMethodInfo($CLASS, $METHOD);
		
		$path   = $METHOD['filename'];
        $lines  = file($path);
        $from   = $METHOD['startLine'];
        $to     = $METHOD['endLine'];
        $len    = $to - $from + 1;
		
		$lines = array_slice($lines, $from - 1, $len);
		$result = Array();
		
		foreach($lines as $line)
		{
			$w = preg_match('/\\$this->'.$REFERENCE.'\((.*)\,\s?\"(.*)\"\);/', trim($line), $m);
			if(!empty($m)) $result[] = $m[2];
		}
		
		return (empty($result)) ? Array() : $result;
	}
	
	public static function getFileCommentDescription($FILENAME, $REFERENCE)
	{
		$lines = file($FILENAME);
		$result = Array();
		
		foreach($lines as $line)
		{
			$w = preg_match('/'.$REFERENCE.':\\s+(.*)/', trim($line), $m);
			if(!empty($w)) $result[] = $m[1];
		}
		
		return (empty($result)) ? false : $result;
	}
	
	public static function hasParent($CLASS)
	{
		if(!$CLASS instanceof ReflectionClass)
        {
            $CLASS = new ReflectionClass($CLASS);
        }
		
		$parent = $CLASS->getParentClass();
		return ($parent) ? $parent->getName() : false;
	}
	
	public static function isMethodExists($CLASS, $METHOD)
	{
		$methods = static::getClassMethods($CLASS);
		return (in_array($METHOD, $methods));
	}
	
	public static function getClassName($FILE)
	{
		$file = pathinfo($FILE);
		return $file['filename'];
	}
	
	public static function _filterMethodByUserDefined($METHODS_ARRAYS)
	{
		$result = Array();
		
		foreach($METHODS_ARRAYS as $key => $val)
		{
			if(is_array($val))
			{
				if(substr($val['method'], 0, 2) != "__" && $val['method'] != "main") $result[] = $val;
			}
			else
			{
				if(substr($val, 0, 2) != "__" && $val != "main") $result[] = $val;
			}
		}
		
		$result = array_merge(Array(), $result);
		
		return $result;
	}
	
}

?>