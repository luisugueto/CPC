<?php
	include("includes/header.php");
	require_once("models/Doctors.php");
	require_once("models/DataDoctors.php");
	require_once("models/CalificationDoctors.php");
	require_once("models/GalleryDoctors.php");

	$id = $_GET['id'];
	$doctors = new Doctors();
	$doctors->setDoctorId($id);
	$content = $doctors->GetDoctorContent();

	$data = new DataDoctors();
	$dataList = $data->GetDataforDoctor($id);

	$califications = new CalificationDoctors();
	$califications->setDoctorId($id);
	$calificationsList = $califications->GetCalificationDoctorContent();

	$gallery = new GalleryDoctors();
	$gallery->setDoctorId($id);
	$galleryList = $gallery->GetGalleryContent();
?>
		<div class="wrapper">
			<div class="container">

				<div class="row">
					<div class="col-sm-12">
						<h4 class="page-title">Médicos</h4>
						<ol class="breadcrumb">
							<li>
								<a href="index.php">Inicio</a>
							</li>
							<li class="active">
								Dr.  <?= $content["Name"] ?>
							</li>
						</ol>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-4">
						<div class="card-box">
							<div class="contact-card">

								<div class="slim profile-picture"
									data-service="server/async.php?id=<?= $id ?>"
									data-label="Subir logo"
									data-ratio="1:1"
									data-size="400, 400"
									data-edit="true"
									data-button-edit-label="Editar"
									data-button-remove-label="Quitar"
									data-button-upload-label="Subir"
									data-button-cancel-label="Cancelar"
									data-button-confirm-label="Confirmar">
									<input type="file" name="slim[]"/>
								</div>

								<div class="member-info">
									<h4 class="m-t-0 m-b-5 header-title"><b>Dr  <?= $content["Name"] ?></b></h4>
									<p class="text-muted">
										<?php
											$i = 0;
											while ($Data = $dataList->fetch(PDO::FETCH_ASSOC))
											{
												if($Data['Name'] == 'Ciudad')
												{
													$ciudad = $Data['Description'];
												}
												elseif($Data['Name'] == 'País')
												{
													$pais = $Data['Description'];
												}

												if(isset($ciudad) || isset($pais))
												{
													if(isset($ciudad) && isset($pais))
													{
														echo $ciudad.', '.$pais;
													}
													elseif(isset($ciudad))
														if($i>0)
															echo ', '.$ciudad;
														else
															echo $ciudad;
													else echo $pais.',';
												}
												$i++;
											}
										?>
										</p>
									<div class="m-t-20">

										<?php
											if (!in_array("per_restaurante_info", $permisos_usuario))
											{
										?>
												<a href="#" class="btn btn-success waves-effect waves-light btn-sm" disabled>Editar</a>
										<?php
											}
											else
											{
										?>
												<a href="javascript:void(0)" onclick="modalCall('medicos','edit','<?php echo $id;?>')" class="btn btn-success waves-effect waves-light btn-sm">Editar</a>
										<?php
											}
										?>

										<?php
											if (in_array("per_clientes", $permisos_usuario))
											{
										?>
												<a href="javascript:void(0)" onclick="modalCall('restaurante','client_form','<?php echo $id;?>')" class="btn btn-success waves-effect waves-light btn-sm">Cambiar cliente</a>
										<?php
											}
										?>

										<a href="javascript:void(0)" data-toggle="modal" data-target="#qrModal" class="btn btn-info waves-effect waves-light btn-sm">Ver código QR</a>
									</div>
								</div>
							</div>
						</div>

						<!-- MODAL QR -->
						<div class="modal fade none-border" id="qrModal">
				            <div class="modal-dialog">
				                <div class="modal-content">
				                    <div class="modal-header">
				                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				                        <h4 class="modal-title"><strong>Código QR: <?= $content["Name"] ?></strong></h4>
				                    </div>
				                    <div class="modal-body text-center">
				                    	<img src="" style="max-width:100%;">
				                    </div>
				                </div>
				            </div>
				        </div>

						<div class="card-box">
							<h4 class="m-t-0 m-b-20 header-title"><b>Descripción</b></h4>
							<p>
								 <?= $content["Description"] ?>
							</p>

							<?php
								if (!in_array("per_restaurante_info", $permisos_usuario))
								{
							?>
									<a href="#" class="btn btn-success waves-effect waves-light btn-sm" disabled>Editar</a>
							<?php
								}
								else
								{
							?>
									<a href="javascript:void(0)" onclick="modalCall('restaurante','form_descripcion','<?php echo $id;?>')" class="btn btn-success waves-effect waves-light btn-sm">Editar</a>
							<?php
								}
							?>
						</div>

						<div class="card-box fotos-galery">
							<h4 class="m-t-0 m-b-20 header-title"><b>Fotos / Videos</b></h4>
							<?php
								if(count($galleryList == 0))
									echo "No posee Fotos / Videos";
							?>
						</div>

						<div class="card-box">
							<h4 class="m-t-0 m-b-20 header-title"><b>Mapa</b></h4>
							<div id="somecomponent" style="width: 100%; height: 300px; margin-bottom:20px;"></div>

							<?php
								if (in_array("per_restaurante_mapa", $permisos_usuario))
								{
							?>
									<form id="pageForm" data-parsley-validate novalidate>
										<input type="hidden" name="Latitude" id="txtLatitude" value="<?= $content['Latitude'] ?>" parsley-trigger="change" required>
										<input type="hidden" name="Longitude" id="txtLongitude" value="<?= $content['Longitude'] ?>" parsley-trigger="change" required>
										<input type="hidden" name="hdGeneralAction" value="edit_map">
										<input type="hidden" name="Doctor" value="<?= $content['DoctorId'] ?>">
										<input type="hidden" name="action" value="submit">
									</form>
									<button id="submitButton" class="btn btn-default waves-effect waves-light" disabled="disabled" onclick="submitPageForm('restaurante');"> <i class="fa fa-check m-r-5"></i> <span>ok</span> </button>
							<?php
								}
								else
								{
							?>
									<button class="btn btn-default waves-effect waves-light" disabled="disabled"><i class="fa fa-check m-r-5"></i> <span>ok</span> </button>
							<?php
								}
							?>
						</div>
					</div>

					<div class="col-lg-8">
						<div class="search-result-box">

							<div class="card-box">
								<h4 class="m-t-0 m-b-20 header-title"><b>Calificaciones</b></h4>
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th>Calificación</th>
												<th>Comentario</th>
												<th>Fecha/Hora</th>
											</tr>
										</thead>
										<tbody>
											<?php
												if(count($calificationsList == 0))
													echo "<tr><td colspan='3'>No posee Calificaciones</td></tr>";
											?>
											<!-- <tr id="1">
												<td>
													<i class="fa fa-star m-r-5"></i>
													<i class="fa fa-star m-r-5"></i>
													<i class="fa fa-star m-r-5"></i>
													<i class="fa fa-star m-r-5"></i>
													<i class="fa fa-star-o m-r-5"></i>
												</td>

												<td>
													Buen médico
												</td>
												<td>
													14/05/2017
												</td>
											</tr> -->
										</tbody>
									</table>
								</div>
							</div>

							<?php
								if (!in_array("per_usuarios", $permisos_usuario))
								{
							?>
									<div class="card-box">
										<h4 class="m-t-0 m-b-20 header-title"><b>Usuarios</b></h4>

										<div class="table-responsive">
											<table class="table">
												<thead>
													<tr>
														<th>Nombre</th>
														<th>Email</th>
														<th>Teléfono</th>
														<th>Acciones</th>
													</tr>
												</thead>
												<tbody>
													<!-- <tr id="1">
														<td>
															Jose Perez
														</td>

														<td>
															correo@correo.com
														</td>

														<td>
															02123334455
														</td>

														<td>
															<a href="javascript:void(0)" onclick="deleteItem('','','')" class="btn btn-danger btn-custom waves-effect waves-light btn-xs"><i class="fa fa-remove"></i></a>
														</td>
													</tr> -->
												</tbody>
											</table>
										</div>

										<a href="javascript:void(0)" onclick="modalCall('restaurante','users_form','<?php echo $_GET["id"];?>')" class="btn btn-success waves-effect waves-light btn-sm">Agregar</a>
									</div>
							<?php
								}
							?>

						</div>
					</div>
				</div>

