<?php
	require_once("admin/models/Sections.php");
	$section = new Sections();
	$section->setSectionId(3);
	$contentSection = $section->GetSectionContent();
	include("includes/header.php");
	require_once("admin/models/Doctors.php");
	require_once("admin/models/DataDoctors.php");
	require_once("admin/models/Plans.php");
	require_once("admin/models/ProceduresDoctor.php");
	require_once("admin/models/CalificationDoctors.php");
	require_once("admin/models/Categories.php");

	$doctor = new Doctors();
	$doctorList = $doctor->ListDoctors();

	$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
	$doctorByPage = 5;

	///// Pagination Doctors
	
	$listDoctor = $doctor->ListDoctorsForClientwithPlanPagination($page, $doctorByPage);
	$totalDoctors = $doctor->GetTotalDoctors();

	$totall = $doctor->numDoctorswithPlan();
	$totallPages = ceil($totall / $doctorByPage);

	///// Fin Pagination Doctors

	$categories = new Categories();
	$categoriesList = $categories->ListCategories();

	$data = new DataDoctors();

	$plan = new Plans();
	$planList = $plan->ListPlans();

	$califications = new CalificationDoctors();

	$procedures = new ProceduresDoctor();
	$doctorss = $doctor->ListDoctorsName();
	$arrayDoctors = array();

	while($Doctor = $doctorss->fetch(PDO::FETCH_ASSOC)){
		$arrayDoctors[$Doctor['DoctorName']." - ".$Doctor['SubTitle']. " [Doctor]"] = null;
	}
	$jsonDoctors = json_encode($arrayDoctors);

	$proceduress = $procedures->ListProceduresName();
	$arrayProcedures = array();

	while($Procedures = $categoriesList->fetch(PDO::FETCH_ASSOC)){
		$arrayProcedures[$Procedures['Name']." - ".$Procedures['CategoryId']." - [Procedimiento]"] = null;
	}
	$jsonProcedures = json_encode($arrayProcedures);
	$arrayMerge = array_merge($arrayDoctors, $arrayProcedures);
?>

	<!-- Contenido -->
	<div class="container">
		<div class="row">

			<!-- columna izquierda -->
			<div class="col m9 s12">

				<section>

					<!-- Título -->
					<div class="title-divider">
						<h1>Especialistas</h1>
					</div>
					<!-- Fin título -->

					<p>
						Busca siempre al especialista idóneo para la cirugía o tratamiento de tu interes. Te invitamos a encontrarlo a continuación y a disfrutar de esta experiencia:
					</p>

				</section>

				<!-- Listado doctores -->
				<?php
					$count_doctors = 0;

					while ($Doctor = $listDoctor->fetch(PDO::FETCH_ASSOC))
					{
						$content = 'medicos';
						$id = $Doctor["DoctorId"];
						$name = '<strong>Médico No.'.$id.'</strong> ('.$Doctor['Name'].')';
						$dataList = $data->GetDataforDoctor($id);
						$logo = ($Doctor['Logo'] != '') ? 'admin/img/doctors/'.$Doctor['Logo'] : 'images/placeholder.jpg';

						if ($count_doctors == 0)
						{
							echo "<div class='row'>";
							echo "<div class='col m6 s12'>";
						}
						elseif ($count_doctors == 1)
						{
							echo "<div class='col m6 s12'>";
						}
				?>
						<ul class="collection">
							<a class="collection-item avatar truncate cirujanos" href="doctor/<?= $id ?>_<?= slugify($Doctor['Name']) ?>">
								<div class="circle" style="background-image: url(<?= $logo ?>)"></div>
								<span class="title">Dr. <?= $Doctor['Name'] ?></span>
								<p style="color:#626262;">
									<?php
										if (strlen($Doctor['Description']) > 50)
										{
											echo substr($Doctor['Description'], 0, 50)."...";
										}
										else
										{
											echo $Doctor['Description'];
										}
									?>
								</p>

				<?php
								$califications->setDoctorId($id);
								$calificationsList = $califications->GetCalificationDoctorContent();

								if($califications->numCalificationsForDoctor() > 0)
								{
									$countStars = 0;
									$i = 0;

									while($Calification = $calificationsList->fetch(PDO::FETCH_ASSOC))
									{
										$countStars+=$Calification['CountStars'];
										$i++;
									}

									$totalStars = intval($countStars/$i);
									$emptyStars = 5 - $totalStars;

				?>
									<div class='stars-rate'>
				<?php
										for ($x = 0; $x < $totalStars; $x++)
										{
											echo "<i class='material-icons left'>star</i>";
										}
										for ($x = 0; $x < $emptyStars; $x++)
										{
											echo "<i class='material-icons inactive left'>star</i>";
										}
										if ($i == 1)
										{
											$comment = "Reseña";
										}
										else
										{
											$comment = "Reseñas";
										}
				?>
										<span style='margin-left:10px; color: black'><?= $i ?> <?= $comment ?></span>
									</div>
				<?php
								}
								else
								{
									echo "<div class='stars-rate'><i class='material-icons inactive left'>star</i><i class='material-icons inactive left'>star</i><i class='material-icons inactive left'>star</i><i class='material-icons inactive left'>star</i><i class='material-icons inactive left'>star</i><span style='margin-left:10px; color: black'>0 Reseñas</span></div>";
								}
				?>
							</a>
						</ul>
				<?php
						if ($count_doctors == 0)
						{
							echo "</div>";
							$count_doctors++;
						}
						elseif ($count_doctors == 1)
						{
							$count_doctors = 0;
							echo "</div>";
							echo "</div>";
						}
					}
				?>
				<!-- Fin listado doctores -->

				<?php
					if ($totallPages > 1)
					{
				?>
						<!-- Paginador -->
						<div class="row">
							<div class="col s12 center-align">

								<ul class="pagination">
									<?php
										if($page > 1)
										{
									?>
											<li class="waves-effect"><a href="inicio_<?=$page-1?>"><i class="material-icons">chevron_left</i></a></li>
									<?php 
										}
										for ($i = 0; $i < $totallPages; $i++) 
										{
											if($page == $i+1)
											{
									?>
												<li class="waves-effect active"><a href="inicio_<?=$i+1?>"><?= $i+1 ?></a></li>
									<?php 
											}	
											else
											{
									?>
												<li class="waves-effect"><a href="inicio_<?=$i+1?>"><?= $i+1 ?></a></li>
									<?php
											}
										}
										if($page < ($totallPages))
										{
									?>
											<li class="waves-effect"><a href="inicio_<?=$page+1 ?>"><i class="material-icons">chevron_right</i></a></li>
									<?php
										}
									?>
								</ul>

							</div>
						</div>
						<!-- Fin de paginador -->
				<?php
					}
				?>

			</div>
			<!-- fin columna izquierda -->

			<!-- side bar (columna derecha) -->
			<div class="col m3 s12 hide-on-small-only">

				<?php include("includes/sidebar.php"); ?>

			</div>
			<!-- fin side bar (columna derecha) -->

		</div>
	</div>
	<!-- Fin contenido -->

	<br>

	<?php include("includes/footer.php"); ?>
