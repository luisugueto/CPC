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

	function permisosChecked($permisoValue)
	{
		global $permisos;
		if(is_array($permisos))
		{
			if(array_key_exists($permisoValue, $permisos))
			{
				echo "checked";
			}
		}
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

					$characteristics = array();

					foreach ($_POST as $param_name => $param_val)
					{
						$first = explode("_", $param_name);
						if ($first[0] == "plan")
						{
							$characteristics[$param_name] = $param_val;
						}
					}

					$plans->setName(GetSQLValueString($_POST["txtName"], "text"));
					$plans->setCharacteristic(serialize($characteristics));
					$plans->setPrice($_POST["txtPrice"]);
					echo json_encode($plans->UpdatePlan());
                    exit();
				}
				else
				{

					$characteristics = array();

					foreach ($_POST as $param_name => $param_val)
					{
						$first = explode("_", $param_name);
						if ($first[0] == "plan")
						{
							$characteristics[$param_name] = $param_val;
						}
					}

					$plans->setName(GetSQLValueString($_POST["txtName"], "text"));
					$plans->setCharacteristic(serialize($characteristics));
					$plans->setPrice(GetSQLValueString($_POST["txtPrice"], "text"));
					echo json_encode($plans->CreatePlan());
                    exit();
				}
			break;

			case 'form':
				if($id != '0')
				{
					$plans->setPlanId($id);
					$registro = $plans->GetPlanContent();
					$permisos = unserialize($registro['Characteristic']);
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

					<h4>Características</h4>

					<table class="tablesaw table m-b-0" data-tablesaw-mode="swipe">
						<tbody>
							<tr>
								<td style="width: 80%">Foto y Descripción de Perfil</td>
								<td style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="plan_foto" value="1" <?= permisosChecked('plan_foto') ?>></td>
							</tr>
							<tr>
								<td style="width: 80%">Datos y Formulario de Contacto</td>
								<td style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="plan_datos" value="1" <?= permisosChecked('plan_datos') ?>></td>
							</tr>
							<tr>
								<td style="width: 80%">Perfil destacado en el listado</td>
								<td style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="plan_perfil" value="1" <?= permisosChecked('plan_perfil') ?>></td>
							</tr>
							<tr>
								<td style="width: 80%">Actualización de su perfil / mes</td>
								<td style="width: 20%">
									<input type="text" name="plan_actualizacion" value="<?= $permisos["plan_actualizacion"] ?>">
								</td>
							</tr>
							<tr>
								<td style="width: 80%">Casos en galería de fotos</td>
								<td style="width: 20%">
									<input type="text" name="plan_casos" value="<?= $permisos["plan_casos"] ?>">
								</td>
							</tr>
							<tr>
								<td style="width: 80%">Link página web</td>
								<td style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="plan_link" value="1" <?= permisosChecked('plan_link') ?>></td>
							</tr>
							<tr>
								<td style="width: 80%">Conteo y Notificación de Review</td>
								<td style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="plan_conteo" value="1" <?= permisosChecked('plan_conteo') ?>></td>
							</tr>
							<tr>
								<td style="width: 80%">Sección "Pregúntale al Doctor"</td>
								<td style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="plan_preguntale" value="1" <?= permisosChecked('plan_preguntale') ?>></td>
							</tr>
							<tr>
								<td style="width: 80%">Reportes</td>
								<td style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="plan_reportes" value="1" <?= permisosChecked('plan_reportes') ?>></td>
							</tr>
							<tr>
								<td style="width: 80%">Cuenta de acceso edición de Perfil</td>
								<td style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="plan_cuenta" value="1" <?= permisosChecked('plan_cuenta') ?>></td>
							</tr>
							<tr>
								<td style="width: 80%">Bloquear Pauta de otros Médicos</td>
								<td style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="plan_bloquear" value="1" <?= permisosChecked('plan_bloquear') ?>></td>
							</tr>
							<tr>
								<td style="width: 80%">Participación en Foros</td>
								<td style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="plan_participacion" value="1" <?= permisosChecked('plan_participacion') ?>></td>
							</tr>
							<tr>
								<td style="width: 80%">Respuesta de Reviews</td>
								<td style="width: 20%"><input type="checkbox" data-plugin="switchery" data-color="#5fbeaa" data-size="small" name="plan_respuesta" value="1" <?= permisosChecked('plan_respuesta') ?>></td>
							</tr>
						</tbody>
					</table>
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
