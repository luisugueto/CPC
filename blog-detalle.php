<?php
	require_once("admin/models/Articles.php");

    $articleId = $_GET["id"];
	$article = new Articles();

	$article->setArticleId($articleId);

	$article->GetArticleContent();

	$pageTitle = $article->getMetaTitle();
	$pageDescription = $article->getMetaDescription();

	$meta_title = $pageTitle." :: Blog - Cirugía Plástica Colombia";
	$meta_desc  = $pageDescription;

    include("includes/header.php");

	$tags = explode(",", $article->getTags());

	$relatedArticles = array();

	foreach ($tags as $tag)
	{
		$result = $article->ListRelatedArticles($tag, $articleId);
		$result = $result->fetchAll(PDO::FETCH_ASSOC);

		foreach ($result as $articleRelated)
		{
			array_push($relatedArticles, $articleRelated);
		}
	}
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
                                    <p class="card-dr-address"><?= nl2br($article->getContent()) ?></p>
                                </div>
                            </div>
                        </div>

					</div>
				</div>
				<!-- Fin detalle Blog -->

				<!-- Título -->
				<div class="title-divider">
					<h1>Artículos relacionados</h1>
				</div>
				<!-- Fin título -->

				<!-- detalle Blog -->
				<div class="row">
					<div class="col s12">

						<div class="owl-carousel owl-theme">
						
							<?php
								foreach ($relatedArticles as $article)
								{
							?>
									<div class="item" onclick="window.location.href='noticia/<?= $article["ArticleId"] ?>_<?= $article["Slug"] ?>'" style="cursor:pointer;">
										<div class="card horizontal" style="min-height: 415px;">
											<div class="card-stacked">
												<div class="card-content" style="line-height: 22px; font-size: 14px;">

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
				<!-- Fin detalle Blog -->

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
			
				<?php include("includes/sidebar_blog.php"); ?>

			</div>
			<!-- fin side bar (columna derecha) -->

		</div>
	</div>
	<!-- Fin contenido -->

	<br>

	<?php include("includes/footer.php"); ?>
