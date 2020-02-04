
<h1 style="border-bottom:none;"><?php
    echo 'Adres';
    if ($_GET['adres_id'])
        echo ' - ' . $conf->pobierz("miasto") . ', ' . $conf->pobierz("adres");
    ?>
</h1>

<script>

    function getCookie1(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }


    function checkCookie1() {
        var user = getCookie("plik1");
        if (user == "1") {
            setCookie("plik1", 0, 1);

            //alert("Welcome again " + user);
            //openCity(event, 'pliki');
            document.getElementById('huurder').style.display = "none";


            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById('huurder').className.replace(" active", "");
            document.getElementById('pliki').style.display = "block";
            document.getElementByName('box_pliki').className += " active";


            //document.getElementByName("box_pliki").click();



        }
    }
</script>

<?php
setcookie('powrot', $_GET['adres_id'], time() + (3600), '/');
?>

<ul class="tab">
    <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'huurder');" <?php if ($_GET['zak'] != 'inspectie' && $_GET['zak'] != 'berichten' && $_GET['zak'] != 'details' ) echo 'id="defaultOpen"'; ?>>NAJEMCA</a></li>
    <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'eigenaar');"  >WŁAŚCICIEL</a></li>
    <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'inspectie');" <?php if ($_GET['zak'] == 'inspectie') echo 'id="defaultOpen"'; ?> >INSPEKCJA</a></li>
    <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'berichten');" <?php if ($_GET['zak'] == 'berichten') echo 'id="defaultOpen"'; ?>  >WIADOMOŚCI</a></li>
	<!--
    <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'pliki');" <?php if ($_GET['zak'] == 'pliki1' ) echo 'id="defaultOpen"'; ?> >WIADOMOŚCI</a></li>
    
    <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'inspectie');" <?php if ($_GET['zak'] == 'inspectie') echo 'id="defaultOpen"'; ?> >INSPECTIE</a></li>
    <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'stat');setCookie('plik1',0,30);"  >BORG/STAT</a></li>
          
    
    <?php
    if ($_GET['adres_id']) {
        echo "<li><a href=\"javascript:void(0)\" class=\"tablinks\" onclick=\"openCity(event, 'details');\"";
        if ($_GET['zak'] == 'details')
            echo 'id="defaultOpen"';
        echo '>DETAILS</a></li>';
    }
    ?>
    -->
</ul>

