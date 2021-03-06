<?php
	require_once("admin/models/Sections.php");
	$section = new Sections();
	$section->setSectionId(6);
	$contentSection = $section->GetSectionContent();
	include("includes/header.php");
  	require_once("admin/PHPMailer/class.phpmailer.php");

	if(isset($_POST['txtEmail']) && isset($_POST['txtName']) && isset($_POST['txtMessage']) && isset($_POST['txtEspecialidad']) && isset($_POST['txtCiudad']))
	{ 
		$mail = new PHPMailer;
		$mail->setFrom('info@cirugiaplasticacolombia.com', 'Cirugía Plástica Colombia');
		$mail->addReplyTo('info@cirugiaplasticacolombia.com', 'Cirugía Plástica Colombia');
		$mail->addAddress();

		$mail->isHTML(true);
		$mail->CharSet = 'UTF-8';

		$mail->Subject = 'Contáctanos Portal Cirugía Plástica Colombia';
		$mail->Body = '
			<html>
				<head>
				<meta name="viewport" content="width=device-width" />
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				<title>Cirugía Plástica Colombia</title>
				<style>
					img {
					border: none;
					-ms-interpolation-mode: bicubic;
					max-width: 100%; }
					body {
					background-color: #f6f6f6;
					font-family: sans-serif;
					-webkit-font-smoothing: antialiased;
					font-size: 14px;
					line-height: 1.4;
					margin: 0;
					padding: 0;
					-ms-text-size-adjust: 100%;
					-webkit-text-size-adjust: 100%; }
					table {
					border-collapse: separate;
					mso-table-lspace: 0pt;
					mso-table-rspace: 0pt;
					width: 100%; }
					table td {
						font-family: sans-serif;
						font-size: 14px;
						vertical-align: top; }
					.body {
					background-color: #f6f6f6;
					width: 100%; }
					.container {
					display: block;
					Margin: 0 auto !important;
					max-width: 580px;
					padding: 10px;
					width: 580px; }
					.content {
					box-sizing: border-box;
					display: block;
					Margin: 0 auto;
					max-width: 580px;
					padding: 10px; }
					.main {
					background: #ffffff;
					border-radius: 3px;
					width: 100%; }
					.wrapper {
					box-sizing: border-box;
					padding: 20px; }
					.content-block {
					padding-bottom: 10px;
					padding-top: 10px;
					}
					.footer {
					clear: both;
					Margin-top: 10px;
					text-align: center;
					width: 100%; }
					.footer td,
					.footer p,
					.footer span,
					.footer a {
						color: #999999;
						font-size: 12px;
						text-align: center; }
					h1,
					h2,
					h3,
					h4 {
					color: #000000;
					font-family: sans-serif;
					font-weight: 400;
					line-height: 1.4;
					margin: 0;
					Margin-bottom: 30px; }
					h1 {
					font-size: 35px;
					font-weight: 300;
					text-align: center;
					text-transform: capitalize; }
					p,
					ul,
					ol {
					font-family: sans-serif;
					font-size: 14px;
					font-weight: normal;
					margin: 0;
					Margin-bottom: 15px; }
					p li,
					ul li,
					ol li {
						list-style-position: inside;
						margin-left: 5px; }
					a {
					color: #3498db;
					text-decoration: underline; }
					.btn {
					box-sizing: border-box;
					width: 100%; }
					.btn > tbody > tr > td {
						padding-bottom: 15px; }
					.btn table {
						width: auto; }
					.btn table td {
						background-color: #ffffff;
						border-radius: 5px;
						text-align: center; }
					.btn a {
						background-color: #ffffff;
						border: solid 1px #3498db;
						border-radius: 5px;
						box-sizing: border-box;
						color: #3498db;
						cursor: pointer;
						display: inline-block;
						font-size: 14px;
						font-weight: bold;
						margin: 0;
						padding: 12px 25px;
						text-decoration: none;
						text-transform: capitalize; }
					.btn-primary table td {
					background-color: #3498db; }
					.btn-primary a {
					background-color: #3498db;
					border-color: #3498db;
					color: #ffffff; }
					.last {
					margin-bottom: 0; }
					.first {
					margin-top: 0; }
					.align-center {
					text-align: center; }
					.align-right {
					text-align: right; }
					.align-left {
					text-align: left; }
					.clear {
					clear: both; }
					.mt0 {
					margin-top: 0; }
					.mb0 {
					margin-bottom: 0; }
					.preheader {
					color: transparent;
					display: none;
					height: 0;
					max-height: 0;
					max-width: 0;
					opacity: 0;
					overflow: hidden;
					mso-hide: all;
					visibility: hidden;
					width: 0; }
					.powered-by a {
					text-decoration: none; }
					hr {
					border: 0;
					border-bottom: 1px solid #f6f6f6;
					Margin: 20px 0; }
					@media only screen and (max-width: 620px) {
					table[class=body] h1 {
						font-size: 28px !important;
						margin-bottom: 10px !important; }
					table[class=body] p,
					table[class=body] ul,
					table[class=body] ol,
					table[class=body] td,
					table[class=body] span,
					table[class=body] a {
						font-size: 16px !important; }
					table[class=body] .wrapper,
					table[class=body] .article {
						padding: 10px !important; }
					table[class=body] .content {
						padding: 0 !important; }
					table[class=body] .container {
						padding: 0 !important;
						width: 100% !important; }
					table[class=body] .main {
						border-left-width: 0 !important;
						border-radius: 0 !important;
						border-right-width: 0 !important; }
					table[class=body] .btn table {
						width: 100% !important; }
					table[class=body] .btn a {
						width: 100% !important; }
					table[class=body] .img-responsive {
						height: auto !important;
						max-width: 100% !important;
						width: auto !important; }}
					@media all {
					.ExternalClass {
						width: 100%; }
					.ExternalClass,
					.ExternalClass p,
					.ExternalClass span,
					.ExternalClass font,
					.ExternalClass td,
					.ExternalClass div {
						line-height: 100%; }
					.apple-link a {
						color: inherit !important;
						font-family: inherit !important;
						font-size: inherit !important;
						font-weight: inherit !important;
						line-height: inherit !important;
						text-decoration: none !important; }
					.btn-primary table td:hover {
						background-color: #34495e !important; }
					.btn-primary a:hover {
						background-color: #34495e !important;
						border-color: #34495e !important; } }
				</style>
				</head>
				<body class="">
				<table border="0" cellpadding="0" cellspacing="0" class="body">
					<tr>
					<td>&nbsp;</td>
					<td class="container">
						<div class="content">
						<table class="main">
							<tr>
							<td class="wrapper">
								<table border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td>
									<p><img src="http://cirugiaplasticacolombia.com/images/logo.png" width="50%"></p>
									<p>Hola '.$registro["Name"].',</p>
									<p>Has recibido un mensaje de: '.$_POST['txtName'].', desde: '.$_POST['txtCiudad'].'. Especialidad: '.$_POST["txtEspecialidad"].'</p>
									<table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
										<tbody>
										<tr>
											<td align="left">
											<table border="0" cellpadding="0" cellspacing="0">
												<tbody>
												<tr>
													<td><p>'.$_POST['txtMessage'].'</p></td>
												</tr>
												</tbody>
											</table>
											</td>
										</tr>
										</tbody>
									</table>
									<p>Puedes responderle a la dirección: '.$_POST['txtEmail'].'</p>
									</td>
								</tr>
								</table>
							</td>
							</tr>
						</table>
						<div class="footer">
							<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td class="content-block">
								<span class="apple-link">Cirugía Plástica Colombia '.date("Y").' &copy;</span>
								</td>
							</tr>
							<tr>
								<td class="content-block powered-by">
								¿Necesitas Ayuda? <a href="http://doopla.co">Doopla Marketing</a>
								</td>
							</tr>
							</table>
						</div>
						</div>
					</td>
					<td>&nbsp;</td>
					</tr>
				</table>
				</body>
			</html>
		';

		if(!$mail->send())
		{
			echo "<script>
				alert('Ha ocurrido un error');
				history.back();
			</script>";
		}
		else
		{
			echo "<script>alert('Mensaje Enviado con Exito')</script>";
		}
 	} 
?>

	<!-- Contenido -->
	<div class="container">
		<div class="row">

			<!-- columna izquierda -->
			<div class="col m9 s12">

				<section>

					<!-- Título -->
					<div class="title-divider">
						<h1>Paute con nosotros</h1>
					</div>
					<!-- Fin título -->

				</section>

				<div class="row">
					<div class="col s12">
						<form class="form-control" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
							<div>
								<label style="font-size: 14px;">Nombre y Apellido:</label>
								<input name="txtName" type="text" parsley-trigger="change" required placeholder=""/>
							</div>
							<div>
								<label style="font-size: 14px;">Correo Electrónico:</label>
								<input name="txtEmail" type="email" parsley-trigger="change" required placeholder=""/>
							</div>
							<div>
								<label style="font-size: 14px;">Ciudad:</label>
								<input name="txtCiudad" type="text" parsley-trigger="change" required placeholder=""/>
							</div>
							<div>
								<label style="font-size: 14px;">Especialidad:</label>
								<input name="txtEspecialidad" type="text" parsley-trigger="change" required placeholder=""/>
							</div>
							<div>
								<label style="font-size: 14px;">Mensaje:</label>
								<input name="txtMessage" type="text" parsley-trigger="change" required placeholder=""/>
							</div>
							<button class="btn btn-primary waves-effect waves-light" style="background-color:#00A5E1">Enviar</button>
						</form>
					</div>

				</div>

			</div>
			<!-- fin columna izquierda -->

			<!-- side bar (columna derecha) -->
			<div class="col m3 s12 hide-on-small-only">
			
				<?php include("includes/sidebar.php"); ?>

			</div>
			<!-- fin side bar (columna derecha) -->

		</div>
	</div>
	<!-- Fin contenido -->

	<br>

	<?php include("includes/footer.php"); ?>
