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
					$mail->setFrom('info@pixelgrafia.com', 'Información Pixelgrafía');
					$mail->addReplyTo('info@pixelgrafia.com', 'Información Pixelgrafía');

					$address = $_POST['txtEmail'];
					$mail->addAddress($address);

					$mail->isHTML(true);
					$mail->CharSet = 'UTF-8';

					$mail->Subject = "Validación de comentario en Cirugía Plástica Colombia";
					$msg = "La url para validar el comentario en Cirugía Plástica Colombia es: http://" . $_SERVER['HTTP_HOST']."/?validationComment=".$codeCalification."-".$id."";
					$mail->Body = $msg;

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
			<div class="modal-header">
				<h4>Califica a: <span style="color:#0059a5"><?= $registro['Name'] ?></span></h4>
			</div>
			<div id="modal-result" class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form class="form-horizontal group-border-dashed" action="#" id="comentarioForm" enctype="multipart/form-data" data-parsley-validate novalidate>

							<input type="hidden" name="action" value="submit" />
							<input type="hidden" name="DoctorId" value="<?php echo $registro['DoctorId']; ?>" />
							<input type="hidden" name="txtCalification" id="calification" value="0">

							<div class="form-group">
								<label class="col-sm-3 control-label">Cantidad de Estrellas</label>
								<div class="col-sm-6">
									<div class="stars-form" style="color:#ffa101">
										<i class="material-icons" style="cursor:pointer;" id="star-1" onclick="setStars(1)">star_border</i>
										<i class="material-icons" style="cursor:pointer;" id="star-2" onclick="setStars(2)">star_border</i>
										<i class="material-icons" style="cursor:pointer;" id="star-3" onclick="setStars(3)">star_border</i>
										<i class="material-icons" style="cursor:pointer;" id="star-4" onclick="setStars(4)">star_border</i>
										<i class="material-icons" style="cursor:pointer;" id="star-5" onclick="setStars(5)">star_border</i>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Nombre Completo</label>
								<div class="col-sm-6">
									<input name="txtName" type="text" class="form-control" parsley-trigger="change" required placeholder=""/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Correo</label>
								<div class="col-sm-6">
									<input name="txtEmail" type="email" class="form-control" parsley-trigger="change" required placeholder=""/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Comentario</label>
								<div class="col-sm-6">
									<input name="txtComment" type="text" class="form-control" parsley-trigger="change" required placeholder=""/>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Código Doctor</label>
								<div class="col-sm-6">
									<input autocomplete="off" id="cod" maxlength="4" type="text" class="form-control" parsley-trigger="change" onkeyup="verifyCode()" onpaste="return false;" placeholder="" value="<?= $get_code ?>"/>
									<span id="verifyCode"></span>
								</div>
							</div>
							<div class="form-group" id="code"></div>

							<div class="form-group" id="addFoto"></div>
							<br>

							<div class="form-group" id="addVideo"></div>
							<br>

							<div class="form-group">
								<a href="javascript:void(0)" onclick="agregarFoto()" class="btn btn-success waves-effect waves-light btn-sm" style="background-color:#0059a5">Agregar Foto</a>
								<?php
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
									}
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
