<?php
	require_once("admin/models/Sections.php");
	$section = new Sections();
	$section->setSectionId(2);
	$contentSection = $section->GetSectionContent();
	include("includes/header.php");
	require_once("admin/models/Categories.php");

	$categories = new Categories();
	$categoriesList = $categories->ListCategories();
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
