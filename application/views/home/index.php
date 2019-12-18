<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>


<?=add_metatags()?>

<?=add_title("Design Klasy biznes - SuperCMS")?>

<?=add_basehref()?>

<?=stylesheet_load('screen.css,sidebar.css')?>

<?=javascript_load('jQuery.js,script.js,jquery.localscroll-1.2.5.js,coda-slider.js?no_compress,jquery.scrollTo-1.3.3.js,jquery.serialScroll-1.2.1.js,main.js,sidebar.js')?> 
    
<?=icon_load("pp_fav.ico")?>

</head>

<body>
 
<?=module_load('SIDEBAR')?>
<div id="content">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">

        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
            <span>X</span>
        </button>
        <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-align-justify"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Page</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Page</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Page</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Page</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<h2>Collapsible Sidebar Using Bootstrap 4</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

<div class="line"></div>

<h2>Lorem Ipsum Dolor</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

<div class="line"></div>

<h2>Lorem Ipsum Dolor</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

<div class="line"></div>

<h3>Lorem Ipsum Dolor</h3>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
</div>
</div>
<?=module_load('FOOTER')?>

</body>
</html>

<div id="content" class="tabela-mansys overige-inkomsten-mansys">
	<div class="srodek">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="navbar-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                   
				<a class="drukuj" href="javascript:drukuj()"></a>
                </div>
            </nav>
	<div class="wmiejscu_gora2">';
if (isset($_GET['wijze_van_betaling']))
echo '

<h1>'.Overige_Inkomsten.' - <span style="color:red;">'.strtoupper($_GET['wijze_van_betaling']).'</span></h1>';
else
	
	if($_GET['od'])
	echo '<a href="index.php?od='.$_GET['od'].'&do='.$_GET['do'].'" class="dodaj" >'.Terug.'</a>';

echo '

<h1>'.Overige_Inkomsten.'</h1>
<div>';

echo '

<div>

<form style="width:100%" action="" method="post" >
<div class="row d-flex m-0 p-0 justify-content-md-between">

	<div class="col-xl-3 m-0 p-0 mt-2">
	<div class="d-flex justify-content-end justify-content-sm-center justify-content-md-center align-items-center">
		<div>'.Woord.'</div>
		<div class="pole_1"><input type="text" class="pole" name="adres" ></div>
		<div class="pole_3"><input type="submit" name="szukaj2" value="'.Zoeken.'" class="button_bootstrap" /></div>
	</div>
	</div>
</form>

<div class="col-xl-3 m-0 p-0 mt-2">
<form action="" method="post">

	
	<div class="d-flex justify-content-end justify-content-md-center justify-content-sm-center justify-content-lg-center align-items-center">
                
		<div class="pole_1">'.Vanaf.'</div>
		<div class="pole_2"><input type="text" class="datepicker" name="vanaf" style="height:20px;" value="'.$od.'"></div>
		<div class="pole_3">'.Tot.'</div>
		<div class="pole_4"><input type="text" class="datepicker" name="tot" style="height:20px;" value="'.$do.'"></div>
		<div class="pole_5"><input type="submit" name="szukaj_wg_daty" value="'.Zoeken.'" class="button_bootstrap" /></div>
	
	';
	
	echo	'
</div>	
			</form>
			
	
</div>
			';
			
		

