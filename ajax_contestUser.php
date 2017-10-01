<?php
	require_once("admin/models/Doctors.php");
	require_once("admin/models/CalificationDoctors.php");
  	require_once("admin/models/ContestCalificationUser.php");

	include("admin/includes/functions.php");

	$calification = new CalificationDoctors();
	$doctors = new Doctors();
  	$contest = new ContestCalificationUser();

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
		'DoctorId' => $id,
		'Name' => '',
		'Comment' => ''
	);

	if($id != '')
	{
		switch ($_POST['action'])
		{
			case 'submit':
          		$contest->setCalificationDoctorId(GetSQLValueString($_POST["CalificationId"], "int"));
		        $contest->setNameUser(GetSQLValueString($_POST["txtNameUser"], "text"));
		        $contest->setEmail(GetSQLValueString($_POST["txtEmail"], "text"));
				$contest->setComment(GetSQLValueString($_POST["txtComment"], "text"));
          		echo json_encode($contest->CreateContestCalificationUser());
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
<script src="js/functions.js"></script>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
		<div class="close-modal" onclick="closePrincipalModal()">
			<i class="material-icons">close</i>
		</div>
      <div class="modal-header">
      	<h4>Comentar calificación de: <?= $registro['NameUser'] ?></h4>
      </div>
      <div id="modal-result" class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal group-border-dashed" action="#" id="modalForm" data-parsley-validate novalidate>
                    <input type="hidden" name="action" value="submit" />
                    <input type="hidden" name="CalificationId" value="<?php echo $id; ?>" />
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nombre y Apellido</label>
                        <div class="col-sm-6">
                            <input name="txtNameUser" type="text" class="form-control" parsley-trigger="change" required placeholder=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Correo</label>
                        <div class="col-sm-6">
                            <input name="txtEmail" type="text" class="form-control" parsley-trigger="change" required placeholder=""/>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Comentario</label>
                        <div class="col-sm-6">
                            <input name="txtComment" type="text" class="form-control" parsley-trigger="change" required placeholder=""/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
	  	<button id="submitButton" class="btn btn-default waves-effect waves-light" style="background-color:#00A5E1" onclick="submitModalSite('contestUser');">Enviar</button>
	  	<button type="button" class="waves-effect waves-light btn grey lighten-4 grey-text" onclick="closeModal()" style="margin-right:10px;">Cancelar</button>
      </div>
    </div>
</div>
<script type="text/javascript">
	function closeModal() {
		$('.modal').modal('close');
	}
</script>
<?php
	}
?>
