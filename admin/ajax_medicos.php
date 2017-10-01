<?php
	require_once("models/Doctors.php");
	require_once("models/DataDoctors.php");
	require_once("models/Plans.php");
	require_once("models/Categories.php");
	require_once("models/SubCategories.php");
	require_once("models/ProceduresDoctor.php");
	require_once("models/Clients.php");

	include("includes/functions.php");

	$doctors = new Doctors();
  	$plans = new Plans();
	$planList = $plans->ListPlans();
	$categories = new Categories();
	$categoriesList = $categories->ListCategories();
	$subcategories = new SubCategories();
	$subcategoriesList = $subcategories->ListSubCategories();
	$clients = new Clients();
	$clientsNotPlan = $clients->ListClients();

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
		'SubTitle' => '',
		'Description' => '',
		'PlanId' => '',
		'Code' => '',
		'Email' => ''
	);

	if($id != '')
	{
		switch ($_POST['action'])
		{
			case 'submit':
				if($id != '0')
				{
					$doctors->setDoctorId($id);

					if(isset($_POST["hdGeneralAction"])){
						if ($_POST["hdGeneralAction"] == "client_form")
						{
							$doctors->setClientId(GetSQLValueString($_POST["txtClient"], "text"));
							echo json_encode($doctors->UpdateClient());
							exit;
						}

						if ($_POST["hdGeneralAction"] == "description")
						{
							$doctors->setDescription($_POST["txtDescription"]);
							echo $doctors->UpdateDoctorDescription();
							exit;
						}
					}

					$doctors->setName(GetSQLValueString($_POST["txtName"], "text"));
					$doctors->setSubTitle(GetSQLValueString($_POST["txtSubTitle"], "text"));
					$doctors->setPlanId($_POST["txtPlan"]);
					$doctors->setEmail(GetSQLValueString($_POST["txtEmail"], "text")); 

					if($doctors->UpdateDoctor() == 'exito')
					{
						if(isset($_POST['txtDescriptionContact']) && isset($_POST['txtTypeContact'])){
							$descriptionContact = $_POST['txtDescriptionContact'];
							$typeContact = $_POST['txtTypeContact'];

							foreach($descriptionContact as $key => $value)
							{
								$newData = new DataDoctors();
								if($typeContact[$key] == '1')
									$newData->setName('Dirección');
								elseif($typeContact[$key] == '2')
									$newData->setName('Ciudad');
								elseif($typeContact[$key] == '3')
									$newData->setName('País');
								elseif($typeContact[$key] == '4')
									$newData->setName('Teléfono');
								elseif($typeContact[$key] == '5')
									$newData->setName('Correo');
								elseif($typeContact[$key] == '6')
									$newData->setName('Whatsapp');
								elseif($typeContact[$key] == '7')
									$newData->setName('Página Web');

								$newData->setDoctorId($id);
								$newData->setDescription($value);
								$newData->CreateData();
							}
						}

		              	if(isset($_POST['txtCategorie']) && isset($_POST['txtSubCategory'])){
		                	$procedureCategory = $_POST['txtCategorie'];
		    				$procedureSubCategory = $_POST['txtSubCategory'];
		                	foreach ($procedureCategory as $key => $value) {

		                  		$procedures = new ProceduresDoctor();
		      					$procedures->setCategoryId($value);
		      					$procedures->setSubCategoryId($procedureSubCategory[$key]);
		      					$procedures->setDoctorId($id);
		      					$procedures->CreateProceduresDoctor();
		                	}
		              	}

						if(isset($_POST['deleteContact']))
						{
							$deleteContact = $_POST['deleteContact'];
							foreach ($deleteContact as $k => $val)
							{
								$deleteData = new DataDoctors();
								$deleteData->setDataId($val);
								$deleteData->DeleteData();
							}
						}

          				if(isset($_POST['deleteProcedures']))
						{
							$deletePro = $_POST['deleteProcedures'];
							foreach ($deletePro as $k => $val)
							{
								$deleteProcedure = new ProceduresDoctor();
								$deleteProcedure->setProceduresDoctorId($val);
								$deleteProcedure->DeleteProceduresDoctor();
							}
						}

						echo json_encode("exito");
						exit();
					}

				}
				else
				{
					$doctors->setClientId(GetSQLValueString($_POST["txtClient"], "text"));
					$doctors->setName(GetSQLValueString($_POST["txtName"], "text"));
					$doctors->setSubTitle(GetSQLValueString($_POST["txtSubTitle"], "text"));
					$doctors->setDescription(GetSQLValueString($_POST["txtDescription"], "text"));
					$doctors->setPlanId($_POST["txtPlan"]);
					$doctors->setEmail(GetSQLValueString($_POST["txtEmail"], "text"));
					$doctors->setCode(GetSQLValueString($_POST["txtCode"], "text"));

					$test = $doctors->CreateDoctor();
					if($test == 'exito'){
						$descriptionContact = $_POST['txtDescriptionContact'];
						$typeContact = $_POST['txtTypeContact'];

						foreach($descriptionContact as $key => $value) {
							$data = new DataDoctors();
							if($typeContact[$key] == '1')
								$data->setName('Dirección');
							elseif($typeContact[$key] == '2')
								$data->setName('Ciudad');
							elseif($typeContact[$key] == '3')
								$data->setName('País');
							elseif($typeContact[$key] == '4')
								$data->setName('Teléfono');
							elseif($typeContact[$key] == '5')
								$data->setName('Correo');
							elseif($typeContact[$key] == '6')
								$data->setName('Whatsapp');
							elseif($typeContact[$key] == '7')
								$data->setName('Página Web');

							$data->setDoctorId($doctors->lastDoctorId());
							$data->setDescription($value);
							$data->CreateData();
						}

						$procedureCategory = $_POST['txtCategorie'];
						$procedureSubCategory = $_POST['txtSubCategory'];
            $lastId = $doctors->lastDoctorId();
            foreach ($procedureCategory as $key => $value) {

              $procedures = new ProceduresDoctor();
  						$procedures->setCategoryId($value);
  						$procedures->setSubCategoryId($procedureSubCategory[$key]);
  						$procedures->setDoctorId($lastId);
  						$procedures->CreateProceduresDoctor();
            }
						echo json_encode("exito");
						          exit();
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

			case 'client_form':
				if($id != '0')
				{
					$doctors->setDoctorId($id);
					$registro = $doctors->GetDoctorContent();
				}
			break;

			case 'description':
				if($id != '0')
				{
					$doctors->setDoctorId($id);
					$registro = $doctors->GetDoctorContent();
				}
			break;

			case 'edit':
			if($id != '0')
			{
				$doctors->setDoctorId($id);
				$registro = $doctors->GetDoctorContent();
				$data = new DataDoctors();
				$dataList = $data->GetDataforDoctor($id);
				$procedures = new ProceduresDoctor();
				$proceduresList = $procedures->GetProceduresDoctorforDoctor($id);
			}
			break;

			case 'delete':
				if($id != '0')
				{
					$doctors->setDoctorId($id);
					echo json_encode($doctors->DeleteDoctor());
                    exit();
				}
			break;

		}
	}

?>

<?php
	if($_POST['action'] == 'description')
	{
?>
<script src="custom.js"></script>
<script src="functions.js"></script>
<script src="js/ckeditor/ckeditor.js"></script>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      	<h2>Médico</h2>
      </div>
      <div id="modal-result" class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal group-border-dashed" action="#" id="modalDescriptionDoctor" data-parsley-validate novalidat>
                    <input type="hidden" name="action" value="submit" />
                    <input type="hidden" name="DoctorId" value="<?php echo $registro['DoctorId']; ?>" />
										<div class="deleted"></div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Registro ID.</label>
                        <div class="col-sm-6">
                            <input type="text" disabled="disabled" class="form-control" value="<?php echo $registro['DoctorId'];?>"/>
                        </div>
                    </div>
										<div class="form-group">
                        <label class="col-sm-3 control-label">Descripción</label>
                        <div class="col-sm-6">
                            <textarea id="ckEditorText" class="ckeditor" parsley-trigger="change" required placeholder=""><?php echo $registro['Description'];?></textarea>
                        </div>
                    </div>
										<input type="hidden" name="hdGeneralAction" id="hdGeneralAction" value="<?= $_POST['action'] ?>">
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-inverse btn-custom waves-effect waves-light" data-dismiss="modal" aria-label="Close"><i class="fa fa-undo m-r-5"></i> <span>Cancelar</span></button>
        <button id="submitDoctorDescription" class="btn btn-default waves-effect waves-light btn-danger"><i class="fa fa-save m-r-5"></i> <span>Guardar</span></button>
      </div>
    </div>
</div>
<?php
	}
?>

<?php
	if($_POST['action'] == 'client_form')
	{
?>
<script src="custom.js"></script>
<script src="functions.js"></script>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      	<h2>Médico</h2>
      </div>
      <div id="modal-result" class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal group-border-dashed" action="#" id="modalForm" data-parsley-validate novalidat>
                    <input type="hidden" name="action" value="submit" />
                    <input type="hidden" name="DoctorId" value="<?php echo $registro['DoctorId']; ?>" />
										<div class="deleted"></div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Registro ID.</label>
                        <div class="col-sm-6">
                            <input type="text" disabled="disabled" class="form-control" value="<?php echo $registro['DoctorId'];?>"/>
                        </div>
                    </div>
										<div class="form-group">
                        <label class="col-sm-3 control-label">Cliente</label>
                        <div class="col-sm-6">
													<select class="form-control" name="txtClient" required>
                            <?php
                              while ($Client = $clientsNotPlan->fetch(PDO::FETCH_ASSOC))
															{
																if ($Client["ClientId"] == $registro["ClientId"])
																{
														?>
																	<option value="<?= $Client['ClientId'] ?>" selected><?= $Client['Name'] ?></option>
														<?php
																}
																else
																{
														?>
																	<option value="<?= $Client['ClientId'] ?>"><?= $Client['Name'] ?></option>
														<?php
																}
															}
                            ?>
                          </select>
                        </div>
                    </div>
										<input type="hidden" name="hdGeneralAction" value="<?= $_POST['action'] ?>">
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-inverse btn-custom waves-effect waves-light" data-dismiss="modal" aria-label="Close"><i class="fa fa-undo m-r-5"></i> <span>Cancelar</span></button>
        <button id="submitButton" class="btn btn-default waves-effect waves-light" disabled="disabled" onclick="submitModalForm('medicos');"> <i class="fa fa-check m-r-5"></i> <span>ok</span> </button>
      </div>
    </div>
</div>
<?php
	}
?>

<?php
	if($_POST['action'] == 'edit')
	{
?>
<script src="custom.js"></script>
<script src="functions.js"></script>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      	<h2>Médico</h2>
      </div>
      <div id="modal-result" class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal group-border-dashed" action="#" id="modalForm" data-parsley-validate novalidat>
                    <input type="hidden" name="action" value="submit" />
                    <input type="hidden" name="DoctorId" value="<?php echo $registro['DoctorId']; ?>" />
										<div class="deleted"></div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Registro ID.</label>
                        <div class="col-sm-6">
                            <input type="text" disabled="disabled" class="form-control" value="<?php echo $registro['DoctorId'];?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nombre</label>
                        <div class="col-sm-6">
                            <input name="txtName" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['Name'];?>"/>
                        </div>
                    </div>
										<div class="form-group">
                        <label class="col-sm-3 control-label">SubTítulo</label>
                        <div class="col-sm-6">
                            <input name="txtSubTitle" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['SubTitle'];?>"/>
                        </div>
                    </div>
										<div class="form-group">
                        <label class="col-sm-3 control-label">Correo</label>
                        <div class="col-sm-6">
                            <input name="txtEmail" type="email" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['Email'];?>"/>
                        </div>
                    </div>
										<div class="form-group">
                        <label class="col-sm-3 control-label">Plan</label>
                        <div class="col-sm-6">
                          <select class="form-control" name="txtPlan">
                            <option value="" disabled>Seleccione</option>
                            <?php
                              while ($Plan = $planList->fetch(PDO::FETCH_ASSOC))
															{
																	if($Plan['PlanId'] == $registro['PlanId']){
                            ?>
                                  <option value="<?= $Plan['PlanId'] ?>" selected><?= $Plan['Name'] ?></option></td>
														<?php } else { ?>
																	<option value="<?= $Plan['PlanId'] ?>"><?= $Plan['Name'] ?></option></td>
                            <?php
																	}
															}
                            ?>
                          </select>
                        </div>
                    </div>
										<hr></hr>

											<?php
												while ($Data = $dataList->fetch(PDO::FETCH_ASSOC))
												{

											?>
											<div class="form-group" id="contact<?= $Data['DataDoctorId']?>">
											<label class="col-sm-3 control-label">Contacto</label>
											<div class="col-sm-3">
												<input type="text" readonly class="form-control" parsley-trigger="change" required placeholder="" value="<?= $Data["Name"];?>"/>
											</div>
											<div class="col-sm-3">
												<input type="text" readonly class="form-control" parsley-trigger="change" required placeholder="" value="<?= $Data['Description'];?>"/>
											</div>
											<div class="col-sm-3">
												<button type="button" class="btn btn-danger waves-effect waves-light" onclick="borrarContacto(<?= $Data['DataDoctorId'] ?>)"><i class="fa fa-close m-r-5"></i>Borrar<span></span></button>
											</div>
											</div>
											<?php
												}
											?>
										<div class="add"></div>
										<div class="center" align="center">
												<button type="button" class="btn btn-success waves-effect waves-light" onclick="agregarContacto()"><i class="fa fa-plus m-r-5"></i> <span>Agregar Contacto</span></button>
										</div>
										<hr></hr>
										<?php
											while ($Procedure = $proceduresList->fetch(PDO::FETCH_ASSOC))
											{
										?>
                    <div class="form-group" id="procedimiento<?= $Procedure['ProceduresDoctorId']?>">
                        <label class="col-sm-3 control-label">Procedimiento</label>
												<div class="col-sm-3">
														<label>Categoría</label>
														<input readonly type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?= $categories->GetCategoryName($Procedure['CategoryId'])?>"/>
												</div>
												<div class="col-sm-3">
													<label>SubCategoría</label>
													<input type="text" readonly class="form-control" parsley-trigger="change" required placeholder="" value="<?= $subcategories->GetSubCategoryName($Procedure['SubCategoryId'])?>"/>
												</div>
                        <div class="col-sm-3">
  												<button type="button" class="btn btn-danger waves-effect waves-light" onclick="borrarProcedimiento(<?= $Procedure['ProceduresDoctorId'] ?>)"><i class="fa fa-close m-r-5"></i>Borrar<span></span></button>
  											</div>
                    </div>
										<?php
											}
										?>
                    <div class="addP">
										</div>
										<div class="center" align="center">
												<button type="button" class="btn btn-success waves-effect waves-light" onclick="agregarProcedimiento()"><i class="fa fa-plus m-r-5"></i> <span>Agregar Procedimiento</span></button>
										</div>
										<hr>
										<div class="form-group">
                        <label class="col-sm-3 control-label">Código</label>
                        <div class="col-sm-6" align="center">
													<?= $registro['Code'];?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-inverse btn-custom waves-effect waves-light" data-dismiss="modal" aria-label="Close"><i class="fa fa-undo m-r-5"></i> <span>Cancelar</span></button>
        <button id="submitButton" class="btn btn-default waves-effect waves-light" disabled="disabled" onclick="submitModalForm('medicos');"> <i class="fa fa-check m-r-5"></i> <span>ok</span> </button>
      </div>
    </div>
</div>

<script>

function agregarContacto(){
	$(".add").append('<div class="form-group"><label class="col-sm-3 control-label">Contacto</label><div class="col-sm-3"><select class="form-control" name="txtTypeContact[]"><option value="" disabled>Seleccione</option><option value="1">Dirección</option><option value="2">Ciudad</option><option value="3">País</option><option value="4">Teléfono</option><option value="5">Correo</option><option value="6">Whatsapp</option><option value="7">Página Web</option></select></div><div class="col-sm-3"><input name="txtDescriptionContact[]" type="text" class="form-control" parsley-trigger="change" required placeholder="" value=""/></div></div>');
}

function borrarContacto(value){
	$(".deleted").append('<input name="deleteContact[]" type="hidden" value="'+value+'"/>');
	$("#contact"+value).hide();
}

function borrarProcedimiento(value){
	$(".deleted").append('<input name="deleteProcedures[]" type="hidden" value="'+value+'"/>');
	$("#procedimiento"+value).hide();
}

var i = 0;
function agregarProcedimiento(){
	$(".addP").append('<div class="form-group">'+
      '<label class="col-sm-3 control-label">Procedimiento</label>'+
      '<div class="col-sm-3">'+
        '<label>Categoría</label>'+
        '<select class="form-control" name="txtCategorie[]" onchange="addSubCategorie('+i+')" id="category'+i+'" required>'+
          '<option value="" disabled selected>Seleccione</option>'+
          '<?php
            $categoriesList = $categories->ListCategories();
            while ($Categorie = $categoriesList->fetch(PDO::FETCH_ASSOC))
            {
          ?>'+
          '<option value="<?= $Categorie['CategoryId'] ?>"><?= $Categorie['Name'] ?></option>'+
          '<?php
            }
          ?>'+
        '</select>'+
      '</div>'+
      '<div class="col-sm-3">'+
        '<label>SubCategoría</label>'+
        '<select class="form-control" name="txtSubCategory[]" id="subcategory'+i+'" required>'+
          '<option value="" disabled selected>Seleccione</option>'+
        '</select>'+
      '</div>'+
  '</div>');
  i++;
}


function addSubCategory(){
		var idCategory = $('#category').val();

		$.ajax({
			data: { id : idCategory},
			type: 'GET',
			url: 'controllers/GetSubCategories.php',
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function (data) {
				if(data == null){
					$('#subcategory').empty();
					$('#subcategory').append('<option value="" disabled selected>Seleccione</option>');
				}
				else{
					$('#subcategory').empty();
					$.each(data,function(index, el){
						$('#subcategory').append('<option value='+el.SubCategoryId+'>'+el.Name+'</option>');
					});
				}
			}
		});
}
function addSubCategorie(id){
		var idCategory = $('#category'+id).val();

		$.ajax({
			data: { id : idCategory},
			type: 'GET',
			url: 'controllers/GetSubCategories.php',
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function (data) {
				if(data == null){
					$('#subcategory'+id).empty();
					$('#subcategory'+id).append('<option value="" disabled selected>Seleccione</option>');
				}
				else{
					$('#subcategory'+id).empty();
					$.each(data,function(index, el){
						$('#subcategory'+id).append('<option value='+el.SubCategoryId+'>'+el.Name+'</option>');
					});
				}
			}
		});
}
</script>
<?php
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
      	<h2>Médico</h2>
      </div>
      <div id="modal-result" class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal group-border-dashed" action="#" id="modalForm" data-parsley-validate novalidate>
                    <input type="hidden" name="action" value="submit" />
                    <input type="hidden" name="DoctorId" value="<?php echo $registro['DoctorId']; ?>" />
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Registro ID.</label>
                        <div class="col-sm-6">
                            <input type="text" disabled="disabled" class="form-control" value="<?php echo $registro['DoctorId'];?>"/>
                        </div>
                    </div>
										<div class="form-group">
                        <label class="col-sm-3 control-label">Cliente</label>
                        <div class="col-sm-6">
													<select class="form-control" name="txtClient" required>
                            <option value="" disabled selected>Seleccione</option>
                            <?php
                              while ($Client = $clientsNotPlan->fetch(PDO::FETCH_ASSOC))
															{
														?>
																<option value="<?= $Client['ClientId'] ?>"><?= $Client['Name'] ?></option></td>
                            <?php
															}
                            ?>
                          </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nombre</label>
                        <div class="col-sm-6">
                            <input name="txtName" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['Name'];?>"/>
                        </div>
                    </div>
										<div class="form-group">
                        <label class="col-sm-3 control-label">SubTítulo</label>
                        <div class="col-sm-6">
                            <input name="txtSubTitle" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['SubTitle'];?>"/>
                        </div>
                    </div>
										<div class="form-group">
                        <label class="col-sm-3 control-label">Descripción</label>
                        <div class="col-sm-6">
                            <textarea name="txtDescription" class="form-control" parsley-trigger="change" required placeholder=""><?php echo $registro['Description'];?></textarea>
                        </div>
                    </div>
										<div class="form-group">
                        <label class="col-sm-3 control-label">Correo</label>
                        <div class="col-sm-6">
                            <input name="txtEmail" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['Email'];?>"/>
                        </div>
										</div>
										
										<?php
											if (in_array("per_planes_editar", $permisos_usuario))
											{
										?>
												<div class="form-group">
														<label class="col-sm-3 control-label">Plan</label>
														<div class="col-sm-6">
															<select class="form-control" name="txtPlan">
																<option value="" disabled>Seleccione</option>
																<?php
																	while ($Plan = $planList->fetch(PDO::FETCH_ASSOC))
																	{
																			if($Plan['PlanId'] == $registro['PlanId']){
																?>
																			<option value="<?= $Plan['PlanId'] ?>" selected><?= $Plan['Name'] ?></option></td>
																<?php } else { ?>
																			<option value="<?= $Plan['PlanId'] ?>"><?= $Plan['Name'] ?></option></td>
																<?php
																			}
																	}
																?>
															</select>
														</div>
												</div>
										<?php
											}
											else
											{
										?>
												<input type="hidden" name="txtPlan" value="<?= $registro['PlanId'] ?>">
										<?php
											}
										?>
										<hr></hr>
										<div class="form-group">
                        <label class="col-sm-3 control-label">Contacto</label>
                        <div class="col-sm-3">
                          <select class="form-control" name="txtTypeContact[]">
                            <option value="" disabled>Seleccione</option>
														<option value="1">Dirección</option>
														<option value="2">Ciudad</option>
														<option value="3">País</option>
														<option value="4">Teléfono</option>
														<option value="5">Correo</option>
														<option value="6">Whatsapp</option>
														<option value="7">Página Web</option>
                          </select>
                        </div>
												<div class="col-sm-3">
                          <input name="txtDescriptionContact[]" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['Description'];?>"/>
                        </div>
                    </div>
										<div class="add">
										</div>
										<div class="center" align="center">
												<button type="button" class="btn btn-success waves-effect waves-light" onclick="agregarContacto()"><i class="fa fa-plus m-r-5"></i> <span>Agregar Contacto</span></button>
										</div>
										<hr></hr>
										<div class="form-group">
                        <label class="col-sm-3 control-label">Procedimiento</label>
                        <div class="col-sm-3">
													<label>Categoría</label>
                          <select class="form-control" name="txtCategorie[]" onchange="addSubCategory()" id="category" required>
                            <option value="" disabled selected>Seleccione</option>
                            <?php
                              $categories = new Categories();
                              $categoriesList = $categories->ListCategories();
                              while ($Categorie = $categoriesList->fetch(PDO::FETCH_ASSOC))
															{
																	if($Categorie['CategoryId'] == $registro['CategoryId']){
                            ?>
                                  <option value="<?= $Categorie['CategoryId'] ?>" selected><?= $Categorie['Name'] ?></option>
														<?php } else { ?>
																	<option value="<?= $Categorie['CategoryId'] ?>"><?= $Categorie['Name'] ?></option>
                            <?php
																	}
															}
                            ?>
                          </select>
                        </div>
												<div class="col-sm-3">
													<label>SubCategoría</label>
													<select class="form-control" name="txtSubCategory[]" id="subcategory" required>
                            <option value="" disabled selected>Seleccione</option>
                          </select>
                        </div>
                    </div>

                    <div class="addP">
										</div>
										<div class="center" align="center">
												<button type="button" class="btn btn-success waves-effect waves-light" onclick="agregarProcedimiento()"><i class="fa fa-plus m-r-5"></i> <span>Agregar Procedimiento</span></button>
										</div>

										<hr>
										<div class="form-group">
												<label class="col-sm-3 control-label">Código</label>
												<div class="col-sm-6">
													<input name="txtCode" disabled="disabled" type="text" pattern='^\d{4}$' maxlength="4" class="form-control" parsley-trigger="change" placeholder="" value="<?= $registro['Code'];?>"/>
												</div>
										</div>

                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-inverse btn-custom waves-effect waves-light" data-dismiss="modal" aria-label="Close"><i class="fa fa-undo m-r-5"></i> <span>Cancelar</span></button>
        <button id="submitButton" class="btn btn-default waves-effect waves-light" disabled="disabled" onclick="submitModalForm('medicos');"> <i class="fa fa-check m-r-5"></i> <span>ok</span> </button>
      </div>
    </div>
</div>
<script>

function agregarContacto(){
	$(".add").append('<div class="form-group"><label class="col-sm-3 control-label">Contacto</label><div class="col-sm-3"><select class="form-control" name="txtTypeContact[]"><option value="" disabled>Seleccione</option><option value="1">Dirección</option><option value="2">Ciudad</option><option value="3">País</option><option value="4">Teléfono</option><option value="5">Correo</option><option value="6">Whatsapp</option></select></div><div class="col-sm-3"><input name="txtDescriptionContact[]" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['Description'];?>"/></div></div>');
}
var i = 0;
function agregarProcedimiento(){
	$(".addP").append('<div class="form-group">'+
      '<label class="col-sm-3 control-label">Procedimiento</label>'+
      '<div class="col-sm-3">'+
        '<label>Categoría</label>'+
        '<select class="form-control" name="txtCategorie[]" onchange="addSubCategorie('+i+')" id="category'+i+'" required>'+
          '<option value="" disabled selected>Seleccione</option>'+
          '<?php
            $categoriesList = $categories->ListCategories();
            while ($Categorie = $categoriesList->fetch(PDO::FETCH_ASSOC))
            {
          ?>'+
          '<option value="<?= $Categorie['CategoryId'] ?>"><?= $Categorie['Name'] ?></option>'+
          '<?php
            }
          ?>'+
        '</select>'+
      '</div>'+
      '<div class="col-sm-3">'+
        '<label>SubCategoría</label>'+
        '<select class="form-control" name="txtSubCategory[]" id="subcategory'+i+'" required>'+
          '<option value="" disabled selected>Seleccione</option>'+
        '</select>'+
      '</div>'+
  '</div>');
  i++;
}

function addSubCategory(){
		var idCategory = $('#category').val();

		$.ajax({
			data: { id : idCategory},
			type: 'GET',
			url: 'controllers/GetSubCategories.php',
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function (data) {
				if(data == null){
					$('#subcategory').empty();
					$('#subcategory').append('<option value="" disabled selected>Seleccione</option>');
				}
				else{
					$('#subcategory').empty();
					$.each(data,function(index, el){
						$('#subcategory').append('<option value='+el.SubCategoryId+'>'+el.Name+'</option>');
					});
				}
			}
		});
}

function addSubCategorie(id){
		var idCategory = $('#category'+id).val();

		$.ajax({
			data: { id : idCategory},
			type: 'GET',
			url: 'controllers/GetSubCategories.php',
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function (data) {
				if(data == null){
					$('#subcategory'+id).empty();
					$('#subcategory'+id).append('<option value="" disabled selected>Seleccione</option>');
				}
				else{
					$('#subcategory'+id).empty();
					$.each(data,function(index, el){
						$('#subcategory'+id).append('<option value='+el.SubCategoryId+'>'+el.Name+'</option>');
					});
				}
			}
		});
}
</script>
<?php
	}
?>
