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

				<!-- Título -->
				<div class="title-divider" id="directory-title">
					<h1>Directorio</h1>
				</div>
				<!-- Fin título -->

				<!-- Listado doctores -->
				<div class="row">

					<div class="col m6 s12">

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





						<!-- <ul class="collection">
							<a class="collection-item avatar truncate cirujanos">
								<div class="circle" style="background-image: url('http://cirugiaplasticacolombia.com/wp-content/uploads/2015/09/Dra-Maria-Mercedes-Valencia-cirujana-plastica-cirugia-plastica-colombia-plastic-surgery-Mauro-Rebolledo-Photography-274x199.jpg')">
								</div>
								<span class="title">Dr. John Garcia</span>
								<p style="color:#b9b9b9;">Cirujano plástico (Cali, Colombia)</p>
								<div class="stars-rate">
									<i class="material-icons left">star</i>
									<i class="material-icons left">star</i>
									<i class="material-icons left">star</i>
									<i class="material-icons inactive left">star</i>
									<i class="material-icons inactive left">star</i>
									<span style="margin-left:10px; color: black">203 Comentarios</span>
								</div>
							</a>
						</ul>

						<ul class="collection">
							<a class="collection-item avatar truncate cirujanos">
								<div class="circle" style="background-image: url('http://cirugiaplasticacolombia.com/wp-content/uploads/2015/09/Dra-Maria-Mercedes-Valencia-cirujana-plastica-cirugia-plastica-colombia-plastic-surgery-Mauro-Rebolledo-Photography-274x199.jpg')">
								</div>
								<span class="title">Dr. John Garcia</span>
								<p style="color:#b9b9b9;">Cirujano plástico (Cali, Colombia)</p>
								<div class="stars-rate">
									<i class="material-icons left">star</i>
									<i class="material-icons left">star</i>
									<i class="material-icons left">star</i>
									<i class="material-icons inactive left">star</i>
									<i class="material-icons inactive left">star</i>
									<span style="margin-left:10px; color: black">203 Comentarios</span>
								</div>
							</a>
						</ul>

					</div>

					<div class="col m6 s12">

						<ul class="collection">
							<a class="collection-item avatar truncate cirujanos">
								<div class="circle" style="background-image: url('http://cirugiaplasticacolombia.com/wp-content/uploads/2015/09/Dra-Maria-Mercedes-Valencia-cirujana-plastica-cirugia-plastica-colombia-plastic-surgery-Mauro-Rebolledo-Photography-274x199.jpg')">
								</div>
								<span class="title">Dr. John Garcia</span>
								<p style="color:#b9b9b9;">Cirujano plástico (Cali, Colombia)</p>
								<div class="stars-rate">
									<i class="material-icons left">star</i>
									<i class="material-icons left">star</i>
									<i class="material-icons left">star</i>
									<i class="material-icons inactive left">star</i>
									<i class="material-icons inactive left">star</i>
									<span style="margin-left:10px; color: black">203 Comentarios</span>
								</div>
							</a>
						</ul>

						<ul class="collection">
							<a class="collection-item avatar truncate cirujanos">
								<div class="circle" style="background-image: url('http://cirugiaplasticacolombia.com/wp-content/uploads/2015/09/Dra-Maria-Mercedes-Valencia-cirujana-plastica-cirugia-plastica-colombia-plastic-surgery-Mauro-Rebolledo-Photography-274x199.jpg')">
								</div>
								<span class="title">Dr. John Garcia</span>
								<p style="color:#b9b9b9;">Cirujano plástico (Cali, Colombia)</p>
								<div class="stars-rate">
									<i class="material-icons left">star</i>
									<i class="material-icons left">star</i>
									<i class="material-icons left">star</i>
									<i class="material-icons inactive left">star</i>
									<i class="material-icons inactive left">star</i>
									<span style="margin-left:10px; color: black">203 Comentarios</span>
								</div>
							</a>
						</ul>

						<ul class="collection">
							<a class="collection-item avatar truncate cirujanos">
								<div class="circle" style="background-image: url('http://cirugiaplasticacolombia.com/wp-content/uploads/2015/09/Dra-Maria-Mercedes-Valencia-cirujana-plastica-cirugia-plastica-colombia-plastic-surgery-Mauro-Rebolledo-Photography-274x199.jpg')">
								</div>
								<span class="title">Dr. John Garcia</span>
								<p style="color:#b9b9b9;">Cirujano plástico (Cali, Colombia)</p>
								<div class="stars-rate">
									<i class="material-icons left">star</i>
									<i class="material-icons left">star</i>
									<i class="material-icons left">star</i>
									<i class="material-icons inactive left">star</i>
									<i class="material-icons inactive left">star</i>
									<span style="margin-left:10px; color: black">203 Comentarios</span>
								</div>
							</a>
						</ul> -->

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

				<!-- Bloque de acción -->
				<div class="row">
					<div class="col s12">
						<div class="card blue-secondary">
							<div class="card-content white-text center-align">
								<span class="card-title">Califica a tu cirujano</span>
								<p>
									Comparte tus casos clínicos con otros pacientes cómo tu.
								</p>
								<br>
								<a class="waves-effect waves-light btn blue-principal" style="border-radius: 20px;">Calificar</a>
							</div>
						</div>
					</div>
				</div>
				<!-- Fin de bloque de acción -->

				<!-- Título -->
				<div class="title-divider">
					<h1>Blog</h1>
				</div>
				<!-- Fin título -->

				<!-- Carousel Blog -->
				<div class="row">
					<div class="col s12">

						<div class="owl-carousel owl-theme">

							<div class="item">
								<div class="card horizontal">
									<div class="card-stacked">
										<div class="card-content">
											<img src="https://static.pexels.com/photos/42273/doctor-medical-medicine-health-42273.jpeg">
											<br>
											<div class="date pull-left">
												<div class="day">
													12
												</div>
												<div class="month">
													Mayo
												</div>
											</div>
											<h5 class="card-dr-title">La grasa vuelve a acumularse después de la liposucción</h5>
											<p class="card-dr-address">Después de la liposucción la grasa puede volver a acumularse un año después, así lo revela un equipo de la Facultad de Medicina de la Universidad de Colorado en Estados Unidos, comentando que la grasa...</p>
										</div>
									</div>
								</div>
							</div>

							<div class="item">
								<div class="card horizontal">
									<div class="card-stacked">
										<div class="card-content">
											<img src="https://static.pexels.com/photos/42273/doctor-medical-medicine-health-42273.jpeg">
											<br>
											<div class="date pull-left">
												<div class="day">
													12
												</div>
												<div class="month">
													Mayo
												</div>
											</div>
											<h5 class="card-dr-title">La grasa vuelve a acumularse después de la liposucción</h5>
											<p class="card-dr-address">Después de la liposucción la grasa puede volver a acumularse un año después, así lo revela un equipo de la Facultad de Medicina de la Universidad de Colorado en Estados Unidos, comentando que la grasa...</p>
										</div>
									</div>
								</div>
							</div>

						</div>

					</div>
				</div>
				<!-- Fin listado Blog -->

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

				<!--<div class="side-bar-block">

					Título
					<div class="title-divider">
						<h1>Directorio Médico</h1>
					</div>
					Fin título

					directorio médico
					<div class="collection">

						<a href="#!" class="collection-item avatar truncate valigncenter">
							<img src="http://cirugiaplasticacolombia.com/wp-content/uploads/2017/02/VIP-Esthetic-Recovery-House-Cali-Colombia-Casa-De-Recuperacion-2-150x150.png" class="circle">
							<span class="truncate">VIP Esthetic Recovery House</span>
						</a>

						<a href="#!" class="collection-item avatar truncate valigncenter">
							<img src="http://cirugiaplasticacolombia.com/wp-content/uploads/2015/09/dra-maria-mercedes-valencia-cirugia-plastica-cali-banner-300x300-150x150.jpg" class="circle">
							<span class="truncate">Dra. María Mercedes Valencia</span>
						</a>

						<a href="#!" class="collection-item avatar truncate valigncenter">
							<img src="http://cirugiaplasticacolombia.com/wp-content/uploads/2015/09/cirujano-plastico-colombia-150x150.jpg" class="circle">
							<span class="truncate">Herley Aguirre</span>
						</a>

						<a href="#!" class="collection-item avatar truncate valigncenter">
							<img src="http://cirugiaplasticacolombia.com/wp-content/uploads/2015/09/alejandro-afanador-bogota-colombia-150x150.jpg" class="circle">
							<span class="truncate">Alejandro Afanador</span>
						</a>

						<a href="#!" class="collection-item avatar truncate valigncenter">
							<img src="http://cirugiaplasticacolombia.com/wp-content/uploads/2015/09/Glenia-Valera-150x150.jpg" class="circle">
							<span class="truncate">Glenia Del Carmen Valera Zapata</span>
						</a>
					</div>
					fin directorio médico

				</div>-->

				<div class="side-bar-block">

					<!-- Video -->
					<div class="title-divider">
						<h1>Últimos Videos</h1>
					</div>
					<iframe width="100%" height="200" src="https://www.youtube.com/embed/q_mB-3x_PsQ?ecver=1" frameborder="0" allowfullscreen></iframe>
					<!-- fin de video -->

				</div>

				<div class="side-bar-block">

					<!-- Instagram -->
					<div class="title-divider">
						<h1>Instagram</h1>
					</div>
					<!-- fin de Instagram -->

					<img src="https://static.pexels.com/photos/42273/doctor-medical-medicine-health-42273.jpeg" width="100%">
					<br>
					<img src="https://static.pexels.com/photos/42273/doctor-medical-medicine-health-42273.jpeg" width="100%">
					<br>
					<img src="https://static.pexels.com/photos/42273/doctor-medical-medicine-health-42273.jpeg" width="100%">

				</div>

				<!--<div class="side-bar-block">
					Blog
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
					fin blog
				</div>-->

			</div>
			<!-- fin side bar (columna derecha) -->

		</div>
	</div>
	<!-- Fin contenido -->

	<br>

	<?php include("includes/footer.php"); ?>
