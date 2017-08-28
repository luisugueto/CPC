<?php
	include("includes/header.php");

	require_once("models/SubCategories.php");
	require_once("models/Categories.php");

	$subCategories = new SubCategories();
	$subcategoriesList = $subCategories->ListSubCategories();

	$categories = new Categories();

	$args = array();
	if(isset($_GET['id']) && $_GET['id'] != "")
	{
		$args['SubCategoryId'] = $_GET['id'];
	}
?>
		<div class="wrapper">
			<div class="container">

				<?php
					if (in_array("per_procedimientos_crear", $permisos_usuario) || in_array("per_procedimientos_editar", $permisos_usuario) || in_array("per_procedimientos_eliminar", $permisos_usuario))
					{
				?>

						<div class="row">
							<div class="col-sm-12">
								<div class="btn-group pull-right m-t-15">
									<?php
										if (in_array("per_procedimientos_crear", $permisos_usuario))
										{
									?>
											<a href="javascript:void(0)" onclick="modalCall('subcategorias','form','0')" class="btn btn-default btn-md waves-effect waves-light m-b-30"><i class="md md-add"></i> Agregar</a>
									<?php
										}
									?>
								</div>
								<h4 class="page-title">Sub procedimientos</h4>
								<ol class="breadcrumb">
									<li>
										<a href="index.php">Inicio</a>
									</li>
									<li class="active">
										Sub procedimientos
									</li>
								</ol>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<div class="card-box m-b-0">
									<table class="tablesaw table m-b-0" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch id="example">
										<thead>
											<tr>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="persist">Id</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Foto</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Nombre</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Categoría</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Acciones</th>
											</tr>
										</thead>
										<tbody>
											<?php
												while ($Category = $subcategoriesList->fetch(PDO::FETCH_ASSOC))
												{
													$content = 'subcategorias';
													$id = $Category["SubCategoryId"];
													$name = '<strong>SubCategoría No.'.$id.'</strong> ('.$Category['Name'].')';
											?>
													<tr id="<?= $id ?>">
														<td><?= $id ?></td>
														<td><img src="../images/procedimientos/<?= $Category['Photo'] ?>" style="width: 100px"></td>
														<td><?= $Category['Name'] ?></td>
														<td><?= $categories->GetCategoryName($Category['CategoryId']); ?></td>
														<td>
															<?php
																if (in_array("per_procedimientos_editar", $permisos_usuario))
																{
															?>
																	<a href="javascript:void(0)" onclick="modalCall('subcategorias','form','<?= $id;?>')" class="btn btn-inverse btn-custom waves-effect waves-light btn-xs"><i class="fa fa-pencil"></i></a>
															<?php
																}	
																if (in_array("per_procedimientos_eliminar", $permisos_usuario))
																{
															?>
																	<a href="javascript:void(0)" onclick="deleteItem('<?= $content ?>','<?= $id ?>','<?= $name ?>')" class="btn btn-danger btn-custom waves-effect waves-light btn-xs"><i class="fa fa-remove"></i></a>
															<?php
																}
															?>
														</td>
													</tr>
											<?php
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>

				<?php
					}
				?>

<?php
	include("includes/footer.php");
	if ((!in_array("per_procedimientos_crear", $permisos_usuario)) && (!in_array("per_procedimientos_editar", $permisos_usuario)) && (!in_array("per_procedimientos_eliminar", $permisos_usuario)))
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