<div id="huurder" class="tabcontent flex-container">
    <div class="lewa_strona">
    <form action="" method="post" enctype="multipart/form-data">
        <table>
            <tbody>
                <tr>
                    <td><?php echo '' . Ulica . ''; ?>
                    </td>
                    <td>
                        <textarea style="height:70px;width: 170px;" name="adres"><?php echo $conf->pobierz("adres"); ?></textarea>
                    </td>
                </tr> 
                <tr>
                    <td><?php echo 'Kod pocztowy'; ?>
                    </td>
                    <td>
                        <input class="pole" type="text" name="kod" value="<?php echo $conf->pobierz("kod"); ?>">
                    </td>
                </tr>	
                <tr>
                    <td><?php echo '' . Miasto . ''; ?></td>
                    <td>
                        <input class="pole" type="text" name="miasto" value="<?php echo $conf->pobierz("miasto"); ?>">
                    </td>
                </tr>	
                <tr>
                    <td><?php echo '' . Huur . ''; ?>
                    </td>
                    <td>
                        <input class="pole" style="width:55px" type="text" name="huur_huurder" value="<?php echo $wplaty_adresy->pobierz("huur_huurder"); ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo '' . Borg . ''; ?>
                    </td>
                    <td>
                        <input class="pole" style="width:55px" type="text" name="borg_huurder" value="<?php echo $wplaty_adresy->pobierz("borg_huurder"); ?>">
                        <select name="borg_oplacony" >
                            <?php
                            if ($wplaty_adresy->pobierz("borg_oplacony") == 1) {
                                echo '
									<option value="1">' . zaplacono . '</option>
									<option value="0">' . nie_zapłacono . '</option>
					';
                            } else {
                                echo '
									<option value="0">' . nie_zapłacono . '</option>
									<option value="1">' . zaplacono . '</option>
					';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?php echo '' . Administratiekosten . ' (21%)'; ?>
                    </td>
                    <td>
                        <input class="pole" style="width:55px" type="text" name="admin_huurder" value="<?php echo $wplaty_adresy->pobierz("admin_huurder"); ?>">
                        <select name="admin_oplacony" >
                            <?php
                            if ($wplaty_adresy->pobierz("admin_oplacony") == 1) {
                                echo '
									<option value="1">' . zaplacono . '</option>
									<option value="0">' . nie_zapłacono . '</option>
					';
                            } else {
                                echo '
									<option value="0">' . nie_zapłacono . '</option>
									<option value="1">' . zaplacono . '</option>
					';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?php echo '' . GE . ' (21%)'; ?>
                    </td>
                    <td>
                        <input class="pole" style="width:55px" type="text" name="ge_huurder" value="<?php echo $wplaty_adresy->pobierz("ge_huurder"); ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo '' . Water . ' (6%)'; ?></td>
                    <td>
                        <input class="pole" style="width:55px" type="text" name="water_huurder" value="<?php echo $wplaty_adresy->pobierz("water_huurder"); ?>">
                    </td>
                </tr>	
                <tr>
                    <td><?php echo '' . Internet . ' (21%)'; ?>
                    </td>
                    <td>
                        <input class="pole" style="width:55px" type="text" name="internet_huurder" value="<?php echo $wplaty_adresy->pobierz("internet_huurder"); ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo '' . Imię . ''; ?></td>
                    <td>
                        <input class="pole" type="text" name="imie" value="<?php echo $conf->pobierz("imie"); ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo '' . Nazwisko . ''; ?>
                    </td>
                    <td>
                        <input class="pole" type="text" name="nazwisko" value="<?php echo $conf->pobierz("nazwisko"); ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo '' . Tel . ''; ?>
                    </td>
                    <td>
                        <input class="pole" type="tel" name="tel" value="<?php echo $conf->pobierz("tel"); ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo '' . Email . ''; ?></td>
                    <td>
                        <input class="pole" type="text" name="email" value="<?php echo $conf->pobierz("email"); ?>">
                    </td>
                </tr>
                <!--
                <tr>
                        <td><?php echo '' . Sleutels . ''; ?></td>
                        <td>
                                <input class="pole" type="text" name="klucze" value="<?php echo $conf->pobierz("klucze"); ?>">
                        </td>
                </tr>	
                
                -->
                <tr>
                    <td>Kara od
                    </td>
                    <td>
                        <input type="text" name="data_boete" class="datepicker" value="<?php echo $data_nl->zmiana_formatu_daty($wplaty_adresy->pobierz("data_boete")); ?>">
                    </td>
                </tr>	
                <!--
                <tr>
                        <td><?php echo '' . Contract_tot . ''; ?></td>
                        <td>
                                <input type="text" name="data" class="datepicker" value="<?php echo $data_nl->zmiana_formatu_daty($conf->pobierz("data")); ?>">
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        
                </tr>
                
                <tr>
                        <td><?php echo '' . Nieuwe_tarieven_vanaf . ''; ?></td>
                        <td>
                                <input type="text" name="nowa_vanaf" class="datepicker" value="">
                        </td>
                        <td>
                <?php
                if ($wplaty_adresy->pobierz("od_nowa") == 1)
                    echo $wplaty_adresy->pobierz("od_kiedy");
                ?>
                        
                        </td>
                        <td>
                        </td>
                        
                </tr>
                -->
                <tr>
                    <td><?php echo '' . Kontrakt . ''; ?>
                    </td>
                    <td>
                        <input type="hidden" name="MAX_FILE_SIZE" /> 
                        <input name="plik" type="file" /> 
                    </td>
                    <td>
                    </td>
                    <td>
                        <?php
                        if ($conf->pobierz("plik"))
                            echo '<a href="../admin/upload/' . $conf->pobierz("plik") . '">' . pobierz_kontrakt . '</a>';
                        ?>
                    </td>
                </tr>
                <tr>
                    <?php
                    if (empty($_GET['adres_id'])) {
                        echo '<td>' . Od . '</td>
									<td>
									<input type="text" name="vanaf_klaant" class="datepicker" value="' . date('d-m-Y') . '">
									</td>';
                    } else {
                        echo '<td>
								</td>
								<td>
								</td>';
                    }
                    ?>
                </tr>
                <tr>
                    <td></td>
<?php
if ($user->userInfo('ranga') == 2)
    echo '<td>
							<input type="submit" name="save" value="Zapisz" class="button_mini" />
						</td>';
?>
                </tr>
            </tbody>
        </table>
        
    
    </div>


<div id="pliki_najemca" class="prawa_strona">
<?php
if ($_GET['adres_id']) {
    if (!$_GET['katalog']) {
        echo '
	<h2>KATALOGI</h2>
	<form method="post" action="">
        <div class="nowy_map">
        <div class="srodek">
			<label>Nowy katalog</label>
			<input type="text" name="nazwa_folderu" size="10" maxlength="30" style="width: 200px;color: rgb(102, 102, 102);border: 1px solid rgb(204, 204, 204);
    padding: 7px;">
			<input type="submit" name="utworz_katalog" value="ZAPISZ">
</div></div>	
</form>';

        echo '
	<div>
	<ul style="width:100%;">
			
			';
        //path to directory to scan
        $directory = "upload/" . $_GET['adres_id'] . "/";


        //get all files in specified directory
        $files = glob($directory . "*");

        //print each file name
        foreach ($files as $file) {
            //check to see if the file is a folder/directory
            if (is_dir($file)) {
                $katalog1 = explode('/', $file);
                echo '<li style="min-width: 110px;float: left;text-align: center;list-style: outside none none;">
	<a style="font-size: 17px;" href="?adres_id=' . $_GET['adres_id'] . '&katalog=' . $katalog1[2] . '"><img src="../themes/admin/img/folder1.png" style="padding: 15px 0px 0px;width: 50px;" /></a>
	<p>
	<a style="font-size: 17px;" href="?adres_id=' . $_GET['adres_id'] . '&katalog=' . $katalog1[2] . '">' . $katalog1[2] . '</a>
	</p>
	<a class="usun" style="margin-left: 45px;margin-top: 15px;" href="?adres_id=' . $_GET['adres_id'] . '&usun=' . $katalog1[2] . '"></a></li>';
            }
        }

        echo '
		
		</ul>
	</div>';
    } else {

        //$kat = $_GET['katalog'];
        //setcookie('pliki', 1, time() + (3600), '/');
    

    echo '
	
	<div style="clear:both;"></div>
	<div id="dokumenty">
	<h2>PLIKI ';

    if ($_GET['katalog'])
        echo 'Z ' . $_GET['katalog'] . ' <a style="color:#d47519;font-size:12px" href="http://www.sewmar.nl/system/admin/adres.php?adres_id='.$_GET['adres_id'].'">WYJDZ</a></h2> ';
    else
        echo '</h2>';


    echo '
	<table  style="display: block;clear: both;margin: 70px 0px 0px;width:100%;">';

    //path to directory to scan
    $directory = 'upload/' . $_GET['adres_id'] . '/' . $_GET['katalog'] . '/';

    //get all files in specified directory
    $files1 = glob($directory . "*");

    //print each file name
    foreach ($files1 as $k => $file1) {
        //check to see if the file is a folder/directory
        if (!is_dir($file1)) {
            $plik = explode('/', $file1);


            if ($k % 2 == 0)
                echo '<tr class="druga">';
            else
                echo '<tr>';

            echo '
	
	<td class="plik" style="text-align:left;"><form action="" method="post" enctype="multipart/form-data">
	<a href="upload/' . $_GET['adres_id'] . '/' . $_GET['katalog'] . '/' . $plik[3] . '">' . $plik[3] . '</a>
	</td>
	<td>
	<input type="hidden" name="plik_do_skasowania" value="' . $plik[3] . '" />';
            if ($user->userInfo('ranga') == 2)
                echo '<input class="usun" type="submit" name="kasuj_plik" value="" />';

            echo
            '</form>
	</td>
	</tr>';
        }
    }



    echo '</table>
	
	</div>
	
	
	';

    if ($user->userInfo('ranga') != 2) {
        echo '';
    }

    if ($user->userInfo('ranga') == 2) {
        echo '<form action="" method="post" enctype="multipart/form-data" style="margin-top:30px">
		<p>
		<input type="file" name="pictures[]" />
		<input type="submit" style="margin-top: 0px;" name="wyslij_pliki" value="ZAPISZ" />
		</p>
	 </form>';
    }
    
    }
}

//if($_COOKIE['pliki'] == 1)
//setcookie('pliki', 0, time() + (3600), '/');




if ($_COOKIE['katalog'] == 1)
    setcookie('katalog', 0, time() + (3600), '/');


if ($_GET['katalog'])
    setcookie('katalog', 1, time() + (3600), '/');
?>

</div>
</div>

<!-- Koniec najemca -->

<div id="eigenaar" class="tabcontent">


    <ul>











        <li class="li_tyt"><?php echo '' . Huur . ''; ?></li>
        <li>
            <input class="pole" style="width:55px" type="text" name="huur" value="<?php echo $wyplaty_adresy->pobierz("huur"); ?>">
        </li>


        <li class="li_tyt"><?php echo '' . Borg . ''; ?></li>
        <li>
            <input class="pole" style="width:55px" type="text" name="borg" value="<?php echo $wyplaty_adresy->pobierz("borg"); ?>">
        </li>



        <li class="li_tyt"><?php echo '' . GE . ' (21%)'; ?></li>
        <li>
            <input class="pole" style="width:55px" type="text" name="overige" value="<?php echo $wyplaty_adresy->pobierz("overige"); ?>">
        </li>




        <li class="li_tyt"><?php echo '' . Water . ' (6%)'; ?></li>
        <li>
            <input class="pole" style="width:55px" type="text" name="water" value="<?php echo $wyplaty_adresy->pobierz("water"); ?>">
        </li>



        <li class="li_tyt"><?php echo '' . Internet . ' (21%)'; ?></li>
        <li>
            <input class="pole" style="width:55px" type="text" name="internet" value="<?php echo $wyplaty_adresy->pobierz("internet"); ?>">
        </li>



        <!--
        <li class="li_tyt"><?php echo '' . Imię . ''; ?></li>
        <li>
                <input class="pole" type="text" name="naam_eigenaar" value="<?php echo $conf->pobierz("naam_wl"); ?>">
        </li>
        

        
        <li class="li_tyt"><?php echo '' . Nazwisko . ''; ?></li>
        <li>
                <input class="pole" type="text" name="achternaam_eigenaar" value="<?php echo $conf->pobierz("achternaam_wl"); ?>">
        </li>
        

        
        <li class="li_tyt"><?php echo '' . Nr_konta_bankowego . ''; ?></li>
        <li>
                <input class="pole" type="text" name="rekening" value="<?php echo $conf->pobierz("rekening"); ?>">
        </li>
        
        
        <li class="li_tyt"><?php echo '' . Email . ''; ?></li>
        <li>
                <input class="pole"  type="text" name="email_eigenaar" value="<?php echo $conf->pobierz("email_eigenaar"); ?>">
        </li>
        
        -->
        <li class="li_tyt"><?php echo 'Kontrakt do'; ?></li>
        <li>
            <input class="datepicker" type="text" name="cotract_tot_eigenaar" value="<?php echo $data_nl->zmiana_formatu_daty($conf->pobierz("cotract_tot_eigenaar")); ?>">
        </li>


<?php
if (empty($_GET['adres_id'])) {
    echo '<li class="li_tyt">' . Vanaf . '</li>
									<li>
									<input type="text" name="vanaf" class="datepicker" value="' . date('d-m-Y') . '">
									</li>';
}
?>

        <li class="li_tyt"></li>
        <li>
            <input name="save" value="Zapisz" class="button_mini" type="submit">
        </li>



    </ul>

</div>

<div id="pliki" class="tabcontent">
<?php
if ($_GET['adres_id']) {
    if (!$_GET['katalog']) {
        echo '
	<h2>MAPPEN</h2>
	<form method="post" action="">
        
			<label>Nieuwe map</label>
			<input type="text" name="nazwa_folderu" size="10" maxlength="30" style="width: 200px;color: rgb(102, 102, 102);border: 1px solid rgb(204, 204, 204);
    padding: 7px;">
			<input type="submit" name="utworz_katalog" value="Opslaan">
	</form>';

        echo '
	<div>
	<ul style="width:100%;">
			
			';
        //path to directory to scan
        $directory = "upload/" . $_GET['adres_id'] . "/";


        //get all files in specified directory
        $files = glob($directory . "*");

        //print each file name
        foreach ($files as $file) {
            //check to see if the file is a folder/directory
            if (is_dir($file)) {
                $katalog1 = explode('/', $file);
                echo '<li style="min-width: 120px;float: left;margin-right: 25px;text-align: center;list-style: outside none none;">
	<a style="font-size: 17px;" href="?adres_id=' . $_GET['adres_id'] . '&katalog=' . $katalog1[2] . '"><img src="../themes/admin/img/folder1.png" style="padding: 15px 0px 0px;" /></a>
	<p>
	<a style="font-size: 17px;" href="?adres_id=' . $_GET['adres_id'] . '&katalog=' . $katalog1[2] . '">' . $katalog1[2] . '</a>
	</p>
	<a class="usun" style="margin-left: 45px;margin-top: 15px;" href="?adres_id=' . $_GET['adres_id'] . '&usun=' . $katalog1[2] . '"></a></li>';
            }
        }

        echo '
		
		</ul>
	</div>';
    } else {

        //$kat = $_GET['katalog'];
        //setcookie('pliki', 1, time() + (3600), '/');
    }

    echo '
	
	<div style="clear:both;"></div>
	<div id="dokumenty">
	<h2>BESTANDEN ';

    if ($_GET['katalog'])
        echo 'VAN ' . $_GET['katalog'] . '</h2>';
    else
        echo '</h2>';


    echo '
	<table  style="display: block;clear: both;margin: 70px 0px 0px;width:100%;">';

    //path to directory to scan
    $directory = 'upload/' . $_GET['adres_id'] . '/' . $_GET['katalog'] . '/';

    //get all files in specified directory
    $files1 = glob($directory . "*");

    //print each file name
    foreach ($files1 as $k => $file1) {
        //check to see if the file is a folder/directory
        if (!is_dir($file1)) {
            $plik = explode('/', $file1);


            if ($k % 2 == 0)
                echo '<tr class="druga">';
            else
                echo '<tr>';

            echo '
	
	<td class="plik" style="text-align:left;"><form action="" method="post" enctype="multipart/form-data">
	<a href="upload/' . $_GET['adres_id'] . '/' . $_GET['katalog'] . '/' . $plik[3] . '">' . $plik[3] . '</a>
	</td>
	<td>
	<input type="hidden" name="plik_do_skasowania" value="' . $plik[3] . '" />';
            if ($user->userInfo('ranga') == 2)
                echo '<input class="usun" type="submit" name="kasuj_plik" value="" />';

            echo
            '</form>
	</td>
	</tr>';
        }
    }



    echo '</table>
	
	</div>
	
	
	';

    if ($user->userInfo('ranga') != 2) {
        echo '';
    }

    if ($user->userInfo('ranga') == 2) {
        echo '<form action="" method="post" enctype="multipart/form-data">
		<p>' . Bestand . ':
		<input type="file" name="pictures[]" />
		<input type="submit" name="wyslij_pliki" value="OPSLAAN" />
		</p>
	 </form>';
    }
}

//if($_COOKIE['pliki'] == 1)
//setcookie('pliki', 0, time() + (3600), '/');




if ($_COOKIE['katalog'] == 1)
    setcookie('katalog', 0, time() + (3600), '/');


if ($_GET['katalog'])
    setcookie('katalog', 1, time() + (3600), '/');
?>

</div>

<div id="inspectie" class="tabcontent">


    <h2>INSPEKCJA</h2>

    <?php
    if ($_GET['adres_id']) {
        if ($handle = opendir('upload/ins/' . $_GET['adres_id'])) {
            echo '<table style="margin-bottom: 65px;">';

            /* This is the correct way to loop over the directory. */
            while (false !== ($entry = readdir($handle))) {
                if ($entry != '.' && $entry != '..') {
                    echo '
	<tr>
	<td><form action="" method="post" enctype="multipart/form-data">
	
	<a href="upload/ins/' . $_GET['adres_id'] . '/' . $entry . '">' . $entry . '</a>
	</td>
	<td>
	<input type="hidden" name="raport_do_skasowania" value="' . $entry . '" />';
                    if ($user->userInfo('ranga') == 2)
                        echo '<input id=\'del\' type="submit" name="kasuj_raport" value="USUŃ" />';

                    echo
                    '</form>
	</td>
	</tr>
	';
                }
            }


            closedir($handle);
        }

        echo '</table>';
        if ($user->userInfo('ranga') == 2) {
            echo '
	


<form action="" method="post" enctype="multipart/form-data">
		<p>' . Plik . ':
		<input type="file" name="pictures_r[]" />
		<input id=\'zapisz\' type="submit" name="wyslij_raport" value="ZAPISZ" />
		</p>
	 </form>
	 

<div style="width: 231px;margin: 8px auto 45px;height: 40px;margin-top: 50px;" >
<a class="button_mobile" style="float:left;color:white;background-color:#d47519!important;" href="inspectieraport.php?adres_id=' . $_GET['adres_id'] . '">RAPORT INSPEKCJI</a>
</div>

<div>
<a class="button_mobile" style="float:left;color:white;background-color:#d47519!important;margin-right: 30px;margin-bottom: 30px;" href="../inspectie.php?adres_id=' . $_GET['adres_id'] . '&type=poczatek">POCZĄTEK</a>
<a class="button_mobile" style="float:left;color:white;background-color:#d47519!important;margin-right: 30px;margin-bottom: 30px;" href="../inspectie.php?adres_id=' . $_GET['adres_id'] . '&type=w-trakcie">W TRAKCIE</a>
<a class="button_mobile" style="float:left;color:white;background-color:#d47519!important;" href="../inspectie.php?adres_id=' . $_GET['adres_id'] . '&type=zakonczenie">ZAKOŃCZENIE</a>
</div>';
        }
        echo '
<div style="clear:both;"></div>


</div>';


        if ($_COOKIE['inspectie'] == 1)
            setcookie('inspectie', 0, time() + (3600), '/');
    }
    ?>

    <div id="stat" class="tabcontent">

    <?php
    $wins_borg_adresu = $inkomsten_borg_adresu - $uitgaven_borg_adresu;
    echo '

<div style="text-align:center;width: 25%;float: left;margin-right: 50px;">
<h2>BORG</h2>

	<div style="float:left;border-bottom:1px solid black;width: 50%;margin-bottom: 15px;">
	<H3>INKOMSTEN</H3>
	€ ' . number_format($inkomsten_borg_adresu, 2, ',', '.') . '
	</div>
	
	<div style="float:left;border-bottom:1px solid black;width: 50%;margin-bottom: 15px;">
	<H3>UITGAVEN</H3>
	€ ' . number_format($uitgaven_borg_adresu, 2, ',', '.') . '
	</div>
	
	<div style="width: 100%;font-weight: bold;
	';
    if ($wins_borg_adresu < 0)
        echo 'color: rgb(228, 139, 139);';

    echo '
	">
	€ ' . number_format($wins_borg_adresu, 2, ',', '.') . '
	</div></div>
	

	';


    $wins = $inkomsten_adresu - $uitgaven_adresu;
    echo '

<div style="width: 25%;float:left;text-align: center;">
<h2>STATISTIEK</h2>

	<div style="float:left;border-bottom:1px solid black;width: 50%;margin-bottom: 15px;">
	<H3>INKOMSTEN</H3>
	€ ' . number_format($inkomsten_adresu, 2, ',', '.') . '
	</div>
	
	<div style="float:left;border-bottom:1px solid black;width: 50%;margin-bottom: 15px;">
	<H3>UITGAVEN</H3>
	€ ' . number_format($uitgaven_adresu, 2, ',', '.') . '
	</div>
	
	<div style="width: 100%;font-weight: bold;
	';
    if ($wins < 0)
        echo 'color: rgb(228, 139, 139);';

    echo '
	">
	€ ' . number_format($wins, 2, ',', '.') . '
	</div></div>
	<div style="clear:both;"></div>';
    ?>

    </div>

    <div id="berichten" class="tabcontent">
        <!--
        <div>
        <h1>Indexering</h1>
        <form action="" method="POST">
        <table>
        <tr>
        <td><?php echo '' . Indexering . ''; ?></td>
                                                        <td>
                                                        <td>
                                                                <input type="checkbox" name="verhuur" value="1"
        <?php
        if ($conf->pobierz("verhuur") == 1 || empty($_GET['adres_id']))
            echo ' checked';
        ?>
                                                                >
                                                        </td>
                                                        
                                                        
                                                        <td>
                                                                <input type="text" name="verhuur_data" class="datepicker" value="<?php
        if ($conf->pobierz("verhuur_data"))
            echo $data_nl->zmiana_formatu_daty($conf->pobierz("verhuur_data"));
        else
            echo date('01-07-Y');
        ?>">
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                        <td>
        <?php
        echo 'Verhuur:</td><td class="do_prawej">' . $ver->pobierz('verhuur') . ' %
						</td>
						</tr>
						<tr>
						<td>';
        echo 'Huidige huur:</td><td class="do_prawej"> € ' . number_format($wplaty_adresy->pobierz("huur_huurder"), 2, ',', '.') . '
						</td>
						</tr>
						<tr>
						<td>
						';

        $verhuur = $ver->pobierz('verhuur') / 100 + 1;
        $nowa_kwota_huur = $wplaty_adresy->pobierz("huur_huurder") * $verhuur;

        $data_ver = date('01-07-Y');

        echo 'Nieuwe huur: </td><td class="do_prawej"> € ' . number_format($nowa_kwota_huur, 2, ',', '.');
        ?>
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                        <td></td><td>
                                                        <input name="save_indexering" value="Opslaan" class="button_mini" type="submit">
                                                        </td>
        </tr>
        </table>
        
        </form>
        </div>
        
        -->
        <div style="clear:both"></div>
        <h1>Listy</h1>
        <a href="adres.php?adres_id=<?php echo $_GET['adres_id'] ?>&zak=berichten" class="dodaj">Czyść</a>	
        <div style="float:left;margin-right: 30px;">	
            <form action="" method="post" enctype="multipart/form-data">
                <table>
                    <colgroup>
                        <col width="180px;">
                        <col>
                    </colgroup>
                    <tbody><tr>
                            <td>Tytuł:</td>
                            <td>
                                <input class="pole" type="text" name="tytul" style="width:700px;" value="<?php
        if ($_GET['list_id'])
            echo $l->pobierz("tytul");
        if ($_GET['klient_list_id'])
            echo $k_l->pobierz("tytul");
        ?>">

                            </td>
                        </tr>

                        <tr>
                            <td>Treść:<br /></td>
                            <td>
                                <textarea id="list" name="list"><?php
        if ($_GET['list_id'])
            echo $l->pobierz("tresc");
        if ($_GET['klient_list_id'])
            echo $k_l->pobierz("tresc");
        ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Pliki(.pdf):<br /></td>
                            <td>
                                <input type="file" name="berichten[]" />
                            </td>

<?php
if ($handle = opendir('upload/berichten/'))
/* This is the correct way to loop over the directory. */
    while (false !== ($entry = readdir($handle))) {
        if ($entry != '.' && $entry != '..') {

            $p = explode('-', $entry);

            if ($_GET['klient_list_id'])
                $id_l = $k_l->pobierz("list_id");
            else
                $id_l = $_GET['list_id'];

            if ($p[0] == $id_l)
                $nazwa_pliku = $entry;
        }
    }
if ($nazwa_pliku)
    echo '
						<tr>
						<td></td>
						<td>
						<a class="plik_podglad" href="upload/berichten/' . $nazwa_pliku . '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $nazwa_pliku . '
						</td>
						</tr>
						'
    ?>

                        </tr>		




                    <script>

                        CKEDITOR.replace('list');
                    </script>

                    <tr>
                        <td></td>
                        <td>
                            <?php
                            if (!$_GET['klient_list_id'])
                                echo '<input type="submit" name="save_list" value="Wyślij" class="button_mini" style="float:right;" />';
                            ?>
                        </td>
                    </tr>

                    </tbody></table>
            </form>	
        </div>


        <div style="clear:both;"></div>

<?php
echo '
<p>&nbsp;</p>
<div>
<div id="kruis_wplaty" style="width: 1151px;">
<div class="kruis_tytul">
<div class="kruis_id_wp">ID</div><div class="kruis_trans_wp">TYTUŁ</div><div class="kruis_data_wp">DATA</div>
</div>
';
foreach ($listy as $k => $list) {
    echo '
	
	
	
	
		
		<div style="clear:both;">';
    if ($k % 2 == 0)
        echo '<div class="kruis_wpl druga">';
    else
        echo '<div class="kruis_wpl">';

    echo '<div class="kruis_id_wp"><a href="adres.php?adres_id=' . $_GET['adres_id'] . '&list_id=' . $list['id'] . '&zak=berichten">' . $list['id'] . '</a></div><div class="kruis_trans_wp"><a href="adres.php?adres_id=' . $_GET['adres_id'] . '&list_id=' . $list['id'] . '&zak=berichten">';

    if (strlen($list['tytul']) > 20)
        echo substr($list['tytul'], 0, 20) . "...";
    else
        echo $list['tytul'];

    echo '</a></div><div class="kruis_data_wp"><a href="adres.php?adres_id=' . $_GET['adres_id'] . '&list_id=' . $list['id'] . '&zak=berichten">' . $list['data'] . '</a></div>
				<a class="usun" style="float: right;" href="?action=delete&adres_id=' . $_GET['adres_id'] . '&list_id=' . $list['id'] . '&zak=berichten" ></a>
			
			
	
		</div>
	
	';
}
//a href="?waarvoor_id='.$waarvoor['id'].'">							

echo '

</div></div>

';
?>
        <div style="clear:both;"></div>	



        <?php
        $query = mysql_query("SELECT * FROM `listy_adresy` WHERE `adres_id` = " . $_GET['adres_id']);

        while ($rows = mysql_fetch_array($query)) {
            $listy_id[] = $rows;
        }

        echo '
	<p>&nbsp;</p>
	
	
	<div id="kruis_wplaty" >
		<div class="kruis_tytul" style="background:red;">
		<div class="kruis_id_wp">ID</div><div class="kruis_trans_wp">WIADOMOŚĆ</div><div style="width: 121px;" class="kruis_data_wp">POTWIERDZENIE</div><div class="kruis_data_wp" style="text-align:center;margin-left: 10px;">IP</div>
		</div>';

        foreach ($listy_id as $list_id) {
            //echo $list_id['data'].'<br/>';
            $l = new conf();

            $l->query(mysql_query("SELECT * FROM `listy` WHERE `id` = " . $list_id['list_id']));

            echo '		
		<div style="clear:both;">';
            if ($k % 2 == 0)
                echo '<div class="kruis_wpl druga">';
            else
                echo '<div class="kruis_wpl">';

            echo '<div class="kruis_id_wp"><a href="adres.php?adres_id=' . $_GET['adres_id'] . '&zak=berichten&klient_list_id=' . $list_id['id'] . '">' . $list_id['id'] . '</a></div><div class="kruis_trans_wp" ><a href="adres.php?adres_id=' . $_GET['adres_id'] . '&zak=berichten&klient_list_id=' . $list_id['id'] . '">';

            if (strlen($list_id['tytul']) > 20)
                echo substr($list_id['tytul'], 0, 20) . "...";
            else
                echo $list_id['tytul'];

            echo '</a></div><div class="kruis_data_wp" style="width:auto;" ><a href="adres.php?adres_id=' . $_GET['adres_id'] . '&zak=berichten&klient_list_id=' . $list_id['id'] . '">' . $list_id['data'] . '</a></div><div class="kruis_data_wp" style="width:auto;" ><a style="margin-left: 10px;" href="adres.php?adres_id=' . $_GET['adres_id'] . '&zak=berichten&klient_list_id=' . $list_id['id'] . '">' . $list_id['ip'] . '</a></div>
				
			
			
	
		</div>';
        }

        echo '</div>';


        if ($listy)
            echo '</div>';


        if ($listy_id)
            echo '</div></div>';
        else
            echo '</div>';
        ?>






        <div id="details" class="tabcontent">

            <div>
                <h1>DETAILS</h1>

                <ul class="nav nav-tabs" id="propertyTabs"><li class="active"><a href="#basic-information-page" data-toggle="tab">Basis informatie</a></li><li class=""><a href="#details-page" data-toggle="tab">Details</a></li><li class=""><a href="#amenities-page" data-toggle="tab">Voorzieningen</a></li><li class=""><a href="#photo-page" data-toggle="tab">Foto</a></li><li class=""><a href="#pulishing-page" data-toggle="tab">Publishing</a></li></ul>


                <script src="http://khbemiddeling.nl/components/com_osproperty/js/lazy.js" type="text/javascript"></script>

                <style>
                    fieldset label, fieldset span.faux-label {
                        clear: right;
                    }

                </style>

                <link rel="stylesheet" href="http://khbemiddeling.nl/components/com_osproperty/js/tag/css/textext.core.css" type="text/css" />

                <link rel="stylesheet" href="http://khbemiddeling.nl/components/com_osproperty/js/tag/css/textext.plugin.tags.css" type="text/css" />
                <script src="http://khbemiddeling.nl/components/com_osproperty/js/tag/js/textext.core.js" type="text/javascript" charset="utf-8"></script>
                <script src="http://khbemiddeling.nl/components/com_osproperty/js/tag/js/textext.plugin.tags.js" type="text/javascript" charset="utf-8"></script>



                <script language="javascript">
                                                                 function loadStateBackend(country_id, state_id, city_id) {
                                                                     var live_site = '<?php echo $_SERVER['HTTP_HOST']; ?>';
                                                                     loadLocationInfoStateCityBackend(country_id, state_id, city_id, 'country', 'state', live_site);
                                                                 }
                                                                 function loadCityBackend(state_id, city_id) {
                                                                     var live_site = '<?php echo $_SERVER['HTTP_HOST']; ?>';
                                                                     loadLocationInfoCityAddProperty(state_id, city_id, 'state', live_site);
                                                                 }
                                                                 function addPhoto() {
                                                                     var current_number_photo = document.getElementById('current_number_photo');
                                                                     current_number = parseInt(current_number_photo.value);
                                                                     current_number++;
                                                                     var temp = document.getElementById('div_' + current_number);
                                                                     if (temp != null) {
                                                                         if (temp.style.display == "none") {
                                                                             temp.style.display = "block";
                                                                         }
                                                                     }
                                                                     current_number_photo.value = current_number;
                                                                 }
                                                                 function check_file(id) {
                                                                     str = document.getElementById(id).value.toUpperCase();
                                                                     var elementspan = document.getElementById(id + 'div');
                                                                     //suffix=".JPG";
                                                                     blnValid = false;
                                                                     var _validFileExtensions = [".jpg", ".jpeg", ".png", ".gif"];
                                                                     for (var j = 0; j < _validFileExtensions.length; j++) {
                                                                         var sCurExtension = _validFileExtensions[j];
                                                                         if (str.substr(str.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                                                                             blnValid = true;
                                                                             break;
                                                                         }
                                                                     }
                                                                     if (!blnValid) {
                                                                         alert('File type not allowed. Allowed file: *.jpg, *.jpeg, *.gif, *.png');
                                                                         document.getElementById(id).value = '';
                                                                         if (elementspan != null) {
                                                                             elementspan.innerHTML = elementspan.innerHTML;
                                                                         }
                                                                     } else {
                                                                         //clientWidth,clientHeight;
                                                                         clientWidth = document.getElementById(id).clientWidth;
                                                                         clientHeight = document.getElementById(id).clientHeight;
                                                                         var max_width = 1024;
                                                                         max_width = parseInt(max_width);
                                                                         var max_height = 768;
                                                                         max_height = parseInt(max_height);
                                                                         if ((clientWidth > max_width) || (clientHeight > max_height)) {
                                                                             alert("Your photo is over limit size");
                                                                             document.getElementById(id).value = '';
                                                                             if (elementspan != null) {
                                                                                 elementspan.innerHTML = elementspan.innerHTML;
                                                                             }
                                                                         }
                                                                     }
                                                                 }

                                                                 Joomla.submitbutton = function (task) {
                                                                     var form = document.adminForm;
                                                                     category_name = form.category_name;
                                                                     if ((task == "properties_save") || (task == "properties_apply")) {
                                                                         var temp1, temp2;
                                                                         var cansubmit = 1;
                                                                         var require_field = document.getElementById('require_field');
                                                                         require_field = require_field.value;
                                                                         var require_label = document.getElementById('require_label');
                                                                         require_label = require_label.value;
                                                                         var require_fieldArr = require_field.split(",");
                                                                         var require_labelArr = require_label.split(",");
                                                                         for (i = 0; i < require_fieldArr.length; i++) {
                                                                             temp1 = require_fieldArr[i];
                                                                             if (temp1 == "category_id") {
                                                                                 if (jQuery('#categoryIds option:selected').length == 0) {
                                                                                     alert(require_labelArr[i] + " is mandatory field");
                                                                                     jQuery('#categoryIds').focus();
                                                                                     cansubmit = 0;
                                                                                     return false;
                                                                                 }
                                                                             }
                                                                             temp2 = document.getElementById(temp1);
                                                                             if (temp2 != null) {
                                                                                 if (temp2.value == "") {
                                                                                     if (temp1 == "state") {
                                                                                         temp3 = document.getElementById('nstate');
                                                                                         if (temp3 != null) {
                                                                                             if (temp3.value == "") {
                                                                                                 alert(require_labelArr[i] + " is mandatory field");
                                                                                                 temp2.focus();
                                                                                                 cansubmit = 0;
                                                                                                 return false;
                                                                                             }
                                                                                         }
                                                                                     } else {
                                                                                         alert(require_labelArr[i] + " is mandatory field");
                                                                                         temp2.focus();
                                                                                         cansubmit = 0;
                                                                                         return false;
                                                                                     }
                                                                                 }
                                                                             } else {
                                                                                 temp2 = document.getElementsByName(temp1);
                                                                                 if (temp2.length > 0) {
                                                                                     cansubmit = 0;
                                                                                     for (var j = 0; j < temp2.length; j++) {
                                                                                         if (temp2[j].checked == true) {
                                                                                             cansubmit = 1;
                                                                                         }
                                                                                     }
                                                                                     if (cansubmit == 0) {
                                                                                         alert(require_labelArr[i] + " is mandatory field");
                                                                                         temp2.focus();
                                                                                         cansubmit = 0;
                                                                                         return false;
                                                                                     }
                                                                                 } else {
                                                                                     temp2 = document.getElementsByName(temp1 + "[]");
                                                                                     if (temp2.length > 0) {
                                                                                         cansubmit = 0;
                                                                                         for (var j = 0; j < temp2.length; j++) {
                                                                                             if (temp2[j].checked == true) {
                                                                                                 cansubmit = 1;
                                                                                             }
                                                                                         }
                                                                                         if (cansubmit == 0) {
                                                                                             alert(require_labelArr[i] + " is mandatory field");
                                                                                             temp2.focus();
                                                                                             cansubmit = 0;
                                                                                             return false;
                                                                                         }
                                                                                     }
                                                                                 }
                                                                             }
                                                                         }

                                                                         var pro_type = document.getElementById('pro_type').value;
                                                                         if (pro_type != "") {
                                                                             var require_field = document.getElementById('type_id_' + pro_type + '_required_name');
                                                                             require_field = require_field.value;
                                                                             if (require_field != "") {
                                                                                 var require_label = document.getElementById('type_id_' + pro_type + '_required_title');
                                                                                 require_label = require_label.value;
                                                                                 var require_fieldArr = require_field.split(",");
                                                                                 var require_labelArr = require_label.split(",");
                                                                                 for (i = 0; i < require_fieldArr.length; i++) {
                                                                                     temp1 = require_fieldArr[i];
                                                                                     temp2 = document.getElementById(temp1);
                                                                                     if (temp2 != null) {
                                                                                         if (temp2.value == "") {
                                                                                             alert(require_labelArr[i] + " is mandatory field");
                                                                                             temp2.focus();
                                                                                             cansubmit = 0;
                                                                                             return false;
                                                                                         }
                                                                                     } else {
                                                                                         temp2 = document.getElementsByName(temp1);
                                                                                         if (temp2.length > 0) {
                                                                                             cansubmit = 0;
                                                                                             for (var j = 0; j < temp2.length; j++) {
                                                                                                 if (temp2[j].checked == true) {
                                                                                                     cansubmit = 1;
                                                                                                 }
                                                                                             }
                                                                                             if (cansubmit == 0) {
                                                                                                 alert(require_labelArr[i] + " is mandatory field");
                                                                                                 temp2.focus();
                                                                                                 cansubmit = 0;
                                                                                                 return false;
                                                                                             }
                                                                                         } else {
                                                                                             temp2 = document.getElementsByName(temp1 + "[]");
                                                                                             if (temp2.length > 0) {
                                                                                                 cansubmit = 0;
                                                                                                 for (var j = 0; j < temp2.length; j++) {
                                                                                                     if (temp2[j].checked == true) {
                                                                                                         cansubmit = 1;
                                                                                                     }
                                                                                                 }
                                                                                                 if (cansubmit == 0) {
                                                                                                     alert(require_labelArr[i] + " is mandatory field");
                                                                                                     temp2.focus();
                                                                                                     cansubmit = 0;
                                                                                                     return false;
                                                                                                 }
                                                                                             }
                                                                                         }
                                                                                     }
                                                                                 }
                                                                             }
                                                                         }

                                                                         if (cansubmit == 1) {
                                                                             Joomla.submitform(task);
                                                                         }
                                                                     } else {
                                                                         Joomla.submitform(task);
                                                                     }
                                                                 }
                                                                 function showPriceFields() {
                                                                     var price_call = document.getElementById('price_call');
                                                                     var pricediv = document.getElementById('pricediv');
                                                                     if (price_call.value == 0) {
                                                                         pricediv.style.display = "block";
                                                                     } else {
                                                                         pricediv.style.display = "none";
                                                                     }
                                                                 }

                                                                 function check_file_type() {
                                                                     str = document.getElementById('zip_file').value.toUpperCase();
                                                                     suffix = ".ZIP";
                                                                     if (!(str.indexOf(suffix, str.length - suffix.length) !== -1)) {
                                                                         alert('File type not allowed. Allowed file: *.zip');
                                                                         document.getElementById('zip_file').value = '';
                                                                     }
                                                                 }
                </script>
                <script src="http://khbemiddeling.nl/media/jui/js/fielduser.min.js" type="text/javascript"></script>
                <script src="http://khbemiddeling.nl/media/system/js/modal.js" type="text/javascript"></script>










                <form method="POST" action="" name="adminForm" id="adminForm" enctype="multipart/form-data">
                    <input type="hidden" name="live_site" id="live_site" value="http://khbemiddeling.nl/" />


                    <ul class="nav nav-tabs" id="propertyTabs"></ul>
                    <div class="tab-content" id="propertyContent">		
                        <div id="basic-information-page" class="tab-pane active">
                            <table width="100%">
                                <tr>
                                    <td width="50%" valign="top">
                                        <table  width="100%">
                                            <tr>
                                                <!-- General tab-->
                                                <td width="100%" valign="top" align="left">
                                                    <div class="col width-100">
                                                        <fieldset class="general">
                                                            <legend>Algemeen</legend>
                                                            <table  width="100%" class="admintable">
                                                                <tr>
                                                                    <td class="key" width="20%">
                                                                        Ref #													</td>
                                                                    <td width="80%">
                                                                        <input type="text" name="ref" id="ref" value="<?php if ($_GET['adres_id'] != 0) {
            echo $prop->pobierz('ref');
        } ?>" class="input-small" />
                                                                    </td>
                                                                </tr>
                                                                <tr>

                                                                </tr>
                                                                <tr>

                                                                </tr>
                                                                <tr>
                                                                    <td class="key">
                                                                        Categorieën													</td>
                                                                    <td>
                                                                        <select id="categoryIds" name="category_id" multiple class="input-large chosen" >
                                                                            <option value="9"
<?php
if ($_GET['adres_id'] != 0) {
    if ($prop->pobierz('category_id') == 9)
        echo ' selected="selected" ';
}
?>
                                                                                    >Aanbod</option>
                                                                            <option value="6" <?php
if ($_GET['adres_id'] != 0) {
    if ($prop->pobierz('category_id') == 6)
        echo ' selected="selected" ';
}
?>
                                                                                    >&nbsp;&nbsp;- Winkelruimten</option>
                                                                            <option value="4" <?php
if ($_GET['adres_id'] != 0) {
    if ($prop->pobierz('category_id') == 4)
        echo ' selected="selected" ';
}
?>>&nbsp;&nbsp;- Nieruchomo</option>
                                                                            <option value="8" <?php
if ($_GET['adres_id'] != 0) {
    if ($prop->pobierz('category_id') == 8)
        echo ' selected="selected" ';
}
?>>&nbsp;&nbsp;- Vakantie</option>
                                                                            <option value="5" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('category_id') == 5)
                                                                                    echo ' selected="selected" ';
                                                                            }
