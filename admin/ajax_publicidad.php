<?php
	require_once("models/Publicitys.php");
	include("includes/functions.php");

	$publicity = new Publicitys();

	if(!isset($_POST['action']))
	{
		$_POST['action'] = '';
	}
	if(isset($_POST['id']))
	{
		$id = $_POST['id'];
	}
	elseif(isset($_POST['PublicityId']))
	{
		$id = $_POST['PublicityId'];
	}
	else
	{
		$id = '0';
	}

	$registro = array(
		'PublicityId' => $id,
		'Title' => '',
		'Content' => ''
	);

	if($id != '')
	{
		switch ($_POST['action'])
		{
			case 'submit':
				if($id != '0')
				{
					$publicity->setPublicityId($id);
					$publicity->setTitle(GetSQLValueString($_POST["txtTitle"], "text"));
					$publicity->setContent(GetSQLValueString($_POST["txtContent"], "text"));
					echo json_encode($publicity->UpdatePublicity());
                    exit();
				}
				else
				{
					$publicity->setTitle(GetSQLValueString($_POST["txtTitle"], "text"));
					$publicity->setContent(GetSQLValueString($_POST["txtContent"], "text"));
					echo json_encode($publicity->CreatePublicity());
                    exit();
				}
			break;

			case 'form':
				if($id != '0')
				{
					$publicity->setPublicityId($id);
					$registro = $publicity->GetPublicityContent();
				}
			break;

			case 'delete':
				if($id != '0')
				{
					$publicity->setPublicityId($id);
					echo json_encode($publicity->DeletePublicity());
                    exit();
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      	<h2>Publicidad</h2>
      </div>
      <div id="modal-result" class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal group-border-dashed" action="#" id="modalForm" data-parsley-validate novalidate>
                    <input type="hidden" name="action" value="submit" />
                    <input type="hidden" name="PublicityId" value="<?php echo $registro['PublicityId']; ?>" />
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Registro ID.</label>
                        <div class="col-sm-6">
                            <input type="text" disabled="disabled" class="form-control" value="<?php echo $registro['PublicityId'];?>"/>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label">Título</label>
                        <div class="col-sm-6">
                            <input name="txtTitle" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['Title'];?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Contenido</label>
                        <div class="col-sm-6">
							<textarea name="txtContent" class="form-control" parsley-trigger="change" required placeholder="">
								<?php echo $registro['Content'];?>
							</textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-inverse btn-custom waves-effect waves-light" data-dismiss="modal" aria-label="Close"><i class="fa fa-undo m-r-5"></i> <span>Cancelar</span></button>
        <button id="submitButton" class="btn btn-default waves-effect waves-light" disabled="disabled" onclick="submitModalForm('publicidad');"> <i class="fa fa-check m-r-5"></i> <span>ok</span> </button>
      </div>
    </div>
</div>

<?php
	}
?>
