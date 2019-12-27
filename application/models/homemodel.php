<?php

include_once($_SERVER['DOCUMENT_ROOT']."/application/providers/db_provider.php");
use Providers\database as DB;

class homemodel
{
	private $config;
	public $query;
    public $cityArray = Array();
	
	public function __construct()
	{
		$this->config = registry::register("config");
	}

    public function getAdress(){
        DB::db();
		//$this->query = DB::$__db->querymy("SELECT * FROM `bedrijf_adresy` WHERE date BETWEEN '2019-12-01' AND '2019-12-10'");
		$this->query = DB::$__db->querymy("SELECT * FROM `bedrijf_adresy`");
        foreach($this->query->fetch_all() as $q){
            array_push($this->cityArray, $q);
        }
       return $this->cityArray;
    }
}

?>