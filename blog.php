<?php
	require_once("admin/models/Sections.php");
	require_once("admin/models/Categories.php");
	require_once("admin/models/Doctors.php");

	$section = new Sections();
	$section->setSectionId(4);
	$contentSection = $section->GetSectionContent();

	$meta_title = $contentSection["MetaTitle"];
	$meta_desc  = $contentSection["MetaDescription"];
    $meta_keywords = $contentSection["Keywords"];

	include("includes/header.php");
	require_once("admin/models/Articles.php");

	$articlesByPage = 5;
	$page = 1;

	if (isset($_GET["page"]))
	{
		$page_explode = explode(".", $_GET["page"]);
		$page = $page_explode[0];
	}

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
	$adjacents = 1;
	$targetpage = "blog_";
	$limit = 5;

	if($page)
	{
		$start = ($page - 1) * $limit;
	}
	else
	{
		$start = 0;
	}

	if ($page == 0) $page = 1;
	$prev = $page - 1;
	$next = $page + 1;
	$lastpage = ceil($total/$limit);
	$lpm1 = $lastpage - 1;

	$pagination = "";

	if($lastpage > 1)
	{
		$pagination .= "<ul class='pagination'>";
		if ($page > $counter+1)
		{
			$pagination.= "<li class='waves-effect'><a href=\"$targetpage$prev\"><i class='fa fa-angle-double-left'></i></a></li>";
		}
		if ($lastpage < 7 + ($adjacents * 2))
		{
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
				$pagination.= "<li class='active'><a href='#'>$counter</a></li>";
				else
				$pagination.= "<li class='waves-effect'><a href=\"$targetpage$counter\">$counter</a></li>";
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))
		{
			if($page < 1 + ($adjacents * 2))
			{
				for ($counter = 1; $counter < 2 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
					$pagination.= "<li class='active'><a href='#'>$counter</a></li>";
					else
					$pagination.= "<li class='waves-effect'><a href=\"$targetpage$counter\">$counter</a></li>";
				}
				//$pagination.= "<li>...</li>";
				//$pagination.= "<li><a href=\"$targetpage$lpm1\">$lpm1</a></li>";
				//$pagination.= "<li><a href=\"$targetpage$lastpage\">$lastpage</a></li>";
			}
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				//$pagination.= "<li><a href=\"$targetpage\"1>1</a></li>";
				//$pagination.= "<li>...</li>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
					$pagination.= "<li class='active'><a href='#'>$counter</a></li>";
					else
					$pagination.= "<li class='waves-effect'><a href=\"$targetpage$counter\">$counter</a></li>";
				}
				//$pagination.= "<li>...</li>";
				//$pagination.= "<li><a href=\"$targetpage$lastpage\">$lastpage</a></li>";
			}
			else
			{
				//$pagination.= "<li><a href=\"$targetpage\"1>1</a></li>";
				//$pagination.= "<li>...</li>";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
					$pagination.= "<li class='active'><a href='#'>$counter</a></li>";
					else
					$pagination.= "<li class='waves-effect'><a href=\"$targetpage$counter\">$counter</a></li>";
				}
			}
		}

		if ($page < $counter - 1)
			$pagination.= "<li class='waves-effect'><a href=\"$targetpage$next\"><i class='fa fa-angle-double-right'></i></a></li>";
		else
			$pagination.= "";
			$pagination.= "</ul>";
	}

	$doctor = new Doctors();

	$doctorss = $doctor->ListDoctorsName();
	$arrayDoctors = array();

	while($Doctor = $doctorss->fetch(PDO::FETCH_ASSOC)){
		$arrayDoctors[$Doctor['DoctorName']." -".$Doctor['SubTitle']. " - [Doctor] - ".$Doctor['DoctorId'].""] = null;		
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
					<h1>Blog</h1>
				</div>
				<!-- Fin título -->

				<!-- Carousel Blog -->
				<div class="row">
					<div class="col s12">

						<?php
							while ($article = $listArticles->fetch(PDO::FETCH_ASSOC))
							{
						?>
								<div class="card horizontal">
									<div class="card-stacked">
										<div class="card-content">
											<a href="noticia/<?= $article["ArticleId"] ?>_<?= $article["Slug"] ?>">
												<img src="images/blog/<?= $article["Photo"] ?>" width="100%">
											</a>
											
											<br><br>

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
						<?php
							}
						?>

					</div>
				</div>
				<!-- Fin listado Blog -->

				<!-- Paginador -->
				<div class="row">
					<div class="col s12 center-align">

						<?php
							if ($totalPages > 1)
							{
								echo $pagination;
							}
						?>

					</div>
				</div>
				<!-- Fin de paginador -->

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
