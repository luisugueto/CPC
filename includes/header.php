<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
	
	<link type="text/css" rel="stylesheet" href="css/owl.carousel.min.css" />
	<link type="text/css" rel="stylesheet" href="css/owl.theme.default.min.css" />

	<link type="text/css" rel="stylesheet" href="css/styles.css" media="screen,projection" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="shortcut icon" href="favicon.ico">

	<title>Cirugía Plástica Colombia</title>
</head>

<body>

	<!-- Elementos flotantes -->

	<!-- Redes sociales -->
	<div class="social-floating hide-on-small-only">
		<a href="https://www.facebook.com/" target="_blank">
			<div class="social-ntwrk" style="background-color: #3a5795;">
				<img src="http://cirugiaplasticacolombia.com/wp-content/themes/directorys/doopla-includes/floating-icons/facebook.png" height="20">
			</div>
		</a>

		<a href="https://www.instagram.com/" target="_blank">
			<div class="social-ntwrk" style="background-color: #000;">
				<img src="http://cirugiaplasticacolombia.com/wp-content/themes/directorys/doopla-includes/floating-icons/instagram.png" height="20">
			</div>
		</a>

		<a href="https://www.plus.google.com/" target="_blank">
			<div class="social-ntwrk" style="background-color: #DB4437;">
				<img src="http://cirugiaplasticacolombia.com/wp-content/themes/directorys/doopla-includes/floating-icons/googleplus.png"
				 height="20">
			</div>
		</a>

		<a href="https://www.facebook.com/" target="_blank">
			<div class="social-ntwrk" style="background-color: #E62117;">
				<img src="http://cirugiaplasticacolombia.com/wp-content/themes/directorys/doopla-includes/floating-icons/youtube.png" height="20">
			</div>
		</a>
	</div>
	<!-- Fin de redes sociales -->

	<!-- Consulta en línea (boton) -->
	<div class="consulting-floating hide-on-small-only">
		<a href="#">
			<div class="consult-btn">
				<i class="material-icons left consult-icon">supervisor_account</i> Consulta <b>en línea</b>
			</div>
		</a>
	</div>
	<!-- Fin de Consulta en línea (boton) -->

	<div class="go-up">
		<a href="#">
			<i class="material-icons left go-up-icon">keyboard_arrow_up</i>
		</a>
	</div>

	<!-- Fin de los elementos flotantes -->

	<!-- Cabecera -->
	<header>

		<div class="navbar-fixed">
			<nav>
				<div class="nav-wrapper">

					<!-- Logo -->
					<a href="#!" class="brand-logo">
						<img src="images/logo.png">
					</a>
					<!-- Logo -->

					<!-- Boton de menu responsive -->
					<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
					<!-- Fin botón de menu responsive -->

					<!-- Menú de navegación web -->
					<ul class="right hide-on-med-and-down">
						<li><a href="#">Inicio</a></li>
						<li><a href="#">Procedimientos</a></li>
						<li><a href="#">Directorio</a></li>
						<li><a href="#">Blog</a></li>
						<li><a href="#">Videos</a></li>
						<li><a href="#">Contáctanos</a></li>
					</ul>
					<!-- Fin de menú navegación web -->

					<!-- Menú Responsive -->
					<ul class="side-nav" id="mobile-demo">
						<!-- Logo menu responsive -->
						<div class="center-align">
							<div class="valign-wrapper menu-logo-responsive">
								<img src="images/logo.png">
							</div>
						</div>
						<!-- Fin logo menu responsive -->

						<hr class="menu-divider">

						<li><a href="#"><i class="material-icons left">home</i> Inicio</a></li>
						<li><a href="#"><i class="material-icons left">work</i> Procedimientos</a></li>
						<li><a href="#"><i class="material-icons left">perm_contact_calendar</i> Directorio</a></li>
						<li><a href="#"><i class="material-icons left">speaker_notes</i> Blog</a></li>
						<li><a href="#"><i class="material-icons left">video_library</i> Videos</a></li>
						<li><a href="#"><i class="material-icons left">email</i> Contáctanos</a></li>
					</ul>
					<!-- Fin Menú Responsive -->

				</div>
			</nav>
		</div>
	</header>
	<!-- Fin cabecera -->

	<?php
		$page_url = basename($_SERVER['PHP_SELF']);

		if ($page_url == "index.php")
		{
	?>
			<!-- Imagen cabecera -->
			<div class="image-header valign-wrapper" style="background-image:url('images/cpc-1.jpg')">
				<div class="container">
					<div class="row" style="margin-bottom:0">
						<div class="input-field col m6 s10 offset-m3">
							<h5>Encuentra información de procedimientos estéticos</h5>
						</div>
					</div>
					<div class="row">
						<div class="input-field col m6 s10 offset-m3">
							<input id="autocomplete-input" class="autocomplete header-search" type="text" placeholder="Buscar procedimiento, o por nombre...">
							<button class="header-search-btn" type="submit"><i class="material-icons" style="padding-left: 2px;">search</i></button>
						</div>
					</div>
				</div>
			</div>
			<div class="principal-header-bar">
				<div class="row" style="margin-bottom:0">

					<div class="col m4 center-align principal-btn-header">
						Encuentra información del procedimiento estético que deseas realizarte
						<br><br>
						<a class="waves-effect waves-light btn">Procedimientos</a>
					</div>

					<div class="col m4 center-align principal-btn-header">
						Encuentra el caso clínico y opiniones de los diferentes cirujanos plásticos en Colombia
						<br><br>
						<a class="waves-effect waves-light btn">Cirujanos Plásticos</a>
					</div>

					<div class="col m4 center-align principal-btn-header">
						Comparte tu caso clínico y experiencia con tu cirujano a otros pacientes como tú
						<br><br>
						<a class="waves-effect waves-light btn" style="background-color:#ffa101 !important">Califica a tu cirujano</a>
					</div>
					
				</div>
			</div>
			<!-- Fin imagen cabecera -->
	<?php
		}
		else
		{
	?>
			<!-- Bar de búsqueda -->
			<nav class="search-nav">
				<form onsubmit="search(); return false;">
					<div class="nav-wrapper">
						<div class="container">
							<div class="row">
								<div class="input-field col s12">
									<input id="autocomplete-input" class="autocomplete search-input" type="text" placeholder="Buscar procedimiento, o por nombre...">
									<button class="submit-search" type="submit"><i class="material-icons">search</i></button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</nav>
			<!-- Fin de barra buscador -->
	<?php
		}
	?>

	<br>