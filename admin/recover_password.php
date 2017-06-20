<?php
    // Si existe la sesión, redirigir al inicio.
    if(isset($_COOKIE['UserId']))
    {
        header('Location: index.php');
        exit;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">
        <link rel="shortcut icon" href="img/favicon.ico">

        <title>Recuperar contraseña - Cirugía Plástica Colombia</title>

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />

        <link href="libs/loading/rolling.css" rel="stylesheet">

        <!-- Style -->
        <link href="style.css" rel="stylesheet">

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="assets/js/modernizr.min.js"></script>

    </head>

    <body>

        <div id="fullscreenloading">
            <div id="fullscreenloading-content">
                <div class="loading">
                    <div class='uil-rolling-css' style='transform:scale(0.36);'><div><div></div><div></div></div></div>
                </div>
            </div>
        </div>

        <div class="account-pages bg-pattern-rojo"></div>
        <div class="clearfix"></div>

        <div class="wrapper-page login text-center">

            <div class=" card-box">

                <a href="login.php" class="logo">
                    <img src="img/logo.png" style="margin:auto; width:150px;">
                </a>

				<div class="panel-heading">
					<h3>Solicitar contraseña</h3>
					<p>Escribe tu <b>Email</b> y enviaremos una nueva contraseña de acceso!</p>
				</div>

				<div class="panel-body">
					<form class="form-horizontal" id="recoveryForm" name="recoverpw" method="post" data-parsley-validate novalidate>
						<div class="alert alert-danger" role="alert" id="login-alert" style="display:none"></div>
                        <div class="alert alert-success" role="alert" id="success-alert" style="display:none"><h4><strong>Nueva contraseña enviada!</strong></h4>Hemos enviado una nueva contraseña de acceso al correo <strong id="strong-email"></strong><br><br><small>Por favor revisa la bandeja de SPAM, es posible que el mensaje pueda haber llegado ahí.</small></div>
						<div class="form-group ">
							<div class="col-xs-12">
								<input name="recovery_email" id="recovery_email" class="form-control" type="email" parsley-trigger="change" required placeholder="Email">
							</div>
						</div>
						<div class="form-group text-center m-t-40">
							<div class="col-xs-12">
								<button class="btn btn-default btn-block text-uppercase waves-effect waves-light" type="submit">Solicitar</button>
							</div>
						</div>
					</form>
					<div class="form-group m-t-30 m-b-0">
						<div class="col-sm-12">
							<a href="login.php" class="text-dark"><i class="fa fa-arrow-left m-r-5"></i> Regresar para acceder a mi cuenta.</a>
						</div>
					</div>
				</div>
            </div>       

            <div class="row">
                <div class="col-sm-12 text-center bg-rojo-text">
                    <p>¿No has podido ingresar? <a href="mailto:soporte@dooplamarketing.com" class="text-primary m-l-5"><b>Contactar Soporte técnico</b></a>.</p>
                </div>
            </div>

        </div>

        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="js/functions.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>

        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

        <!-- Parsleyjs -->
        <script type="text/javascript" src="assets/plugins/parsleyjs/dist/parsley.min.js"></script>
        <script src="assets/plugins/parsleyjs/src/i18n/es.js"></script>

    </body>
</html>