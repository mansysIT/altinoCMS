<?php


$id=$_GET['id'];
// MaNSyS - skrypt tworzacy faktur w pdf
$serwer  = "23105.m.tld.pl";  // nazwa serwera mysql
$login   = "admin23105_khbemiddeling";  // login do bazy
$haslo   = "hNfvdud1vhf";  // haslo do bazy
$baza    = "baza23105_khbemiddeling";  // nazwa bazy
$tabela  = "bs_customer";  // nazwa tabeli
$prefiks = "n3";     //pefiks do tabel


// czymy si z baz danych
$polacz = mysql_connect($serwer, $login, $haslo) or die(mysql_error());
$db = mysql_select_db($baza, $polacz) or die(mysql_error());

//WAZNE !!! - ustawienie kodowania po³aczenia z MySQL dzieki czemu wyswietlane sa polskie litery
mysql_query("SET NAMES 'latin2'");
 

// laczymy si z baza danych
  if (mysql_connect($serwer, $login, $haslo) and mysql_select_db($baza)) {
   // zapytanie do bazy danych
	$wynik = mysql_query("SELECT id, imie, nazwisko, ulica, kod_pocz, miasto, data_dod, email, rezerwacja, amount, faktura_nr FROM n3_ideal_orders WHERE faktura_nr=$id")
		or die("Bad w zapytaniu!");
        mysql_close();
    }

else echo "Nie moge polczyc sie z baza danych!";

    // wyswietlany wyniki zapytania
    while($rek = mysql_fetch_array($wynik)) {
    $polacz = mysql_connect($serwer, $login, $haslo) or die(mysql_error());
	mysql_query('SET NAMES \'utf8\' COLLATE \'utf8_unicode_ci\';', $polacz);
	
        $email=$rek['email'];
		$imie=$rek['imie'];
		$nazwisko=$rek['nazwisko'];
		$data_dod=$rek['data_dod'];
		$rezerwacja=$rek['rezerwacja'];
		$nr_zamow=$rek['id'];
		$ulica=$rek['ulica'];
		$kod_pocz=$rek['kod_pocz'];
		$miasto=$rek['miasto'];
		$faktura_nr=$rek['faktura_nr'];
		$kwota=$rek['amount'];
   mysql_close();

    }

if ($id==$faktura_nr){

require('fpdf.php');

$pdf = new FPDF();
$pdf->AddFont('ArialMT','','arial.php');
$pdf->AddPage();
$pdf->SetFont('ArialMT','',12);



$pdf->Image('logo.png',7,10,75);
$pdf->SetX(160);
$nr='AL-00'.$id;

$pdf->SetFont('ArialMT','',14);
$pdf->Cell(0,0,'Factuur: '.$nr,0,1);
$pdf->SetY(45);
$pdf->SetFont('ArialMT','',17);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0,5,'KH Bemiddeling',0,1);
$pdf->SetFont('ArialMT','',10);

$pdf->Cell(0,5,'De Pellenwever 98',0,1);
$pdf->Cell(0,5,'5283XN Boxtel',0,1);
$pdf->Cell(0,5,'Tel: 06-42665647',0,1);
$pdf->Cell(0,5,'info@khbemiddeling.nl',0,1);
$pdf->Cell(0,5,'KvK: 73523097',0,1);
$pdf->Cell(0,5,'BTW: NL852307342B01',0,1);
$pdf->Cell(0,5,'IBAN: NL29RABO0152307478',0,1);



$pdf->SetXY(130,45);
$pdf->SetFont('ArialMT','',12);
$pdf->Cell(0,5,'Factuur voor:',0,1);
$pdf->SetX(130);



$pdf->Cell(0,5,''.$imie.' '.$nazwisko,0,1);
$pdf->SetX(130);
$pdf->Cell(0,5,''.$ulica,0,1);
$pdf->SetX(130);
$pdf->Cell(0,5,''.$kod_pocz,0,1);
$pdf->SetX(130);
$pdf->Cell(0,5,''.$miasto,0,1);


$pdf->SetY(120);
$date=substr ($data_dod, 0, 10) ;
$pdf->SetFillColor(248, 107, 107);
$pdf->Cell(0,5,'Factuur: '.$nr.' van '.$date,1,1,1,true);


$pdf->Cell(100,10,'Order: '.$nr_zamow,1,1);

$pdf->SetXY(110,125);
$betaalmethode='iDEAL';
$pdf->Cell(90,10,'Betaalmethode: '.$betaalmethode,1,1);


$cena=$kwota/100;

$pdf->SetY(150);


$pdf->Cell(0,5,'Beschrijving                                                                       Prijs (EUR)              Antaal       Totaal (EUR)',T,1,1,true);
$pdf->Cell(0,5,'Registratie op de website',0,1);

$pdf->SetXY(120,155);
$pdf->Cell(0,5,''.$cena.',00                       1                  '.$cena.',00',0,1);
$pdf->Line(10,160,200,160);

$cena_bez=$cena/1.21;

$btw=$cena-$cena_bez;

$pdf->Line(150,200,200,200);
$pdf->SetXY(155,200);
$pdf->SetFont('ArialMT','',9);
$pdf->Cell(0,10,'Subtotaal (EUR)          '.round($cena_bez, 2),0,1);
$pdf->SetX(150);
$pdf->SetFont('ArialMT','',8);
$pdf->Cell(0,5,'   21% BTW over   (EUR)       '.round($btw, 2),0,1);
$pdf->Line(150,220,200,220);
$pdf->SetXY(150,220);
$pdf->SetFont('ArialMT','',9);
$pdf->Cell(0,5,'Totaal incl. BTW (EUR)      '.$cena.',00',T,1,1,true);

$pdf->SetY(270);
$pdf->Line(10,265,200,265);
$pdf->Cell(30,5,'KvK 73523097',1,1);
$pdf->SetXY(80,270);
$pdf->Cell(50,5,'IBAN: NL29RABO0152307478',1,1);
$pdf->SetXY(160,270);
$pdf->Cell(40,5,'BTW NL852307342B01',1,1);


$pdf->Output('faktura-'.$nr.'.pdf','D');
}

?>