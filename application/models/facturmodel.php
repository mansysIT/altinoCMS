<?php

error_reporting(E_ERROR | E_PARSE);

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
        factur.factur_numer,
        adresy.id
        
        FROM bouw_city AS city INNER JOIN bouw_adresy  AS adresy ON city.city_id = adresy.city 
        INNER JOIN bouw_factur AS factur ON adresy.id = factur.adres_id 
        WHERE factur.factur_numer = ".$this->__params[1]);
        $x = array();
        foreach($data as $q){
            array_push($x, $q);

        }

        
        $y = $this->getAllWarforForAdres();

        $z = array_merge($x, $y);
       
        // print_r($z);

        return $z;

    } 

    private function getAllWarforForAdres() {
        $dataWarfor = $this->__db->execute("SELECT 
        factur_nr,
        waarvoor_id,
        quantity,
        price,
        id
        FROM bouw_factur_details 
        WHERE factur_nr = ".$this->__params[1]);

        $y = array();
        foreach($dataWarfor as $q){

            array_push($y, $q);
            // print_r($q);

        }

        return $y;
    }

    public function editFactura()
	{
		if(isset($this->__params['POST']['editwarfor'])) {

            $adres = $this->__params['POST']['adres'];
            $factur =$this->__params['POST']['facturnumer'];
            $data = $this->__params['POST']['facturdata'];

			$this->__db->execute("UPDATE bouw_factur 
            SET
			adres_id = $adres,
			oferten_id = 6, 
			factur_numer = $factur,
			data = '$data' 
            WHERE factur_numer = $factur
            ");

            $i = 1;

            if (count($this->__params['POST']['warforInputId']) >= count($this->getAllWarforForAdres())) {
                foreach (array_slice($this->__params['POST']['warforInputId'], 1) as $row) {
                    $id = $this->__params['POST']['warforInputId'][$i];
                    $allwarfor = $this->getAllWarforForAdres()[$i - 1];
                    if (in_array($id, $allwarfor)) {
                    $r = $this->__db->execute("UPDATE bouw_factur_details 
                    SET
                    factur_nr = '".$factur."',
                    waarvoor_id = '".$this->__params['POST']['warfortype'][$i]."', 
                    quantity = '".$this->__params['POST']['warfortimespend'][$i]."',
                    price = '".$this->__params['POST']['warforquantity'][$i]."'
                    WHERE id = '".$this->__params['POST']['warforInputId'][$i]."'
                    ");
                        // print_r(" [ ".$r." / ");
                        } else {
                            $this->__db->execute("INSERT INTO bouw_factur_details 
                        (factur_nr, 
                        waarvoor_id, 
                        quantity,
                        price) 
                        VALUES (
                        ".$factur.",
                        ".$this->__params['POST']['warfortype'][$i].",
                        ".$this->__params['POST']['warfortimespend'][$i].",
                        ".$this->__params['POST']['warforquantity'][$i]."
                        )");
                        }
                  
                    $i++;
                    
                }
            }
            header("Location: ".SERVER_ADDRESS."administrator/inkomsten/index");
        }
    }

    public function removewarfor() {
        if ($this->__params['POST']['action'] == 'removewarfor') {
            $this->__db->execute("DELETE FROM bouw_factur_details WHERE id = ".$this->__params['POST']['warfor_id']);
        }

    }

}

?>