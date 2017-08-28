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
		'CategoryId' => '',
		'Name' => '',
		'Description' => '',
		'Content' => '',
		'Photo' => ''
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
					$SubCategories->setContent($_POST["txtContent"]);

					if ($_FILES['foto']['name'] != NULL)
					{
						$alowedExt = array("jpg","png","gif","jpeg");

						//Obtener la extensión del archivo
						$explode = explode(".",$_FILES['foto']["name"]);
						$fileExt = end($explode);

						//Crear String aleatorio de 10 caracteres para asignarlo al nombre de la foto
						$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
						$charactersLength = strlen($characters);
						$randomString = '';

						for ($i = 0; $i < 3; $i++) {
							$randomString .= $characters[rand(0, $charactersLength - 1)];
						}

						$_FILES['foto']['name'] = $randomString."_".slugify($_FILES['foto']['name']);

						//Obtener el nombre del archivo
						$SubCategories->setPhoto($_FILES['foto']["name"]);

						//Validar si la extensión del archivo esta permitido
						if (in_array($fileExt,$alowedExt))
						{
							$folder = "../images/procedimientos/";
							$ruta = $_FILES['croppedImage']["tmp_name"];
							$file = $SubCategories->getPhoto();
							$destino = $folder.$file;
							//Validar si el archivo ya existe en la carpeta
							if(!file_exists($destino))
							{

								$image = $_FILES['croppedImage']['tmp_name'];

								$original_info = getimagesize($image);

								if ($original_info['mime'] == 'image/jpeg')
								{
									$original_img = imagecreatefromjpeg($image);
								}
								elseif ($original_info['mime'] == 'image/gif')
								{
									$original_img = imagecreatefromgif($image);
								}
								elseif ($original_info['mime'] == 'image/png')
								{
									$original_img = imagecreatefrompng($image);
								}

								$width = imagesx($original_img);
								$height = imagesy($original_img);

								$default_width = 1000;

								if ($width > $default_width) {
									$percent = $default_width / $width;
									$new_width = $width * $percent;
									$new_height = $height * $percent;
								}

								$percent = $default_width / $width;
								$new_width = $width * $percent;
								$new_height = $height * $percent;

								$thumb = imagecreatetruecolor( $new_width, $new_height );
								imagecopyresampled($thumb, $original_img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
								imagejpeg($thumb, $image, 80);
								move_uploaded_file($ruta, $destino);
							}
						}
					}
					else
					{
						$SubCategories->setSubCategoryId($id);
						$registro = $SubCategories->GetSubCategoryContent();
						$SubCategories->setPhoto($registro["Photo"]);
					}

					echo $SubCategories->UpdateSubCategory();
					exit();
				}
				else
				{
					$SubCategories->setName(GetSQLValueString($_POST["txtName"], "text"));
					$SubCategories->setCategoryId($_POST["txtCategoria"]);
					$SubCategories->setDescription(GetSQLValueString($_POST["txtDescription"], "text"));
					$SubCategories->setContent($_POST["txtContent"]);

					if ($_FILES['foto']['name'] != NULL)
					{
						$alowedExt = array("jpg","png","gif","jpeg");

						//Obtener la extensión del archivo
						$explode = explode(".",$_FILES['foto']["name"]);
						$fileExt = end($explode);

						//Crear String aleatorio de 10 caracteres para asignarlo al nombre de la foto
						$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
						$charactersLength = strlen($characters);
						$randomString = '';

						for ($i = 0; $i < 3; $i++) {
							$randomString .= $characters[rand(0, $charactersLength - 1)];
						}

						$_FILES['foto']['name'] = $randomString."_".slugify($_FILES['foto']['name']);

						//Obtener el nombre del archivo
						$SubCategories->setPhoto($_FILES['foto']["name"]);

						//Validar si la extensión del archivo esta permitido
						if (in_array($fileExt,$alowedExt))
						{
							$folder = "../images/procedimientos/";
							$ruta = $_FILES['croppedImage']["tmp_name"];
							$file = $SubCategories->getPhoto();
							$destino = $folder.$file;
							//Validar si el archivo ya existe en la carpeta
							if(!file_exists($destino))
							{

								$image = $_FILES['croppedImage']['tmp_name'];

								$original_info = getimagesize($image);

								if ($original_info['mime'] == 'image/jpeg')
								{
									$original_img = imagecreatefromjpeg($image);
								}
								elseif ($original_info['mime'] == 'image/gif')
								{
									$original_img = imagecreatefromgif($image);
								}
								elseif ($original_info['mime'] == 'image/png')
								{
									$original_img = imagecreatefrompng($image);
								}

								$width = imagesx($original_img);
								$height = imagesy($original_img);

								$default_width = 960;

								if ($width > $default_width) {
									$percent = $default_width / $width;
									$new_width = $width * $percent;
									$new_height = $height * $percent;
								}

								$percent = $default_width / $width;
								$new_width = $width * $percent;
								$new_height = $height * $percent;

								$thumb = imagecreatetruecolor( $new_width, $new_height );
								imagecopyresampled($thumb, $original_img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
								imagejpeg($thumb, $image, 80);
								move_uploaded_file($ruta, $destino);
							}
						}
					}

					echo $SubCategories->CreateSubCategory();
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
<script src="js/ckeditor/ckeditor.js"></script>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      	<h2>SubCategoría</h2>
      </div>
      <div id="modal-result" class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal group-border-dashed" action="#" id="modalSubCategorias" data-parsley-validate novalidate>
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
							<textarea name="txtDescription" class="form-control" parsley-trigger="change" required placeholder="">
								<?php echo $registro['Description'];?>
							</textarea>
                        </div>
                    </div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Contenido</label>
						<div class="col-sm-6">
							<textarea id="ckEditorText" class="ckeditor" rows="4" style="text-transform:none;"><?= $registro["Content"] ?></textarea>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Foto</label>
						<div class="col-sm-6">
							<?php
								if ($registro["Photo"])
								{
							?>
									<img id="previewImage" src="../images/procedimientos/<?= $registro["Photo"] ?>" style="max-width:100%;">
							<?php
								}
								else
								{
							?>
									<img id="previewImage" src="#" style="max-width:100%; display:none;">
							<?php
								}
							?>
							<br>
							<input type="file" class="custom-file-input cropit-image-input" id="imgSlide" name="foto">
							<div class="alert alert-warning" role="alert" id="photo-alert" style="display:none; margin-top:10px;">La imagen que está intentando subir pesa más de 5Mb, debe seleccionar una imagen de menor peso.</div>
						</div>
					</div>

                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-inverse btn-custom waves-effect waves-light" data-dismiss="modal" aria-label="Close"><i class="fa fa-undo m-r-5"></i> <span>Cancelar</span></button>
        <button id="submitSubCategorias" class="btn btn-default waves-effect waves-light" disabled="disabled"> <i class="fa fa-check m-r-5"></i> <span>ok</span> </button>
      </div>
    </div>
</div>

	<script type="text/javascript">

        function readURL(input) {
			var Loader = $("#loader");
			Loader.fadeIn(500);

			if (input.files && input.files[0]) {

				var size = input.files[0].size;

				if (size > 5000000) {
					$("#photo-alert").fadeIn(500);
					Loader.fadeOut(500);
				}
				else {
					$("#photo-alert").fadeOut(500);
					var reader = new FileReader();

					reader.onload = function (e) {
						$('#previewImage').attr('src', e.target.result);
						$('#previewImage').fadeIn(500);
						$('#previewImage').cropper({
							aspectRatio: 24 / 5,
							autoCropArea: 0,
							strict: true,
							guides: true,
							highlight: false,
							dragCrop: true,
							cropBoxResizable: true,
							scalable: false,
							rotatable: false,
							zoomable: false,
							dragMode: "move",
							built: function () {
								$('#previewImage').cropper('setData', {"x":0,"y":0,"width":960,"height":200,"rotate":0,"scaleX":1,"scaleY":1});
							}
						});
						Loader.fadeOut(500);
					}
					reader.readAsDataURL(input.files[0]);
				}

			}
		}

		$("#imgSlide").change(function(){
			readURL(this);
		});

	</script>

<?php
	}
?>
