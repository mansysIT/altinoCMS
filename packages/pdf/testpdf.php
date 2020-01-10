<?php
require('fpdf.php');

$pdf = new FPDF();
$pdf->AddFont('ArialMT','','arial.php');
$pdf->AddPage();
$pdf->SetFont('ArialMT','',12);

$pdf->Image('logo.png',30,15,25);
$pdf->SetX(160);
$nr='AL10-12523';

$pdf->SetFont('ArialMT','',14);
$pdf->Cell(0,0,'Factuur: '.$nr,0,1);
$pdf->SetY(45);
$pdf->SetFont('ArialMT','',17);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0,5,'Korpalhuizenbemiddeling',0,1);
$pdf->SetFont('ArialMT','',10);

$pdf->Cell(0,5,'De Pellenwever 98',0,1);
$pdf->Cell(0,5,'5283XN Boxtel',0,1);
$pdf->Cell(0,5,'Tel: 06-42665647',0,1);
$pdf->Cell(0,5,'info@khbemiddeling.nl',0,1);
$pdf->Cell(0,5,'KvK: 52409694',0,1);
$pdf->Cell(0,5,'BTW: NL229720377B01',0,1);
$pdf->Cell(0,5,'Rabobankreknr.: 152307478',0,1);



$pdf->SetXY(130,45);
$pdf->SetFont('ArialMT','',12);
$pdf->Cell(0,5,'Factuur voor:',0,1);
$pdf->SetX(130);
$nazwa='Huizen';

$adres='Prins Alexanderweg 56';
$pdf->Cell(0,5,''.$nazwa,0,1);
$pdf->SetX(130);
$pdf->Cell(0,5,''.$adres,0,1);

$pdf->SetY(120);
$date=date('d-m-Y');
$pdf->SetFillColor(39, 193, 60);
$pdf->Cell(0,5,'Factuur: '.$nr.' van '.$date,1,1,1,true);

$order=15;
$pdf->Cell(100,10,'order: '.$order,1,1);

$pdf->SetXY(110,125);
$betaalmethode='iDEAL';
$pdf->Cell(90,10,'Betaalmethode: '.$betaalmethode,1,1);
//$pdf->Output('plik.pdf','D');

$dom='Smidshof 32, Vught';

$pdf->SetY(150);


$pdf->Cell(0,5,'Beschrijving                                                                       Prijs (EUR)              Antaal       Totaal (EUR)',T,1,1,true);
$pdf->Cell(0,5,'Reservering van '.$dom,0,1);

$pdf->SetXY(120,155);
$pdf->Cell(0,5,'500,00                       1                  500,00',0,1);
$pdf->Line(10,160,200,160);



$pdf->Line(150,200,200,200);
$pdf->SetXY(155,200);
$pdf->SetFont('ArialMT','',9);
$pdf->Cell(0,10,'Subtotaal (EUR)          420,17',0,1);
$pdf->SetX(150);
$pdf->SetFont('ArialMT','',7);
$pdf->Cell(0,5,'   19% BTW over   (EUR)                 79,83',0,1);
$pdf->Line(150,220,200,220);
$pdf->SetXY(150,220);
$pdf->SetFont('ArialMT','',9);
$pdf->Cell(0,5,'Totaal incl. BTW (EUR)      500,00',T,1,1,true);

$pdf->SetY(270);
$pdf->Line(10,265,200,265);
$pdf->Cell(30,5,'KvK 50699466',1,1);
$pdf->SetXY(80,270);
$pdf->Cell(40,5,'Rabobank 15.23.07.478',1,1);
$pdf->SetXY(160,270);
$pdf->Cell(40,5,'BTW NL268218407.B.01',1,1);

$pdf->Output();
?>