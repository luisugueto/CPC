<?php
	require_once("models/Doctors.php");
	require_once("models/CalificationDoctors.php");
  	require_once("models/ContestCalification.php");

	include("includes/functions.php");

	$calification = new CalificationDoctors();
	$doctors = new Doctors();
  	$contest = new ContestCalification();

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

	$registro = array(
		'CalificationId' => $id,
		'Name' => '',
		'Comment' => ''
	);

	if($id != '')
	{
		switch ($_POST['action'])
		{
			case 'submit':
          $contest->setCalificationDoctorId($_POST['CalificationId']);
					$contest->setComment(GetSQLValueString($_POST["txtComment"], "text"));
          echo json_encode($contest->CreateContestCalificationDoctor());
			break;

			case 'form':
				if($id != '0')
				{
					$calification->setCalificationDoctorId($id);
					$registro = $calification->GetCalificationDoctor();
				}
			break;
		}
	}

?>

<?php
	if($_POST['action'] == 'form')
	{
?>
<script src="custom.js"></script>
<script src="functions.js"></script>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      	<h4>Responder Calificación del usuario <?= $registro['NameUser'] ?></h4>
      </div>
      <div id="modal-result" class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal group-border-dashed" action="#" id="modalForm" data-parsley-validate novalidate>
                    <input type="hidden" name="action" value="submit" />
                    <input type="hidden" name="CalificationId" value="<?php echo $id; ?>" />
					<div class="form-group">
                        <label class="col-sm-3 control-label">Comentario</label>
                        <div class="col-sm-6">
                            <textarea name="txtComment" class="form-control" parsley-trigger="change" required></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-inverse btn-custom waves-effect waves-light" data-dismiss="modal" aria-label="Close"><i class="fa fa-undo m-r-5"></i> <span>Cancelar</span></button>
        <button id="submitButton" class="btn btn-default waves-effect waves-light" disabled="disabled" onclick="submitModalForm('contestCalification');"> <i class="fa fa-check m-r-5"></i> <span>ok</span> </button>
      </div>
    </div>
</div>
<?php
	}
?>
