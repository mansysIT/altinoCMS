<?php

namespace Providers;
include_once($_SERVER['DOCUMENT_ROOT']."/core/main/registry.php");
use registry;

class database {
	public static $__config;
	public static $__router;
    public static $__params;
    public static $__db;
	
	public static function db()
	{
		self::$__config = registry::register("config");
		self::$__router = registry::register("router");
        self::$__params = self::$__router->getParams();
        self::$__db = registry::register("db");
	}
}

?>