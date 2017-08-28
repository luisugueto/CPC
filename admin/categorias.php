<?php
	include("includes/header.php");

	require_once("models/Categories.php");

	$categories = new Categories();
	$categoriesList = $categories->ListCategories();

	$args = array();
	if(isset($_GET['id']) && $_GET['id'] != "")
	{
		$args['CategoryId'] = $_GET['id'];
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
											<a href="javascript:void(0)" onclick="modalCall('categorias_proce','form','0')" class="btn btn-default btn-md waves-effect waves-light m-b-30"><i class="md md-add"></i> Agregar</a>
									<?php
										}
									?>
								</div>
								<h4 class="page-title">Procedimientos</h4>
								<ol class="breadcrumb">
									<li>
										<a href="index.php">Inicio</a>
									</li>
									<li class="active">
										Procedimientos
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
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Nombre</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Acciones</th>
											</tr>
										</thead>
										<tbody>
											<?php
												while ($Category = $categoriesList->fetch(PDO::FETCH_ASSOC))
												{
													$content = 'categorias_proce';
													$id = $Category["CategoryId"];
													$name = '<strong>Categoría No.'.$id.'</strong> ('.$Category['Name'].')';
											?>
													<tr id="<?= $id ?>">
														<td><?= $id ?></td>
														<td><?= $Category['Name'] ?></td>
														<td>
															<?php
																if (in_array("per_procedimientos_editar", $permisos_usuario))
																{
															?>
																	<a href="javascript:void(0)" onclick="modalCall('categorias_proce','form','<?= $id;?>')" class="btn btn-inverse btn-custom waves-effect waves-light btn-xs"><i class="fa fa-pencil"></i></a>
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
