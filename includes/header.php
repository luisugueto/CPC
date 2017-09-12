<?php
	function slugify($cadena)
	{
	    // Convertimos la cadena a minusculas
	    $cadena = strtolower($cadena);

	    // Remplazo tildes y eñes
	    $unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
	                        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
	                        'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
	                        'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
	                        'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y');
	    $cadena = strtr( $cadena, $unwanted_array );

	    // Remplazo cuarquier caracter que no este entre A-Za-z0-9 por un espacio vacio
	    $cadena = trim(preg_replace("#[^a-z\s-\.]#i", "", $cadena));

	    // Eliminamos espacios en blanco y cambiamos por separador
	    $cadena = str_replace(" ", "-", $cadena);

	    return $cadena;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<base href="http://localhost:86/CPC/">

	<?php
		if(!empty($contentSection))
		{
	?>	
			<meta name="title" content="<?= $contentSection['MetaTitle'] ?>">
			<meta name="description" content="<?= $contentSection['MetaDescription'] ?>">
			<meta name="keywords" content="<?= $contentSection['Keywords'] ?>">
	<?php
		}
		else
		{
	?>
			<meta name="title" content="<?= $meta_title ?>">
			<meta name="description" content="<?= $meta_description ?>">
	<?php
		}
	?>

	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />

	<link type="text/css" rel="stylesheet" href="css/owl.carousel.min.css" />
	<link type="text/css" rel="stylesheet" href="css/owl.theme.default.min.css" />

	<link type="text/css" rel="stylesheet" href="css/styles.css" media="screen,projection" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="shortcut icon" href="favicon.ico">

	<link href="admin/assets/plugins/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css">

	<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	<?php 
		if(!empty($contentSection))
		{
	?>
			<title><?= $contentSection['MetaTitle'] ?></title>
	<?php
		}
		else
		{
	?>
			<title><?= $meta_title ?></title>
	<?php
		}
	?>

	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-53019838-8', 'auto');
		ga('send', 'pageview');
	</script>

</head>

<div class="loader" id="pageloader">
	<div class="loader-container">
		<div id="udb-loader">
			<div class="udb-loader-spin-wrapper">
				<div class="udb-loader-spin"></div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal" id="modal-001"></div>

