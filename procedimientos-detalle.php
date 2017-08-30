<?php
	require_once("admin/models/Categories.php");
	require_once("admin/models/ProceduresDoctor.php");
	require_once("admin/models/Doctors.php");
	require_once("admin/models/SubCategories.php");

	$doctor = new Doctors();
	$categories = new Categories();
	$categoriesList = $categories->ListCategories();

	$procedures = new ProceduresDoctor();

	$subCategories = new SubCategories();

	if(isset($_POST['search']))
	{
		$explode = explode("[", $_POST['search']);
		$string = explode("-", $explode[0]);
		$procedures->setCategoryId($string[1]);
		$categories->setCategoryId($string[1]);
		$content = $categories->GetCategoryContent();
		$subCategories->setCategoryId($string[1]);
		$listSubCategories = $subCategories->GetSubCategoriesByCategory();
	}
	elseif(isset($_GET['id']))
	{
		$procedures->setCategoryId($_GET['id']);
		$categories->setCategoryId($_GET['id']);
		$content = $categories->GetCategoryContent();
		$subCategories->setCategoryId($_GET["id"]);
		$listSubCategories = $subCategories->GetSubCategoriesByCategory();
	}

	$proceduresCategory = $procedures->ListProceduresCategory();

	$categories = new Categories();
	$categoriesList = $categories->ListCategories();
	$categoriesListt = $categories->ListCategories();

	$doctorss = $doctor->ListDoctorsName();
	$arrayDoctors = array();

	while($Doctor = $doctorss->fetch(PDO::FETCH_ASSOC))
	{
		$arrayDoctors[$Doctor['DoctorName']." - ".$Doctor['SubTitle']. " [Doctor]"] = null;
	}

	$jsonDoctors = json_encode($arrayDoctors);

	$proceduress = $procedures->ListProceduresName();
	$arrayProcedures = array();

	while($Procedures = $categoriesListt->fetch(PDO::FETCH_ASSOC))
	{
		$arrayProcedures[$Procedures['Name']." - ".$Procedures['CategoryId']." - [Procedimiento]"] = null;
	}

	$jsonProcedures = json_encode($arrayProcedures);
	$arrayMerge = array_merge($arrayDoctors, $arrayProcedures);

	$meta_title = $content['Name']." :: Procedimientos - Cirugía Plástica Colombia";
	$meta_desc  = $content['Name'];

	include("includes/header.php");
?>

	<!-- Contenido -->
	<div class="container">
		<div class="row">

			<!-- columna izquierda -->
			<div class="col m9 s12">

				<section>
					<!-- Título -->
          			<div class="title-divider">
						<h1><?= $content['Name'] ?></h1>
					</div>
					<!-- Fin título -->
				</section>

				<!-- Listado procedimientos -->
				<?php
					$counter = 0;
					$x = 0;
					$pair = false;
					$totalCategories = $listSubCategories->rowCount();

					while ($subCategory = $listSubCategories->fetch(PDO::FETCH_ASSOC))
					{
						if ($counter == 0)
						{
							echo "<div class='row'>";
							echo "<div class='col m4 s12'>";
						}
						elseif ($counter == 1 || $counter == 2)
						{
							echo "<div class='col m4 s12'>";
						}
				?>
						<div class="card horizontal" style="height: 250px">
							<div class="card-stacked">
								<div class="card-content">
									<a href="subprocedimiento/<?= $subCategory["SubCategoryId"] ?>_<?= slugify($subCategory["Name"]) ?>">
										<img src="images/procedimientos/<?= $subCategory["Photo"] ?>" width="100%">
									</a>
									<br><br>
									<h5 class="card-dr-title"><?= $subCategory["Name"] ?></h5>
									<p class="card-dr-address" style="text-align:justify;"><?= $subCategory["Description"] ?></p>
								</div>
							</div>
						</div>
				<?php
						if ($counter == 0)
						{
							echo "</div>";
							$pair = false;
							$counter++;
						}
						elseif ($counter == 1)
						{
							$counter++;
							echo "</div>";
						}
						elseif ($counter == 2)
						{
							$counter = 0;
							echo "</div>";
							echo "</div>";
							$pair = true;
						}

						$x++;

						if ($x == $totalCategories && !$pair)
						{
							echo "</div>";
						}
					}
				?>
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
