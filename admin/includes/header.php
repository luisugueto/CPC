<?php
	session_start();

	// Si no existe la sesión, redirigir al inicio de sesión.
	if(!isset($_COOKIE['UserId']))
	{
		header('Location: login.php');
		exit;
	}

	$page_url  = basename($_SERVER['PHP_SELF']);

	require_once("models/Users.php");
	require_once("models/PlanClients.php");
	require_once("models/Clients.php");

	$users = new Users();
	$planClient = new PlanClients();
	$users->setUserId($_COOKIE['UserId']);
	$usuario = $users->GetUserContent();

	if($usuario['Type']=='Client')
	{
		$clientId = $usuario['TypeId'];
	}

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
        <link href="assets/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
		<link href="css/awesome-bootstrap-checkbox.css" rel="stylesheet" type="text/css" />
		<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
		<link href="css/bootstrap-select.css" rel="stylesheet" type="text/css" />
		<link href="css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
		<link href="css/cropper.min.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="css/bootstrap-tagsinput.css" type="text/css">

		<!-- font-awesome -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<!-- Loading -->
		<link href="libs/loading/rolling.css" rel="stylesheet">

		<!-- Style -->
		<link href="css/slim.min.css" rel="stylesheet">
		<link href="style.css" rel="stylesheet">
		<link href="../css/styles.css" rel="stylesheet">

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
										if (in_array("per_usuarios_editar", $permisos_usuario))
										{
									?>
											<li><a href="usuarios.php"><i class="fa fa-users"></i> Usuarios</a></li>
									<?php
										}
									?>
									<?php
										if(isset($clientId))
											if($planClient->numPlanClient($clientId) == 0)
												echo "<li><a href='javascript:void(0)' onclick='modalCall('plan','form','0')'><i class='ti-power-off m-r-5'></i> Pago de Plan</a></li>";
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
								if ((in_array("per_blog_crear", $permisos_usuario)) || (in_array("per_blog_editar", $permisos_usuario)) || (in_array("per_blog_eliminar", $permisos_usuario)))
								{
							?>
									<li <?php if ($page_url == "articulos.php") { echo 'class="active"'; } ?>>
										<a href="articulos.php"><i class="fa fa-newspaper-o"></i>Blog</a>
									</li>
							<?php
								}
								if (in_array("per_medicos_crear", $permisos_usuario) || in_array("per_medicos_editar", $permisos_usuario) || in_array("per_medicos_eliminar", $permisos_usuario) || in_array("per_medico_info", $permisos_usuario) || in_array("per_medico_descripcion", $permisos_usuario) || in_array("per_medico_galeria", $permisos_usuario) || in_array("per_medico_calificaciones", $permisos_usuario))
								{
							?>
									<li <?php if (($page_url == "medicos.php") || ($page_url == "perfil_medico.php")) { echo 'class="active"'; } ?>>
										<a href="medicos.php"><i class="fa fa-user-md"></i>Médicos</a>
									</li>
							<?php
								}
								if ((in_array("per_planes_crear", $permisos_usuario)) || (in_array("per_planes_editar", $permisos_usuario)) || (in_array("per_planes_eliminar", $permisos_usuario)))
								{
							?>
									<li <?php if ($page_url == "planes.php") { echo 'class="active"'; } ?>>
										<a href="planes.php"><i class="fa fa-credit-card"></i>Planes</a>
									</li>
							<?php
								}
								if ((in_array("per_procedimientos_crear", $permisos_usuario)) || (in_array("per_procedimientos_editar", $permisos_usuario)) || (in_array("per_procedimientos_eliminar", $permisos_usuario)))
								{
							?>
									<li <?php if ($page_url == "categorias.php") { echo 'class="active"'; } ?>>
										<a href="categorias.php"><i class="fa fa-medkit"></i>Procedimientos</a>
									</li>
									<li <?php if ($page_url == "subcategorias.php") { echo 'class="active"'; } ?>>
										<a href="subcategorias.php"><i class="fa fa-medkit"></i>Sub Procedimientos</a>
									</li>
							<?php
								}
								if ((in_array("per_clientes_crear", $permisos_usuario)) || (in_array("per_clientes_editar", $permisos_usuario)) || (in_array("per_clientes_eliminar", $permisos_usuario)))
								{
							?>
									<li <?php if ($page_url == "clientes.php") { echo 'class="active"'; } ?>>
										<a href="clientes.php"><i class="fa fa-users"></i>Clientes</a>
									</li>
							<?php
								}
								if ((in_array("per_publicidad_crear", $permisos_usuario)) || (in_array("per_publicidad_editar", $permisos_usuario)) || (in_array("per_publicidad_eliminar", $permisos_usuario)))
								{
							?>
									<li <?php if ($page_url == "publicidad.php") { echo 'class="active"'; } ?>>
										<a href="publicidad.php"><i class="fa fa-puzzle-piece"></i>Publicidad</a>
									</li>
							<?php
								}
								if ((in_array("per_pagos_crear", $permisos_usuario)) || (in_array("per_pagos_editar", $permisos_usuario)) || (in_array("per_pagos_eliminar", $permisos_usuario)))
								{
							?>
									<li <?php if ($page_url == "pagos.php") { echo 'class="active"'; } ?>>
										<a href="pagos.php"><i class="fa fa-money"></i>Pagos</a>
									</li>
							<?php
								}
								if ((in_array("per_seo_editar", $permisos_usuario)))
								{
							?>
									<li <?php if ($page_url == "sections.php") { echo 'class="active"'; } ?>>
										<a href="sections.php"><i class="fa fa-info-circle"></i>SEO</a>
									</li>
							<?php
								}
							?>
						</ul>
					</div>
				</div>
			</div>
		</header>