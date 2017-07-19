<?php
	// Si no existe la sesión, redirigir al inicio de sesión.
	if(!isset($_COOKIE['UserId']))
	{
		header('Location: login.php');
		exit;
	}

	$page_url  = basename($_SERVER['PHP_SELF']);

	require_once("models/Users.php");
	$users = new Users();
	$users->setUserId($_COOKIE['UserId']);
	$usuario = $users->GetUserContent();

	$permisos_usuario = unserialize($usuario["Permissions"]);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
		<meta name="author" content="Coderthemes">
		<link rel="shortcut icon" href="img/favicon.ico">
		<title>Cirugía Plástica Colombia</title>

		<!-- Sweet Alert -->
		<link href="assets/plugins/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css">

		<link href="assets/plugins/fullcalendar/dist/fullcalendar.css" rel="stylesheet" />
        <link href="assets/plugins/select2/select2.css" rel="stylesheet" type="text/css" />

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/cropper/cropper.css" rel="stylesheet" type="text/css" />

		<!-- font-awesome -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<!-- Loading -->
		<link href="libs/loading/rolling.css" rel="stylesheet">

		<!-- Style -->
		<link href="css/slim.min.css" rel="stylesheet">
		<link href="style.css" rel="stylesheet">

		<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="assets/js/modernizr.min.js"></script>
	</head>

	<!-- Modal -->
	<div class="modal fade" id="modal-001"></div>

	<body>
		<div id="fullscreenloading">
			<div id="fullscreenloading-content">
				<div class="loading">
					<div class='uil-rolling-css' style='transform:scale(0.36);'><div><div></div><div></div></div></div>
				</div>
			</div>
		</div>

		<header id="topnav">
			<div class="topbar-main">
				<div class="container">
					<div class="logo">
						<a href="index.php" class="logo"><img src="img/logo.png" width="100"></a>
					</div>
					<div class="menu-extras">
						<ul class="nav navbar-nav navbar-right pull-right">
							<li class="dropdown">
								<a href="" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true"><span class="hidden-xs" style="margin-right:10px;"><?php echo $_COOKIE['UserName']; ?> </span><img src="img/user-icon.png" alt="user-img" class="img-circle"></a>
								<ul class="dropdown-menu">
									<li><a href="javascript:void(0)" onclick="modalCall('usuarios','form','<?= $_COOKIE["UserId"] ?>')"><i class="ti-user m-r-5"></i>Mi cuenta</a></li>
									<?php
										if (in_array("per_usuarios_ver", $permisos_usuario))
										{
									?>
											<li><a href="usuarios.php"><i class="fa fa-users"></i> Usuarios</a></li>
									<?php
										}
									?>
									<li><a href="logout.php"><i class="ti-power-off m-r-5"></i> Salir</a></li>
								</ul>
							</li>
						</ul>
						<div class="menu-item">
							<a class="navbar-toggle">
								<div class="lines">
									<span></span>
									<span></span>
									<span></span>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>

			<div class="navbar-custom">
				<div class="container">
					<div id="navigation">
						<ul class="navigation-menu">
							<?php
								if (in_array("per_clientes_ver", $permisos_usuario))
								{
							?>
									<li data-toggle="dropdown" aria-expanded="true" <?php if ($page_url == "articulos.php" || $page_url = "categorias_blog.php") { echo 'class="active"'; } ?>><a href="javascript:void(0)"><i class="fa fa-newspaper-o"></i>Blog</a>
									</li>
									<ul class="dropdown-menu">
										<li><a href="articulos.php">Artículos</a></li>
										<li><a href="categorias_blog.php">Categorías</a></li>
									</ul>

							<?php
								}
							?>
							<li <?php if (($page_url == "medicos.php") || ($page_url == "perfil_medico.php")) { echo 'class="active"'; } ?>>
								<a href="medicos.php"><i class="fa fa-user-md"></i>Médicos</a>
							</li>
							<li <?php if ($page_url == "planes.php") { echo 'class="active"'; } ?>>
								<a href="planes.php"><i class="fa fa-bars"></i>Planes</a>
							</li>
							<li <?php if ($page_url == "categorias.php") { echo 'class="active"'; } ?>>
								<a href="categorias.php"><i class="fa fa-newspaper-o"></i>Categorias</a>
							</li>
							<li <?php if ($page_url == "subcategorias.php") { echo 'class="active"'; } ?>>
								<a href="subcategorias.php"><i class="fa fa-newspaper-o"></i>SubCategorias</a>
							</li>
							<li <?php if ($page_url == "clientes.php") { echo 'class="active"'; } ?>>
								<a href="clientes.php"><i class="fa fa-user"></i>Clientes</a>
							</li>
							<li <?php if ($page_url == "publicidad.php") { echo 'class="active"'; } ?>>
								<a href="publicidad.php"><i class="fa fa-user"></i>Publicidad</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</header>
