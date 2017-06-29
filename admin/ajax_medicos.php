<?php
	require_once("models/Doctors.php");
	require_once("models/DataDoctors.php");
	require_once("models/Plans.php");
	require_once("models/Categories.php");
	require_once("models/SubCategories.php");
	require_once("models/ProceduresDoctor.php");

	include("includes/functions.php");

	$doctors = new Doctors();
  $plans = new Plans();
	$planList = $plans->ListPlans();
	$categories = new Categories();
	$categoriesList = $categories->ListCategories();
	$subcategories = new SubCategories();
	$subcategoriesList = $subcategories->ListSubCategories();

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
		'PlanId' => ''
	);

	if($id != '')
	{
		switch ($_POST['action'])
		{
			case 'submit':
				if($id != '0')
				{
					$doctors->setDoctorId($id);
					$doctors->setName(GetSQLValueString($_POST["txtName"], "text"));
					$doctors->setSubTitle(GetSQLValueString($_POST["txtSubTitle"], "text"));
					$doctors->setDescription(GetSQLValueString($_POST["txtDescription"], "text"));
					$doctors->setPlanId($_POST["txtPlan"]);
					echo json_encode($doctors->UpdateDoctor());
                    exit();
				}
				else
				{
					$doctors->setName(GetSQLValueString($_POST["txtName"], "text"));
					$doctors->setSubTitle(GetSQLValueString($_POST["txtSubTitle"], "text"));
					$doctors->setDescription(GetSQLValueString($_POST["txtDescription"], "text"));
					$doctors->setPlanId($_POST["txtPlan"]);

					$test = $doctors->CreateDoctor();
					if($test == 'exito'){
						$descriptionContact = $_POST['txtDescriptionContact'];
						$typeContact = $_POST['txtTypeContact'];

						foreach($descriptionContact as $key => $value) {
							$data = new DataDoctors();
							if($typeContact[$key] == '1')
								$data->setName('Direccion');
							elseif($typeContact[$key] == '2')
								$data->setName('Ciudad');
							elseif($typeContact[$key] == '3')
								$data->setName('Pais');
							elseif($typeContact[$key] == '4')
								$data->setName('Telefono');
							elseif($typeContact[$key] == '5')
								$data->setName('Correo');
							elseif($typeContact[$key] == '6')
								$data->setName('Whatsapp');

							$data->setDoctorId($doctors->lastDoctorId());
							$data->setDescription($value);
							$data->CreateDataDoctor();
						}

						$procedureCategory = $_POST['txtCategorie'];
						$procedureSubCategory = $_POST['txtSubCategory'];

						$procedures = new ProceduresDoctor();
						$procedures->setCategoryId($procedureCategory);
						$procedures->setSubCategoryId($procedureSubCategory);
						$procedures->setDoctorId($doctors->lastDoctorId());
						$procedures->CreateProceduresDoctor();


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

			case 'edit':
			if($id != '0')
			{
				$doctors->setDoctorId($id);
				$registro = $doctors->GetDoctorContent();
				$data = new DataDoctors();
				$data->GetAllDataDoctorsforDoctor($id);
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
				<?php
					while ($procedures = $proceduresList->fetch(PDO::FETCH_ASSOC))
					{
						$content = 'medicos';
						$id = $procedures["DoctorId"];
				?>

							<?= $id ?>

				<?php
					}
				?>
      </div>
		</div>
	</div>
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
                            <input name="txtDescription" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['Description'];?>"/>
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
                          <select class="form-control" name="txtCategorie" onchange="addSubCategory()" id="category" required>
                            <option value="" disabled selected>Seleccione</option>
                            <?php
                              while ($Categorie = $categoriesList->fetch(PDO::FETCH_ASSOC))
															{
																	if($Categorie['CategoryId'] == $registro['CategoryId']){
                            ?>
                                  <option value="<?= $Categorie['CategoryId'] ?>" selected><?= $Categorie['Name'] ?></option></td>
														<?php } else { ?>
																	<option value="<?= $Categorie['CategoryId'] ?>"><?= $Categorie['Name'] ?></option></td>
                            <?php
																	}
															}
                            ?>
                          </select>
                        </div>
												<div class="col-sm-3">
													<select class="form-control" name="txtSubCategory" id="subcategory" required>
                            <option value="" disabled selected>Seleccione</option>
                          </select>
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
</script>
<?php
	}
?>