if (isset($_POST['szukaj'])) {
	
	
	
	$query_search = mysql_query("SELECT * FROM `adresy` WHERE `miasto` LIKE '%".$_POST['adres']."%' OR `adres` LIKE '%".$_POST['adres']."%' ORDER BY `miasto` ASC");
	
	
       if(mysql_num_rows($query_search) < 1){		
		echo '<span class="wynik_wyszukiwania"><a href="wplaty.php" class="button_mini" style="color:black;margin-top: 5px;float: left;" >'.Clear.'</a></span><br/>'.Geen_resultaat.'<br/><br/>';
		}
		else {
		
	
		
	echo '
	</div>
	<span class="wynik_wyszukiwania"><a href="wplaty.php" class="button_mini" style="color:black; color:black;margin-top: 5px;float: left;" >'.Clear.'</a></span> <table width="100%" CELLPADDING="2px" class="tabela">
	<table width="67%" CELLPADDING="2px" class="wmiejscu">
	<tr class="tytul">
	<td  style="width:5%;">'.Id.'</td><td style="width:15%;">'.Stad.'</td><td  style="width:40%;">'.Adres.'</td><td  style="width:12%;">'.Waarvoor.'</td> <td  style="width:13%;">'.Bedrag.'</td><td  style="width:5%;">'.Factuur.'</td> <td style="width:10%;">'.Datum.'</td> <td style="width:5%;">'.Action.'</td>
	</tr>
	</table>
	<table width="77%" CELLPADDING="2px" class="tabela">';
	
	$suma  = 0;
	$suma2 = 0;
	
	while ($wplata = mysql_fetch_array($query_search)) {
	
	$query_adres = mysql_query("SELECT `adres`, `miasto` FROM `adresy` WHERE `id` = '".$wplata['adres_id']."' ");
	$adres = mysql_fetch_array($query_adres);
	
	if($kwota_[$wplata['id']])
	$suma2 += $kwota_[$wplata['id']];
	
	elseif($wplata['oplacona'] == 1)
	$suma += $wplata['kwota'];
	
	if($_GET['inkomsten'] && $kwota_[$wplata['id']] > 0){
	echo '<tr>
	<td class="body-cell col1"><a href="wplata.php?wplata_id='.$wplata['id'].'">'.$wplata['id'].'</td>
	<td class="body-cell col2"><a href="wplata.php?wplata_id='.$wplata['id'].'">'.$wplata['adres_id'].'</a></td>
	<td class="body-cell col3"><a href="wplata.php?wplata_id='.$wplata['id'].'">';
	
	if($wplata['tytul'])
	echo $wplata['tytul'];
	else
	echo $adres['adres'];
	
	echo '</a></td>
	<td class="body-cell col4"><a href="wplata.php?wplata_id='.$wplata['id'].'">';
	switch ($_GET['inkomsten']) {
				case 24:
				echo 'Huur';
				break;
				
				case 20:
				echo 'Administariekosten ';
				break;
				
				case 19:
				echo 'GE';
				break;
				
				case 21:
				echo 'Water';
				break;
				
				case 50:
				echo 'Water_9';
				break;
				
				case 13:
				echo 'Internet';
				break;
				
				case 18:
				echo 'Borg';
				break;
				
				case 33:
				echo 'Boete';
				break;
				
				}
			($_GET['inkomsten'] > 0 )? $b = $kwota_[$wplata['id']] : $b = $wplata['kwota'];
		
	echo '</a></td>
	<td  class="body-cell col5"><a href="wplata.php?wplata_id='.$wplata['id'].'">€ '.number_format(($_GET['inkomsten'] > 0 )? $kwota_[$wplata['id']] : $wplata['kwota'], 2, ',', '. ').'</a></td>
	<td class="body-cell col6"><a href="../faktura.php?id='.$wplata['faktura_nr'].'">'.$wplata['faktura_nr'].'</a></td> 
	<td class="body-cell col7"><a href="wplata.php?wplata_id='.$wplata['id'].'">'.$data_nl->zmiana_formatu_daty($wplata['data']).'</a></td>
	<td class="body-cell col8">';
	
		
	echo '
		  <a class="usun" href="?action=delete&id='.$wplata['id'];
		  
		  if($wplata['faktura_nr'] !=0)		  
		  echo '&faktura_nr='.$wplata['faktura_nr'];
		  
		  echo '" onclick="return confirm(\'Of verwijderen inkomst '.$wplata['id'].'?\')"></a>';	 
	
	
	
	echo '</td><td class="body-cell col9"></td>
	</tr>';
	}
	
	elseif(empty($_GET['inkomsten'])){
	echo '<tr>
	<td><a id="'.$wplata['id'].'" href="wplata.php?wplata_id='.$wplata['id'].'">'.$wplata['id'].'</td>
	<td><a href="wplata.php?wplata_id='.$wplata['id'].'">'.$adres['miasto'].'</a></td>
	<td><a href="wplata.php?wplata_id='.$wplata['id'].'">';
	
	if($wplata['tytul'])
	echo $wplata['tytul'];
	else
	echo $adres['adres'];
	
	echo '</a></td>
	<td><a href="wplata.php?wplata_id='.$wplata['id'].'">'.$waar->waarvoor($wplata['waarvoor_id']).'</a></td>
	<td class="do_prawej"><a href="wplata.php?wplata_id='.$wplata['id'].'">€ '.number_format($wplata['kwota'], 2, ',', '. ').'</a></td><td><a href="../faktura.php?id='.$wplata['faktura_nr'].'">'.$wplata['faktura_nr'].'</a></td> <td><a href="wplata.php?wplata_id='.$wplata['id'].'">'.$data_nl->zmiana_formatu_daty($wplata['data']).'</a></td>
	<td>';
	
		
	echo '
		  <a  class="usun" href="?action=delete&id='.$wplata['id'];
		  
		  if($wplata['faktura_nr'] !=0)		  
		  echo '&faktura_nr='.$wplata['faktura_nr'];
		  
		  echo '
		  " onclick="return confirm(\'Of verwijderen inkomst '.$wplata['id'].'?\')"></a>';	 
	
	
	
	echo '</td>
	</tr>';