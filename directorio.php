<?php
	include("includes/header.php");
	require_once("admin/models/Doctors.php");
	require_once("admin/models/DataDoctors.php");
	require_once("admin/models/Plans.php");
	require_once("admin/models/ProceduresDoctor.php");
	require_once("admin/models/CalificationDoctors.php");

	$doctor = new Doctors();
	$doctorList = $doctor->ListDoctors();

	$data = new DataDoctors();

	$plan = new Plans();
	$planList = $plan->ListPlans();

	$califications = new CalificationDoctors();
?>

	<!-- Contenido -->
	<div class="container">
		<div class="row">

			<!-- columna izquierda -->
			<div class="col m9 s12">

				<section class="hide-on-small-only">

					<!-- Título -->
					<div class="title-divider">
						<h1>Directorio</h1>
					</div>
					<!-- Fin título -->

					<p>
						Cirugia Plastica Colombia es el portal de la estética y de la cirugia plastica en Colombia, el cual busca promover las buenas prácticas en la industria de la cirugia plastica y estetica en Colombia, proporcionando información veraz, oportuna y actualizada sobre la oferta de procedimientos y especialistas certificados, facilitando a los pacientes una elección responsable y segura de sus intervenciones medicas y esteticas.
					</p>

				</section>

				<!-- Listado doctores -->
				<div class="row">

					<div class="col m12">

						<?php
							while ($Doctor = $doctorList->fetch(PDO::FETCH_ASSOC))
							{
								$content = 'medicos';
								$id = $Doctor["DoctorId"];
								$name = '<strong>Médico No.'.$id.'</strong> ('.$Doctor['Name'].')';
								$dataList = $data->GetDataforDoctor($id);
						?>
						<ul class="collection">
							<a class="collection-item avatar truncate cirujanos" href="directorio-detalle.php?id=<?= $id ?>">
								<div class="circle" style="background-image: url('http://cirugiaplasticacolombia.com/wp-content/uploads/2015/09/Dra-Maria-Mercedes-Valencia-cirujana-plastica-cirugia-plastica-colombia-plastic-surgery-Mauro-Rebolledo-Photography-274x199.jpg')">
								</div>
										<span class="title">Dr. <?= $Doctor['Name'] ?></span>
											<p style="color:#b9b9b9;"><?= $Doctor['Description'] ?> (<?php
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
											?>)</p>

											<?php
											$califications->setDoctorId($id);
											$calificationsList = $califications->GetCalificationDoctorContent();
												if(count($calificationsList == 0))
													echo "<div class='stars-rate'>
														<i class='material-icons inactive left'>star</i>
														<i class='material-icons inactive left'>star</i>
														<i class='material-icons inactive left'>star</i>
														<i class='material-icons inactive left'>star</i>
														<i class='material-icons inactive left'>star</i>
														<span style='margin-left:10px; color: black'>0 Comentarios</span>
													</div>";
											?>
											<!-- <div class="stars-rate">
												<i class="material-icons left">star</i>
												<i class="material-icons left">star</i>
												<i class="material-icons left">star</i>
												<i class="material-icons inactive left">star</i>
												<i class="material-icons inactive left">star</i>
												<span style="margin-left:10px; color: black">203 Comentarios</span>
											</div> -->
										</a>
									</ul>

								<?php
									}
								?>

					</div>

				</div>
				<!-- Fin listado doctores -->

				<!-- Paginador -->
				<div class="row">
					<div class="col s12 center-align">

						<ul class="pagination">
							<li class="waves-effect"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
							<li class="waves-effect"><a href="#!">1</a></li>
							<li class="waves-effect"><a href="#!">2</a></li>
							<li class="waves-effect"><a href="#!">3</a></li>
							<li class="waves-effect"><a href="#!">4</a></li>
							<li class="waves-effect"><a href="#!">5</a></li>
							<li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
						</ul>

					</div>
				</div>
				<!-- Fin de paginador -->

			</div>
			<!-- fin columna izquierda -->

			<!-- side bar (columna derecha) -->
			<div class="col m3 s12 hide-on-small-only">

				<div class="side-bar-block">

					<!-- Video -->
					<div class="title-divider">
						<h1>Últimos Videos</h1>
					</div>
					<iframe width="100%" height="200" src="https://www.youtube.com/embed/q_mB-3x_PsQ?ecver=1" frameborder="0" allowfullscreen></iframe>
					<!-- fin de video -->

				</div>

				<div class="side-bar-block">

					<div class="title-divider">
						<h1>Blog</h1>
					</div>

					<div class="collection">

						<a href="#!" class="collection-item avatar truncate valigncenter">
							<img src="http://cirugiaplasticacolombia.com/wp-content/uploads/2017/05/Desmontando-los-10-mitos-m%C3%A1s-comunes-de-la-cirug%C3%ADa-pl%C3%A1stica-cirujano-plastico-cirujano-corporal-cirugia-plastica-colombia-plastic-surgery-surgeon-150x150.jpg" class="circle">
							<span class="truncate">Desmontando los 10 mitos más comunes de la cirugía plástica</span>
						</a>

						<a href="#!" class="collection-item avatar truncate valigncenter">
							<img src="http://cirugiaplasticacolombia.com/wp-content/uploads/2017/05/Medicina-est%C3%A9tica-Cuidado-con-los-retoques-que-te-puedan-deformar-cirujano-plastico-cirujano-corporal-cirugia-plastica-colombia-plastic-surgery-surgeon-150x150.jpeg" class="circle">
							<span class="truncate">Medicina estética: Cuidado con los retoques que te puedan deformar</span>
						</a>

						<a href="#!" class="collection-item avatar truncate valigncenter">
							<img src="http://cirugiaplasticacolombia.com/wp-content/uploads/2017/05/te-has-hecho-un-retoque-cirujano-plastico-cirujano-corporal-cirugia-plastica-colombia-plastic-surgery-surgeon-150x150.jpeg" class="circle">
							<span class="truncate">Cirugía plástica ¿Te has hecho un retoque?</span>
						</a>

						<a href="#!" class="collection-item avatar truncate valigncenter">
							<img src="http://cirugiaplasticacolombia.com/wp-content/uploads/2017/05/pensando-en-una-cirug%C3%ADa-pl%C3%A1stica-qu%C3%A9-considerar-antes-del-retoque-cirujano-plastico-cirujano-corporal-cirugia-plastica-colombia-plastic-surgery-surgeon-150x150.jpg" class="circle">
							<span class="truncate">¿Pensando en una cirugía plástica? Qué considerar antes del “retoque”</span>
						</a>

						<a href="#!" class="collection-item avatar truncate valigncenter">
							<img src="http://cirugiaplasticacolombia.com/wp-content/uploads/2017/05/rinoplast%C3%ADa-en-hombres-cirujano-plastico-cirujano-corporal-cirugia-plastica-colombia-plastic-surgery-surgeon-150x150.jpeg" class="circle">
							<span class="truncate">Rinoplastia en Hombres</span>
						</a>
					</div>
				</div>

			</div>
			<!-- fin side bar (columna derecha) -->

		</div>
	</div>
	<!-- Fin contenido -->

	<br>

	<?php include("includes/footer.php"); ?>
