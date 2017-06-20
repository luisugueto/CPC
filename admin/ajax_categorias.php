<?php
	require_once("models/ArticlesCategories.php");
	include("includes/functions.php");

	$articlesCategories = new ArticlesCategories();

	if(!isset($_POST['action']))
	{
		$_POST['action'] = '';
	}
	if(isset($_POST['id']))
	{
		$id = $_POST['id'];
	}
	elseif(isset($_POST['CategoryId']))
	{
		$id = $_POST['CategoryId'];
	}
	else
	{
		$id = '0';
	}

	$registro = array(
		'CategoryId' => $id,
		'Name' => ''
	);

	if($id != '')
	{
		switch ($_POST['action'])
		{
			case 'submit':
				if($id != '0')
				{
					$articlesCategories->setCategoryId($id);
					$articlesCategories->setName(GetSQLValueString($_POST["txtName"], "text"));
					echo json_encode($articlesCategories->UpdateArticleCategory());
                    exit();
				}
				else
				{
					$articlesCategories->setName(GetSQLValueString($_POST["txtName"], "text"));
					echo json_encode($articlesCategories->CreateArticleCategory());
                    exit();
				}
			break;

			case 'form':
				if($id != '0')
				{
					$articlesCategories->setCategoryId($id);
					$registro = $articlesCategories->GetArticleCategoryContent();
				}
			break;

			case 'delete':
				if($id != '0')
				{
					$articlesCategories->setCategoryId($id);
					echo json_encode($articlesCategories->DeleteArticleCategory());
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
      	<h2>Categoría</h2>
      </div>
      <div id="modal-result" class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal group-border-dashed" action="#" id="modalForm" data-parsley-validate novalidate>
                    <input type="hidden" name="action" value="submit" />
                    <input type="hidden" name="CategoryId" value="<?php echo $registro['CategoryId']; ?>" />
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Registro ID.</label>
                        <div class="col-sm-6">
                            <input type="text" disabled="disabled" class="form-control" value="<?php echo $registro['CategoryId'];?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nombre</label>
                        <div class="col-sm-6">
                            <input name="txtName" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['Name'];?>"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-inverse btn-custom waves-effect waves-light" data-dismiss="modal" aria-label="Close"><i class="fa fa-undo m-r-5"></i> <span>Cancelar</span></button>
        <button id="submitButton" class="btn btn-default waves-effect waves-light" disabled="disabled" onclick="submitModalForm('categorias');"> <i class="fa fa-check m-r-5"></i> <span>ok</span> </button>
      </div>
    </div>
</div>

<?php
	}
?>
