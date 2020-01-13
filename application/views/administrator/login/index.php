<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<?=add_metatags()?>

<?=add_title("Sing In")?>

<?=add_basehref()?>

<?=stylesheet_load('')?>

<?=javascript_load('')?> 
    
<?=icon_load("pp_fav.ico")?>

	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="/application/media/login/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/application/media/login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/application/media/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/application/media/login/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/application/media/login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="/application/media/login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/application/media/login/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/application/media/login/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="/application/media/login/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/application/media/login/css/util.css">
	<link rel="stylesheet" type="text/css" href="/application/media/login/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	
	<div class="container-login100" style="background-image: url('/application/media/login/images/bg-01.jpg');">
		<div class="wrap-login100 p-l-55 p-r-55 p-t-80 p-b-30">
			<form class="login100-form validate-form" action="logowanie" method="post">
				<span class="login100-form-title p-b-37">
					<img src="/application/media/images/logo.png">
				 	Inloggen
				</span>

				<div class="wrap-input100 validate-input m-b-20" data-validate="Beheerder">
					<input class="input100" type="text" name="login" placeholder="Beheerder">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input m-b-25" data-validate = "wachtwoord">
					<input class="input100" type="password" name="password" placeholder="wachtwoord">
					<span class="focus-input100"></span>
				</div>

				<div class="container-login100-form-btn">
					<button class="login100-form-btn">
						Opslaan
					</button>
				</div>


			</form>

			
		</div>
	</div>
	
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="/application/media/login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="/application/media/login/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="/application/media/login/vendor/bootstrap/js/popper.js"></script>
	<script src="/application/media/login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="/application/media/login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="/application/media/login/vendor/daterangepicker/moment.min.js"></script>
	<script src="/application/media/login/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="/application/media/login/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="/application/media/login/js/main.js"></script>

</body>
</html>