<?php
	include("includes/header.php");

    require_once("models/Articles.php");
	require_once("models/SubCategories.php");

    $articleId = $_GET["id"];

    $article = new Articles();
	$article->setArticleId($articleId);
	$article->GetArticleContent();

	$subCategories = new SubCategories();
    $listSubCategories = $subCategories->GetAllSubCategories();

?>
        <script src="js/ckeditor/ckeditor.js"></script>
		<div class="wrapper">
			<div class="container">

                <?php
					if (in_array("per_blog_editar", $permisos_usuario))
					{
				?>

                        <form method="POST" onsubmit="UpdateArticle(this); return false;" enctype="multipart/form-data">

                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="page-title">Artículos</h4>
                                    <ol class="breadcrumb">
                                        <li>
                                            <a href="index.php">Inicio</a>
                                        </li>
                                        <li class="active">
                                            <?= $article->getTitle() ?>
                                        </li>
                                    </ol>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-lg-8">
                                    <div class="search-result-box">
                                        <div class="card-box">
                                            
                                            <div class="form-group">
                                                <label>Título:</label>
                                                <input type="text" id="txtTitle" name="txtTitle" class="form-control" style="text-transform:none;" onblur="createSlug(this)" value="<?= $article->getTitle() ?>">
                                            </div>

                                            <div class="form-group">
                                                <label>Contenido:</label>
                                                <textarea id="txtContent" name="txtContent" class="ckeditor" rows="4" style="text-transform:none;"><?= $article->getContent(); ?></textarea>
                                            </div>

                                            <hr>

                                            <h4>Información para SEO</h4>

                                            <div class="form-group">
                                                <label>Meta título:</label>
                                                <input type="text" id="txtMetaTitle" name="txtMetaTitle" class="form-control" value="<?= $article->getMetaTitle() ?>">
                                            </div>

                                            <div class="form-group">
                                                <label>Meta descripción:</label>
                                                <textarea id="txtMetaDescription" name="txtMetaDescription" class="form-control" style="text-transform:none;" maxlength="200"><?= $article->getMetaDescription(); ?></textarea>
                                                <small>El texto no debe superar los 200 carácteres</small>
                                            </div>

                                            <div class="form-group">
                                                <label>Url (Slug):</label>
                                                <br>
                                                http://www.cirugiaplasticacolombia.com/ <input type="text" id="slug-article" name="slug-article" class="form-control" style="text-transform:none;display:inline-block;width:50%;" onblur="createSlug(this)" value="<?= $article->getSlug() ?>">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="search-result-box">
                                        <div class="card-box">

                                            <h4>Publicación</h4>

                                            <hr>

                                            <div class="form-group">
                                                <?php
                                                    if($article->getStatusId() == "1")
                                                    {
                                                ?>
                                                        <input type="checkbox" name="statusCheck" data-size="medium" data-on-color="success" data-off-color="danger" name="chkStatus" id="chkStatus" data-on-text="Publica" data-off-text="Borrador" checked>
                                                <?php
                                                    }
                                                    else
                                                    {
                                                ?>
                                                        <input type="checkbox" name="statusCheck" data-size="medium" data-on-color="success" data-off-color="danger" name="chkStatus" id="chkStatus" data-on-text="Publica" data-off-text="Borrador">
                                                <?php
                                                    }
                                                ?>
                                            </div>

                                            <div class="form-group">
                                                <div class="input-group date" id='datetimepicker'>
                                                    <?php
                                                        $newDate = date("d-m-Y", strtotime($article->getPublishDate()));
                                                    ?>
                                                    <input type="text" id="txtPublishDate" name="txtPublishDate" class="form-control" style="text-transform:none;" value="<?= $newDate ?>">
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar">
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>

                                            <hr>

                                            <h4>Categorías</h4>

                                            <hr>

                                            <?php
                                                while ($category = $listSubCategories->fetch(PDO::FETCH_ASSOC))
                                                {
                                                    $categoryId = $article->GetCategoryIdByArticleId($category["SubCategoryId"]);

                                                    if ($categoryId != "")
                                                    {
                                            ?>
                                                        <div class="checkbox checkbox-primary">
                                                            <input type="checkbox" name="categoryCheck" id="category<?= $category["SubCategoryId"] ?>" value="<?= $category["SubCategoryId"] ?>" checked>
                                                            <label>
                                                                <?= $category["Name"] ?>
                                                            </label>
                                                        </div>
                                            <?php
                                                    }
                                                    else
                                                    {
                                            ?>
                                                        <div class="checkbox checkbox-primary">
                                                            <input type="checkbox" name="categoryCheck" id="category<?= $category["SubCategoryId"] ?>" value="<?= $category["SubCategoryId"] ?>">
                                                            <label>
                                                                <?= $category["Name"] ?>
                                                            </label>
                                                        </div>
                                            <?php
                                                    }
                                                }
                                            ?>

                                            <hr>

                                            <h4>Seleccionar imagen</h4>

                                            <hr>

                                            <div class="form-group">
                                                <div>
                                                    <img id="previewImage" src="../images/blog/<?= $article->getPhoto() ?>" style="max-width:100%;">
                                                </div>

                                                <br>
                                                <input type="file" class="custom-file-input cropit-image-input" id="imgSlide" name="imgSlide">
                                                <div class="alert alert-warning" role="alert" id="photo-alert" style="display:none; margin-top:10px;">La imagen que está intentando subir pesa más de 5Mb, debe seleccionar una imagen de menor peso.</div>
                                            </div>

                                            <hr>

                                            <div class="form-group">
                                                <input type="hidden" id="hdAuthor" name="hdAuthor" value="<?= $_COOKIE["UserName"] ?>">
                                                <input type="hidden" id="hdSlug" name="hdSlug" value="">
                                                <input type="hidden" name="hdArticleId" id="hdArticleId" value="<?= $articleId ?>">
                                                <input type="hidden" name="hdActualImage" id="hdActualImage" value="<?= $article->getPhoto() ?>">
                                                <button class="btn btn-default btn-signin" type="submit" style="width:150px">Guardar</button>
                                                <div class="alert alert-danger" style="display:none; margin-top:10px;" id="errorMsg"></div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </form>

                <?php
                    }
                ?>

<?php
	include("includes/footer.php");
    if ((!in_array("per_blog_editar", $permisos_usuario)))
	{
		echo '<script type="text/javascript">swal({
				html:true,
				title: "Atención!",
				text: "La URL a la que intenta ingresar, es restringida<br/>",
				type: "error",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Cerrar",
				closeOnConfirm: false
			}, function(){
				$(".sweet-alert").hide();
				$(".sweet-overlay").hide();
				$("#fullscreenloading").show();
				location.href = "index.php";
			});</script>';
	}
?>

    <script src="js/functions.js"></script>
    <script type="text/javascript">

		jQuery(function($) {
			$('#slug-article').slugify('#txtTitle');
		});

		function createSlug(sender) {
			$('#slug-article').slugify(sender);
		}

		$(function(argument) {
			$('input[name=statusCheck]').bootstrapSwitch();
		});

		$(function () {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1;
            var yy = today.getFullYear();
            var todayDate =  mm + "/" + dd + "/" + yy;

            $('#datetimepicker').datetimepicker({
				defaultDate: todayDate,
            	format: "DD/MM/YYYY",
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                }
            });
        });

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
							aspectRatio: 2 / 1,
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
								$('#previewImage').cropper('setData', {"x":0,"y":0,"width":1024,"height":512,"rotate":0,"scaleX":1,"scaleY":1});
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