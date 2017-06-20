<?php
	include("includes/header.php");

	require_once("models/Articles.php");

	$articles = new Articles();
	$articlesList = $articles->ListArticles();

	$args = array();
	if(isset($_GET['id']) && $_GET['id'] != "")
	{
		$args['ArticleId'] = $_GET['id'];
	}
?>
		<div class="wrapper">
			<div class="container">

				<?php
					if (!in_array("per_articulos_ver", $permisos_usuario))
					{
				?>

						<div class="row">
							<div class="col-sm-12">
								<div class="btn-group pull-right m-t-15">
									<a href="javascript:void(0)" onclick="modalCall('medicos','form','0')" class="btn btn-default btn-md waves-effect waves-light m-b-30"><i class="md md-add"></i> Agregar</a>
								</div>
								<h4 class="page-title">Médicos</h4>
								<ol class="breadcrumb">
									<li>
										<a href="index.php">Inicio</a>
									</li>
									<li class="active">
										Médicos
									</li>
								</ol>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<div class="card-box m-b-0">
									<table class="tablesaw table m-b-0" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch>
										<thead>
											<tr>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="persist">Foto</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Título</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Categorías</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Estado</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Acciones</th>
											</tr>
										</thead>
										<tbody>
											<?php
												while ($article = $articlesList->fetch(PDO::FETCH_ASSOC))
												{
													$content = 'articulos';
													$id = $article["ArticleId"];
													$name = '<strong>Artículo No.'.$id.'</strong> ('.$article['Title'].')';
											?>
													<tr id="<?= $id ?>">
														<td><img src="../images/blog/<?= $article['Photo'] ?>" width="100"></td>
														<td><?= $article['Title'] ?></td>
														<td><?= $article['Categories'] ?></td>

														<td>
															<?php
																if ($article['StatusId'] == "1")
																{
															?>
																	<a href="javascript:void(0)" onclick="UpdateArticleStatus('<?= $id ?>', 2)" style="color:#4CAF50"><i class="fa fa-circle" aria-hidden="true"></i></a>
															<?php
																}
																else
																{
															?>
																	<a href="javascript:void(0)" onclick="UpdateArticleStatus('<?= $id ?>', 1)" style="color:#999"><i class="fa fa-circle" aria-hidden="true"></i></a>
															<?php
																}
															?>
														</td>

														<td>
															<a href="javascript:void(0)" onclick="modalCall('<?= $content ?>','form','<?= $id;?>')" class="btn btn-inverse btn-custom waves-effect waves-light btn-xs"><i class="fa fa-pencil"></i></a>
															<a href="javascript:void(0)" onclick="deleteItem('<?= $content ?>','<?= $id ?>','<?= $name ?>')" class="btn btn-danger btn-custom waves-effect waves-light btn-xs"><i class="fa fa-remove"></i></a>
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
	/*if (!in_array("per_articulos_ver", $permisos_usuario))
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
	}*/
?>
