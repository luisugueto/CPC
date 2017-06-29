<?php
	require_once("models/Categories.php");
  require_once("models/SubCategories.php");
	include("includes/functions.php");

	$Categories = new Categories();
  $categoriesList = $Categories->ListCategories();
  $SubCategories = new SubCategories();

	if(!isset($_POST['action']))
	{
		$_POST['action'] = '';
	}
	if(isset($_POST['id']))
	{
		$id = $_POST['id'];
	}
	elseif(isset($_POST['SubCategoryId']))
	{
		$id = $_POST['SubCategoryId'];
	}
	else
	{
		$id = '0';
	}

	$registro = array(
		'SubCategoryId' => $id,
		'Name' => '',
    'Description'
	);

	if($id != '')
	{
		switch ($_POST['action'])
		{
			case 'submit':
				if($id != '0')
				{
					$SubCategories->setSubCategoryId($id);
          $SubCategories->setName(GetSQLValueString($_POST["txtName"], "text"));
          $SubCategories->setCategoryId($_POST["txtCategoria"]);
          $SubCategories->setDescription(GetSQLValueString($_POST["txtDescription"], "text"));
					echo json_encode($SubCategories->UpdateSubCategory());
                    exit();
				}
				else
				{
          $SubCategories->setName(GetSQLValueString($_POST["txtName"], "text"));
          $SubCategories->setCategoryId($_POST["txtCategoria"]);
          $SubCategories->setDescription(GetSQLValueString($_POST["txtDescription"], "text"));

					echo json_encode($SubCategories->CreateSubCategory());
                    exit();
				}
			break;

			case 'form':
				if($id != '0')
				{
					$SubCategories->setSubCategoryId($id);
					$registro = $SubCategories->GetSubCategoryContent();
				}
			break;

			case 'delete':
				if($id != '0')
				{
					$SubCategories->setSubCategoryId($id);
					echo json_encode($SubCategories->DeleteSubCategory());
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
      	<h2>SubCategoría</h2>
      </div>
      <div id="modal-result" class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal group-border-dashed" action="#" id="modalForm" data-parsley-validate novalidate>
                    <input type="hidden" name="action" value="submit" />
                    <input type="hidden" name="SubCategoryId" value="<?php echo $registro['SubCategoryId']; ?>" />
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Registro ID.</label>
                        <div class="col-sm-6">
                            <input type="text" disabled="disabled" class="form-control" value="<?php echo $registro['SubCategoryId'];?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Categoría</label>
                        <div class="col-sm-6">
                          <select class="form-control" name="txtCategoria">
                            <option value="" disabled>Seleccione</option>
                            <?php
															while ($Category = $categoriesList->fetch(PDO::FETCH_ASSOC))
															{
																	if($Category['CategoryId'] == $registro['CategoryId']){
														?>
																	<option value="<?= $Category['CategoryId'] ?>" selected><?= $Category['Name'] ?></option></td>
														<?php } else { ?>
																	<option value="<?= $Category['CategoryId'] ?>"><?= $Category['Name'] ?></option></td>
														<?php
																	}
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
                        <label class="col-sm-3 control-label">Descripcion</label>
                        <div class="col-sm-6">
                            <input name="txtDescription" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['Name'];?>"/>
                        </div>
                    </div>

                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-inverse btn-custom waves-effect waves-light" data-dismiss="modal" aria-label="Close"><i class="fa fa-undo m-r-5"></i> <span>Cancelar</span></button>
        <button id="submitButton" class="btn btn-default waves-effect waves-light" disabled="disabled" onclick="submitModalForm('subcategorias');"> <i class="fa fa-check m-r-5"></i> <span>ok</span> </button>
      </div>
    </div>
</div>

<?php
	}
?>
