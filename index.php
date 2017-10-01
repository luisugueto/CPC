<?php
	require_once("admin/models/Sections.php");
	$section = new Sections();
	$section->setSectionId(1);
	$contentSection = $section->GetSectionContent();

	include("includes/header.php");
	require_once("admin/models/Doctors.php");
	require_once("admin/models/Articles.php");
	require_once("admin/models/DataDoctors.php");
	require_once("admin/models/Plans.php");
	require_once("admin/models/ProceduresDoctor.php");
	require_once("admin/models/CalificationDoctors.php");
	require_once("admin/models/ValidationCalificationDoctors.php");
	require_once("admin/models/GalleryDoctors.php");
	require_once("admin/models/Categories.php");

	$uri = $_SERVER['REQUEST_URI']; // Get URI
	$uri_array = explode( "/", $uri ); 
	$last_uri = count($uri_array)-1; // Get last element in URI
	$uriParts = explode("_", $uri_array[$last_uri]); 
	
	$page = (count($uriParts) == 2) ? $uriParts[1] : 1;
	$doctorByPage = 6;

	$doctor = new Doctors();
	$doctorRedirect = new Doctors();
	$doctorList = $doctor->ListDoctors();

	///// Pagination Doctors
	
	$listDoctor = $doctor->ListDoctorsForClientwithPlanPagination($page, $doctorByPage);
	$totalDoctors = $doctor->GetTotalDoctors();

	$totall = $doctor->numDoctorswithPlan();
	$totallPages = ceil($totall / $doctorByPage);

	///// Fin Pagination Doctors

	$categories = new Categories();
	$categoriesList = $categories->ListCategories();

	$procedures = new ProceduresDoctor();

	$articlesByPage = 15;

	$tomorrowDay = date('d', time());
	$tomorrowMonth = date('m', time());
	$tomorrowYear = date('Y', time());

	$tomorrow = $tomorrowYear."-".$tomorrowMonth."-".$tomorrowDay;

	$articles = new Articles();
	$listArticles = $articles->GetAllArticles($page, $articlesByPage, $tomorrow);
	$totalArticles = $articles->GetTotalArticles($tomorrow);

	$total = $totalArticles->fetch(PDO::FETCH_ASSOC);
	$totalPages = ceil($total["Total"] / $articlesByPage);
	$total = $total["Total"];

	$data = new DataDoctors();

	$plan = new Plans();
	$planList = $plan->ListPlans();

	$califications = new CalificationDoctors();
	$validationCalification = new ValidationCalificationDoctors();
	$gallery = new GalleryDoctors();
	$galleryList = $gallery->ListGallery();

	if(isset($_GET['validationComment']))
	{
		$validationCommentParts = explode("-", $_GET['validationComment']);
		$doctorRedirect->setDoctorId($validationCommentParts[1]);
		$contentRedirect = $doctorRedirect->GetDoctorContent();
		$validationCalification->UpdateValidationCalificationDoctor($validationCommentParts[0]);
		$calificationDoctorId = $validationCalification->GetCalificationDoctorIdForCode($validationCommentParts[0]);

		$updateCalification = $califications->UpdateCalificationDoctor($calificationDoctorId);
		if(trim($updateCalification) == 'exito')
		{
			echo "<script>
					window.location.href='/doctor/".$validationCommentParts[1]."_".slugify($contentRedirect['Name'])."';
				</script>"; 
		}
		else
		{
			echo "<script>
					alert('El Código de validación para la calificación es Incorrecto o la calificación ya está validada.');
			</script>";
		}
	}
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
					<?php
						$count_doctors = 0;

						while ($Doctor = $listDoctor->fetch(PDO::FETCH_ASSOC))
						{
							$content = 'medicos';
							$id = $Doctor["DoctorId"];
							$logo = ($Doctor['Logo'] != '') ? 'admin/img/doctors/'.$Doctor['Logo'] : 'images/placeholder.jpg';

							if ($count_doctors == 0)
							{
								echo "<div class='col m6 s12'>";
							}
							elseif ($count_doctors > 0)
							{
								echo "<div class='col m6 s12'>";
							}
					?>
							<ul class="collection">
								<a class="collection-item avatar truncate cirujanos" href="doctor/<?= $id ?>_<?= slugify($Doctor['Name']) ?>">
									<div class="circle" style="background-image: url(<?= $logo ?>)"></div>
									<span class="title"><?= $Doctor['Name'] ?></span>
									<p style="color:#626262;">
										<?php
											if (strlen($Doctor['SubTitle']) > 50)
											{
												echo substr($Doctor['SubTitle'], 0, 50)."...";
											}
											else
											{
												echo $Doctor['SubTitle'];
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
							elseif ($count_doctors > 0)
							{
								$count_doctors = 0;
								echo "</div>";
							}
						}
					?>
				</div>
				
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
								<a id="action-block-qualify" class="waves-effect waves-light btn blue-principal" href="directorio" style="border-radius: 20px;">Calificar</a>
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

							<?php
								while ($article = $listArticles->fetch(PDO::FETCH_ASSOC))
								{
							?>
									<div class="item" onclick="window.location.href='noticia/<?= $article["ArticleId"] ?>_<?= $article["Slug"] ?>'" style="cursor:pointer;">
										<div class="card horizontal" style="min-height: 415px;">
											<div class="card-stacked">
												<div class="card-content">

													<img src="images/blog/<?= $article["Photo"] ?>">

													<br>

													<?php
														$d = date_parse($article["PublishDate"]);
														$monthNum = $d["month"];
														$months = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
														$monthName = $months[$monthNum - 1];
													?>

													<div class="date pull-left">
														<div class="day">
															<?= $d["day"] ?>
														</div>
														<div class="month">
															<?= $monthName ?>
														</div>
													</div>
													<h5 class="card-dr-title"><?= $article["Title"] ?></h5>
													<p class="card-dr-address"><?= $article["MetaDescription"] ?></p>
												</div>
											</div>
										</div>
									</div>
							<?php
								}
							?>

						</div>

					</div>
				</div>
				<!-- Fin listado Blog -->

				<!-- Paginador -->
				<div class="row">
					<div class="col s12 center-align">

						<ul class="pagination" id="customDots">
							<li class="waves-effect"><a href="javascript:void(0)" onclick="toPosition(0)">1</a></li>
							<li class="waves-effect"><a href="javascript:void(0)" onclick="toPosition(1)">2</a></li>
							<li class="waves-effect"><a href="javascript:void(0)" onclick="toPosition(2)">3</a></li>
							<li class="waves-effect"><a href="javascript:void(0)" onclick="toPosition(3)">4</a></li>
							<li class="waves-effect"><a href="javascript:void(0)" onclick="toPosition(4)">5</a></li>
							<li class="waves-effect"><a href="javascript:void(0)" onclick="toPosition(5)">6</a></li>
							<li class="waves-effect"><a href="javascript:void(0)" onclick="toPosition(6)">7</a></li>
							<li class="waves-effect"><a href="javascript:void(0)" onclick="toPosition(7)">8</a></li>
							<li class="waves-effect"><a href="javascript:void(0)" onclick="toPosition(8)">9</a></li>
							<li class="waves-effect"><a href="javascript:void(0)" onclick="toPosition(9)">10</a></li>
						</ul>

					</div>
				</div>
				<!-- Fin de paginador -->

			</div>
			<!-- fin columna izquierda -->

			<!-- side bar (columna derecha) -->
			<div class="col m3 s12 hide-on-small-only">
				<?php include("includes/sidebar_home.php"); ?>
			</div>
			<!-- fin side bar (columna derecha) -->

		</div>
	</div>
	<!-- Fin contenido -->

	<br>

	<?php include("includes/footer.php"); ?>