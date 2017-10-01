<?php
	include("includes/header.php");
	include 'libs/phpqrcode/qrlib.php';
	require_once("models/Doctors.php");
	require_once("models/DataDoctors.php");
	require_once("models/CalificationDoctors.php");
	require_once("models/GalleryDoctors.php");
	require_once("models/Users.php");
	require_once("models/UserDoctors.php");
	require_once("models/Plans.php");

	$plans = new Plans();

	$id = $_GET['id'];
	$doctors = new Doctors();
	$doctors->setDoctorId($id);
	$content = $doctors->GetDoctorContent();

	$plans->setPlanId($content["PlanId"]);
	$plan = $plans->GetPlanContent();
	$plan_caracteristicas = unserialize($plan["Characteristic"]);

	$data = new DataDoctors();
	$dataList = $data->GetDataforDoctor($id);

	$califications = new CalificationDoctors();
	$califications->setDoctorId($id);
	$numCalificationsList = $califications->numCalificationsForDoctor();
	$calificationsList = $califications->GetCalificationDoctorContent();

	$gallery = new GalleryDoctors();
	$gallery->setDoctorId($id);
	$gallery->setType('Image');
	$imageList = $gallery->GetGalleryDoctorContent();
	$imageUserList = $gallery->GetGalleryUserContent();
	$gallery->setType('Video');
	$videoList = $gallery->GetGalleryDoctorContent();
	$videoUserList = $gallery->GetGalleryUserContent();

	$users = new Users();
	$userDoctors = new UserDoctors();
	$userDoctors->setDoctorId($id);
	$listUserDoctors = $userDoctors->ListUserForDoctors();

	$file = 'files/qr/'.$_GET['id'].'.png';
	$data = 'http://www.ciguriaplasticacolombia.com/directorio-detalle?id='.$_GET['id'];

	// El tamaño de la imagen.
	$size = 6;
	// Capacidad de corrección de errores.
	$level = QR_ECLEVEL_H;
	QRcode::png($data, $file, $level, $size);

	require_once '../google-api/src/Google/autoload.php';

	$OAUTH2_CLIENT_ID = '411055274937-p4qa318es9r8smcdte190i7nmfflqdfc.apps.googleusercontent.com';
	$OAUTH2_CLIENT_SECRET = 'sDyrjrrqdcLhXzXBuOfZy0ye';

  	$client = new Google_Client();
    $client->setClientId($OAUTH2_CLIENT_ID);
    $client->setClientSecret($OAUTH2_CLIENT_SECRET);
    $client->setScopes('https://www.googleapis.com/auth/youtube');

    $redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], FILTER_SANITIZE_URL);

    $client->setRedirectUri($redirect);

    if (isset($_SESSION['token']))
    {
        $client->setAccessToken($_SESSION['token']);
    }

    if (isset($_GET['code']))
    {
        if (strval($_SESSION['state']) !== strval($_GET['state']))
        {
            var_dump($_SESSION['state']);
            var_dump($_GET['state']);
                die('El estado de la sesión no coincide.');
        }
        $client->authenticate($_GET['code']);
        $_SESSION['token'] = $client->getAccessToken();
        header('Location: ' . $redirect);
    }
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
							<?php
								if (in_array("per_pagos_crear", $permisos_usuario))
								{
							?>
									<li class="pull-right">
										<a href="javascript:void(0)" onclick="modalCall('plan','form','<?= $id ?>')" class="btn btn-default btn-md waves-effect waves-light m-b-30">
											<i class="md md-add"></i> Pagar Perfil
										</a>
									</li>
							<?php
								}
							?>
						</ol>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4">
						<div class="card-box">
							<div class="contact-card">

								<?php
									if (array_key_exists("plan_foto", $plan_caracteristicas))
									{
										if ($content["Logo"] == "")
										{
								?>
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
								<?php
										}
										else
										{
								?>
											<div class="slim profile-picture"
												data-service="server/async.php?id=<?= $id ?>"
												data-label="Cambiar logo"
												data-ratio="1:1"
												data-size="400, 400"
												data-edit="true"
												data-button-edit-label="Editar"
												data-button-remove-label="Quitar"
												data-button-upload-label="Subir"
												data-button-cancel-label="Cancelar"
												data-button-confirm-label="Confirmar">
												<img src="img/doctors/<?= $content["Logo"] ?>" alt="<?= $content["Name"] ?>">
												<input type="file" name="slim[]"/>
											</div>
								<?php
										}
									}
									else
									{
										if ($content["Logo"] == "")
										{
								?>
											<img src="../images/placeholder.jpg" alt="<?= $content["Name"] ?>">
								<?php
										}
										else
										{
								?>
											<img src="img/doctors/<?= $content["Logo"] ?>" alt="<?= $content["Name"] ?>">
								<?php
										}	
									}
								?>

								<div class="member-info">
									<h4 class="m-t-0 m-b-5 header-title"><b><?= $content["Name"] ?></b></h4>

									<?php
										if (array_key_exists("plan_datos", $plan_caracteristicas))
										{
											if ($dataList->rowCount() > 0)
											{
												while ($Data = $dataList->fetch(PDO::FETCH_ASSOC))
												{
													echo '<p><b>'.$Data['Name'].':</b> '.$Data['Description'].'</p>';
												}
												echo '<br>';
											}
										}
									?>

									<br>
									Enlace de calificación: <a href="http://www.cirugiaplasticacolombia.com/doctor/calificar/<?= base64_encode($id) ?>-<?= base64_encode($content["Code"]) ?>">http://www.cirugiaplasticacolombia.com/doctor/calificar/<?= base64_encode($id) ?>-<?= base64_encode($content["Code"]) ?></a>
										
									<div class="m-t-20">

										<?php
											if (!in_array("per_medico_info", $permisos_usuario))
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
											if (in_array("per_clientes_editar", $permisos_usuario))
											{
										?>
												<a href="javascript:void(0)" onclick="modalCall('medicos','client_form','<?php echo $id;?>')" class="btn btn-success waves-effect waves-light btn-sm">Cambiar cliente</a>
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
				                        <h4 class="modal-title"><strong>Código QR:</strong></h4>
				                    </div>
				                    <div class="modal-body text-center">
															<img src="files/qr/<?= $id.'.png' ?>" style="max-width:100%;">
				                    </div>
				                </div>
				            </div>
				        </div>

						<?php
							if (array_key_exists("plan_foto", $plan_caracteristicas))
							{
						?>
								<div class="card-box">
									<h4 class="m-t-0 m-b-20 header-title"><b>Descripción</b></h4>
									<p>
										<?= $content["Description"] ?>
									</p>

									<?php
										if (!in_array("per_medico_descripcion", $permisos_usuario))
										{
									?>
											<a href="#" class="btn btn-success waves-effect waves-light btn-sm" disabled>Editar</a>
									<?php
										}
										else
										{
									?>
											<a href="javascript:void(0)" onclick="modalCall('medicos','description','<?php echo $id;?>')" class="btn btn-success waves-effect waves-light btn-sm">Editar</a>
									<?php
										}
									?>
								</div>
						<?php
							}
						?>

						<div class="card-box fotos-galery">
							<h4 class="m-t-0 m-b-20 header-title"><b>Fotos / Videos</b></h4>
							<?php
								if($gallery->numGalleryForDoctor() == 0 && $gallery->numGalleryForDoctorUser() == 0){
									echo "No posee Fotos / Videos";
								}
								else{
									echo "<h4>Fotos</h4>";
									while($Gallery = $imageList->fetch(PDO::FETCH_ASSOC)){
											echo "<img src='img/doctors/galleries/".$Gallery['Location']."' style='margin: 15px; height: 100px; width: 100px'>";
											?>
											<a href="javascript:void(0)" onclick="deleteItem('gallery','<?= $Gallery['GalleryDoctorId'] ?>','<?= $Gallery['Location'] ?>')" class="btn btn-danger btn-custom waves-effect waves-light btn-xs"><i class="fa fa-remove"></i></a>
											<?php
									}

									while($GalleryUser = $imageUserList->fetch(PDO::FETCH_ASSOC)){
											echo "<img src='files/images/".$GalleryUser['Location']."' style='margin: 15px; height: 100px; width: 100px'>";
											?>
											<a href="javascript:void(0)" onclick="deleteItem('gallery','<?= $GalleryUser['GalleryDoctorId'] ?>','<?= $GalleryUser['Location'] ?>')" class="btn btn-danger btn-custom waves-effect waves-light btn-xs"><i class="fa fa-remove"></i></a>
											<?php
									}
									echo "<br><h4>Videos</h4>";
									while($GalleryVideos = $videoList->fetch(PDO::FETCH_ASSOC)){
											echo "<iframe width='100%' height='200' src='https://www.youtube.com/embed/".$GalleryVideos['Location']."' frameborder='0' allowfullscreen></iframe>";
											?>
											<a href="javascript:void(0)" onclick="deleteItem('gallery','<?= $GalleryVideos['GalleryDoctorId'] ?>','<?= $GalleryVideos['Location'] ?>')" class="btn btn-danger btn-custom waves-effect waves-light btn-xs"><i class="fa fa-remove"></i></a>
											<?php

									}

									while($GalleryUserVideos = $videoUserList->fetch(PDO::FETCH_ASSOC)){
											echo "<iframe width='100%' height='200' src='https://www.youtube.com/embed/".$GalleryUserVideos['Location']."' frameborder='0' allowfullscreen></iframe>";
											?>
											<a href="javascript:void(0)" onclick="deleteItem('gallery','<?= $GalleryUserVideos['GalleryDoctorId'] ?>','<?= $GalleryUserVideos['Location'] ?>')" class="btn btn-danger btn-custom waves-effect waves-light btn-xs"><i class="fa fa-remove"></i></a>
											<?php
									}
								}
							?>
							<br>
							<?php
								if (!in_array("per_medico_galeria", $permisos_usuario))
								{
							?>
									<a href="#" class="btn btn-success waves-effect waves-light btn-sm" disabled>Agregar Foto</a>
							<?php
								}
								else
								{
							?>
									<a href="javascript:void(0)" onclick="modalCall('gallery','images','<?= $id ?>')" class="btn btn-success waves-effect waves-light btn-sm">Agregar Foto</a>
							<?php
								}
							?>

							<?php
								if (!$client->getAccessToken())
								{
									$state = mt_rand();
									$client->setState($state);
									$_SESSION['state'] = $state;
									$authUrl = $client->createAuthUrl();

									if (in_array("per_medico_galeria", $permisos_usuario))
									{
										echo "<a href='".$authUrl."&id=".$id."' class='btn btn-success waves-effect waves-light btn-sm'>Autorizar para subir Videos</a>";
									}
								}
								else
								{
									if (!in_array("per_medico_galeria", $permisos_usuario))
									{
							?>
										<a href="#" class="btn btn-success waves-effect waves-light btn-sm" disabled>Agregar Video</a>
							<?php
									}
									else
									{
							?>
										<a href="javascript:void(0)" onclick="modalCall('gallery','videos','<?php echo $id;?>')" class="btn btn-primary waves-effect waves-light btn-sm">Agregar Video</a>
							<?php
									}
								}
							?>
						</div>
					</div>

					<div class="col-lg-8">
						<div class="search-result-box">

							<div class="card-box">
								<h4 class="m-t-0 m-b-20 header-title"><b>Calificaciones</b></h4>
								<div class="table-responsive">
									<table id="example" class="table" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>Calificación</th>
												<th>Comentario</th>
												<th>Fecha/Hora</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tbody>
											<?php
												if($numCalificationsList == 0)
													echo "<tr><td colspan='3'>No posee Calificaciones</td></tr>";
												elseif ($numCalificationsList > 0) {
			                    while($Calification = $calificationsList->fetch(PDO::FETCH_ASSOC)){
															switch ($Calification['CountStars']) {
					                      case 1:
					                        $stars = "<div class='stars-rate'>
					                          <i class='fa fa-star'></i>
					                          <i class='fa fa-star inactive'></i>
					                          <i class='fa fa-star inactive'></i>
					                          <i class='fa fa-star inactive'></i>
					                          <i class='fa fa-star inactive'></i>
					                        </div>";
					                        break;
					                      case 2:
					                        $stars = "<div class='stars-rate'>
					                          <i class='fa fa-star'></i>
					                          <i class='fa fa-star'></i>
					                          <i class='fa fa-star inactive'></i>
					                          <i class='fa fa-star inactive'></i>
					                          <i class='fa fa-star inactive'></i>
					                        </div>";
					                        break;
					                      case 3:
					                        $stars = "<div class='stars-rate'>
					                          <i class='fa fa-star'></i>
					                          <i class='fa fa-star'></i>
					                          <i class='fa fa-star'></i>
					                          <i class='fa fa-star inactive'></i>
					                          <i class='fa fa-star inactive'></i>
					                        </div>";
					                        break;
					                      case 4:
					                        $stars = "<div class='stars-rate'>
					                          <i class='fa fa-star'></i>
					                          <i class='fa fa-star'></i>
					                          <i class='fa fa-star'></i>
					                          <i class='fa fa-star'></i>
					                          <i class='fa fa-star inactive'></i>
					                        </div>";
					                        break;
					                      case 5:
					                        $stars = "<div class='stars-rate'>
					                          <i class='fa fa-star'></i>
					                          <i class='fa fa-star'></i>
					                          <i class='fa fa-star'></i>
					                          <i class='fa fa-star'></i>
					                          <i class='fa fa-star'></i>
					                        </div>";
					                        break;
					                      default:
					                        $stars = "<div class='stars-rate'>
					                          <i class='fa fa-star inactive'></i>
					                          <i class='fa fa-star inactive'></i>
					                          <i class='fa fa-star inactive'></i>
					                          <i class='fa fa-star inactive'></i>
					                          <i class='fa fa-star inactive'></i>
					                        </div>";
					                        break;
					                    }
			                      echo "<tr>
										<td>".$stars."</td>
										<td>".$Calification['Comment']."</td>
										<td>".$Calification['DateComment']."</td>
										";
										?>
										<td>
											<?php
												if (array_key_exists("plan_respuesta", $plan_caracteristicas))
												{
											?>
													<a href="javascript:void(0)" onclick="modalCall('contestCalification','form','<?= $Calification['CalificationDoctorId'] ?>')" class="btn btn-success waves-effect waves-light btn-sm">Responder</a>
											<?php
												}
											?>
										</td>
									<?php 
										echo "</tr>";

			                    }
												}
											?>
										</tbody>
									</table>
								</div>
							</div>

							<?php
								if (in_array("per_usuarios_editar", $permisos_usuario))
								{
							?>
									<div class="card-box">
										<h4 class="m-t-0 m-b-20 header-title"><b>Usuarios</b></h4>

										<div class="table-responsive">
											<table id="example1" class="table" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>Nombre</th>
														<th>Correo</th>
														<th>Teléfono</th>
														<th>Acciones</th>
													</tr>
												</thead>
												<tbody>
												<?php
													$users->setType('UserDoctor');
													$userList = $users->GetUsersForDoctor($id);

													while ($User = $listUserDoctors->fetch(PDO::FETCH_ASSOC))
													{
														$name = '<strong>Usuario No.'.$User['UserId'].'</strong> ('.$User['Name'].')';
													?>
													<tr>
														<td><?= $User['Name'] ?></td>
														<td><?= $User['Email'] ?></td>
														<td><?= $User['Phone'] ?></td>
														<td>
															<a href="javascript:void(0)" onclick="deleteItemType('usuarios','<?= $User['UserDoctorsId'] ?>','<?= $name ?>', 'deletePerfil')" class="btn btn-danger btn-custom waves-effect waves-light btn-xs"><i class="fa fa-remove"></i></a>
														</td>
															</tr>
													<?php
														}
													?>
												</tbody>
											</table>
										</div>

										<a href="javascript:void(0)" onclick="modalCall('usuarios','perfil_medico','<?= $id ?>')" class="btn btn-success waves-effect waves-light btn-sm">Agregar</a>
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
