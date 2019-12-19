<?php

namespace Modal;
include_once($_SERVER['DOCUMENT_ROOT']."/application/providers/db_provider.php");
use Providers\database as DB;

class sidebarModal {
    public $query;
    public $cityArray = Array();

    public function getCityName(){
        DB::db();
        $this->query = DB::$__db->querymy("SELECT miasto FROM bedrijf_adresy");
        foreach($this->query->fetch_all() as $q){
            array_push($this->cityArray, $q);
        }
       return $this->cityArray;
    }
}

?>