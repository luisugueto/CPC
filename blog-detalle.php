<?php
	require_once("admin/models/Articles.php");
	require_once("admin/models/Categories.php");
	require_once("admin/models/Doctors.php");

    $articleId = $_GET["id"];
	$article = new Articles();

	$article->setArticleId($articleId);

	$article->GetArticleContent();

	$pageTitle = $article->getMetaTitle();
	$pageDescription = $article->getMetaDescription();

	$meta_title = $pageTitle." :: Blog - Cirugía Plástica Colombia";
	$meta_desc  = $pageDescription;

    include("includes/header.php");

	$doctor = new Doctors();

	$doctorss = $doctor->ListDoctorsName();
	$arrayDoctors = array();

	while($Doctor = $doctorss->fetch(PDO::FETCH_ASSOC)){
		$arrayDoctors[$Doctor['DoctorName']." - ".$Doctor['SubTitle']. " [Doctor]"] = null;
	}
	$jsonDoctors = json_encode($arrayDoctors);

	$categories = new Categories();
	$categoriesList = $categories->ListCategories();

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

				<!-- Título -->
				<div class="title-divider">
					<h1><?= $article->getTitle(); ?></h1>
				</div>
				<!-- Fin título -->

				<!-- detalle Blog -->
				<div class="row">
					<div class="col s12">

                        <div class="card horizontal">
                            <div class="card-stacked">
                                <div class="card-content">
                                    <img src="images/blog/<?= $article->getPhoto() ?>" width="100%">
                                    <br><br>
                                    <p class="card-dr-address"><?= $article->getContent() ?></p>
                                </div>
                            </div>
                        </div>

					</div>
				</div>
				<!-- Fin detalle Blog -->

			</div>
			<!-- fin columna izquierda -->

			<!-- side bar (columna derecha) -->
			<div class="col m3 s12 hide-on-small-only">
			
				<?php include("includes/sidebar_blog.php"); ?>

			</div>
			<!-- fin side bar (columna derecha) -->

		</div>
	</div>
	<!-- Fin contenido -->

	<br>

	<?php include("includes/footer.php"); ?>