<body>

	<!-- Elementos flotantes -->

	<!-- Redes sociales -->
	<div class="social-floating hide-on-small-only">
		<a href="https://www.facebook.com/CPC.oficial/" target="_blank">
			<div class="social-ntwrk" style="background-color: #3a5795;">
				<img src="images/facebook.png" height="20">
			</div>
		</a>

		<a href="https://www.instagram.com/cirugia.plastica.colombia/" target="_blank">
			<div class="social-ntwrk" style="background-color: #000;">
				<img src="images/instagram.png" height="20">
			</div>
		</a>

		<a href="https://plus.google.com/111925479170553120343" target="_blank">
			<div class="social-ntwrk" style="background-color: #DB4437;">
				<img src="images/googleplus.png"
				 height="20">
			</div>
		</a>

		<a href="https://www.youtube.com/user/CirugiaPlasticaCol" target="_blank">
			<div class="social-ntwrk" style="background-color: #E62117;">
				<img src="images/youtube.png" height="20">
			</div>
		</a>
	</div>
	<!-- Fin de redes sociales -->

	<!-- Consulta en línea (boton) -->
	<div class="consulting-floating hide-on-small-only">
		<a href="javascript:void(0)" onclick="modalCallSite('consulta','form','0')" id="consulta-en-linea">
			<div class="consult-btn">
				<i class="material-icons left consult-icon">supervisor_account</i> Consulta <b>en línea</b>
			</div>
		</a>
	</div>
	<!-- Fin de Consulta en línea (boton) -->

	<div class="go-up" id="gouparrow" style="opacity:0">
		<a href="javascript:void(0)" onclick="goUp()">
			<i class="material-icons left go-up-icon">keyboard_arrow_up</i>
		</a>
	</div>

	<!-- Fin de los elementos flotantes -->

	<!-- Cabecera -->
	<header>

		<div class="navbar-fixed">

			<?php
				require_once("admin/models/Categories.php");
				$categories = new Categories();
				$categoriesList = $categories->ListCategories();
				$list_categories = $categories->ListCategories();
			?>

			<nav>
				<div class="nav-wrapper">

					<!-- Logo -->
					<a href="inicio" class="brand-logo">
						<img src="images/logo.png">
					</a>
					<!-- Logo -->

					<!-- Boton de menu responsive -->
					<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
					<!-- Fin botón de menu responsive -->

					<!-- Menú de navegación web -->
					<ul class="right hide-on-med-and-down">
						<li><a href="inicio">Inicio</a></li>
						<li><a href="directorio">Especialistas</a></li>
						<li><a class="dropdown-button" id="dropdown-desk" href="javascript:void(0)" data-activates="dropdown1">Procedimientos <i class="material-icons right">arrow_drop_down</i></a></li>
						<li><a href="videos">Videos</a></li>
						<li><a href="blog_1">Blog</a></li>
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

						<li><a href="inicio"><i class="material-icons left">home</i> Inicio</a></li>
						<li><a href="directorio"><i class="material-icons left">perm_contact_calendar</i> Especialistas</a></li>
						<li><a class="dropdown-button" id="dropdown-mobile" href="javascript:void(0)" data-activates="dropdown-mobile-procedures"><i class="material-icons left">face</i> Procedimientos <i class="material-icons right">arrow_drop_down</i></a></li>
						<li><a href="videos"><i class="material-icons left">video_library</i> Videos</a></li>
						<li><a href="blog_1"><i class="material-icons left">speaker_notes</i> Blog</a></li>
					</ul>
					<!-- Fin Menú Responsive -->

				</div>
			</nav>

			<ul id="dropdown1" class="dropdown-content">
				<?php
					while ($Procedures = $categoriesList->fetch(PDO::FETCH_ASSOC))
					{
						echo "<li><a href='procedimiento/".$Procedures['CategoryId']."_".slugify($Procedures['Name'])."'>".$Procedures['Name']."</a></li>";
					}
				?>
			</ul>

			<ul id="dropdown-mobile-procedures" class="dropdown-content">
				<?php
					while ($categories_procedures = $list_categories->fetch(PDO::FETCH_ASSOC))
					{
						echo "<li><a href='procedimiento/".$categories_procedures['CategoryId']."_".slugify($categories_procedures['Name'])."'>".$categories_procedures['Name']."</a></li>";
					}
				?>
			</ul>

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
							<h5 style="color: #fff; text-shadow: 0px 2px 2px rgba(0, 0, 0, 0.28);">Encuentra información sobre especialistas y procedimientos de tu interés</h5>
						</div>
					</div>
					<div class="row">
						<div class="input-field col m6 s10 offset-m3">
							<form method="post" id="formSearch">
								<input id="autocomplete-input" class="autocomplete header-search" type="text" placeholder="Buscar procedimiento, o por nombre..." name="search" autocomplete="off">
								<button class="header-search-btn" type="submit"><i class="material-icons" style="padding-left: 2px;">search</i></button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="principal-header-bar">
				<div class="row" style="margin-bottom:0">

					<div class="col m4 s12 center-align principal-btn-header">
						¿Quieres información sobre el
						<br>
						procedimiento que deseas realizarte?
						<br><br>
						<a class="waves-effect waves-light btn" href="procedimientos">Procedimientos</a>
					</div>

					<div class="col m4 s12 center-align principal-btn-header">
						¿Buscas información sobre
						<br>
						especialistas en Colombia?
						<br><br>
						<a class="waves-effect waves-light btn" href="directorio">Cirujanos Plásticos</a>
					</div>

					<div class="col m4 s12 center-align principal-btn-header">
						¿Te realizaste un procedimiento?
						<br>
						Cuenta tu experiencia y compártelo
						<br><br>
						<a id="header-qualify" class="waves-effect waves-light btn" href="directorio" style="background-color:#ffa101 !important">Califica a tu cirujano</a>
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
				<form method="post" id="formSearch">
					<div class="nav-wrapper">
						<div class="container">
							<div class="row">
								<div class="input-field col s12">
										<input id="autocomplete-input" class="autocomplete search-input" type="text" placeholder="Buscar procedimiento, o por nombre..." name="search" autocomplete="off">
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
