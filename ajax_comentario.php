<?php
	require_once("admin/models/Doctors.php");
	require_once("admin/models/CalificationDoctors.php");
	require_once("admin/models/ValidationCalificationDoctors.php");
	require_once("admin/PHPMailer/class.phpmailer.php");
	require_once("admin/models/GalleryDoctors.php");
	require_once 'google-api/src/Google/autoload.php';

	session_start();

	include("admin/includes/functions.php");

	$calification = new CalificationDoctors();
	$doctors = new Doctors();
	$validationCalification = new ValidationCalificationDoctors();
	$gallery = new GalleryDoctors();

	if(!isset($_POST['action']))
	{
		$_POST['action'] = '';
	}
	if(isset($_POST['id']))
	{
		$id = $_POST['id'];
	}
	elseif(isset($_POST['DoctorId']))
	{
		$id = $_POST['DoctorId'];
	}
	else
	{
		$id = '0';
	}

	if (isset($_POST["args"]))
	{
		$get_code = explode(".", $_POST["args"]);
		$get_code = $get_code[0];
	}
	else
	{
		$get_code = "";
	}

	$registro = array(
		'DoctorId' => $id,
		'Name' => '',
		'Comment' => ''
	);

	if($id != '')
	{
		switch ($_POST['action'])
		{
			case 'submit':
				$calification->setDoctorId($id);
				$calification->setNameUser(GetSQLValueString($_POST["txtName"], "text"));
				$calification->setCountStars(GetSQLValueString($_POST['txtCalification']), "int");
				$calification->setEmail(GetSQLValueString($_POST["txtEmail"], "text"));
				$calification->setComment(GetSQLValueString($_POST["txtComment"], "text"));

				if(isset($_POST['txtCode'])){
					if($_POST['txtCode'] == 1){
						$calification->setStatusDoctor(true);
					}
				}
				
				if($calification->CreateCalificationDoctor() == 'exito')
				{
				
					$validationCalification = new ValidationCalificationDoctors();
					$calification = new CalificationDoctors();
					$validation = $calification->lastCalificationDoctorId();
					$codeCalification = generarCodigo(9);
					$validationCalification->setCalificationDoctorId($validation);
					$validationCalification->setCode($codeCalification);
					$validationCalification->CreateValidationCalificationDoctor();

					if(isset($_FILES["images"]))
					{
						$nameTemp = array();
						$nameImg = array();

						foreach($_FILES['images']["name"] as $key=>$val)
						{
							$nameImg[$key] = $val;
						}

						foreach($_FILES['images']["tmp_name"] as $key=>$val)
						{
							$nameTemp[$key] = $val;
						}

						$typeImg = array();

						foreach($_FILES['images']["type"] as $key=>$val)
						{
							if ($val != 'image/jpg' && $val != 'image/jpeg' && $val != 'image/png' && $val != 'image/gif')
							{

							}
							else
							{
								$code = generarCodigo(9);
								$nombre = $code.$nameImg[$key];
								$ruta_provisional = $nameTemp[$key];
								
								$carpeta = "admin/files/images/";
								$src = $carpeta.$nombre;
								if(move_uploaded_file($ruta_provisional, $src))
								{
									$gallery->setDoctorId($_POST['DoctorId']);
									$gallery->setLocation($nombre);
									$gallery->setType('Image');
									$gallery->setCalificationDoctorId($calification->lastCalificationDoctorId());
									$gallery->CreateGalleryDoctor();
								}
							}
						}
					}
					if(isset($_FILES['videoName']))
					{
						$OAUTH2_CLIENT_ID = '411055274937-p4qa318es9r8smcdte190i7nmfflqdfc.apps.googleusercontent.com';
						$OAUTH2_CLIENT_SECRET = 'sDyrjrrqdcLhXzXBuOfZy0ye';

						$client = new Google_Client();
						$client->setClientId($OAUTH2_CLIENT_ID);
						$client->setClientSecret($OAUTH2_CLIENT_SECRET);
						$client->setScopes('https://www.googleapis.com/auth/youtube');

						$redirect = filter_var('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'], FILTER_SANITIZE_URL);

						$client->setRedirectUri($redirect);

						$youtube = new Google_Service_YouTube($client);

						if (isset($_GET['code']))
						{
							if (strval($_SESSION['state']) !== strval($_GET['state']))
							{
								var_dump($_SESSION['state']);
								var_dump($_GET['state']);
								die('El estado de la sesión ha vencido.');
							}
							$client->authenticate($_GET['code']);
							$_SESSION['token'] = $client->getAccessToken();
							header('Location: ' . $redirect);
						}
						if (isset($_SESSION['token']))
						{
							$client->setAccessToken($_SESSION['token']);
						}

						if ($client->getAccessToken())
						{
							try
							{
								foreach ($_FILES["videoName"]["tmp_name"] as $key => $value)
								{
									$videoTitle = $_POST["videoTitle"][$key];
									$videoInfo = $_POST["videoInfo"][$key];
									$videoTags = explode(",", $_POST["videoTags"][$key]);
									$videoPath = $value;

									$snippet = new Google_Service_YouTube_VideoSnippet();
									$snippet->setTitle($videoTitle);
									$snippet->setDescription($videoInfo);
									$snippet->setTags($videoTags);

									//Categorías: https://developers.google.com/youtube/v3/docs/videoCategories/list
									$snippet->setCategoryId("22");

									// Estados: 'public', 'private' y 'unlisted'.
									$status = new Google_Service_YouTube_VideoStatus();
									$status->privacyStatus = "public";

									$video = new Google_Service_YouTube_Video();
									$video->setSnippet($snippet);
									$video->setStatus($status);

									$chunkSizeBytes = 1 * 1024 * 1024;

									$client->setDefer(true);

									$insertRequest = $youtube->videos->insert("status,snippet", $video);

									$media = new Google_Http_MediaFileUpload(
										$client,
										$insertRequest,
										'video/*',
										null,
										true,
										$chunkSizeBytes
									);

									$media->setFileSize(filesize($videoPath));

									$status = false;
									$handle = fopen($videoPath, "rb");

									while (!$status && !feof($handle))
									{
											$chunk = fread($handle, $chunkSizeBytes);
											$status = $media->nextChunk($chunk);
									}

									fclose($handle);

									$client->setDefer(false);

									$gallery->setDoctorId($_POST['DoctorId']);
									$gallery->setLocation($status['id']);
									$gallery->setType('Video');
									$gallery->CreateGalleryDoctor();

									echo trim("exito");
									
								}
							}
							catch (Google_ServiceException $e)
							{
									echo trim("Ha ocurrido un error del servicio");
							}
							catch (Google_Exception $e)
							{
									echo trim("Ha ocurrido un error del cliente");
							}

							$_SESSION['token'] = $client->getAccessToken();
							exit();
						}
						else
						{
							$state = mt_rand();
							$client->setState($state);
							$_SESSION['state'] = $state;
							$authUrl = $client->createAuthUrl();
							echo trim("Se requiere autorización de YouTube");
							exit();
						}
					}
					
					//
					// Enviando correo para validar el comentario
					// 
					
					$mail = new PHPMailer;
					$mail->setFrom('info@cirugiaplasticacolombia.com', 'Cirugía Plástica Colombia');
					$mail->addReplyTo('info@cirugiaplasticacolombia.com', 'Cirugía Plástica Colombia');

					$address = $_POST['txtEmail'];
					$mail->addAddress($address);

					$mail->isHTML(true);
					$mail->CharSet = 'UTF-8';

					$mail->Subject = "Validación de comentario en Cirugía Plástica Colombia";

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
												<p>Hola '.$_POST["txtName"].',</p>
												<p>En el siguiente enlace podrás validar tu comentario</p>
												<table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
													<tbody>
													<tr>
														<td align="left">
														<table border="0" cellpadding="0" cellspacing="0">
															<tbody>
															<tr>
																<td> <a href="http://'.$_SERVER['HTTP_HOST'].'/?validationComment='.$codeCalification.'-'.$id.'" target="_blank">Validar comentario</a> </td>
															</tr>
															</tbody>
														</table>
														</td>
													</tr>
													</tbody>
												</table>
												<p>Si no funciona el botón, prueba copiando y pegando el siguiente enlace en el navegador: http://'.$_SERVER['HTTP_HOST'].'/?validationComment='.$codeCalification.'-'.$id.'</p>
												<p>Buena suerte!</p>
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
											<br>
											Estás recibiendo este correo a la dirección '.$address.' porque está relacionada con el portal. Si recibiste este mensaje por equivocación puedes ignorarlo.
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
						echo trim("fallo");
					}
					else
					{
						echo trim("exito");
					}
				}
				else
				{
					echo trim("fallo");
				}
			break;

			case 'form':
				if($id != '0')
				{
					$doctors->setDoctorId($id);
					$registro = $doctors->GetDoctorContent();
				}
			break;
		}
	}

	require_once 'google-api/src/Google/autoload.php';

	$OAUTH2_CLIENT_ID = '411055274937-p4qa318es9r8smcdte190i7nmfflqdfc.apps.googleusercontent.com';
	$OAUTH2_CLIENT_SECRET = 'sDyrjrrqdcLhXzXBuOfZy0ye';

  	$client = new Google_Client();
    $client->setClientId($OAUTH2_CLIENT_ID);
    $client->setClientSecret($OAUTH2_CLIENT_SECRET);
    $client->setScopes('https://www.googleapis.com/auth/youtube');

    $redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], FILTER_SANITIZE_URL);

    $client->setRedirectUri($redirect);

    if (isset($_SESSION['token']))
    {
        $client->setAccessToken($_SESSION['token']);
    }

    if (isset($_GET['code']))
    {
        if (strval($_SESSION['state']) !== strval($_GET['state']))
        {
            var_dump($_SESSION['state']);
            var_dump($_GET['state']);
                die('El estado de la sesión no coincide.');
        }
        $client->authenticate($_GET['code']);
        $_SESSION['token'] = $client->getAccessToken();
        header('Location: ' . $redirect);
    }