?>>&nbsp;&nbsp;- Pokoje</option>
                                                                            <option value="7" <?php
                                                                                    if ($_GET['adres_id'] != 0) {
                                                                                        if ($prop->pobierz('category_id') == 7)
                                                                                            echo ' selected="selected" ';
                                                                                    }
                                                                                    ?>>&nbsp;&nbsp;- Wkr</option>
                                                                            <option value="1" <?php
                                                                                    if ($_GET['adres_id'] != 0) {
                                                                                        if ($prop->pobierz('category_id') == 1)
                                                                                            echo ' selected="selected" ';
                                                                                    }
                                                                                    ?>>&nbsp;&nbsp;- Domy</option>
                                                                            <option value="3" <?php
                                                                                    if ($_GET['adres_id'] != 0) {
                                                                                        if ($prop->pobierz('category_id') == 3)
                                                                                            echo ' selected="selected" ';
                                                                                    }
                                                                                    ?>>&nbsp;&nbsp;- Studio</option>
                                                                            <option value="2" <?php
                                                                                    if ($_GET['adres_id'] != 0) {
                                                                                        if ($prop->pobierz('category_id') == 2)
                                                                                            echo ' selected="selected" ';
                                                                                    }
                                                                                    ?>>&nbsp;&nbsp;- Mieszkania</option>
                                                                        </select>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="key">
                                                                        Eigendom type													</td>
                                                                    <td>
                                                                        <select id="pro_type" name="pro_type" class="input-large">
                                                                            <option value="">--</option>
                                                                            <option value="1" <?php
                                                                                    if ($_GET['adres_id'] != 0) {
                                                                                        if ($prop->pobierz('pro_type') == 1)
                                                                                            echo ' selected="selected" ';
                                                                                    }
                                                                                    ?>>for sale</option>
                                                                            <option value="3" <?php
                                                                                    if ($_GET['adres_id'] != 0) {
                                                                                        if ($prop->pobierz('pro_type') == 3)
                                                                                            echo ' selected="selected" ';
                                                                                    }
                                                                                    ?>>For Sale or Lease</option>
                                                                            <option value="4" <?php
                                                                                    if ($_GET['adres_id'] != 0) {
                                                                                        if ($prop->pobierz('pro_type') == 4)
                                                                                            echo ' selected="selected" ';
                                                                                    }
                                                                                    ?>>Te huur</option>
                                                                            <option value="2" <?php
                                                                                    if ($_GET['adres_id'] != 0) {
                                                                                        if ($prop->pobierz('pro_type') == 2)
                                                                                            echo ' selected="selected" ';
                                                                                    }
                                                                                    ?>>Vakanties</option>
                                                                            <option value="5" <?php
                                                                                    if ($_GET['adres_id'] != 0) {
                                                                                        if ($prop->pobierz('pro_type') == 5)
                                                                                            echo ' selected="selected" ';
                                                                                    }
                                                                                    ?>>Verhuurd</option>
                                                                            <option value="6" <?php
                                                                                            if ($_GET['adres_id'] != 0) {
                                                                                                if ($prop->pobierz('pro_type') == 6)
                                                                                                    echo ' selected="selected" ';
                                                                                            }
                                                                                            ?>>Verwerkte</option>
                                                                        </select>

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="key" valign="top">
                                                                        Prijs informatie													</td>
                                                                    <td>
                                                                        <div>
                                                                            <table width="100%">
                                                                                <tr>
                                                                                    <td class="key" width="20%">
                                                                                        Vraag naar prijs																</td>
                                                                                    <td width="80%">
                                                                                        <select id="price_call" name="price_call" class="input-mini" onChange="javascript:showPriceFields()">
                                                                                            <option value="">--</option>
                                                                                            <option value="1" <?php
                                                                                                    if ($_GET['adres_id'] != 0) {
                                                                                                        if ($prop->pobierz('price_call') == 1)
                                                                                                            echo ' selected="selected" ';
                                                                                                    }
                                                                                                    ?>>Ja</option>
                                                                                            <option value="0" <?php
                                                                                                    if ($_GET['adres_id'] != 0) {
                                                                                                        if ($prop->pobierz('price_call') == 0)
                                                                                                            echo ' selected="selected" ';
                                                                                                    }
                                                                                                    ?>>Nee</option>
                                                                                        </select>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                        <div id="pricediv" style="display:block;">
                                                                            <table width="100%">

                                                                                <tr>
                                                                                    <td class="key">
                                                                                        Prijs voor																	</td>
                                                                                    <td>
                                                                                        <select id="rent_time" name="rent_time" class="input-medium">
                                                                                            <option value="">--</option>
                                                                                            <option value="OS_PER_NIGHT" <?php
                                                                                                    if ($_GET['adres_id'] != 0) {
                                                                                                        if ($prop->pobierz('rent_time') == 'OS_PER_NIGHT')
                                                                                                            echo ' selected="selected" ';
                                                                                                    }
                                                                                                    ?>>Per nacht</option>
                                                                                            <option value="OS_PER_WEEK" <?php
                                                                                                    if ($_GET['adres_id'] != 0) {
                                                                                                        if ($prop->pobierz('rent_time') == 'OS_PER_WEEK')
                                                                                                            echo ' selected="selected" ';
                                                                                                    }
                                                                                                    ?>>Per week</option>
                                                                                            <option value="OS_PER_MONTH" <?php
                                                                                                    if ($_GET['adres_id'] != 0) {
                                                                                                        if ($prop->pobierz('rent_time') == 'OS_PER_MONTH')
                                                                                                            echo ' selected="selected" ';
                                                                                                    }
                                                                                                    ?>>Per maand</option>
                                                                                            <option value="OS_PER_SQUARE_FEET" <?php
                                                                                                    if ($_GET['adres_id'] != 0) {
                                                                                                        if ($prop->pobierz('rent_time') == 'OS_PER_SQUARE_FEET')
                                                                                                            echo ' selected="selected" ';
                                                                                                    }
                                                                                                    ?>>Per vierkante voet</option>
                                                                                            <option value="OS_PER_SQUARE_METRE" <?php
                                                                                                    if ($_GET['adres_id'] != 0) {
                                                                                                        if ($prop->pobierz('rent_time') == 'OS_PER_SQUARE_METRE')
                                                                                                            echo ' selected="selected" ';
                                                                                                    }
                                                                                                    ?>>Per vierkante meter</option>
                                                                                        </select>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="key">
                                                                                        <label id="price_text-lbl" for="price_text" class="hasTooltip hasTip" title="&lt;strong&gt;Price text&lt;/strong&gt;&lt;br /&gt;If you enter text here, it will be shown instead of value of price">Prijs text</label>																	</td>
                                                                                    <td>
                                                                                        <input type="text" class="input-large" name="price_text" value="<?php if ($_GET['adres_id'] != 0) {
                                                                                                        echo $prop->pobierz('price_text');
                                                                                                    } ?>" />
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </div>
                                                    <!-- End General tab-->
                                                </td>
                                            </tr>
                                            <tr id="sold_information" style="display:none;">
                                                <!-- Other information -->
                                                <td width="100%">
                                                    <div class="col width-100">
                                                        <fieldset class="general">
                                                            <legend>Verkocht Status</legend>
                                                            <table  width="100%" class="admintable">
                                                                <tr>
                                                                    <td class="key">
                                                                        Is verkocht													</td>
                                                                    <td>
                                                                        <fieldset id="isSold" class="radio btn-group btn-group-yesno"><input type="radio" id="isSold0" name="isSold" value="1" /><label for="isSold0">Ja</label><input type="radio" id="isSold1" name="isSold" value="0" checked="checked" /><label for="isSold1">Nee</label></fieldset>														</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="key">
                                                                        Verkocht													</td>
                                                                    <td>
                                                                        <div class="field-calendar">
                                                                            <div class="input-append">
                                                                                <input type="text" id="soldOn" name="soldOn" value="-1-11-30" 		 data-alt-value="-1-11-30" autocomplete="off"/>
                                                                                <button type="button" class="btn btn-secondary"
                                                                                        id="soldOn_btn"
                                                                                        data-inputfield="soldOn"
                                                                                        data-dayformat="%Y-%m-%d"
                                                                                        data-button="soldOn_btn"
                                                                                        data-firstday="0"
                                                                                        data-weekend="0,6"
                                                                                        data-today-btn="0"
                                                                                        data-week-numbers="0"
                                                                                        data-show-time="0"
                                                                                        data-show-others="0"
                                                                                        data-time-24="24"
                                                                                        data-only-months-nav="0"
                                                                                        ><span class="icon-calendar"></span></button>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </div>
                                                </td>
                                                <!-- End Other information -->
                                            </tr>

                                        </table>
                                    </td>
                                    <td width="50%" valign="top">
                                        <table>
                                            <tr>
                                                <!-- Address -->
                                                <td width="100%">
                                                    <div class="col width-100">
                                                        <fieldset class="general">
                                                            <legend>Adres</legend>
                                                            <table  width="100%" class="admintable">
                                                                <tr>
                                                                    <td class="key" width="20%">
                                                                        <label id="show_address-lbl" for="show_address" class="hasTooltip hasTip" title="&lt;strong&gt;Show address&lt;/strong&gt;&lt;br /&gt;Do you want to show address of property at front-end">Toon adres</label>													</td>
                                                                    <td width="80%">
                                                                        <div id="div_states">
                                                                            <fieldset id="show_address" class="radio btn-group btn-group-yesno"><input type="radio" id="show_address0" name="show_address" value="1" <?php if ($_GET['adres_id'] != 0) {
                                                                                                        if ($prop->pobierz('show_address') == 1) echo 'checked="checked"';
                                                                                                    } ?>  /><label for="show_address0">Ja</label><input type="radio" id="show_address1" name="show_address" value="0" <?php if ($_GET['adres_id'] != 0) {
                                                                                    if ($prop->pobierz('show_address') == 0) echo 'checked="checked"';
                                                                                } ?> /><label for="show_address1">Nee</label></fieldset>														</div>
                                                                    </td>
                                                                </tr>



                                                                <input type='hidden' name='country' value='130' id='country'>												<tr>
                                                                    <td class="key">
                                                                        Region													</td>
                                                                    <td>
                                                                        <div id="country_state">
                                                                            <select id="state" name="state"  onChange="javascript:loadCityBackend(this.value, '<?php if ($_GET['adres_id'] != 0) {
                                                                                    $prop->pobierz('city');
                                                                                } ?>')" >
                                                                                <option value="">--</option>



                                                                                <option value="65" <?php
                                                                                if ($_GET['adres_id'] != 0) {
                                                                                    if ($prop->pobierz('state') == 65)
                                                                                        echo ' selected="selected" ';
                                                                                }
                                                                                                    ?>>Array</option>
                                                                                <option value="53" <?php
                                                                                if ($_GET['adres_id'] != 0) {
                                                                                    if ($prop->pobierz('state') == 53)
                                                                                        echo ' selected="selected" ';
                                                                                }
                                                                                ?>>Drenthe</option>
                                                                                <option value="54" <?php
                                                                                if ($_GET['adres_id'] != 0) {
                                                                                    if ($prop->pobierz('state') == 54)
                                                                                        echo ' selected="selected" ';
                                                                                }
                                                                                ?>>Flevoland</option>
                                                                                <option value="55" <?php
                                                                                if ($_GET['adres_id'] != 0) {
                                                                                    if ($prop->pobierz('state') == 55)
                                                                                        echo ' selected="selected" ';
                                                                                }
                                                                                ?>>Friesland</option>
                                                                                <option value="56" <?php
                                                                                if ($_GET['adres_id'] != 0) {
                                                                                    if ($prop->pobierz('state') == 56)
                                                                                        echo ' selected="selected" ';
                                                                                }
                                                                                ?>>Gelderland</option>
                                                                                <option value="57" <?php
                                                                                if ($_GET['adres_id'] != 0) {
                                                                                    if ($prop->pobierz('state') == 57)
                                                                                        echo ' selected="selected" ';
                                                                                }
                                                                                ?>>Groningen</option>
                                                                                <option value="58" <?php
                                                                                if ($_GET['adres_id'] != 0) {
                                                                                    if ($prop->pobierz('state') == 58)
                                                                                        echo ' selected="selected" ';
                                                                                }
                                                                                ?>>Limburg</option>
                                                                                <option value="59" <?php
                                                                                if ($_GET['adres_id'] != 0) {
                                                                                    if ($prop->pobierz('state') == 59)
                                                                                        echo ' selected="selected" ';
                                                                                }
                                                                                ?>>Noord-Brabant</option>
                                                                                <option value="60" <?php
                                                                                if ($_GET['adres_id'] != 0) {
                                                                                    if ($prop->pobierz('state') == 60)
                                                                                        echo ' selected="selected" ';
                                                                                }
                                                                                ?>>Noord-Holland</option>
                                                                                <option value="61" <?php
                                                                                if ($_GET['adres_id'] != 0) {
                                                                                    if ($prop->pobierz('state') == 61)
                                                                                        echo ' selected="selected" ';
                                                                                }
                                                                                ?>>Overijssel</option>
                                                                                <option value="62" <?php
                                                                                if ($_GET['adres_id'] != 0) {
                                                                                    if ($prop->pobierz('state') == 62)
                                                                                        echo ' selected="selected" ';
                                                                                }
                                                                                ?>>Utrecht</option>
                                                                                <option value="63" <?php
                                                                                if ($_GET['adres_id'] != 0) {
                                                                                    if ($prop->pobierz('state') == 63)
                                                                                        echo ' selected="selected" ';
                                                                                }
                                                                                ?>>Zeeland</option>
                                                                                <option value="64" <?php
                                                                                if ($_GET['adres_id'] != 0) {
                                                                                    if ($prop->pobierz('state') == 64)
                                                                                        echo ' selected="selected" ';
                                                                                }
                                                                                ?>>Zuid-Holland</option>
                                                                            </select>


                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="key">
                                                                        City													</td>
                                                                    <td>
                                                                            <!--<input type="text" name="city" id="city" value="32376" size="20">-->
                                                                        <div id="city_div">
                                                                            <select id="city" name="city" class="input-medium chosen" >
                                                                                <option value="0">--</option>

