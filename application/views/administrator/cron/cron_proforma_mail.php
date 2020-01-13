<?php

$maile = model_load('proformamodel', 'getProformaForCron', '');

$ilosc_maili = 0;

foreach($maile as $q){
    $ileMaili = model_load('proformamodel', 'proform_ilosc_maili', $q['id']);
    $x = array($q['id'], $q['proforma_numer']);
    if($ileMaili <= 2) {
        model_load('proformamodel', 'sendproforma', $x);
    }
}
?>