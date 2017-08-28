<?php
	include("includes/header.php");

	require_once("models/Doctors.php");
	require_once("models/DataDoctors.php");
	require_once("models/Plans.php");
	require_once("models/ProceduresDoctor.php");

	$doctor = new Doctors();
	$doctorList = $doctor->ListDoctors();

	$plan = new Plans();

	$args = array();
	if(isset($_GET['id']) && $_GET['id'] != "")
	{
		$args['DoctorId'] = $_GET['id'];
	}
?>
		<div class="wrapper">
			<div class="container">

				<?php
					if (in_array("per_medicos_crear", $permisos_usuario) || in_array("per_medicos_editar", $permisos_usuario) || in_array("per_medicos_eliminar", $permisos_usuario) || in_array("per_medico_info", $permisos_usuario) || in_array("per_medico_descripcion", $permisos_usuario) || in_array("per_medico_galeria", $permisos_usuario) || in_array("per_medico_calificaciones", $permisos_usuario))
					{
				?>

						<div class="row">
							<div class="col-sm-12">
								<div class="btn-group pull-right m-t-15">
									<?php
										if (in_array("per_medicos_crear", $permisos_usuario))
										{
									?>
											<a href="javascript:void(0)" onclick="modalCall('medicos','form','0')" class="btn btn-default btn-md waves-effect waves-light m-b-30"><i class="md md-add"></i> Agregar</a>
									<?php
										}
									?>
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
									<table class="tablesaw table m-b-0" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch id="example">
										<thead>
											<tr>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="persist">Id</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Nombre</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">SubTítulo</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Descripción</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Plan</th>
												<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Acciones</th>
											</tr>
										</thead>
										<tbody>
											<?php
												while ($Doctor = $doctorList->fetch(PDO::FETCH_ASSOC))
												{
													$content = 'medicos';
													$id = $Doctor["DoctorId"];
													$name = '<strong>Médico No.'.$id.'</strong> ('.$Doctor['Name'].')';
											?>
													<tr id="<?= $id ?>">
														<td><?= $id ?></td>
														<td><?= $Doctor['Name'] ?></td>
														<td><?= $Doctor['SubTitle'] ?></td>
														<td><?= $Doctor['Description'] ?></td>
														<td><?= $plan->GetPlanName($Doctor['PlanId']) ?></td>
														<td>
															<?php
																if (in_array("per_medico_info", $permisos_usuario) || in_array("per_medico_descripcion", $permisos_usuario) || in_array("per_medico_galeria", $permisos_usuario) || in_array("per_medico_calificaciones", $permisos_usuario))
																{
															?>
																	<a href="perfil_medico.php?id=<?= $Doctor['DoctorId']?>"class="btn btn-primary btn-custom waves-effect waves-light btn-xs"><i class="fa fa-eye"></i></a>
															<?php
																}	
																if (in_array("per_medicos_editar", $permisos_usuario))
																{
															?>
																	<a href="javascript:void(0)" onclick="modalCall('<?= $content ?>','edit','<?= $id;?>')" class="btn btn-inverse btn-custom waves-effect waves-light btn-xs"><i class="fa fa-pencil"></i></a>
															<?php
																}	
																if (in_array("per_medicos_eliminar", $permisos_usuario))
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
	if ((!in_array("per_medicos_crear", $permisos_usuario)) && (!in_array("per_medicos_editar", $permisos_usuario)) && (!in_array("per_medicos_eliminar", $permisos_usuario)) && (!in_array("per_medico_info", $permisos_usuario)) && (!in_array("per_medico_descripcion", $permisos_usuario)) && (!in_array("per_medico_galeria", $permisos_usuario)) && (!in_array("per_medico_calificaciones", $permisos_usuario)))
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
