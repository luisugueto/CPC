<?php
	include("includes/header.php");

	require_once("models/PlanClients.php");
	require_once("models/Plans.php");
	require_once("models/Users.php");

	$PlansClientes = new PlanClients();
	$planClientsList = $PlansClientes->ListPlanClientsJoin();
	$Plan = new Plans();

	$users->setUserId($_COOKIE['UserId']);
	$usuario = $users->GetUserContent();

	if(isset($usuario['Type']))
	{
		if($usuario['Type']=='Client')
		{
			$clientId = $usuario['TypeId'];
		}
	}		

	$args = array();
	if(isset($_GET['id']) && $_GET['id'] != "")
	{
		$args['PlanId'] = $_GET['id'];
	}
?>
		<div class="wrapper">
			<div class="container">

				<?php
					if (in_array("per_pagos_crear", $permisos_usuario) || in_array("per_pagos_editar", $permisos_usuario) || in_array("per_pagos_eliminar", $permisos_usuario))
					{
				?>

						<div class="row">
							<div class="col-sm-12">
								<div class="btn-group pull-right m-t-15">
									<?php
										if (in_array("per_pagos_crear", $permisos_usuario))
										{
									?>
											<a href="javascript:void(0)" onclick="modalCall('plan','form','0')" class="btn btn-default btn-md waves-effect waves-light m-b-30"><i class="md md-add"></i> Agregar</a>
									<?php
										}	
									?>
								</div>
								<h4 class="page-title">Pagos</h4>
								<ol class="breadcrumb">
									<li>
										<a href="index.php">Inicio</a>
									</li>
									<li class="active">
										Pagos
									</li>
								</ol>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<div class="card-box m-b-0">
									<table id="example" class="tablesaw table m-b-0" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch>
										<thead>
											<tr>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="persist">Id</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Nombre Cliente</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Plan</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Costo Plan</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Acciones</th>
											</tr>
										</thead>
										<tbody>
											<?php
												while ($ContentPlan = $planClientsList->fetch(PDO::FETCH_ASSOC))
												{
													$content = 'plan';
													$id = $ContentPlan["PlanClientId"];
													$Plan->setPlanId($ContentPlan["PlanId"]);
													$plann = $Plan->GetPlanContent();
											?>
													<tr id="<?= $id ?>">
														<td><?= $id ?></td>
                            							<td><?= $ContentPlan['Name'] ?></td>
														<td><?= $plann['Name']; ?></td>
                            							<td><?= $plann['Price']; ?></td>
														<td>
															<?php
																if (in_array("per_pagos_editar", $permisos_usuario))
																{
															?>
																	<a href="javascript:void(0)" onclick="modalCall('<?= $content ?>','form','<?= $id;?>')" class="btn btn-inverse btn-custom waves-effect waves-light btn-xs"><i class="fa fa-pencil"></i></a>
															<?php
																}	
																if (in_array("per_pagos_eliminar", $permisos_usuario))
																{
															?>
																	<a href="javascript:void(0)" onclick="deleteItem('<?= $content ?>','<?= $id ?>', 'Id = <?= $id ?>')" class="btn btn-danger btn-custom waves-effect waves-light btn-xs"><i class="fa fa-remove"></i></a>
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
    if ((!in_array("per_pagos_crear", $permisos_usuario)) && (!in_array("per_pagos_editar", $permisos_usuario)) && (!in_array("per_pagos_eliminar", $permisos_usuario)))
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
