<?php
	include("includes/header.php");

	require_once("models/Sections.php");

	$sections = new Sections();
	$sectionsList = $sections->ListSections();

	$args = array();
	if(isset($_GET['id']) && $_GET['id'] != "")
	{
		$args['SectionId'] = $_GET['id'];
	}
?>
		<div class="wrapper">
			<div class="container">

				<?php
					if (in_array("per_seo_editar", $permisos_usuario))
					{
				?>

						<div class="row">
							<div class="col-sm-12">
								<div class="btn-group pull-right m-t-15">
								</div>
								<h4 class="page-title">Secciones</h4>
								<ol class="breadcrumb">
									<li>
										<a href="index.php">Inicio</a>
									</li>
									<li class="active">
										Secciones
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
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Nombre</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">MetaTitle</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">MetaDescription</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Keywords</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Acciones</th>
											</tr>
										</thead>
										<tbody>
											<?php
												while ($Section = $sectionsList->fetch(PDO::FETCH_ASSOC))
												{
													$content = 'section';
													$id = $Section["SectionId"];
													$name = '<strong>Sección No.'.$id.'</strong>';
											?>
													<tr id="<?= $id ?>">
														<td><?= $id ?></td>
                            							<td><?= $Section['Name'] ?></td>
														<td><?= $Section['MetaTitle'] ?></td>
                            							<td><?= $Section['MetaDescription'] ?></td>
                            							<td><?= $Section['Keywords'] ?></td>
														<td>
															<?php
																if (in_array("per_seo_editar", $permisos_usuario))
																{
															?>
																	<a href="javascript:void(0)" onclick="modalCall('section','form','<?= $id;?>')" class="btn btn-inverse btn-custom waves-effect waves-light btn-xs"><i class="fa fa-pencil"></i></a>
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
	if (!in_array("per_seo_editar", $permisos_usuario))
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