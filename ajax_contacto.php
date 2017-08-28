<?php
	require_once("admin/models/Doctors.php");
	require_once("admin/PHPMailer/class.phpmailer.php");

	include("admin/includes/functions.php");

	$doctors = new Doctors();

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

	if($id != '')
	{
		switch ($_POST['action'])
		{
			case 'submit':
				if($id != '0')
				{
		            $doctors->setDoctorId($id);
		            $registro = $doctors->GetDoctorContent();
		            
					$mail = new PHPMailer;
					$mail->setFrom('info@pixelgrafia.com', 'Información Pixelgrafía');
					$mail->addReplyTo('info@pixelgrafia.com', 'Información Pixelgrafía');
					$mail->addAddress($_POST["DoctorEmail"]);

					$mail->isHTML(true);
					$mail->CharSet = 'UTF-8';
					$mail->Subject = "Contacto desde Cirugía Plástica Colombia";
					$body = $_POST['txtName']." - ".$_POST['txtEmail']." de: ".$_POST['txtCountry']." lo quiere contactar con el siguiente mensaje:<br>".$_POST['txtMessage']."";
					
					$mail->Body = $body;

					if(!$mail->send())
					{
						echo json_encode("fallo");
					}
					else
					{
						echo json_encode("exito");
					}
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

<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
		  <h4>Contacta a: <span style="color:#0059a5"><?= $registro['Name'] ?></span></h4>
		  <p>Escribenos, estamos para resolver tus preguntas, dudas o comentarios.</p>
      </div>
      <div id="modal-result" class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal group-border-dashed" action="#" id="modalForm" data-parsley-validate novalidate>
                    <input type="hidden" name="action" value="submit" />
                    <input type="hidden" name="DoctorId" value="<?php echo $registro['DoctorId']; ?>" />
                    <input type="hidden" name="DoctorEmail" value="<?php echo $registro['Email']; ?>">
					<div class="form-group">
                        <label class="col-sm-3 control-label">Nombre y Apellido</label>
                        <div class="col-sm-6">
                            <input name="txtName" type="text" class="form-control" parsley-trigger="change" required>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Correo</label>
                        <div class="col-sm-6">
                            <input name="txtEmail" type="email" class="form-control" parsley-trigger="change" required>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Teléfono / Celular</label>
                        <div class="col-sm-6">
                            <input name="txtPhone" type="tel" class="form-control" parsley-trigger="change" required>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Ciudad / País</label>
                        <div class="col-sm-6">
                            <input name="txtCountry" type="tel" class="form-control" parsley-trigger="change" required>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Mensaje</label>
                        <div class="col-sm-6">
                            <textarea name="txtMessage" class="materialize-textarea" parsley-trigger="change" required></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
	  	<button id="submitButton" class="btn btn-default waves-effect waves-light" style="background-color:#00A5E1" onclick="submitModalsSite('contacto', 'Enviado Correctamente', 'Hemos enviado tus datos a Dr. <?= strtoupper($registro['Name']) ?> correctamente. Pronto se pondrá en contacto contigo.');">Enviar</button>
		<button type="button" class="waves-effect waves-light btn grey lighten-4 grey-text" onclick="closeModal()" style="margin-right:10px;">Cancelar</button>
      </div>
    </div>
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