<?php
if ($_GET['adres_id'] != 0) {
    foreach ($city as $klucz => $w) {

        echo '
	<option value="' . $w['id'] . '"';
        if ($prop->pobierz('city') == $w['id'])
            echo ' selected="selected" ';

        echo '>' . $w['city'] . '</option>
	';
    }
}
?>



                                                                            </select>
                                                                        </div>
                                                                        <!-- -->
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="key">
                                                                        Region													</td>
                                                                    <td>
                                                                        <input type="text" name="region" id="region" value="<?php if ($_GET['adres_id'] != 0) {
    echo $prop->pobierz('province');
} ?>"" size="30">

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="key">

                                                                        Latitude													</td>
                                                                    <td>
                                                                        <input type="text" class="input-small" name="lat_add" id="lat_add" value="<?php if ($_GET['adres_id'] != 0) {
    echo $prop->pobierz('lat_add');
} ?>" size="30"><!--  -->

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="key">
                                                                        Longitude													</td>
                                                                    <td>
                                                                        <input type="text" class="input-small" name="long_add" id="long_add" value="<?php if ($_GET['adres_id'] != 0) {
    echo $prop->pobierz('long_add');
} ?>" size="30">
                                                                        <!-- -->

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="key" valign="top">
                                                                        Sleep de kaart voor coördinaten:
                                                                    </td>
                                                                    <td>
                                                                        <script type="text/javascript">
                                                                            var propertyPoint = new google.maps.LatLng(<?php if ($_GET['adres_id'] != 0) {
    if ($prop->pobierz('lat_add')) echo $prop->pobierz('lat_add');
    else echo '51.5769057';
} ?>,<?php if ($_GET['adres_id'] != 0) {
    if ($prop->pobierz('long_add')) echo $prop->pobierz('long_add');
    else echo '5.0322442';
} ?>);
                                                                            var marker;
                                                                            var map;
                                                                            var geocoder;
                                                                            var centerChangedLast;
                                                                            var reverseGeocodedLast;
                                                                            var currentReverseGeocodeResponse;
                                                                            var markersArray = [];
                                                                            function initialize() {
                                                                                var mapOptions = {
                                                                                    zoom: 5,
                                                                                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                                                                                    mapTypeControl: true,
                                                                                    navigationControl: true,
                                                                                    center: propertyPoint
                                                                                };
                                                                                geocoder = new google.maps.Geocoder();
                                                                                map = new google.maps.Map(document.getElementById("map"), mapOptions);
                                                                                marker = new google.maps.Marker({
                                                                                    map: map,
                                                                                    draggable: true,
                                                                                    animation: google.maps.Animation.DROP,
                                                                                    position: propertyPoint
                                                                                });
                                                                                markersArray.push(marker);
                                                                                google.maps.event.addListener(marker, 'dragend', toggleBounce);
                                                                            }

                                                                            function toggleBounce() {
                                                                                if (marker.getAnimation() != null) {
                                                                                    marker.setAnimation(null);
                                                                                } else {
                                                                                    marker.setAnimation(google.maps.Animation.BOUNCE);
                                                                                }
                                                                                var point = marker.getPosition();
                                                                                map.panTo(point);
                                                                                document.getElementById("lat_add").value = point.lat().toFixed(5);
                                                                                document.getElementById("long_add").value = point.lng().toFixed(5);
                                                                            }

                                                                            function showAddress(address) {
                                                                                geocoder.geocode({'address': address, 'partialmatch': true}, geocodeResult);
                                                                            }
                                                                            function geocodeResult(results, status) {
                                                                                if (status == 'OK' && results.length > 0) {
                                                                                    map.fitBounds(results[0].geometry.viewport);

                                                                                    marker.setPosition(map.getCenter());
                                                                                    marker.setMap(map);
                                                                                    //markersArray.push(marker);
                                                                                    google.maps.event.addListener(marker, 'dragend', toggleBounce);
                                                                                    document.getElementById("lat_add").value = map.getCenter().lat().toFixed(5);
                                                                                    document.getElementById("long_add").value = map.getCenter().lng().toFixed(5);
                                                                                } else {
                                                                                    alert("Geocode was not successful for the following reason: " + status);
                                                                                }
                                                                            }

                                                                            function addMarkerAtCenter() {
                                                                                var marker = new google.maps.Marker({
                                                                                    position: map.getCenter(),
                                                                                    map: map
                                                                                });
                                                                                //var infowindow = new google.maps.InfoWindow({ content: text });
                                                                                //google.maps.event.addListener(marker, 'click', function() {
                                                                                // infowindow.open(map,marker);
                                                                                //});
                                                                            }

                                                                            function addMarker(location) {
                                                                                marker = new google.maps.Marker({
                                                                                    position: location,
                                                                                    map: map
                                                                                });
                                                                                markersArray.push(marker);
                                                                            }

                                                                            // Removes the overlays from the map, but keeps them in the array
                                                                            function clearOverlays() {
                                                                                if (markersArray) {
                                                                                    for (i in markersArray) {
                                                                                        markersArray[i].setMap(null);
                                                                                    }
                                                                                }
                                                                            }

                                                                        </script>
                                                                <body onload="initialize();">
                                                                    <div id="map" style="width: 500px; height: 300px;border:1px solid #CCC;"></div>
                                                                </body>
                                                                <BR>
                                                                <div>
                                                                    <b>Voer adres in om breedte en lengte te controleren: </b>
                                                                    <BR>
                                                                    <input type="text" name="add" id="add" value="" size="20" class="inputbox"><input type="button" class="btn btn-primary" value="Search" onclick="javascript:showAddress(document.adminForm.add.value);">
                                                                </div>
                                                                <BR>
                                                                </td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <!-- Other information -->
                                    <td width="100%" colspan="2">
                                        <div class="col width-100">
                                            <fieldset class="general">
                                                <legend>Beschrijving</legend>
                                                <table  width="100%" class="admintable">
                                                    <tr>
                                                        <td class="key" valign="top">
                                                            Korte beschrijving									</td>
                                                        <td width="80%">
                                                            <textarea name="pro_small_desc" id="pro_small_desc" style="width:450px !important;" rows="5" class="input-large"><?php if ($_GET['adres_id'] != 0) {
    echo $prop->pobierz('pro_small_desc');
} ?></textarea>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="key" valign="top">
                                                            Beschrijving									</td>
                                                        <td width="80%">
                                                            <div ><textarea
                                                                    name="opis"
                                                                    id="opis"
                                                                    cols="75"
                                                                    rows="20"
                                                                    style="width: 95%; height: 250px;"

                                                                    ><?php if ($_GET['adres_id'] != 0) {
    echo $prop->pobierz('pro_full_desc');
} ?>
                                                                </textarea>
                                                            </div>									</td>
                                                    </tr>							
                                                </table>
                                            </fieldset>
                                        </div>	
                                    </td>
                                    <!-- End Other information -->
                                </tr>
                            </table>

                        </div>		


                        <script>

                            CKEDITOR.replace('opis');
                        </script>
                        <div id="details-page" class="tab-pane">
                            <table width="100%">
                                <tr>
                                    <td width="100%">
                                        <div class="col width-100">
                                            <fieldset class="general">
                                                <legend>Eigendom informatie</legend>
                                                <table  width="100%" class="admintable">
                                                    <tr>
                                                        <td class="key" valign="top">
                                                            Video embed code									</td>
                                                        <td width="80%">
                                                            <textarea name="pro_video" id="pro_video" cols="50" rows="3" class="inputbox" style="width:300px !important;"><?php if ($_GET['adres_id'] != 0) {
                                                                                        echo $prop->pobierz('pro_video');
                                                                                    } ?></textarea>
                                                        </td>
                                                    </tr>

                                                </table>

                                                <div id="menu-pane3" class="pane-sliders"><div style="display:none;"><div></div></div><div class="panel"><div class="pane-slider content">							<table  width="100%" class="admintable">
                                                                <tr>
                                                                    <td class="key">
                                                                        # Aantal kamers									</td>
                                                                    <td width="80%">
                                                                        <select id="rooms" name="rooms" class="input-small chosen" >
                                                                            <option value="">Kamers</option>
                                                                            <option value="1" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('rooms') == 1)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>1</option>
                                                                            <option value="2" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('rooms') == 2)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>2</option>
                                                                            <option value="3" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('rooms') == 3)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>3</option>
                                                                            <option value="4" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('rooms') == 4)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>4</option>
                                                                            <option value="5" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('rooms') == 5)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>5</option>
                                                                            <option value="6" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('rooms') == 6)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>6</option>
                                                                            <option value="7" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('rooms') == 7)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>7</option>
                                                                            <option value="8" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('rooms') == 8)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>8</option>
                                                                            <option value="9" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('rooms') == 9)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>9</option>
                                                                            <option value="10" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('rooms') == 10)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>10</option>

                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="key">
                                                                        # Aantal badkamers									</td>
                                                                    <td>
                                                                        <select id="bath_room" name="bath_room" class="input-small chosen" >
                                                                            <option value="">Bad</option>
                                                                            <option value="1"  <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('bath_room') == 1)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>1</option>
                                                                            <option value="2" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('bath_room') == 2)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>2</option>
                                                                            <option value="3" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('bath_room') == 3)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>3</option>
                                                                            <option value="4" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('bath_room') == 4)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>4</option>
                                                                            <option value="5" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('bath_room') == 5)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>5</option>
                                                                            <option value="6" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('bath_room') == 6)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>6</option>
                                                                            <option value="7" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('bath_room') == 7)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>7</option>
                                                                            <option value="8" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('bath_room') == 8)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>8</option>
                                                                            <option value="9" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('bath_room') == 9)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>9</option>
                                                                            <option value="10" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('bath_room') == 10)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>10</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="key">
                                                                        # Aantal slaapkamers									</td>
                                                                    <td>
                                                                        <select id="bed_room" name="bed_room" class="input-small chosen" >
                                                                            <option value="">Slaapkamers</option>
                                                                            <option value="1"  <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('bed_room') == 1)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>1</option>
                                                                            <option value="2" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('bed_room') == 2)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>2</option>
                                                                            <option value="3" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('bed_room') == 3)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>3</option>
                                                                            <option value="4" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('bed_room') == 4)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>4</option>
                                                                            <option value="5" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('bed_room') == 5)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>5</option>
                                                                            <option value="6" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('bed_room') == 6)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>6</option>
                                                                            <option value="7" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('bed_room') == 7)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>7</option>
                                                                            <option value="8" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('bed_room') == 8)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>8</option>
                                                                            <option value="9" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('bed_room') == 9)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>9</option>
                                                                            <option value="10" <?php
                                                                            if ($_GET['adres_id'] != 0) {
                                                                                if ($prop->pobierz('bed_room') == 10)
                                                                                    echo ' selected="selected" ';
                                                                            }
                                                                            ?>>10</option>

                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="key" style="vertical-align:top;padding-top:10px;">
                                                                        Borg									</td>
                                                                    <td style="vertical-align:top;padding-top:5px;">
                                                                        <input type="text" name="living_areas" id="living_areas" class="input-large" value="<?php if ($_GET['adres_id'] != 0) {
                                                                                echo $prop->pobierz('living_areas');
                                                                            } ?>" />
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                        </div></div><div class="panel"><div class="pane-slider content">								<table  width="100%" class="admintable">
                                                                <tr>
                                                                    <td class="key">
                                                                        Administratiekosten										</td>
                                                                    <td width="80%">
                                                                        <input type="text" name="garage_description" id="garage_description" size="20" class="input-large" value="<?php if ($_GET['adres_id'] != 0) {
                                                                                echo $prop->pobierz('garage_description');
                                                                            } ?>" />
                                                                    </td>
                                                                </tr>
                                                                <tr>

                                                                </tr>
                                                            </table>
                                                        </div></div><div class="panel"><div class="pane-slider content">								<table  width="100%" class="admintable">


                                                                <tr>
                                                                    <td class="key">
                                                                        # Vierkante meter (m²)
                                                                    </td>
                                                                    <td width="80%">
                                                                        <input type="text" name="square_feet" id="square_feet" size="10" class="input-small" value="<?php if ($_GET['adres_id'] != 0) {
                                                                                echo $prop->pobierz('square_feet');
                                                                            } ?>"/>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="key">
                                                                        # Beschikbaar vanaf

                                                                    </td>
                                                                    <td width="80%">
                                                                        <input type="text" name="lot_size" id="lot_size" class="datepicker" value="<?php if ($_GET['adres_id'] != 0) {
                                                                                echo $prop->pobierz('lot_size');
                                                                            } ?>" />
                                                                    </td>
                                                                </tr>

                                                            </table>
                                                        </div></div>
                                                    <script language="javascript">
                                                        jQuery(document).ready(function () {
                                                            jQuery('.removehistory').live('click', function () {
                                                                jQuery(this).parent().parent().remove();
                                                            });

                                                            jQuery('.addhistory').live('click', function () {
                                                                jQuery(this).val('Delete');
                                                                jQuery(this).attr('class', 'btn removehistory');
                                                                var appendTxt = '<tr id="history_table_tr"><td><input type="text" name="history_date[]" value="" class="input-small" /></td><td><input type="text" name="history_event[]" value="" class="input-medium" /></td><td><input type="text" name="history_price[]" value="" class="input-small" /></td><td><input type="text" name="history_source[]" value="" class="input-medium" /></td><td><input type="button" class="btn addhistory" value="Add new" /></td></tr>';
                                                                jQuery("#property_history_table>tbody>tr:last").after(appendTxt);
                                                            });

                                                            jQuery('.removetax').live('click', function () {
                                                                jQuery(this).parent().parent().remove();
                                                            });

                                                            jQuery('.addtax').live('click', function () {
                                                                jQuery(this).val('Delete');
                                                                jQuery(this).attr('class', 'btn removetax');
                                                                var appendTxt = '<tr id="tax_table_tr"><td><input type="text" name="tax_year[]" value="" class="input-small" /></td><td><input type="text" name="tax_value[]" value="" class="input-small" /></td><td><input type="text" name="tax_change[]" value="" class="input-small" /></td><td><input type="text" name="tax_assessment[]" value="" class="input-small" /></td><td><input type="text" name="tax_assessment_change[]" value="" class="input-small" /></td><td><input type="button" class="btn addtax" value="Add new" /></td></tr>';
                                                                jQuery("#property_tax_table>tbody>tr:last").after(appendTxt);
                                                            });
                                                        });
                                                    </script>
                                                </div>	
                                                </td>
                                                <!-- End Other information -->
                                                </tr>
                                                </table>

                                        </div>		
                                        <div id="amenities-page" class="tab-pane">
                                            <table  width="100%">
                                                <tr>
                                                    <td width="50%" style="text-align:left;padding:10px;vertical-align:top;">
                                                        <table width="100%">
                                                            <tr>
                                                                <td width="100%" style="height:30px;background-color:#2a2a2a;color:white;text-align:center;font-weight:bold;font-size:16px;">
                                                                    Algemene voorzieningen											</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%">
                                                                    <input type="checkbox" id="amenity_104" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(104, $am_prop) != false) echo 'checked';
                                                                            } ?> value="104" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_104">4 badkamers</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_80" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(80, $am_prop) != false) echo 'checked';
                                                                            } ?> value="80" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_80">Lift</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_72" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(72, $am_prop) != false) echo 'checked';
                                                                            } ?> value="72" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_72">Koelkast</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_71" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(71, $am_prop) != false) echo 'checked';
                                                                            } ?> value="71" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_71">Droger</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_69" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(69, $am_prop) != false) echo 'checked';
                                                                            } ?> value="69" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_69">Vriezer</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_68" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(68, $am_prop) != false) echo 'checked';
                                                                            } ?> value="68" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_68">Tuin voor het huis</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_86" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(86, $am_prop) != false) echo 'checked';
                                                                            } ?> value="86" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_86">Prive parkeerplaats</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_91" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (array_search('91', $am_prop)) echo 'checked';
                                                                            } ?>  value="91" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_91">1 Slaapkamer</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_63" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(63, $am_prop) != false) echo 'checked';
                                                                            } ?> value="63" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_63">Vaatwasser</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_81" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(81, $am_prop) != false) echo 'checked';
                                                                            } ?> value="81" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_81">Woonkamer</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_82" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(82, $am_prop) != false) echo 'checked';
                                                                            } ?> value="82" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_82">Balkon</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_103" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(103, $am_prop) != false) echo 'checked';
                                                                            } ?> value="103" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_103">18 Slaapkamers</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_102" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(102, $am_prop) != false) echo 'checked';
                                                                            } ?> value="102" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_102">Kelder</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_101" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(101, $am_prop) != false) echo 'checked';
                                                                            } ?> value="101" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_101">gedeeld douche</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_100" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(100, $am_prop) != false) echo 'checked';
                                                                            } ?> value="100" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_100">Gedeeld toilet</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_98" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(98, $am_prop) != false) echo 'checked';
                                                                            } ?> value="98" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_98">Open keuken</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_97" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(97, $am_prop) != false) echo 'checked';
                                                                            } ?> value="97" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_97">Slaapkamer / Woonkamer</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_79" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(79, $am_prop) != false) echo 'checked';
                                                                            } ?> value="79" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_79">incl- gas,water en elektra</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_83" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(83, $am_prop) != false) echo 'checked';
                                                                            } ?> value="83" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_83">Winter Garden</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_62" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(62, $am_prop) != false) echo 'checked';
                                                                            } ?> value="62" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_62">Badkamer met bad</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_61" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(61, $am_prop) != false) echo 'checked';
                                                                            } ?> value="61" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_61">Terras</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_99" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(99, $am_prop) != false) echo 'checked';
                                                                            } ?> value="99" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_99">Kookplaat</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_84" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(84, $am_prop) != false) echo 'checked';
                                                                            } ?> value="84" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_84">Sauna</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_90" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(90, $am_prop) != false) echo 'checked';
                                                                            } ?> value="90" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_90">Badkamer met douche / bad</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_51" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(51, $am_prop) != false) echo 'checked';
                                                                            } ?> value="51" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_51">Oven</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_93" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(93, $am_prop) != false) echo 'checked';
                                                                            } ?> value="93" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_93">3 Slaapkamers</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_92" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(92, $am_prop) != false) echo 'checked';
                                                                            } ?> value="92" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_92">2 Slaapkamers</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_55" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(55, $am_prop) != false) echo 'checked';
                                                                            } ?> value="55" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_55">Ongemeubileerd</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_87" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(87, $am_prop) != false) echo 'checked';
                                                                            } ?> value="87" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_87">Veranda</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_88" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(88, $am_prop) != false) echo 'checked';
                                                                            } ?> value="88" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_88">Zolder</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_58" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(58, $am_prop) != false) echo 'checked';
                                                                            } ?> value="58" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_58">excl- gas,water en lektra </label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_94" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(94, $am_prop) != false) echo 'checked';
                                                                            } ?> value="94" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_94">4 Slaapkamers</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_89" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(89, $am_prop) != false) echo 'checked';
                                                                            } ?> value="89" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_89">Berging</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_3" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(3, $am_prop) != false) echo 'checked';
                                                                            } ?> value="3" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_3">Cable Internet</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_4" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(4, $am_prop) != false) echo 'checked';
                                                                            } ?> value="4" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_4">Cable TV</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_5" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(5, $am_prop) != false) echo 'checked';
                                                                            } ?> value="5" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_5">Electric Hot Water</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_8" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(8, $am_prop) != false) echo 'checked';
                                                                            } ?> value="8" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_8">Garage</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_10" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(10, $am_prop) != false) echo 'checked';
                                                                            } ?> value="10" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_10">Sprinkler System</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_11" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(11, $am_prop) != false) echo 'checked';
                                                                            } ?> value="11" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_11">Wood Stove</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_42" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(42, $am_prop) != false) echo 'checked';
                                                                            } ?> value="42" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_42">Satellite Dish</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_48" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(48, $am_prop) != false) echo 'checked';
                                                                            } ?> value="48" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_48">Badkamer met douche</label>
                                                                    <BR />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td width="50%" style="text-align:left;padding:10px;vertical-align:top;">
                                                        <table width="100%">
                                                            <tr>
                                                                <td width="100%" style="height:30px;background-color:#2a2a2a;color:white;text-align:center;font-weight:bold;font-size:16px;">
                                                                    Toegankelijkheidsvoorzieningen										</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%">
                                                                    <input type="checkbox" id="amenity_31" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(31, $am_prop) != false) echo 'checked';
                                                                            } ?> value="31" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_31">Handicap Facilities</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_49" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(49, $am_prop) != false) echo 'checked';
                                                                            } ?> value="49" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_49">Wheelchair Ramp</label>
                                                                    <BR />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr><tr>								<td width="50%" style="text-align:left;padding:10px;vertical-align:top;">
                                                        <table width="100%">
                                                            <tr>
                                                                <td width="100%" style="height:30px;background-color:#2a2a2a;color:white;text-align:center;font-weight:bold;font-size:16px;">
                                                                    Apparaat voorzieningen										</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%">
                                                                    <input type="checkbox" id="amenity_6" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(6, $am_prop) != false) echo 'checked';
                                                                            } ?> value="6" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_6">Freezer</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_9" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(9, $am_prop) != false) echo 'checked';
                                                                            } ?> value="9" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_9">Microwave</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_14" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(14, $am_prop) != false) echo 'checked';
                                                                            } ?> value="14" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_14">Washer/Dryer</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_15" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(15, $am_prop) != false) echo 'checked';
                                                                            } ?> value="15" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_15">Dishwasher</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_26" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(26, $am_prop) != false) echo 'checked';
                                                                            } ?> value="26" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_26">Garbage Disposal</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_30" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(30, $am_prop) != false) echo 'checked';
                                                                            } ?> value="30" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_30">Grill Top</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_38" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(38, $am_prop) != false) echo 'checked';
                                                                            } ?> value="38" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_38">Toilet</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_39" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(39, $am_prop) != false) echo 'checked';
                                                                            } ?> value="39" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_39">Keuken</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_40" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(40, $am_prop) != false) echo 'checked';
                                                                            } ?> value="40" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_40">Wasmashine</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_47" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(47, $am_prop) != false) echo 'checked';
                                                                            } ?> value="47" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_47">Trash Compactor</label>
                                                                    <BR />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td width="50%" style="text-align:left;padding:10px;vertical-align:top;">
                                                        <table width="100%">
                                                            <tr>
                                                                <td width="100%" style="height:30px;background-color:#2a2a2a;color:white;text-align:center;font-weight:bold;font-size:16px;">
                                                                    Gemeenschappelijke voorzieningen										</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%">
                                                                    <input type="checkbox" id="amenity_7" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(7, $am_prop) != false) echo 'checked';
                                                                            } ?> value="7" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_7">Swimming Pool</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_45" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(45, $am_prop) != false) echo 'checked';
                                                                            } ?> value="45" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_45">Tennis Court</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_46" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(46, $am_prop) != false) echo 'checked';
                                                                            } ?> value="46" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_46">Football ground</label>
                                                                    <BR />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr><tr>								<td width="50%" style="text-align:left;padding:10px;vertical-align:top;">
                                                        <table width="100%">
                                                            <tr>
                                                                <td width="100%" style="height:30px;background-color:#2a2a2a;color:white;text-align:center;font-weight:bold;font-size:16px;">
                                                                    Energiebesparende voorzieningen											</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%">
                                                                    <input type="checkbox" id="amenity_1" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(1, $am_prop) != false) echo 'checked';
                                                                            } ?> value="1" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_1">Gas Hot Water</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_24" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(24, $am_prop) != false) echo 'checked';
                                                                            } ?> value="24" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_24">Fireplace</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_27" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(27, $am_prop) != false) echo 'checked';
                                                                            } ?> value="27" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_27">Gas Fireplace</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_28" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(28, $am_prop) != false) echo 'checked';
                                                                            } ?> value="28" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_28">Gas Stove</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_36" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(36, $am_prop) != false) echo 'checked';
                                                                            } ?> value="36" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_36">Pellet Stove</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_37" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(37, $am_prop) != false) echo 'checked';
                                                                            } ?> value="37" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_37">Gemeubileerd</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_50" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(50, $am_prop) != false) echo 'checked';
                                                                            } ?> value="50" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_50">Wood Stove</label>
                                                                    <BR />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td width="50%" style="text-align:left;padding:10px;vertical-align:top;">
                                                        <table width="100%">
                                                            <tr>
                                                                <td width="100%" style="height:30px;background-color:#2a2a2a;color:white;text-align:center;font-weight:bold;font-size:16px;">
                                                                    Exterieur Voorzieningen										</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%">
                                                                    <input type="checkbox" id="amenity_12" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(12, $am_prop) != false) echo 'checked';
                                                                            } ?> value="12" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_12">Fruit Trees</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_17" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(17, $am_prop) != false) echo 'checked';
                                                                            } ?> value="17" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_17">Boat Slip</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_21" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(21, $am_prop) != false) echo 'checked';
                                                                            } ?> value="21" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_21">Covered Patio</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_22" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(22, $am_prop) != false) echo 'checked';
                                                                            } ?> value="22" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_22">Exterior Lighting</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_23" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(23, $am_prop) != false) echo 'checked';
                                                                            } ?> value="23" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_23">Fence</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_25" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(25, $am_prop) != false) echo 'checked';
                                                                            } ?> value="25" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_25">Garage</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_29" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(29, $am_prop) != false) echo 'checked';
                                                                            } ?> value="29" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_29">Gazebo</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_34" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(34, $am_prop) != false) echo 'checked';
                                                                            } ?> value="34" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_34">Open Deck</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_35" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(35, $am_prop) != false) echo 'checked';
                                                                            } ?> value="35" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_35">Tuin</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_41" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(41, $am_prop) != false) echo 'checked';
                                                                            } ?> value="41" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_41">RV Parking</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_43" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(43, $am_prop) != false) echo 'checked';
                                                                            } ?> value="43" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_43">TV</label>
                                                                    <BR />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr><tr>								<td width="50%" style="text-align:left;padding:10px;vertical-align:top;">
                                                        <table width="100%">
                                                            <tr>
                                                                <td width="100%" style="height:30px;background-color:#2a2a2a;color:white;text-align:center;font-weight:bold;font-size:16px;">
                                                                    Interieur voorzieningen										</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%">
                                                                    <input type="checkbox" id="amenity_2" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(2, $am_prop) != false) echo 'checked';
                                                                            } ?> value="2" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_2">Central Air</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_19" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(19, $am_prop) != false) echo 'checked';
                                                                            } ?> value="19" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_19">Carpet Throughout</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_20" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(20, $am_prop) != false) echo 'checked';
                                                                            } ?> value="20" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_20">Central Vac</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_32" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(32, $am_prop) != false) echo 'checked';
                                                                            } ?> value="32" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_32">Jacuzi Tub</label>
                                                                    <BR />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td width="50%" style="text-align:left;padding:10px;vertical-align:top;">
                                                        <table width="100%">
                                                            <tr>
                                                                <td width="100%" style="height:30px;background-color:#2a2a2a;color:white;text-align:center;font-weight:bold;font-size:16px;">
                                                                    Landschap Voorzieningen											</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%">
                                                                    <input type="checkbox" id="amenity_13" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(13, $am_prop) != false) echo 'checked';
                                                                            } ?> value="13" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_13">Skylights</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_16" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(16, $am_prop) != false) echo 'checked';
                                                                            } ?> value="16" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_16">Landscaping</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_33" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(33, $am_prop) != false) echo 'checked';
                                                                            } ?> value="33" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_33">Lawn</label>
                                                                    <BR />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr><tr>								<td width="50%" style="text-align:left;padding:10px;vertical-align:top;">
                                                        <table width="100%">
                                                            <tr>
                                                                <td width="100%" style="height:30px;background-color:#2a2a2a;color:white;text-align:center;font-weight:bold;font-size:16px;">
                                                                    Beveiliging Voorzieningen									</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%">
                                                                    <input type="checkbox" id="amenity_18" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(18, $am_prop) != false) echo 'checked';
                                                                            } ?> value="18" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_18">Burglar Alarm</label>
                                                                    <BR />
                                                                    <input type="checkbox" id="amenity_44" name="amenities[]" <?php if ($_GET['adres_id'] != 0) {
                                                                                if (searchIt(44, $am_prop) != false) echo 'checked';
                                                                            } ?> value="44" /> &nbsp; 
                                                                    <label style="display:inline !important;" for="amenity_44">Internet</label>
                                                                    <BR />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>

                                        </div>				
                                        <div id="opentime-page" class="tab-pane">
                                            <table width="100%">
                                                <tr>
                                                    <!-- Other information -->
                                                    <td width="100%">
                                                        <div class="col width-100">
                                                            <fieldset class="general">
                                                                <legend>Open House</legend>
                                                                <table  width="100%" class="admintable">
                                                                    <tr>
                                                                        <td class="key" valign="top">
                                                                            Opening Time									</td>
                                                                        <td>
                                                                            <table width="100%" id="property_open_table">
                                                                                <tr>
                                                                                    <th>
                                                                                        From												</th>
                                                                                    <th>
                                                                                        To												</th>
                                                                                </tr>
                                                                                <tr id="history_table_tr">
                                                                                    <td>
                                                                                        <div class="field-calendar">
                                                                                            <div class="input-append">
                                                                                                <input type="text" id="start_from1" name="start_from[]" value="" 		 data-alt-value="" autocomplete="off"/>
                                                                                                <button type="button" class="btn btn-secondary"
                                                                                                        id="start_from1_btn"
                                                                                                        data-inputfield="start_from1"
                                                                                                        data-dayformat="%Y-%m-%d %H:%M:%S"
                                                                                                        data-button="start_from1_btn"
                                                                                                        data-firstday="0"
                                                                                                        data-weekend="0,6"
                                                                                                        data-today-btn="0"
                                                                                                        data-week-numbers="0"
                                                                                                        data-show-time="0"
                                                                                                        data-show-others="0"
                                                                                                        data-time-24="24"
                                                                                                        data-only-months-nav="0"
                                                                                                        ><span class="icon-calendar"></span></button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="field-calendar">
                                                                                            <div class="input-append">
                                                                                                <input type="text" id="end_to1" name="end_to[]" value="" 		 data-alt-value="" autocomplete="off"/>
                                                                                                <button type="button" class="btn btn-secondary"
                                                                                                        id="end_to1_btn"
                                                                                                        data-inputfield="end_to1"
                                                                                                        data-dayformat="%Y-%m-%d %H:%M:%S"
                                                                                                        data-button="end_to1_btn"
                                                                                                        data-firstday="0"
                                                                                                        data-weekend="0,6"
                                                                                                        data-today-btn="0"
                                                                                                        data-week-numbers="0"
                                                                                                        data-show-time="0"
                                                                                                        data-show-others="0"
                                                                                                        data-time-24="24"
                                                                                                        data-only-months-nav="0"
                                                                                                        ><span class="icon-calendar"></span></button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr id="history_table_tr">
                                                                                    <td>
                                                                                        <div class="field-calendar">
                                                                                            <div class="input-append">
                                                                                                <input type="text" id="start_from2" name="start_from[]" value="" 		 data-alt-value="" autocomplete="off"/>
                                                                                                <button type="button" class="btn btn-secondary"
                                                                                                        id="start_from2_btn"
                                                                                                        data-inputfield="start_from2"
                                                                                                        data-dayformat="%Y-%m-%d %H:%M:%S"
                                                                                                        data-button="start_from2_btn"
                                                                                                        data-firstday="0"
                                                                                                        data-weekend="0,6"
                                                                                                        data-today-btn="0"
                                                                                                        data-week-numbers="0"
                                                                                                        data-show-time="0"
                                                                                                        data-show-others="0"
                                                                                                        data-time-24="24"
                                                                                                        data-only-months-nav="0"
                                                                                                        ><span class="icon-calendar"></span></button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="field-calendar">
                                                                                            <div class="input-append">
                                                                                                <input type="text" id="end_to2" name="end_to[]" value="" 		 data-alt-value="" autocomplete="off"/>
                                                                                                <button type="button" class="btn btn-secondary"
                                                                                                        id="end_to2_btn"
                                                                                                        data-inputfield="end_to2"
                                                                                                        data-dayformat="%Y-%m-%d %H:%M:%S"
                                                                                                        data-button="end_to2_btn"
                                                                                                        data-firstday="0"
                                                                                                        data-weekend="0,6"
                                                                                                        data-today-btn="0"
                                                                                                        data-week-numbers="0"
                                                                                                        data-show-time="0"
                                                                                                        data-show-others="0"
                                                                                                        data-time-24="24"
                                                                                                        data-only-months-nav="0"
                                                                                                        ><span class="icon-calendar"></span></button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr id="history_table_tr">
                                                                                    <td>
                                                                                        <div class="field-calendar">
                                                                                            <div class="input-append">
                                                                                                <input type="text" id="start_from3" name="start_from[]" value="" 		 data-alt-value="" autocomplete="off"/>
                                                                                                <button type="button" class="btn btn-secondary"
                                                                                                        id="start_from3_btn"
                                                                                                        data-inputfield="start_from3"
                                                                                                        data-dayformat="%Y-%m-%d %H:%M:%S"
                                                                                                        data-button="start_from3_btn"
                                                                                                        data-firstday="0"
                                                                                                        data-weekend="0,6"
                                                                                                        data-today-btn="0"
                                                                                                        data-week-numbers="0"
                                                                                                        data-show-time="0"
                                                                                                        data-show-others="0"
                                                                                                        data-time-24="24"
                                                                                                        data-only-months-nav="0"
                                                                                                        ><span class="icon-calendar"></span></button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="field-calendar">
                                                                                            <div class="input-append">
                                                                                                <input type="text" id="end_to3" name="end_to[]" value="" 		 data-alt-value="" autocomplete="off"/>
                                                                                                <button type="button" class="btn btn-secondary"
                                                                                                        id="end_to3_btn"
                                                                                                        data-inputfield="end_to3"
                                                                                                        data-dayformat="%Y-%m-%d %H:%M:%S"
                                                                                                        data-button="end_to3_btn"
                                                                                                        data-firstday="0"
                                                                                                        data-weekend="0,6"
                                                                                                        data-today-btn="0"
                                                                                                        data-week-numbers="0"
                                                                                                        data-show-time="0"
                                                                                                        data-show-others="0"
                                                                                                        data-time-24="24"
                                                                                                        data-only-months-nav="0"
                                                                                                        ><span class="icon-calendar"></span></button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr id="history_table_tr">
                                                                                    <td>
                                                                                        <div class="field-calendar">
                                                                                            <div class="input-append">
                                                                                                <input type="text" id="start_from4" name="start_from[]" value="" 		 data-alt-value="" autocomplete="off"/>
                                                                                                <button type="button" class="btn btn-secondary"
                                                                                                        id="start_from4_btn"
                                                                                                        data-inputfield="start_from4"
                                                                                                        data-dayformat="%Y-%m-%d %H:%M:%S"
                                                                                                        data-button="start_from4_btn"
                                                                                                        data-firstday="0"
                                                                                                        data-weekend="0,6"
                                                                                                        data-today-btn="0"
                                                                                                        data-week-numbers="0"
                                                                                                        data-show-time="0"
                                                                                                        data-show-others="0"
                                                                                                        data-time-24="24"
                                                                                                        data-only-months-nav="0"
                                                                                                        ><span class="icon-calendar"></span></button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="field-calendar">
                                                                                            <div class="input-append">
                                                                                                <input type="text" id="end_to4" name="end_to[]" value="" 		 data-alt-value="" autocomplete="off"/>
                                                                                                <button type="button" class="btn btn-secondary"
                                                                                                        id="end_to4_btn"
                                                                                                        data-inputfield="end_to4"
                                                                                                        data-dayformat="%Y-%m-%d %H:%M:%S"
                                                                                                        data-button="end_to4_btn"
                                                                                                        data-firstday="0"
                                                                                                        data-weekend="0,6"
                                                                                                        data-today-btn="0"
                                                                                                        data-week-numbers="0"
                                                                                                        data-show-time="0"
                                                                                                        data-show-others="0"
                                                                                                        data-time-24="24"
                                                                                                        data-only-months-nav="0"
                                                                                                        ><span class="icon-calendar"></span></button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr id="history_table_tr">
                                                                                    <td>
                                                                                        <div class="field-calendar">
                                                                                            <div class="input-append">
                                                                                                <input type="text" id="start_from5" name="start_from[]" value="" 		 data-alt-value="" autocomplete="off"/>
                                                                                                <button type="button" class="btn btn-secondary"
                                                                                                        id="start_from5_btn"
                                                                                                        data-inputfield="start_from5"
                                                                                                        data-dayformat="%Y-%m-%d %H:%M:%S"
                                                                                                        data-button="start_from5_btn"
                                                                                                        data-firstday="0"
                                                                                                        data-weekend="0,6"
                                                                                                        data-today-btn="0"
                                                                                                        data-week-numbers="0"
                                                                                                        data-show-time="0"
                                                                                                        data-show-others="0"
                                                                                                        data-time-24="24"
                                                                                                        data-only-months-nav="0"
                                                                                                        ><span class="icon-calendar"></span></button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="field-calendar">
                                                                                            <div class="input-append">
                                                                                                <input type="text" id="end_to5" name="end_to[]" value="" 		 data-alt-value="" autocomplete="off"/>
                                                                                                <button type="button" class="btn btn-secondary"
                                                                                                        id="end_to5_btn"
                                                                                                        data-inputfield="end_to5"
                                                                                                        data-dayformat="%Y-%m-%d %H:%M:%S"
                                                                                                        data-button="end_to5_btn"
                                                                                                        data-firstday="0"
                                                                                                        data-weekend="0,6"
                                                                                                        data-today-btn="0"
                                                                                                        data-week-numbers="0"
                                                                                                        data-show-time="0"
                                                                                                        data-show-others="0"
                                                                                                        data-time-24="24"
                                                                                                        data-only-months-nav="0"
                                                                                                        ><span class="icon-calendar"></span></button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </fieldset>
                                                        </div>	
                                                    </td>
                                                    <!-- End Other information -->
                                                </tr>
                                            </table>

                                        </div>		

                                        <div id="neighbor-page" class="tab-pane">
                                            <table  width="100%" class="admintable">
                                                <tr>
                                                    <td class="key" width="15%">
                                                        <label for="nei_1">
                                                            <strong>Shopping center</strong>
                                                        </label>
                                                    </td>
                                                    <td width="5%">
                                                        <input type="checkbox" value="0" name="nei_1" id="nei_1" 0 onclick="javascript:showNeighborhood('1')" />
                                                    </td>
                                                    <td width="80%">
                                                        <div id="div_nei_1" style="display:none;">
                                                            <input type="text" name="mins_nei_1" size="3" value="" class="input-mini" style="width:20px;" /> minutes by								&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="traffic_type_1" id="traffic_type_1" value="1" > Walk								<input type="radio" name="traffic_type_1" id="traffic_type_1" value="2" > Car								<input type="radio" name="traffic_type_1" id="traffic_type_1" value="3" > Train							</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="key" width="15%">
                                                        <label for="nei_2">
                                                            <strong>Town center</strong>
                                                        </label>
                                                    </td>
                                                    <td width="5%">
                                                        <input type="checkbox" value="0" name="nei_2" id="nei_2" 0 onclick="javascript:showNeighborhood('2')" />
                                                    </td>
                                                    <td width="80%">
                                                        <div id="div_nei_2" style="display:none;">
                                                            <input type="text" name="mins_nei_2" size="3" value="" class="input-mini" style="width:20px;" /> minutes by								&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="traffic_type_2" id="traffic_type_2" value="1" > Walk								<input type="radio" name="traffic_type_2" id="traffic_type_2" value="2" > Car								<input type="radio" name="traffic_type_2" id="traffic_type_2" value="3" > Train							</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="key" width="15%">
                                                        <label for="nei_3">
                                                            <strong>Hospital</strong>
                                                        </label>
                                                    </td>
                                                    <td width="5%">
                                                        <input type="checkbox" value="0" name="nei_3" id="nei_3" 0 onclick="javascript:showNeighborhood('3')" />
                                                    </td>
                                                    <td width="80%">
                                                        <div id="div_nei_3" style="display:none;">
                                                            <input type="text" name="mins_nei_3" size="3" value="" class="input-mini" style="width:20px;" /> minutes by								&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="traffic_type_3" id="traffic_type_3" value="1" > Walk								<input type="radio" name="traffic_type_3" id="traffic_type_3" value="2" > Car								<input type="radio" name="traffic_type_3" id="traffic_type_3" value="3" > Train							</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="key" width="15%">
                                                        <label for="nei_4">
                                                            <strong>Police station</strong>
                                                        </label>
                                                    </td>
                                                    <td width="5%">
                                                        <input type="checkbox" value="0" name="nei_4" id="nei_4" 0 onclick="javascript:showNeighborhood('4')" />
                                                    </td>
                                                    <td width="80%">
                                                        <div id="div_nei_4" style="display:none;">
                                                            <input type="text" name="mins_nei_4" size="3" value="" class="input-mini" style="width:20px;" /> minutes by								&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="traffic_type_4" id="traffic_type_4" value="1" > Walk								<input type="radio" name="traffic_type_4" id="traffic_type_4" value="2" > Car								<input type="radio" name="traffic_type_4" id="traffic_type_4" value="3" > Train							</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="key" width="15%">
                                                        <label for="nei_5">
                                                            <strong>Train station</strong>
                                                        </label>
                                                    </td>
                                                    <td width="5%">
                                                        <input type="checkbox" value="0" name="nei_5" id="nei_5" 0 onclick="javascript:showNeighborhood('5')" />
                                                    </td>
                                                    <td width="80%">
                                                        <div id="div_nei_5" style="display:none;">
                                                            <input type="text" name="mins_nei_5" size="3" value="" class="input-mini" style="width:20px;" /> minutes by								&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="traffic_type_5" id="traffic_type_5" value="1" > Walk								<input type="radio" name="traffic_type_5" id="traffic_type_5" value="2" > Car								<input type="radio" name="traffic_type_5" id="traffic_type_5" value="3" > Train							</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="key" width="15%">
                                                        <label for="nei_6">
                                                            <strong>Bus station</strong>
                                                        </label>
                                                    </td>
                                                    <td width="5%">
                                                        <input type="checkbox" value="0" name="nei_6" id="nei_6" 0 onclick="javascript:showNeighborhood('6')" />
                                                    </td>
                                                    <td width="80%">
                                                        <div id="div_nei_6" style="display:none;">
                                                            <input type="text" name="mins_nei_6" size="3" value="" class="input-mini" style="width:20px;" /> minutes by								&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="traffic_type_6" id="traffic_type_6" value="1" > Walk								<input type="radio" name="traffic_type_6" id="traffic_type_6" value="2" > Car								<input type="radio" name="traffic_type_6" id="traffic_type_6" value="3" > Train							</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="key" width="15%">
                                                        <label for="nei_7">
                                                            <strong>Airport</strong>
                                                        </label>
                                                    </td>
                                                    <td width="5%">
                                                        <input type="checkbox" value="0" name="nei_7" id="nei_7" 0 onclick="javascript:showNeighborhood('7')" />
                                                    </td>
                                                    <td width="80%">
                                                        <div id="div_nei_7" style="display:none;">
                                                            <input type="text" name="mins_nei_7" size="3" value="" class="input-mini" style="width:20px;" /> minutes by								&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="traffic_type_7" id="traffic_type_7" value="1" > Walk								<input type="radio" name="traffic_type_7" id="traffic_type_7" value="2" > Car								<input type="radio" name="traffic_type_7" id="traffic_type_7" value="3" > Train							</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="key" width="15%">
                                                        <label for="nei_8">
                                                            <strong>Coffee shop</strong>
                                                        </label>
                                                    </td>
                                                    <td width="5%">
                                                        <input type="checkbox" value="0" name="nei_8" id="nei_8" 0 onclick="javascript:showNeighborhood('8')" />
                                                    </td>
                                                    <td width="80%">
                                                        <div id="div_nei_8" style="display:none;">
                                                            <input type="text" name="mins_nei_8" size="3" value="" class="input-mini" style="width:20px;" /> minutes by								&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="traffic_type_8" id="traffic_type_8" value="1" > Walk								<input type="radio" name="traffic_type_8" id="traffic_type_8" value="2" > Car								<input type="radio" name="traffic_type_8" id="traffic_type_8" value="3" > Train							</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="key" width="15%">
                                                        <label for="nei_9">
                                                            <strong>Beach</strong>
                                                        </label>
                                                    </td>
                                                    <td width="5%">
                                                        <input type="checkbox" value="0" name="nei_9" id="nei_9" 0 onclick="javascript:showNeighborhood('9')" />
                                                    </td>
                                                    <td width="80%">
                                                        <div id="div_nei_9" style="display:none;">
                                                            <input type="text" name="mins_nei_9" size="3" value="" class="input-mini" style="width:20px;" /> minutes by								&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="traffic_type_9" id="traffic_type_9" value="1" > Walk								<input type="radio" name="traffic_type_9" id="traffic_type_9" value="2" > Car								<input type="radio" name="traffic_type_9" id="traffic_type_9" value="3" > Train							</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="key" width="15%">
                                                        <label for="nei_10">
                                                            <strong>Cinema</strong>
                                                        </label>
                                                    </td>
                                                    <td width="5%">
                                                        <input type="checkbox" value="0" name="nei_10" id="nei_10" 0 onclick="javascript:showNeighborhood('10')" />
                                                    </td>
                                                    <td width="80%">
                                                        <div id="div_nei_10" style="display:none;">
                                                            <input type="text" name="mins_nei_10" size="3" value="" class="input-mini" style="width:20px;" /> minutes by								&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="traffic_type_10" id="traffic_type_10" value="1" > Walk								<input type="radio" name="traffic_type_10" id="traffic_type_10" value="2" > Car								<input type="radio" name="traffic_type_10" id="traffic_type_10" value="3" > Train							</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="key" width="15%">
                                                        <label for="nei_11">
                                                            <strong>Park</strong>
                                                        </label>
                                                    </td>
                                                    <td width="5%">
                                                        <input type="checkbox" value="0" name="nei_11" id="nei_11" 0 onclick="javascript:showNeighborhood('11')" />
                                                    </td>
                                                    <td width="80%">
                                                        <div id="div_nei_11" style="display:none;">
                                                            <input type="text" name="mins_nei_11" size="3" value="" class="input-mini" style="width:20px;" /> minutes by								&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="traffic_type_11" id="traffic_type_11" value="1" > Walk								<input type="radio" name="traffic_type_11" id="traffic_type_11" value="2" > Car								<input type="radio" name="traffic_type_11" id="traffic_type_11" value="3" > Train							</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="key" width="15%">
                                                        <label for="nei_12">
                                                            <strong>School</strong>
                                                        </label>
                                                    </td>
                                                    <td width="5%">
                                                        <input type="checkbox" value="0" name="nei_12" id="nei_12" 0 onclick="javascript:showNeighborhood('12')" />
                                                    </td>
                                                    <td width="80%">
                                                        <div id="div_nei_12" style="display:none;">
                                                            <input type="text" name="mins_nei_12" size="3" value="" class="input-mini" style="width:20px;" /> minutes by								&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="traffic_type_12" id="traffic_type_12" value="1" > Walk								<input type="radio" name="traffic_type_12" id="traffic_type_12" value="2" > Car								<input type="radio" name="traffic_type_12" id="traffic_type_12" value="3" > Train							</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="key" width="15%">
                                                        <label for="nei_13">
                                                            <strong>University</strong>
                                                        </label>
                                                    </td>
                                                    <td width="5%">
                                                        <input type="checkbox" value="0" name="nei_13" id="nei_13" 0 onclick="javascript:showNeighborhood('13')" />
                                                    </td>
                                                    <td width="80%">
                                                        <div id="div_nei_13" style="display:none;">
                                                            <input type="text" name="mins_nei_13" size="3" value="" class="input-mini" style="width:20px;" /> minutes by								&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="traffic_type_13" id="traffic_type_13" value="1" > Walk								<input type="radio" name="traffic_type_13" id="traffic_type_13" value="2" > Car								<input type="radio" name="traffic_type_13" id="traffic_type_13" value="3" > Train							</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="key" width="15%">
                                                        <label for="nei_14">
                                                            <strong>Exhibition</strong>
                                                        </label>
                                                    </td>
                                                    <td width="5%">
                                                        <input type="checkbox" value="0" name="nei_14" id="nei_14" 0 onclick="javascript:showNeighborhood('14')" />
                                                    </td>
                                                    <td width="80%">
                                                        <div id="div_nei_14" style="display:none;">
                                                            <input type="text" name="mins_nei_14" size="3" value="" class="input-mini" style="width:20px;" /> minutes by								&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="traffic_type_14" id="traffic_type_14" value="1" > Walk								<input type="radio" name="traffic_type_14" id="traffic_type_14" value="2" > Car								<input type="radio" name="traffic_type_14" id="traffic_type_14" value="3" > Train							</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="key" width="15%">
                                                        <label for="nei_15">
                                                            <strong>Super market</strong>
                                                        </label>
                                                    </td>
                                                    <td width="5%">
                                                        <input type="checkbox" value="0" name="nei_15" id="nei_15" 0 onclick="javascript:showNeighborhood('15')" />
                                                    </td>
                                                    <td width="80%">
                                                        <div id="div_nei_15" style="display:none;">
                                                            <input type="text" name="mins_nei_15" size="3" value="" class="input-mini" style="width:20px;" /> minutes by								&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" name="traffic_type_15" id="traffic_type_15" value="1" > Walk								<input type="radio" name="traffic_type_15" id="traffic_type_15" value="2" > Car								<input type="radio" name="traffic_type_15" id="traffic_type_15" value="3" > Train							</div>
                                                    </td>
                                                </tr>
                                            </table>
                                            <script language="javascript">
                                                function showNeighborhood(nid) {
                                                    var temp = document.getElementById('nei_' + nid);
                                                    var div = document.getElementById('div_nei_' + nid);
                                                    if (temp.value == 0) {
                                                        div.style.display = "block";
                                                        temp.value = 1;
                                                    } else {
                                                        div.style.display = "none";
                                                        temp.value = 0;
                                                    }
                                                }
                                            </script>

                                        </div>		
                                        <div id="photo-page" class="tab-pane">
                                            <div class="col width-100">
                                                <fieldset id="photos2292">
                                                    <legend>Eigendom foto's</legend>


                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="photo-file">
                                                            <BR /><BR />
                                                            <div style="display:block;padding:3px;border:1px dotted #efefef;" id="div_0">

