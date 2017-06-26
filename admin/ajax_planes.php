<?php
	require_once("models/Plans.php");
	include("includes/functions.php");

	$plans = new Plans();

	if(!isset($_POST['action']))
	{
		$_POST['action'] = '';
	}
	if(isset($_POST['id']))
	{
		$id = $_POST['id'];
	}
	elseif(isset($_POST['PlanId']))
	{
		$id = $_POST['PlanId'];
	}
	else
	{
		$id = '0';
	}

	$registro = array(
		'PlanId' => $id,
		'Name' => '',
		'Price' => 0,
		'Characteristic' => ''
	);

	if($id != '')
	{
		switch ($_POST['action'])
		{
			case 'submit':
				if($id != '0')
				{
					$plans->setPlanId($id);
					$plans->setName(GetSQLValueString($_POST["txtName"], "text"));
					$plans->setCharacteristic(GetSQLValueString($_POST["txtCharacteristic"], "text"));
					$plans->setPrice(GetSQLValueString($_POST["txtPrice"], "text"));
					echo json_encode($plans->UpdatePlan());
                    exit();
				}
				else
				{
					$plans->setName(GetSQLValueString($_POST["txtName"], "text"));
					$plans->setCharacteristic(GetSQLValueString($_POST["txtCharacteristic"], "text"));
					$plans->setPrice(GetSQLValueString($_POST["txtPrice"], "text"));
					$test = json_encode($plans->UpdatePlan());
					if($test == 'exito')
						echo $test;
					else echo "No";
                    exit();
				}
			break;

			case 'form':
				if($id != '0')
				{
					$plans->setPlanId($id);
					$registro = $plans->GetPlanContent();
				}
			break;

			case 'delete':
				if($id != '0')
				{
					$plans->setPlanId($id);
					echo json_encode($plans->DeletePlan());
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
      	<h2>Planes</h2>
      </div>
      <div id="modal-result" class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal group-border-dashed" action="#" id="modalForm" data-parsley-validate novalidate>
                    <input type="hidden" name="action" value="submit" />
                    <input type="hidden" name="PlanId" value="<?php echo $registro['PlanId']; ?>" />
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Registro ID.</label>
                        <div class="col-sm-6">
                            <input type="text" disabled="disabled" class="form-control" value="<?php echo $registro['PlanId'];?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nombre</label>
                        <div class="col-sm-6">
                            <input name="txtName" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['Name'];?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Precio</label>
                        <div class="col-sm-6">
                            <input name="txtPrice" type="number" class="form-control" parsley-trigger="change" step="0" placeholder="" value="<?php echo $registro['Price'];?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Caracteristica</label>
                        <div class="col-sm-6">
                            <input name="txtCharacteristic" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['Characteristic'];?>"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-inverse btn-custom waves-effect waves-light" data-dismiss="modal" aria-label="Close"><i class="fa fa-undo m-r-5"></i> <span>Cancelar</span></button>
        <button id="submitButton" class="btn btn-default waves-effect waves-light" disabled="disabled" onclick="submitModalForm('planes');"> <i class="fa fa-check m-r-5"></i> <span>ok</span> </button>
      </div>
    </div>
</div>

<?php
	}
?>
