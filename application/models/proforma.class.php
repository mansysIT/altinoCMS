<?php

class proforma extends conf {

    var $db_query;
    private $d_od;
    private $d_do;
    private $db_query_p;
    public $db_query_m;
    public $proformy_dane;
    public $proformy_maile;
	public $ilosc_maili;
    public $tab;

    public function wplata_data_jest($id) {
        $sql = "SELECT `wplata_data` FROM `bedrijf_proformy` WHERE `id`=$id";
        //echo $sql;
        $wynik = mysql_query($sql);

        while ($res = mysql_fetch_array($wynik)) {
            $this->tab = $res;
        }

        if ($this->tab['wplata_data'] == '0000-00-00') {
            return 0;
        } else {
            return 1;
        }

    }

    public function query_tablica($q) {
        $this->db_query = mysql_query($q);

        while ($res = mysql_fetch_array($this->db_query)) {
            $this->tab = $res;
        }
        return $this->tab;
    }

    public function query($q) {
        $this->db_query = $q;
        $this->pobierz = mysql_fetch_array($this->db_query);
    }

    public function pobierz($row) {
        return $this->pobierz[$row];
    }

   public function wystaw_proforme($adres_id, $nowy_huurder, $miesiac_rok, $warrvoor = 0, $tab = null) {
		/*
		if ($_POST['persoon'] == 'eigenaar')
		{
			echo 'jest';
		}
		else
		{
			echo 'nie';
		}
		exit();
        */
        if (empty($nowy_huurder)) {
            $this->query(mysql_query("SELECT w.*, w.borg_oplacony AS borg_oplacony_wplaty, w.water_huurder AS water_huurder_wplaty, w.internet_huurder AS internet_huurder_wplaty,a.* FROM `wplaty_adresy` w LEFT JOIN adresy a ON a.id = w.adres_id WHERE a.id = " . $adres_id . " ORDER BY w.id DESC LIMIT 1 "));

            $naam = $tab['kto_imie'];
            $achternaam = $tab['kto_nazwisko'];
            $bedrijf = $tab['kto_bedrijf'];
            $adres = $tab['kto_adres'];
            $postcode = $tab['kto_kod'];
            $stad = $tab['kto_miasto'];
            $kvk = $tab['kto_kvk'];
            $btw = $tab['kto_btw'];
            $email = $tab['kto_email'];

            //Sprawdzenie ilosci wplat
            if (empty($this->pobierz('borg_oplacony_wplaty')))
                $borg = $this->pobierz('borg_huurder');

            if (empty($this->pobierz('admin_oplacony')))
                $admin = $this->pobierz('admin_huurder');


            $cala_kwota_proforma = $borg + $admin + $this->pobierz('huur_huurder') + $this->pobierz('ge_huurder') + $this->pobierz('internet_huurder_wplaty') + $this->pobierz('water_huurder_wplaty');

            $huur = $this->pobierz('huur_huurder');
            $ge = $this->pobierz('ge_huurder');
            $internet = $this->pobierz('internet_huurder_wplaty');
            $water = $this->pobierz('water_huurder_wplaty');

            /*
              $vat_huur = $this->pobierz('vat_huur');
              $vat_ge = $this->pobierz('vat_ge');
              $vat_internet = $this->pobierz('vat_internet');
              $vat_water = $this->pobierz('vat_water');
              $vat_admin = $this->pobierz('vat_admin');
              $vat_borg = $this->pobierz('vat_borg');
             */

            $vat_huur = 0;
            $vat_ge = 21;
            $vat_internet = 21;
            $vat_water = 9;
            $vat_admin = 21;
            $vat_borg = 0;
        }
        else {
            $this->query(mysql_query("SELECT w.*,w.borg_oplacony AS borg_oplacony_wplaty, w.borg AS borg_wplaty, w.email AS email_nowy, a.* FROM `bedrijf_nieuweHuurder` w LEFT JOIN adresy a ON a.id = w.adres_id WHERE a.id = " . $adres_id . " ORDER BY w.id DESC LIMIT 1 "));


            if (empty($this->pobierz('id'))) {
                $msg .= 'Er is geen nieuwe hurder';
                header('Location:proforma.php?msg=' . $msg);
                break;
            }

            $naam = $tab['kto_imie'];
            $achternaam = $tab['kto_nazwisko'];
            $bedrijf = $tab['kto_bedrijf'];
            $adres = $tab['kto_adres'];
            $postcode = $tab['kto_kod'];
            $stad = $tab['kto_miasto'];
            $kvk = $tab['kto_kvk'];
            $btw = $tab['kto_btw'];
            $email = $tab['kto_email'];
	
			
			


            //Sprawdzenie ilosci wplat
            if (empty($this->pobierz('borg_oplacony_wplaty')))
                $borg = $this->pobierz('borg_wplaty');

            if (empty($this->pobierz('admin_oplacony')))
                $admin = $this->pobierz('administratiekosten');


            $cala_kwota_proforma = $borg + $admin + $this->pobierz('huur') + $this->pobierz('ge') + $this->pobierz('internet') + $this->pobierz('water');


            $huur = $this->pobierz('huur');
            $ge = $this->pobierz('ge');
            $internet = $this->pobierz('internet');
            $water = $this->pobierz('water');

            /*
              $vat_huur = $this->pobierz('vat_huur');
              $vat_ge = $this->pobierz('vat_ge');
              $vat_internet = $this->pobierz('vat_internet');
              $vat_water = $this->pobierz('vat_water');
              $vat_admin = $this->pobierz('vat_admin');
              $vat_borg = $this->pobierz('vat_borg');
             */

            $vat_huur = 0;
            $vat_ge = 21;
            $vat_internet = 21;
            $vat_water = 9;
            $vat_admin = 21;
            $vat_borg = 0;
        }

        $miesiac_rok = $this->zmiana_formatu_daty('15-' . $miesiac_rok);

        if ($warrvoor == 0) {
            mysql_query("INSERT INTO `bedrijf_proformy`(`adres_id`, `data_proformy`, `borg`, `administratiekosten`, `huur`, `ge`, `internet`, `water`, `vat_huur`, `vat_borg`, `vat_admin`, `vat_ge`, `vat_water`, `vat_internet`,  `title`, `title_btw`, `miesiac_rok`, `cala_kwota_proforma`, `naam`, `achternaam`, `bedrijf`, `adres`, `postcode`, `stad`, `kvk`, `btw`, `email`,`nowy_huurder`) VALUES 
                    ('" . $adres_id . "', '" . date('Y-m-d') . "', '" . $borg . "', '" . $admin . "', '" . $huur . "', '" . $ge . "', '" . $internet . "', '" . $water . "', '" . $vat_huur . "', '" . $vat_borg . "', '" . $vat_admin . "', '" . $vat_ge . "', '" . $vat_water . "', '" . $vat_internet . "', '', 0, '" . $miesiac_rok . "', '" . $cala_kwota_proforma . "', '" . $naam . "', '" . $achternaam . "', '" . $bedrijf . "', '" . $adres . "', '" . $postcode . "', '" . $stad . "', '" . $kvk . "', '" . $btw . "', '" . $email . "', '" . $nowy_huurder . "')") or die(mysql_error());
        } else {
			
			$title = $tab['title'];
			$title_cena = $tab['title_cena']; 
			$title_btw = $tab['title_btw'];
			
			
            mysql_query("INSERT INTO `bedrijf_proformy`(`warrvoor`,`adres_id`, `data_proformy`,  `title`,  `title_btw`,  `cala_kwota_proforma`, `naam`, `achternaam`, `bedrijf`, `adres`, `postcode`, `stad`, `kvk`, `btw`, `email`,`nowy_huurder`) VALUES 
                    ('1','" . $adres_id . "', '" . date('Y-m-d') . "', '".$title."', '" . $title_btw . "', '" . $title_cena . "', '" . $naam . "', '" . $achternaam . "', '" . $bedrijf . "', '" . $adres . "', '" . $postcode . "', '" . $stad . "', '" . $kvk . "', '" . $btw . "', '" . $email . "', '" . $nowy_huurder . "')") or die(mysql_error());
        }
        $id_prof = mysql_insert_id();

        if ($warrvoor == 1) {


            foreach ($tab['waarvoor'] as $key => $value) {

				if($tab['waarvoor'][$key] != 0)	{
					$sql10 = 'INSERT INTO `bedrjf_proforma_warrvoor`(`proforma_id`, `warrvoor_id`, `kwota`) VALUES 
						(\'' . $id_prof . '\', \'' . $tab['waarvoor'][$key] . '\', \'' . str_replace(',', '.', $tab['waarvoor_cena'][$key]) . '\')';

					mysql_query($sql10) or die(mysql_error());
					echo '<br>' . $sql10;
				}
            }
        } else {
            echo "warrvoor=0";
        }
		
		
		$pr = new ProformaPdf();
		$pr -> ProformaMakePdf($id_prof);
		
		
    }

    public function aktualizacja_daty_zaplaty($proforma_id, $data_zaplaty, $warvoor = 0) {


        $this->query(mysql_query("SELECT * FROM `bedrijf_proformy` WHERE id = " . $proforma_id));


        $huur = $this->pobierz('huur');
        $borg = $this->pobierz('borg');
        $admin = $this->pobierz('administratiekosten');
        $ge = $this->pobierz('ge');
        $internet = $this->pobierz('internet');
        $water = $this->pobierz('water');
		$warvoor = $this->pobierz('warrvoor');
		$adres_id = $this->pobierz('adres_id');


        $laczne_wplaty = $huur + $ge + $internet + $water;


        $faktura_nr = $this->numer_faktury();

        if ($warvoor == 1) {

            $warrvoor_id = new conf();
            $sql3_mansys = 'SELECT `warrvoor_id`, `kwota` FROM `bedrjf_proforma_warrvoor` WHERE `proforma_id` = "' . $this->pobierz('id') . '"';
            $warrvoor_id->query(mysql_query($sql3_mansys));

            //$adres_id = $this->pobierz('adres_id');
            $laczne_wplaty_warvoor = $warrvoor_id->pobierz('kwota');
            //echo $sql3_mansys;
            //break;
			
			
			if(!empty($laczne_wplaty_warvoor)){
				mysql_query("INSERT INTO `wplaty`(
				`adres_id`, 
				
				`waarvoor_id`, 
				`kto_imie`, 
				`kto_nazwisko`, 
				`kto_bedrijf`, 
				`kto_adres`, 
				`kto_kod`, 
				`kto_miasto`, 
				`kto_kvk`, 
				`kto_btw`, 
				`kto_email`, 
				`kwota`, 
				`sposob_wplaty`, 
				`faktura_nr`, 
				`proforma_nr`, 
				`data_faktury`, 
				`oplacona`, 
				`pobrano`, 
				`pobrano_data`, 
				`data`, 
				`nowy_huurder`) VALUES 
				('" . $this->pobierz('adres_id') . "', 
				
				'" . $warrvoor_id->pobierz('warrvoor_id') . "', 
				'" . $this->pobierz('naam') . "', 
				'" . $this->pobierz('achternaam') . "', 
				'" . $this->pobierz('bedrijf') . "', 
				'" . $this->pobierz('adres') . "', 
				'" . $this->pobierz('postcode') . "', 
				'" . $this->pobierz('stad') . "', 
				'" . $this->pobierz('kvk') . "', 
				'" . $this->pobierz('btw') . "', 
				'" . $this->pobierz('email') . "', 
				'" . $laczne_wplaty_warvoor . "', 
				'Overboeking', 
				'" . $faktura_nr . "', 
				'" . $this->pobierz('id') . "', 
				'" . $this->zmiana_formatu_daty($data_zaplaty) . "', 
				1,  
				1,
				'" . $this->zmiana_formatu_daty($data_zaplaty) . "', 
				'" . $this->zmiana_formatu_daty($data_zaplaty) . "',
				'" . $this->pobierz('nowy_huurder') . "'
				)") or die(mysql_error());
				
				
				

				mysql_query("INSERT INTO `faktury` (
				`adres_id`, 
				`faktura_nr`, 
				`data_faktury`, 
				`id_ost_wplaty`, 
				`cala_kwota_faktury`,
				`waarvoor_id`,
				`tytul`, `proforma`) VALUES (
				'" . $adres_id . "', 
				'" . $faktura_nr . "', 
				'" . $this->zmiana_formatu_daty($data_zaplaty) . "', 
				'" . $this->pobierz('id') . "', 
				'" . $warrvoor_id->pobierz('kwota') . "',
				'" . $warrvoor_id->pobierz('warrvoor_id') . "',
				'Proforma nr " . $this->pobierz('id') . "',
				1
				
				
				)") or die(mysql_error());
				
			}
			else{
				
				mysql_query("INSERT INTO `wplaty`(
				`adres_id`, 
				`tytul`,
				`kto_imie`, 
				`kto_nazwisko`, 
				`kto_bedrijf`, 
				`kto_adres`, 
				`kto_kod`, 
				`kto_miasto`, 
				`kto_kvk`, 
				`kto_btw`, 
				`kto_email`, 
				`kwota`, 
				`btw`,
				`sposob_wplaty`, 
				`faktura_nr`, 
				`proforma_nr`, 
				`data_faktury`, 
				`oplacona`, 
				`pobrano`, 
				`pobrano_data`, 
				`data`, 
				`nowy_huurder`) VALUES 
				('" . $this->pobierz('adres_id') . "', 
				'" .$this->pobierz('title'). "',
				
				'" . $this->pobierz('naam') . "', 
				'" . $this->pobierz('achternaam') . "', 
				'" . $this->pobierz('bedrijf') . "', 
				'" . $this->pobierz('adres') . "', 
				'" . $this->pobierz('postcode') . "', 
				'" . $this->pobierz('stad') . "', 
				'" . $this->pobierz('kvk') . "', 
				'" . $this->pobierz('btw') . "', 
				'" . $this->pobierz('email') . "', 
				'" . $this->pobierz('cala_kwota_proforma'). "', 
				'" . $this->pobierz('title_btw'). "',
				'Overboeking', 
				'" . $faktura_nr . "', 
				'" . $this->pobierz('id') . "', 
				'" . $this->zmiana_formatu_daty($data_zaplaty) . "', 
				1,  
				1,
				'" . $this->zmiana_formatu_daty($data_zaplaty) . "', 
				'" . $this->zmiana_formatu_daty($data_zaplaty) . "',
				'" . $this->pobierz('nowy_huurder') . "'
				)") or die(mysql_error());
				
				$id_wplaty = mysql_insert_id();

				mysql_query("INSERT INTO `faktury` (
				`adres_id`, 
				`faktura_nr`, 
				`data_faktury`, 
				`id_ost_wplaty`, 
				`cala_kwota_faktury`,
				`btw`,
				`tytul`, `proforma`) VALUES (
				'" . $adres_id . "', 
				'" . $faktura_nr . "', 
				'" . $this->zmiana_formatu_daty($data_zaplaty) . "', 
				'" .$id_wplaty. "', 
				'" . $this->pobierz('cala_kwota_proforma'). "',
				'" . $this->pobierz('title_btw'). "',
				'Proforma nr " . $this->pobierz('id') . "',
				1
				
				
				)") or die(mysql_error());
				
				
			}
			
			

            $query = mysql_query("UPDATE `bedrijf_proformy` SET 
						`wplata_data`='" . $this->zmiana_formatu_daty($data_zaplaty) . "'  
						WHERE id=" . $proforma_id) or die(mysql_error());
        } else {

            mysql_query("INSERT INTO `wplaty`(
			`adres_id`, 
			
			`waarvoor_id`, 
			`kto_imie`, 
			`kto_nazwisko`, 
			`kto_bedrijf`, 
			`kto_adres`, 
			`kto_kod`, 
			`kto_miasto`, 
			`kto_kvk`, 
			`kto_btw`, 
			`kto_email`, 
			`kwota`, 
			`sposob_wplaty`, 
			`faktura_nr`, 
			`proforma_nr`, 
			`data_faktury`, 
			`oplacona`, 
			`pobrano`, 
			`pobrano_data`, 
			`data`, 
			`nowy_huurder`) VALUES 
			('" . $this->pobierz('adres_id') . "', 
			
			0, 
			'" . $this->pobierz('naam') . "', 
			'" . $this->pobierz('achternaam') . "', 
			'" . $this->pobierz('bedrijf') . "', 
			'" . $this->pobierz('adres') . "', 
			'" . $this->pobierz('postcode') . "', 
			'" . $this->pobierz('stad') . "', 
			'" . $this->pobierz('kvk') . "', 
			'" . $this->pobierz('btw') . "', 
			'" . $this->pobierz('email') . "', 
			'" . $laczne_wplaty . "', 
			'Overboeking', 
			'" . $faktura_nr . "', 
			'" . $this->pobierz('id') . "', 
			'" . $this->zmiana_formatu_daty($data_zaplaty) . "', 
			1,  
			1,
			'" . $this->zmiana_formatu_daty($data_zaplaty) . "', 
			'" . $this->zmiana_formatu_daty($data_zaplaty) . "',
			'" . $this->pobierz('nowy_huurder') . "'
			)") or die(mysql_error());


            if ($borg > 0) {

                mysql_query("INSERT INTO `wplaty`(
					`adres_id`, 
				
					`waarvoor_id`, 
					`kto_imie`, 
					`kto_nazwisko`, 
					`kto_bedrijf`, 
					`kto_adres`, 
					`kto_kod`, 
					`kto_miasto`, 
					`kto_kvk`, 
					`kto_btw`, 
					`kto_email`, 
					`kwota`, 
					`sposob_wplaty`, 
					`faktura_nr`, 
					`proforma_nr`, 
					`data_faktury`, 
					`oplacona`, 
					`pobrano`, 
					`pobrano_data`, 
					`data`, 
					`nowy_huurder`) VALUES 
					('" . $this->pobierz('adres_id') . "', 
					
					18, 
					'" . $this->pobierz('naam') . "', 
					'" . $this->pobierz('achternaam') . "', 
					'" . $this->pobierz('bedrijf') . "', 
					'" . $this->pobierz('adres') . "', 
					'" . $this->pobierz('postcode') . "', 
					'" . $this->pobierz('stad') . "', 
					'" . $this->pobierz('kvk') . "', 
					'" . $this->pobierz('btw') . "', 
					'" . $this->pobierz('email') . "', 
					'" . $borg . "', 
					'Overboeking', 
					'" . $faktura_nr . "', 
					'" . $this->pobierz('id') . "', 
					'" . $this->zmiana_formatu_daty($data_zaplaty) . "', 
					1,  
					1,
					'" . $this->zmiana_formatu_daty($data_zaplaty) . "', 
					'" . $this->zmiana_formatu_daty($data_zaplaty) . "',
					'" . $this->pobierz('nowy_huurder') . "'
					)") or die(mysql_error());
            }


            if ($admin > 0) {
                mysql_query("INSERT INTO `wplaty`(
					`adres_id`, 
					
					`waarvoor_id`, 
					`kto_imie`, 
					`kto_nazwisko`, 
					`kto_bedrijf`, 
					`kto_adres`, 
					`kto_kod`, 
					`kto_miasto`, 
					`kto_kvk`, 
					`kto_btw`, 
					`kto_email`, 
					`kwota`, 
					`sposob_wplaty`, 
					`faktura_nr`, 
					`proforma_nr`, 
					`data_faktury`, 
					`oplacona`, 
					`pobrano`, 
					`pobrano_data`, 
					`data`, 
					`nowy_huurder`) VALUES 
					('" . $this->pobierz('adres_id') . "', 
					
					20, 
					'" . $this->pobierz('naam') . "', 
					'" . $this->pobierz('achternaam') . "', 
					'" . $this->pobierz('bedrijf') . "', 
					'" . $this->pobierz('adres') . "', 
					'" . $this->pobierz('postcode') . "', 
					'" . $this->pobierz('stad') . "', 
					'" . $this->pobierz('kvk') . "', 
					'" . $this->pobierz('btw') . "', 
					'" . $this->pobierz('email') . "', 
					'" . $admin . "', 
					'Overboeking', 
					'" . $faktura_nr . "', 
					
					'" . $this->pobierz('id') . "', 
					'" . $this->zmiana_formatu_daty($data_zaplaty) . "', 
					1,  
					1,
					'" . $this->zmiana_formatu_daty($data_zaplaty) . "', 
					'" . $this->zmiana_formatu_daty($data_zaplaty) . "',
					'" . $this->pobierz('nowy_huurder') . "'
					)") or die(mysql_error());
            }

           if($this->faktura_stawki_vat('water', $this->pobierz('data_proformy'))[0] == 9){
					$water_vat_type = 'water_9';
				}else{
					$water_vat_type = 'water';
				}
			
            mysql_query("INSERT INTO `faktury` (
			`adres_id`, 
			`faktura_nr`, 
			`data_faktury`, 
			`borg`, 
			`administratiekosten`, 
			`huur`, 
			`ge`, 		
			`internet`, 
			".$water_vat_type.", 
			`id_ost_wplaty`, 
			`cala_kwota_faktury`, 
			`tytul`) VALUES (
			'" . $adres_id . "', 
			'" . $faktura_nr . "', 
			'" . $this->zmiana_formatu_daty($data_zaplaty) . "', 
			'" . $borg . "', 
			'" . $admin . "', 
			'" . $huur . "', 
			'" . $ge . "', 
			'" . $internet . "', 
			'" . $water . "', 
			'" . $this->pobierz('id') . "', 
			'" . $this->pobierz('cala_kwota_proforma') . "', 
			'Proforma nr " . $this->pobierz('id') . "'
			
			
			)") or die(mysql_error());


            mysql_query("INSERT INTO `miesiace` (
			`adres_id`, 
			`faktura_nr`, 
			`data`) VALUES (
			'" . $adres_id . "', 
			'" . $faktura_nr . "', 
			'" . $this->pobierz('miesiac_rok') . "'
			)") or die(mysql_error());
			
			if($this->pobierz('nowy_huurder') != 1)
				$this->doIndexering($adres_id, $this->zmiana_formatu_daty($data_zaplaty));


            $query = mysql_query("UPDATE `bedrijf_proformy` SET 
						`wplata_data`='" . $this->zmiana_formatu_daty($data_zaplaty) . "'  
						WHERE id=" . $proforma_id) or die(mysql_error());
        }

        $msg .= 'Proforma is bijgewerkt';
        //header('Location:proforma.php?msg='.$msg.'&id='.$_GET['id']);	
    }

    public function proformy($od, $do, $slowo, $niezaplacone = null) {


        $this->d_od = $od;
        $this->d_do = $do;
		
		$nie = '';
		
		if(!empty($niezaplacone)){			
			$nie = ' AND `wplata_data` = 0000-00-00';
		}

        $this->db_query_p = mysql_query(
                "SELECT p.*, a.adres AS adresy_adres, a.miasto AS adresy_miasto FROM `bedrijf_proformy` p 
		LEFT JOIN adresy a ON a.id = p.adres_id
		WHERE p.data_proformy >= '" . $this->d_od . "' AND p.data_proformy <= '" . $this->d_do . "' AND a.miasto LIKE '%" . $slowo . "%' ".$nie." 
		OR p.data_proformy >= '" . $this->d_od . "' AND p.data_proformy <= '" . $this->d_do . "' AND a.adres LIKE '%" . $slowo . "%' ".$nie." 
		OR p.data_proformy >= '" . $this->d_od . "' AND p.data_proformy <= '" . $this->d_do . "' AND p.id LIKE '%" . $slowo . "%' ".$nie." 
		OR p.data_proformy >= '" . $this->d_od . "' AND p.data_proformy <= '" . $this->d_do . "' AND p.cala_kwota_proforma LIKE '%" . $slowo . "%' ".$nie." 
		OR p.data_proformy >= '" . $this->d_od . "' AND p.data_proformy <= '" . $this->d_do . "' AND p.data_proformy LIKE '%" . $slowo . "%' ".$nie." 
		ORDER BY p.id DESC");



        $this->db_query_p2 = mysql_query("SELECT * FROM `bedrijf_proformy_maile` ORDER BY `data_czas` ASC");


        while ($res = mysql_fetch_array($this->db_query_p2)) {


            $this->proforma_maile_czas[$res['proforma_id']] = $res['data_czas'];

            //echo '<br>'.$res['proforma_id'].'<br>';
        }



        $i = 0;
        while ($res1 = mysql_fetch_array($this->db_query_p)) {


            $this->proformy_dane[] = $res1;
            if ($res1['warrvoor'] == '1') {
                $sql = 'SELECT * FROM `bedrjf_proforma_warrvoor` WHERE proforma_id = ' . $res1['id'] . ' ORDER BY `id` DESC LIMIT 1';
                //echo $sql.'<br>';
                $this->db_query_p4 = mysql_query($sql);

                while ($res = mysql_fetch_array($this->db_query_p4)) {
                    $this->proformy_dane[$i]['kwota'] = $res['kwota'];
                }
				
				
				
				
				
            }
            //echo '<pre>';



			//echo 'rrr:'.$res1['id'].'<br>';

            foreach ($this->proforma_maile_czas as $k => $v) {

                //echo $k.'-'.$v.'-'.$res['id'].'<br>';

                if ($res1['id'] == $k) {

                    //	echo 'klucz='.$i.'<br>';

                    $this->proformy_dane[$i][33] = $v;
                    $this->proformy_dane[$i]['data_czas'] = $v;
                }
            }

            $i++;
        }

        //echo '<pre>';
        //print_r($this->proformy_dane);


        if (mysql_num_rows($this->db_query_p) > 0)
            return $this->proformy_dane;
        else
            return false;
    }
	


    public function proformy_mail_zapisz($id_proforma, $email, $betaald = null) {

		
	//$this->proform_ilosc_maili($id_proforma, $email, $betaald = null)

        $temat = 'Herinnering over het betalen van KH Bemiddeling';

        $tresc = '
					Beste <br><br>
					We herinneren u aan de betaling van het proforma nummer: ' . $id_proforma . '<br />
					Factuur proforma kan door te klikken op de link gedownload worden.<br /><br />
								
					<a href="http://www.khbemiddeling.nl/bedrijf/proforma_mail.php?id=' . $id_proforma . '">http://www.khbemiddeling.nl/bedrijf/proforma_mail.php?id=' . $id_proforma . '</a><br /><br />
					
					met vriendelijke groet <br />
					KHBemiddeling';


        $this->wyslij_email(str_replace(' ', '', $email), $temat, $tresc);


        mysql_query("INSERT INTO `bedrijf_proformy_maile` (`proforma_id`, `data_czas`) VALUES (" . $id_proforma . ", '" . date('Y-m-d H:i:s') . "') ") or die(mysql_error());
    }
	

    public function proformy_mail() {

        //$dzis = date('Y-m-01');
		
		$dzis = date('Y-m-d');

        //$date = new DateTime($dzis);
        //$date->modify('-7 days');
        //$dni7_wczesniej =  $date->format('Y-m-d');
        //echo $dni7_wczesniej;
  
        $this->db_query_m = mysql_query("SELECT `id`, `email` FROM `bedrijf_proformy` WHERE `wplata_data` = '0000-00-00' AND `data_proformy` <= '" . $dzis . "' ");
		
		//$this->db_query_m = mysql_query("SELECT `id`, `email` FROM `bedrijf_proformy` WHERE `wplata_data` = '0000-00-00' AND `data_proformy` <= '" . $dzis . "' AND id = 257");    
  
   
        while ($res = mysql_fetch_array($this->db_query_m)) {

            $this->proformy_maile[] = $res; 
        }



        if (mysql_num_rows($this->db_query_m) > 0)
            return $this->proformy_maile;
        else
            return false;
    }
	
	
	public function proform_ilosc_maili($id_proforma) {
		
		$dzis = date('Y-m-d');
		
		$this->db_query_m = mysql_query("SELECT `id` FROM `bedrijf_proformy_maile` WHERE `proforma_id` =  ".$id_proforma." ");


        while ($res = mysql_fetch_array($this->db_query_m)) {
	
			
				$this->ilosc_maili++;
	
		}
		
		return $this->ilosc_maili;
	
	}	 
	
	

    public function proformy_mail_wyslij($email, $proforma_id, $betaald = null, $wystaw_i_wyslij = null) {
		
		
		if(!empty($betaald)){
			

			
			if($betaald == 1){
				$temat = 'BETALINGSHERINNERING - proforma factuur van KH Bemiddeling';

				$tresc = '
							Beste <br><br>
							In de bijlage kunt u de proforma factuur inzien en uitprinten.<br /><br />
										
							
							met vriendelijke groet <br />
							KHBemiddeling';
		 
				
				
				$proforma_pdf = 'upload/proformy/KH-00'.$proforma_id.'-1.pdf';
			}
			
			if($betaald == 2){
				$temat = 'AANMANING - proforma factuur van KH Bemiddeling'; 

				$tresc = '
							Beste <br><br>
							In de bijlage kunt u de proforma factuur inzien en uitprinten.<br /><br />
										
							
							met vriendelijke groet <br />
							KHBemiddeling';
		 
				
				
				$proforma_pdf = 'upload/proformy/KH-00'.$proforma_id.'-2.pdf';
			}
		
		
		}
		
		else{
		
	
			$temat = 'proforma Factuur van KH Bemiddeling';

			$tresc = '
						Beste <br><br>
						In de bijlage kunt u de proforma factuur inzien en uitprinten.<br /><br />
									
						
						met vriendelijke groet <br />
						KHBemiddeling';
			$proforma_pdf = 'upload/proformy/KH-00'.$proforma_id.'.pdf';
			
			$proforma1 = file_exists($proforma_pdf); 

			if (!$proforma1 && $wystaw_i_wyslij){
				$pr = new ProformaPdf();
				$pr -> ProformaMakePdf($proforma_id);
			}
	 
		}
		
			$mail = new conf();

			//$mail -> wyslij_email(str_replace(' ', '', $email), $temat, $tresc);
			$pocztaKlient = str_replace(' ', '', $email);
			
		
		
		
		
		
        $mail->wyslij_maila_smtp($pocztaKlient, $temat, $tresc, $mail->baza_dane_firmy(), $proforma_pdf);
		


        mysql_query("INSERT INTO `bedrijf_proformy_maile`(`proforma_id`, `data_czas`) VALUES (" . $proforma_id . ", '" . date('Y-m-d H:i:s') . "') ") or die(mysql_error());

        $msg = 'E-mail was verstuurd.';
        //header('Location:proformy.php?msg=' . $msg);
    
	}

    public function historia_maili($proforma_id) {


        $this->db_query = mysql_query("SELECT * FROM `bedrijf_proformy_maile` WHERE `proforma_id` = " . $proforma_id . " ORDER BY `data_czas` ASC");


        while ($res = mysql_fetch_array($this->db_query)) {


            $this->historia_maili[] = $res['data_czas'];
        }

        return $this->historia_maili;
    }

}

?>