<?php
$nr_z = 1;
foreach ($n_zd as $k => $zd) {


    echo '
										<table class="admintable">
										<tr>
										<td class="key">
										Photo												</td>
										<td width="70%">
										<img src="http://khbemiddeling.nl/images/osproperty/properties/';

    if ($_GET['adres_id'] != 0) {
        echo $pr->pobierz('prop_id');
    }

    echo '/thumb/' . $zd['image'] . '"
										class="img-rounded img-polaroid oslazy" style="width:170px !important;max-width:150px !important;"   alt="" />
            							<span id="photo_1div">
										<input type="file" name="ph_' . $nr_z . '" id="photo_1" size="30" onchange="javacript:check_file("photo_1");">
										</span>
										</td>
										</tr>
										
										
										<tr>
												<td class="key">
													Photo description												</td>
												<td>
													<textarea name="photodesc_' . $nr_z . '" id="photodesc_1" class="inputbox" cols="40" rows="3">' . $zd['image_desc'] . '</textarea>
												</td>
											</tr>
											<tr>
												<td class="key">

													Ordering												</td>
												<td>
													<input type="text" name="ordering_' . $nr_z . '" id="ordering_1" class="input-mini" style="width:20px;" value="' . $zd['ordering'] . '">
												
												<input type="hidden" name="ph2_' . $nr_z . '"  value="' . $zd['image'] . '" />
											
												</td>
											</tr>
											<tr>
												<td class="key">

													<form action="" method="post" enctype="multipart/form-data">
	

													<input name="zdjecie_do_skasowania" value="' . $zd['image'] . '" type="hidden">
													<input class="usun" name="kasuj_zdjecie" value="" type="submit">												</td>
													</form>	
													<td>
													</td>
											</tr>
										</table>
										
										
										';

    $nr_z++;
}


