<?php
	require_once("models/Sections.php");
	include("includes/functions.php");

	$sections = new Sections();

	if(!isset($_POST['action']))
	{
		$_POST['action'] = '';
	}
	if(isset($_POST['id']))
	{
		$id = $_POST['id'];
	}
	elseif(isset($_POST['SectionId']))
	{
		$id = $_POST['SectionId'];
	}
	else
	{
		$id = '0';
	}

	$registro = array(
		'Section' => $id,
		'Name' => ''
	);

	if($id != '')
	{
		switch ($_POST['action'])
		{
			case 'submit':
				if($id != '0')
				{
					$sections->setSectionId($id);
					$sections->setMetaTitle(GetSQLValueString($_POST["txtTitle"], "text"));
          $sections->setMetaDescription(GetSQLValueString($_POST["txtDescription"], "text"));
          $sections->setKeywords(GetSQLValueString($_POST["txtKeywords"], "text"));
					echo json_encode($sections->UpdateSection());
                    exit();
				}

			break;

			case 'form':
				if($id != '0')
				{
					$sections->setSectionId($id);
					$registro = $sections->GetSectionContent();
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
      	<h2>Sección</h2>
      </div>
      <div id="modal-result" class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal group-border-dashed" action="#" id="modalForm" data-parsley-validate novalidate>
                    <input type="hidden" name="action" value="submit" />
                    <input type="hidden" name="SectionId" value="<?php echo $registro['SectionId']; ?>" />
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nombre</label>
                        <div class="col-sm-6">
                            <input type="text" disabled="disabled" class="form-control" value="<?php echo $registro['Name'];?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">MetaTitle</label>
                        <div class="col-sm-6">
                            <input name="txtTitle" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['MetaTitle'];?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">MetaDescription</label>
                        <div class="col-sm-6">
                            <textarea name="txtDescription" class="form-control" parsley-trigger="change" required><?php echo $registro['MetaDescription'];?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Keywords</label>
                        <div class="col-sm-6">
                            <input name="txtKeywords" type="text" class="form-control" parsley-trigger="change" required placeholder="" value="<?php echo $registro['Keywords'];?>"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-inverse btn-custom waves-effect waves-light" data-dismiss="modal" aria-label="Close"><i class="fa fa-undo m-r-5"></i> <span>Cancelar</span></button>
        <button id="submitButton" class="btn btn-default waves-effect waves-light" disabled="disabled" onclick="submitModalForm('section');"> <i class="fa fa-check m-r-5"></i> <span>ok</span> </button>
      </div>
    </div>
</div>

<?php
	}
?>
