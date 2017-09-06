<?php
	require_once("admin/models/Sections.php");
	$section = new Sections();
	$section->setSectionId(2);
	$contentSection = $section->GetSectionContent();
	include("includes/header.php");
	require_once("admin/models/Categories.php");
	require_once("admin/models/Doctors.php");
	require_once("admin/models/ProceduresDoctor.php");

	$categories = new Categories();
	$categoriesList = $categories->ListCategories();
	$categoriesListt = $categories->ListCategories();

	$doctor = new Doctors();
	$procedures = new ProceduresDoctor();

	$doctorss = $doctor->ListDoctorsName();
	$arrayDoctors = array();

	while($Doctor = $doctorss->fetch(PDO::FETCH_ASSOC)){
		$arrayDoctors[$Doctor['DoctorName']." -".$Doctor['SubTitle']. " - [Doctor] - ".$Doctor['DoctorId'].""] = null;
	}
	$jsonDoctors = json_encode($arrayDoctors);

	$proceduress = $procedures->ListProceduresName();
	$arrayProcedures = array();

	while($Procedures = $categoriesListt->fetch(PDO::FETCH_ASSOC)){
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
						<h1>Procedimientos</h1>
					</div>
					<!-- Fin título -->

				</section>

				<!-- Listado procedimientos -->
				<div class="row">

					<div class="col m12">
              <div class="collection">
								<?php
								while($Procedures = $categoriesList->fetch(PDO::FETCH_ASSOC)){
									echo "<a href='procedimiento/".$Procedures['CategoryId']."_".slugify($Procedures['Name'])."' class='collection-item'>".$Procedures['Name']."</a>";
								}
								?>
              </div>
					</div>

				</div>
				<!-- Fin listado procedimientos -->

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