?>

<?php
	if($_POST['action'] == 'form')
	{
?>
		<script src="js/functions.js"></script>

		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			<div class="close-modal" onclick="closePrincipalModal()">
				<i class="material-icons">close</i>
			</div>
			<div class="modal-header">
				<h4>Califica a: <span style="color:#0059a5"><?= $registro['Name'] ?></span></h4>
			</div>
			<div id="modal-result" class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form class="form-horizontal group-border-dashed" action="#" id="comentarioForm" enctype="multipart/form-data" data-parsley-validate novalidate>

							<input type="hidden" name="action" value="submit" />
							<input type="hidden" name="DoctorId" value="<?php echo $registro['DoctorId']; ?>" />
							<input type="hidden" name="txtCalification" id="calification" value="5">

							<div class="form-group">
								<label class="col-sm-3 control-label">Cantidad de Estrellas:</label>
								<div class="col-sm-6">
									<div class="stars-form" style="color:#ffa101">
										<i class="material-icons" style="cursor:pointer;" id="star-1" onclick="setStars(1)">star</i>
										<i class="material-icons" style="cursor:pointer;" id="star-2" onclick="setStars(2)">star</i>
										<i class="material-icons" style="cursor:pointer;" id="star-3" onclick="setStars(3)">star</i>
										<i class="material-icons" style="cursor:pointer;" id="star-4" onclick="setStars(4)">star</i>
										<i class="material-icons" style="cursor:pointer;" id="star-5" onclick="setStars(5)">star</i>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Nombre Completo:</label>
								<div class="col-sm-6">
									<input name="txtName" type="text" class="form-control" parsley-trigger="change" required placeholder=""/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Correo Electrónico:</label>
								<div class="col-sm-6">
									<input name="txtEmail" type="email" class="form-control" parsley-trigger="change" required placeholder=""/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Comentario:</label>
								<div class="col-sm-6">
									<input name="txtComment" type="text" class="form-control" parsley-trigger="change" required placeholder=""/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Código Doctor:</label>
								<div class="col-sm-6">
									<input autocomplete="off" id="cod" maxlength="4" type="text" class="form-control" parsley-trigger="change" onkeyup="verifyCode()" onpaste="return false;" placeholder="Si no posee el código, puede omitir este campo" value="<?= $get_code ?>"/>
									<span id="verifyCode"></span>
								</div>
							</div>
							<div class="form-group" id="code"></div>

							<div class="form-group" id="addFoto"></div>
							<br>

							<!--<div class="form-group" id="addVideo"></div>
							<br>-->

							<div class="form-group">
								<a href="javascript:void(0)" onclick="agregarFoto()" class="btn btn-success waves-effect waves-light btn-sm" style="background-color:#0059a5">Agregar Foto</a>
								<?php/*
									if (!$client->getAccessToken())
									{
										$state = mt_rand();
										$client->setState($state);
										$_SESSION['state'] = $state;
										$authUrl = $client->createAuthUrl();
										$htmlBody = "<a href='".$authUrl."&id=".$id."' class='btn btn-success waves-effect waves-light btn-sm' style='background-color:#00a5dd'>Autorizar para subir Videos</a>";

										echo $htmlBody;
									}
									else
									{
									?>
										<a href="javascript:void(0)" id="video" onclick="agregarVideo()" class="btn btn-success waves-effect waves-light btn-sm" style="background-color:#00A5E1">Agregar Video</a>
									<?php
									}*/
								?>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id="submitButton" class="btn btn-default waves-effect waves-light" style="background-color:#00A5E1" onclick="submitComentario();">Enviar</button>
				<button type="button" class="waves-effect waves-light btn grey lighten-4 grey-text" onclick="closeModal()" style="margin-right:10px;">Cancelar</button>
			</div>
			</div>
		</div>

		<script type="text/javascript">
			function closeModal() {
				$('.modal').modal('close');
			}

			$(document).ready(function() {
				$('select').material_select();
			});

			function agregarFoto(){
				$("#addFoto").append("<label class='col-sm-3 control-label'><h5>Foto</h5></label><div class='col-sm-6'><input type='file' id='file' accept='image/x-png,image/gif,image/jpeg' name='images[]' required multiple></div><hr>");
			}

			function agregarVideo(){
				$("#addVideo").append("<label class='col-sm-3 control-label'><h5>Video</h5></label><div class='col-sm-6'><div class='form-group'><label>Título:</label><input type='text' name='videoTitle[]' id='videoTitle' class='form-control' required></div><div class='form-group'><label>Descripción:</label><textarea name='videoInfo[]' id='videoInfo' required class='form-control'></textarea></div><div class='form-group'><label>Etiquetas:</label><input type='text' name='videoTags[]' id='videoTags' class='form-control' required><small>Separar por comas ','</small></div>	<div class='form-group'><label>Seleccione video:</label><input type='file' name='videoName[]' id='videoName' required multiple></div></div><hr>");
			}
	
			function setStars(star) {
				for (var i = 1; i <= 5; i++) {
					$("#star-" + i).html("star_border");
				};
				for (var i = 1; i < star + 1; i++) {
					$("#star-" + i).html("star");
				};
				$("#calification").val(star);
			}
		</script>

<?php
	}
?>
