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
        factur.data,
        factur.factur_numer
        
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
       
        // print_r($z);

        return $z;

    } 

    public function editFactura()
	{
		if(isset($this->__params['POST']['editwarfor'])) {
            // print_r("aaaaaaaaaaaaaaa");
            // print_r($this->__params['POST']['adres']);
            // print_r($this->__params['POST']['facturnumer']);
            // print_r($this->__params['POST']['facturdata']);

			$this->__db->execute("UPDATE bouw_factur SET
			adres_id = '".$this->__params['POST']['adres']."',
			oferten_id = 6, 
			factur_numer = '".$this->__params['POST']['facturnumer']."',
			data = '".$this->__params['POST']['facturdata']."'
            WHERE factur_numer = '".$this->__params['POST']['facturnumer']."'
            ");

            for ($i=0; $i < 20; $i++) {
                print_r($this->__params['POST']['warfortype'][$i]);

                $r = $this->__db->execute("UPDATE bouw_factur_details SET
                factur_nr = '".$this->__params['POST']['facturnumer']."',
                waarvoor_id = '".$this->__params['POST']['warfortype'][$i]."',
                quantity = '".$this->__params['POST']['warfortimespend'][$i]."',
                price = '".$this->__params['POST']['warforquantity'][$i]."'
                WHERE factur_nr = ".$this->__params['POST']['facturnumer']."
                ");
            }
            
            print_r($r);

            // header("Location: ".SERVER_ADDRESS."administrator/inkomsten/index");
        }	
    }

}

?>