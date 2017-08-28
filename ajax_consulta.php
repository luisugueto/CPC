<?php
	require_once("admin/models/Doctors.php");
	require_once("admin/models/ProceduresDoctor.php");
	require_once("admin/models/Categories.php");
	require_once("admin/PHPMailer/class.phpmailer.php");

	include("admin/includes/functions.php");

	$doctors = new Doctors();
	$procedures = new ProceduresDoctor();

	$categories = new Categories();
	$categoriesList = $categories->ListCategories();

	if(!isset($_POST['action']))
	{
		$_POST['action'] = '';
	}
	if(isset($_POST['id']))
	{
		$id = $_POST['id'];
	}
	else
	{
		$id = '0';
	}

	if($id != '')
	{
		switch ($_POST['action'])
		{
			case 'submit':
				$emails = array();
				foreach ($_POST['procedimientos'] as $key => $value) 
				{
					$procedures->setCategoryId($value);
					$proceduresCategory = $procedures->ListProceduresCategory();

					while($Procedures = $proceduresCategory->fetch(PDO::FETCH_ASSOC))
					{
						$doctors->setDoctorId($Procedures['DoctorId']);
						$content = $doctors->GetDoctorContent();
						array_push($emails, $content['Email']);
					}
				}
				
				$mail = new PHPMailer;
				$mail->setFrom('info@pixelgrafia.com', 'Información Pixelgrafía');
				$mail->addReplyTo('info@pixelgrafia.com', 'Información Pixelgrafía');

				foreach($emails as $email)
				{
					$mail->addAddress($email);
				}

				$mail->isHTML(true);
				$mail->CharSet = 'UTF-8';

				$mail->Subject = 'Consulta en línea';
				$mail->Body = "El usuario con el correo ".$_POST['txtEmail']." lo quiere contactar con el siguiente mensaje: ".$_POST['txtMessage']."";

				if(!$mail->send())
				{
					echo json_encode("fallo");
				}
				else
				{
					echo json_encode("exito");
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

?>

<?php
	if($_POST['action'] == 'form')
	{
?>
		<script src="js/functions.js"></script>

		<div class="modal-content">
			<h4>Consulta en línea</h4>
			<p>¿Tienes preguntas? ¿Deseas mayor información sobre algún procedimiento? Déjanos tu pregunta y en breve te contactará un especialista para brindarte asesoría.</p>

			<div class="row">
				<div class="col-md-12">
					<form class="form-horizontal group-border-dashed" action="#" id="modalForm" data-parsley-validate novalidate>

						<input type="hidden" name="action" value="submit" />

						<div class="form-group" style="margin-bottom:30px;">
							<label>Procedimientos:</label>
							<br><br>
							<?php
								$i = 0;

								while($Procedures = $categoriesList->fetch(PDO::FETCH_ASSOC))
								{
									echo '
										<input type="checkbox" name="procedimientos[]" id="test'.$i.'" value="'.$Procedures['CategoryId'].'" />
										<label for="test'.$i.'" style="margin-right: 15px;">
											'.$Procedures['Name'].'
										</label>
									';
									$i++;
								}
							?>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">
								Correo de Contacto
							</label>
							<div class="col-sm-6">
								<input name="txtEmail" type="email" class="form-control" parsley-trigger="change" required placeholder=""/>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">
								Mensaje
							</label>
							<div class="col-sm-6">
								<input name="txtMessage" type="text" class="form-control" parsley-trigger="change" required placeholder=""/>
							</div>
						</div>

					</form>
				</div>
			</div>
			
		</div>
		<div class="modal-footer">
			<button id="submitButton" class="btn btn-default waves-effect waves-light" style="background-color:#00A5E1" onclick="submitModalsSite('consulta', 'Enviado Correctamente', 'Hemos enviado su información a los especialistas relaciones con los procedimientos que seleccionó. Pronto se pondrán en contacto contigo.');">Enviar</button>
			<button type="button" class="waves-effect waves-light btn grey lighten-4 grey-text" onclick="closeModal()" style="margin-right:10px;">Cancelar</button>
		</div>

		<script type="text/javascript">
			$(document).ready(function() {
				$('select').material_select();
			});

			function closeModal() {
				$('.modal').modal('close');
			}
		</script>
<?php
	}
?>
