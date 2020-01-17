<?php

error_reporting(E_ERROR | E_PARSE);

class allmodel
{
	public $query;
	public $cityArray = Array();

	private $__config;
	private $__router;
    private $__params;
    private $__db;
	
	public function __construct()
	{
		$this->__config = registry::register("config");
		$this->__router = registry::register("router");
        $this->__params = $this->__router->getParams();
        $this->__db = registry::register("db");
	}

	public function getOffertenActive() {  

		//echo 'jest';
		if(isset($this->__params['POST']['action'])){
			if($this->__params['POST']['action'] == 'oferty') {
					$adresy = $this->__db->querymy("SELECT id, oferten_numer FROM bouw_oferten WHERE data_end = '0000-00-00' AND `adres_id` = ".$this->__params['POST']['id_adres']);
					//$adresy = $this->__db->querymy("SELECT id, oferten_numer FROM bouw_oferten WHERE `adres_id` = 32");
					//echo 'numer'.$adresy->num_rows;
					if($adresy->num_rows > 0){  
						foreach($adresy->fetch_all() as $q){ 
							// array_push($this->adresArray, $q);
							if(isset($this->__params['POST']['oferte_id'])){
							echo "<option value='$q[0]'"; 
							if($q[0] == $this->__params['POST']['oferte_id'])
							{ echo "selected"; }
							echo ">$q[1]</option>"; 
							} else {
							echo "<option value='$q[0]'>$q[1]</option>";
							}
						}
					}
					else
						echo "<option value=''>Geen offerten</option>";


					//echo $this->adresArray;
					return $this->adresArray;
			}
		}
	} 


}

?>