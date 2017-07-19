<?php
	require_once("admin/models/Doctors.php");
	require_once("admin/models/CalificationDoctors.php");

	include("admin/includes/functions.php");

	$calification = new CalificationDoctors();
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
					$calification->setCountStars(5);
					$calification->setEmail(GetSQLValueString($_POST["txtEmail"], "text"));
					$calification->setComment(GetSQLValueString($_POST["txtComment"], "text"));
					echo json_encode($calification->CreateCalificationDoctor());
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
<script src="admin/custom.js"></script>
<script src="admin/functions.js"></script>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      	<h4>Agregar Comentario</h4>
      </div>
      <div id="modal-result" class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal group-border-dashed" action="#" id="modalForm" data-parsley-validate novalidate>
                    <input type="hidden" name="action" value="submit" />
                    <input type="hidden" name="DoctorId" value="<?php echo $registro['DoctorId']; ?>" />
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nombre</label>
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

                    </div>

                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-inverse btn-custom waves-effect waves-light" data-dismiss="modal" aria-label="Close"><i class="fa fa-undo m-r-5"></i> <span>Cancelar</span></button>
        <button id="submitButton" class="btn btn-default waves-effect waves-light" disabled="disabled" onclick="submitModalForm('comentario');"> <i class="fa fa-check m-r-5"></i> <span>ok</span> </button>
      </div>
    </div>
</div>
<?php
	}
?>
