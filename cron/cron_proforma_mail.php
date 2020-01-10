<?php
ini_set( 'display_errors', 'On' ); 
error_reporting( E_ALL );

require_once('../connect.php');
require_once('../include/module/admin/conf.class.php');
require_once('../include/module/admin/proforma.class.php');
require_once('../include/module/admin/proforma.pdf.class.php');
require_once('../include/module/pdf/fpdf.php');

$maile = new proforma();

$ilosc_maili = 0;
//echo 'jest<pre>'; print_r($maile->proformy_mail());

foreach($maile->proformy_mail() as $v){
	echo $v['id'].'-'.$v['email'].'<br>';
	
	
	$p = new proforma();
	//echo $p->proform_ilosc_maili($v['id']);
	
	
	$ilosc_maili = $p->proform_ilosc_maili($v['id']);
	
	echo $ilosc_maili; 
	
	if($ilosc_maili >= 1 && $ilosc_maili <= 2 && !empty($v['id'])){ 
	
			if($ilosc_maili == 1){
				
				//echo 'aaa1';
				$pr = new ProformaPdf();
				$pr -> ProformaMakePdf($v['id'],1); 
			}
			
			if($ilosc_maili == 2){ 
				
				//echo 'aaa';
				
				$pr = new ProformaPdf();
				$pr -> ProformaMakePdf($v['id'],2);
			}	 
		 
		  
		//$maile->proformy_mail_zapisz($v['id'], $v['email']);   
		
		$maile->proformy_mail_wyslij($v['email'], $v['id'], $ilosc_maili);     
		
	}
	
}

if(isset($_GET['url']) == 'ustawienia.php'){
		$msg='Taak voltooid: Proforma mail';
		header('Location: ustawienia.php?navs=Automatische&msg='.$msg);
	}
?>