<?php
	include("includes/footer.php")
?>

	<script type="text/javascript" src='http://maps.google.com/maps/api/js?key=AIzaSyCAS7zgxAVNOoB9GJ6GHt586s-aOBs2Nno&libraries=places'></script>
	<script src="js/locationpicker.jquery.js"></script>
	<script type="text/javascript">
		$(document).on("click", ".addSchedule", function () {
			var dayId = $(this).data('day');
			localStorage.setItem("daySelectedSchedule", dayId);
		});
	</script>
	<script>

		$('#somecomponent').locationpicker({
			location: {
				latitude: -16.1704283,
				longitude: -67.1014834
			},
			zoom: 2,
			radius: 100,
			inputBinding: {
				latitudeInput: $("#txtLatitude"),
				longitudeInput: $("#txtLongitude")
			},
			markerIcon: "img/marker.png",
			onchanged: function (currentLocation, radius, isMarkerDropped) {
				if (currentLocation.latitude != -16.1704283)
				{
					$("#submitButton").addClass('btn-danger');
					$("#submitButton").html('<i class="fa fa-save m-r-5"></i> <span>Guardar</span>');
					$("#submitButton").attr("disabled", false);
				}
			},
			oninitialized: function (component) {
				$("#submitButton").removeClass('btn-danger');
				$("#submitButton").html('<i class="fa fa-check m-r-5"></i> <span>Ok</span>');
				$("#submitButton").attr("disabled", "disabled");
			}
		});
	</script>
