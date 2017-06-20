<?php
	include("includes/header.php");

	require_once("models/Users.php");

	$users = new Users();
	$usersList = $users->ListUsers();

	$args = array();
	if(isset($_GET['id']) && $_GET['id'] != "")
	{
		$args['UserId'] = $_GET['id'];
	}
?>
		<div class="wrapper">
			<div class="container">

				<?php
					if (in_array("per_usuarios_ver", $permisos_usuario))
					{
				?>

						<div class="row">
							<div class="col-sm-12">
								<div class="btn-group pull-right m-t-15">
									<a href="javascript:void(0)" onclick="modalCall('usuarios','form','0')" class="btn btn-default btn-md waves-effect waves-light m-b-30"><i class="md md-add"></i> Agregar</a>
								</div>
								<h4 class="page-title">Usuarios</h4>
								<ol class="breadcrumb">
									<li>
										<a href="index.php">Inicio</a>
									</li>
									<li class="active">
										Usuarios
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
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="persist">Id</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Nombre</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Correo</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Teléfono</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Permisos</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Acciones</th>
											</tr>
										</thead>
										<tbody>
											<?php
												while ($user = $usersList->fetch(PDO::FETCH_ASSOC))
												{
													$content = 'usuarios';
													$id = $user["UserId"];
													$name = '<strong>Usuario No.'.$id.'</strong> ('.$user['Name'].')';	
											?>
													<tr id="<?= $id ?>">
														<td><?= $id ?></td>
														<td><?= $user['Name'] ?></td>
														<td><?= $user['Email'] ?></td>
														<td><?= $user['Phone'] ?></td>
														<td></td>
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
	if (!in_array("per_usuarios_ver", $permisos_usuario))
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