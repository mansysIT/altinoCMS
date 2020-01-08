<?php

// error_reporting(E_ERROR | E_PARSE);

class facturmodel
{

	private $__config;
	private $__router;
    public $__params;
	private $__db;
	
	public function __construct()
	{
		$this->__config = registry::register("config");
		$this->__router = registry::register("router");
        $this->__params = $this->__router->getParams();
		$this->__db = registry::register("db");
    }
    
    public function showdata() {

        $data = $this->__db->execute("SELECT 
        city.city_id,
        city.city,
        adresy.adres, 
        adresy.postcode,
        -- adresy.private_naam,
        -- adresy.private_achternaam,
        -- adresy.private_id_kaart,
        -- adresy.private_tel,
        -- adresy.private_geboortedatum,
        -- adresy.bedrijf_bedrijf,
        -- adresy.bedrijf_adres,
        -- adresy.bedrijf_postcode,
        -- adresy.bedrijf_stad,
        -- adresy.bedrijf_kvk,
        -- adresy.bedrijf_btw,
        -- adresy.bedrijf_tel,
        -- adresy.email,
        -- adresy.rekening,
        factur.data
        
        FROM bouw_city AS city INNER JOIN bouw_adresy  AS adresy ON city.city_id = adresy.city 
        INNER JOIN bouw_factur AS factur ON adresy.id = factur.adres_id 
        WHERE factur.factur_numer = ".$this->__params[1]);
        $x = array();
        foreach($data as $q){
            array_push($x, $q);

        }

        
        $dataWarfor = $this->__db->execute("SELECT 
        factur_nr,
        waarvoor_id,
        quantity,
        price
        FROM bouw_factur_details 
        WHERE factur_nr = ".$this->__params[1]);

        $y = array();
        foreach($dataWarfor as $q){

            array_push($y, $q);

        }
        $z = array_merge($x, $y);
       
        // print_r($z[0]);

        return $z;

    }

}

?>