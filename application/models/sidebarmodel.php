<?php

namespace Modal;
include_once($_SERVER['DOCUMENT_ROOT']."/application/providers/db_provider.php");
use Providers\database as DB;

class sidebarModal {
    public $query;
    public $cityArray = Array();

    public function getCityName(){
        DB::db();
        $this->query = DB::$__db->execute("SELECT miasto FROM bedrijf_adresy");

        foreach($this->query as $q){
            array_push($this->cityArray, $q['miasto']);
        }
       return $this->cityArray;
    }
}

?>