if ($nr_z <= 20) {

    while ($nr_z <= 20) {

        echo '
										
										<div style="display:none;padding:3px;border:1px dotted #efefef;" id="div_' . $nr_z . '">
										<table class="admintable">
										<tr>
										<td class="key">
										Photo ' . $nr_z . '												</td>
										<td width="70%">
										<img src="/components/com_osproperty/images/assets/loader.gif" data-original="http://khbemiddeling.nl/images/osproperty/properties/';



        echo '/thumb/"
										class="img-rounded img-polaroid oslazy" style="width:170px !important;max-width:150px !important;"   alt="" />
            							<span id="photo_1div">
										<input type="file" name="ph_' . $nr_z . '" id="photo_1" size="30" onchange="javacript:check_file("photo_1");">
										</span>
										</td>
										</tr>
										
										
										<tr>
												<td class="key">
													Photo description												</td>
												<td>
													<textarea name="photodesc_' . $nr_z . '" id="photodesc_1" class="inputbox" cols="40" rows="3"></textarea>
												</td>
											</tr>
											<tr>
												<td class="key">

													Ordering												</td>
												<td>
													<input type="text" name="ordering_' . $nr_z . '" id="ordering_1" class="input-mini" style="width:20px;" value="' . $nr_z . '">
												</td>
											</tr>
												</table>
										
										</div>
										';


        $nr_z++;
    }
}
?>									





                                                            </div>



                                                            <div id="newphoto" class="button2-left" style="display:block;">
                                                                <div class="image">
                                                                    <a href="javascript:addPhoto();" class="btn btn-success"><i class="icon-new"></i>&nbsp;Voeg foto toe</a>
                                                                </div>
                                                            </div>

                                                            <BR>

                                                        </div>
                                                        <div class="tab-pane" id="zip-file"  style="text-align:center;">
                                                            <input type="file" onchange="javascript:check_file_type()" class="inputbox" id="zip_file" name="zip_file" size="30">
                                                        </div>
                                                        <div class="tab-pane" id="ajax-file" style="text-align:center;">
                                                            <div id="itemImagesWrap">
                                                                <div id="itemImages">
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                            <div id="uploader"><p>Unfortunately images multiupload was unable to start, there are probably some script errors on site.						</div>
                                                        </div>
                                                </fieldset>
                                            </div>
                                            <div>
                                                <!-- jQuery Upload go here -->

                                            </div>

                                        </div>		
                                        <div id="pulishing-page" class="tab-pane">
                                            <table width="100%" class="admintable" style="padding:5px;">
                                                <tr>


                                                <input type="hidden" id="agent_id" name="agent_id" value="1" />						 
                                                </td>
                                                </tr>

                                                <tr>
                                                    <td class="key">
                                                        Featured					</td>
                                                    <td>
                                                        <fieldset id="isFeatured" class="radio btn-group btn-group-yesno"><input type="radio" id="isFeatured0" name="isFeatured" value="1" <?php if ($_GET['adres_id'] != 0) {
    if ($prop->pobierz('isFeatured') == 1) echo ' checked="checked"';
} ?> /><label for="isFeatured0">Ja</label><input type="radio" id="isFeatured1" name="isFeatured" value="0" <?php if ($_GET['adres_id'] != 0) {
    if ($prop->pobierz('isFeatured') == 0) echo ' checked="checked"';
} ?> /><label for="isFeatured1">Nee</label></fieldset>					</td>
                                                </tr>
                                                <tr>
                                                    <td class="key" width="15%">
                                                        Approved					</td>
                                                    <td width="85%">
                                                        <fieldset id="approved" class="radio btn-group btn-group-yesno"><input type="radio" id="approved0" name="approved" value="1" <?php if ($_GET['adres_id'] != 0) {
    if ($prop->pobierz('approved') == 1) echo ' checked="checked"';
} ?> /><label for="approved0">Ja</label><input type="radio" id="approved1" name="approved" value="0" <?php if ($_GET['adres_id'] != 0) {
    if ($prop->pobierz('approved') == 0) echo ' checked="checked"';
} ?> /><label for="approved1">Nee</label></fieldset>					</td>
                                                </tr>
                                                <tr>
                                                    <td class="key">
                                                        Published					</td>
                                                    <td>
                                                        <fieldset id="published" class="radio btn-group btn-group-yesno"><input type="radio" id="published0" name="published" value="1" <?php if ($_GET['adres_id'] != 0) {
    if ($prop->pobierz('published') == 1) echo ' checked="checked"';
} ?>/><label for="published0">Ja</label><input type="radio" id="published1" name="published" value="0" <?php if ($_GET['adres_id'] != 0) {
    if ($prop->pobierz('published') == 0) echo ' checked="checked"';
} ?> /><label for="published1">Nee</label></fieldset>					</td>
                                                </tr>
                                                <tr>
                                                    <td class="key">
                                                        Start publishing					</td>
                                                    <td>
                                                        <div class="field-calendar">
                                                            <div class="input-append">
                                                                <input type="text" id="publish_up" name="publish_up" value="<?php if ($_GET['adres_id'] != 0) {
    echo $prop->pobierz('publish_up');
} ?>" class="input-small"		 data-alt-value="<?php if ($_GET['adres_id'] != 0) {
    echo $data_nl->zmiana_formatu_daty($prop->pobierz('publish_up'));
} ?>" autocomplete="off"/>
                                                                <button type="button" class="btn btn-secondary"
                                                                        id="publish_up_btn"
                                                                        data-inputfield="publish_up"
                                                                        data-dayformat="%d-%m-%Y"
                                                                        data-button="publish_up_btn"
                                                                        data-firstday="0"
                                                                        data-weekend="0,6"
                                                                        data-today-btn="0"
                                                                        data-week-numbers="0"
                                                                        data-show-time="0"
                                                                        data-show-others="0"
                                                                        data-time-24="24"
                                                                        data-only-months-nav="0"
                                                                        ><span class="icon-calendar"></span></button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="key">
                                                        End publishing					</td>
                                                    <td>
                                                        <div class="field-calendar">
                                                            <div class="input-append">
                                                                <input type="text" id="publish_down" name="publish_down" value="<?php if ($_GET['adres_id'] != 0) {
    echo $prop->pobierz('publish_down');
} ?>" class="input-small"		 data-alt-value="<?php if ($_GET['adres_id'] != 0) {
    echo $data_nl->zmiana_formatu_daty($prop->pobierz('publish_down'));
} ?>" autocomplete="off"/>
                                                                <button type="button" class="btn btn-secondary"
                                                                        id="publish_down_btn"
                                                                        data-inputfield="publish_down"
                                                                        data-dayformat="%d-%m-%Y"
                                                                        data-button="publish_down_btn"
                                                                        data-firstday="0"
                                                                        data-weekend="0,6"
                                                                        data-today-btn="0"
                                                                        data-week-numbers="0"
                                                                        data-show-time="0"
                                                                        data-show-others="0"
                                                                        data-time-24="24"
                                                                        data-only-months-nav="0"
                                                                        ><span class="icon-calendar"></span></button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                            </table>

                                        </div>

                                        <div id="meta-page" class="tab-pane">
                                            <table  width="100%" class="admintable" style="padding:5px;">
                                                <tr>
                                                    <td class="key" valign="top" width="15%">
                                                        Browser Page Title					</td>
                                                    <td width="85%">
                                                        <input type="text" class="input-large" name="pro_browser_title" id="pro_browser_title" value="" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="key" valign="top">
                                                        Meta description					</td>
                                                    <td width="70%">
                                                        <textarea name="metadesc" id="metadesc" cols="40" rows="4"></textarea>
                                                    </td>
                                                </tr>
                                            </table>

                                        </div>		

                                        <div id="note-page" class="tab-pane">
                                            <table width="100%" class="admintable">
                                                <tr>
                                                    <td class="key" valign="top" width="15%">
                                                        User note				</td>
                                                    <td width="85%">
                                                        <textarea name="note" id="note" cols="50" rows="5" class="inputbox" style="width:400px !important;height:150px !important;"></textarea>
                                                    </td>
                                                </tr>
                                            </table>

                                        </div>		
                                        </div>
                                        <input type="hidden" name="current_number_photo" id="current_number_photo" value="5" />
                                        <input type="hidden" name="newphoto" id="newphoto" value="6" />
                                        <input type="hidden" name="option" value="com_osproperty" />
                                        <input type="hidden" name="task" value="" />
                                        <input type="hidden" name="boxchecked" value="0" />
                                        <input type="hidden" name="id" value="2292" />
                                        <input type="hidden" name="MAX_FILE_SIZE" value="9000000000" />
                                        <input type="hidden" name="require_field" id="require_field" value="pro_name,category_id,pro_type,state,pro_small_desc,agent_id" />
                                        <input type="hidden" name="require_label" id="require_label" value="Property name,Category,Property type,State/Province,Small description,Owner" />
                                        <input type="hidden" name="type_id_1" id="type_id_1" value=""/>
                                        <input type="hidden" name="type_id_1_required" id="type_id_1_required" value=""/>
                                        <input type="hidden" name="type_id_1_required_name" id="type_id_1_required_name" value=""/>
                                        <input type="hidden" name="type_id_1_required_title" id="type_id_1_required_title" value=""/>
                                        <input type="hidden" name="type_id_2" id="type_id_2" value=""/>
                                        <input type="hidden" name="type_id_2_required" id="type_id_2_required" value=""/>
                                        <input type="hidden" name="type_id_2_required_name" id="type_id_2_required_name" value=""/>
                                        <input type="hidden" name="type_id_2_required_title" id="type_id_2_required_title" value=""/>
                                        <input type="hidden" name="type_id_3" id="type_id_3" value=""/>
                                        <input type="hidden" name="type_id_3_required" id="type_id_3_required" value=""/>
                                        <input type="hidden" name="type_id_3_required_name" id="type_id_3_required_name" value=""/>
                                        <input type="hidden" name="type_id_3_required_title" id="type_id_3_required_title" value=""/>
                                        <input type="hidden" name="type_id_4" id="type_id_4" value=""/>
                                        <input type="hidden" name="type_id_4_required" id="type_id_4_required" value=""/>
                                        <input type="hidden" name="type_id_4_required_name" id="type_id_4_required_name" value=""/>
                                        <input type="hidden" name="type_id_4_required_title" id="type_id_4_required_title" value=""/>
                                        <input type="hidden" name="type_id_5" id="type_id_5" value=""/>
                                        <input type="hidden" name="type_id_5_required" id="type_id_5_required" value=""/>
                                        <input type="hidden" name="type_id_5_required_name" id="type_id_5_required_name" value=""/>
                                        <input type="hidden" name="type_id_5_required_title" id="type_id_5_required_title" value=""/>
                                        <input type="hidden" name="type_id_6" id="type_id_6" value=""/>
                                        <input type="hidden" name="type_id_6_required" id="type_id_6_required" value=""/>
                                        <input type="hidden" name="type_id_6_required_name" id="type_id_6_required_name" value=""/>
                                        <input type="hidden" name="type_id_6_required_title" id="type_id_6_required_title" value=""/>
                                        <input type="hidden" name="field_ids" id="field_ids" value="" />

                                        <input type="hidden" name="sold_property_types" id="sold_property_types" value="" />
                                        <input type="submit" class="prop_s" name="save_prop"  value="Opslaan" />
                                        </form>
                                        <script language="javascript">
                                            jQuery("#pro_type").change(function () {
                                                var fields = jQuery("#field_ids").val();
                                                var fieldArr = fields.split(",");
                                                if (fieldArr.length > 0) {
                                                    for (i = 0; i < fieldArr.length; i++) {
                                                        jQuery("#extrafield_" + fieldArr[i]).hide("fast");
                                                    }
                                                }
                                                var selected_value = jQuery("#pro_type").val();
                                                var selected_fields = jQuery("#type_id_" + selected_value).val();
                                                var fieldArr = selected_fields.split(",");
                                                if (fieldArr.length > 0) {
                                                    for (i = 0; i < fieldArr.length; i++) {
                                                        jQuery("#extrafield_" + fieldArr[i]).show("slow");
                                                    }
                                                }
                                                var selected_value = jQuery("#pro_type").val();
                                                var selected_fields = jQuery("#sold_property_types").val();
                                                var fieldArr = selected_fields.split("|");
                                                if (fieldArr.length > 0) {
                                                    var show = 0;
                                                    for (i = 0; i < fieldArr.length; i++) {
                                                        if (fieldArr[i] == selected_value)
                                                        {
                                                            show = 1;
                                                        }
                                                    }
                                                    if (show == 1) {
                                                        jQuery("#sold_information").show("slow");
                                                    } else {
                                                        jQuery("#sold_information").hide("slow");
                                                    }
                                                }
                                            });
                                        </script>
                                        <div style="clear:both;">
                                        </div>

                                        <script type="text/javascript">
                                            jQuery(function () {
                                                jQuery("img.oslazy").lazyload();
                                            });
                                        </script>

                                        </div>
                                        </div>
                                        <!-- End Content -->
                                        </section>

                                        </div>























                                        </div>
                                        </div>






                                        <script>
                                            function openCity(evt, cityName) {
                                                var i, tabcontent, tablinks;
                                                tabcontent = document.getElementsByClassName("tabcontent");
                                                for (i = 0; i < tabcontent.length; i++) {
                                                    tabcontent[i].style.display = "none";
                                                }
                                                tablinks = document.getElementsByClassName("tablinks");
                                                for (i = 0; i < tablinks.length; i++) {
                                                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                                                }
                                                document.getElementById(cityName).style.display = "block";
                                                evt.currentTarget.className += " active";
                                            }

                                        // Get the element with id="defaultOpen" and click on it
                                            document.getElementById("defaultOpen").click();


                                            function setCookie(cname, cvalue, exdays) {
                                                var d = new Date();
                                                d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                                                var expires = "expires=" + d.toUTCString();
                                                document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
                                            }






                                        </script>
                                        <div style="clear:both"></div>


