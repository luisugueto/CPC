<?php
					require_once("admin/models/Articles.php");
					require_once("admin/models/CalificationDoctors.php");
					require_once("admin/models/GalleryDoctors.php");

					$tomorrowDay = date('d', time());
					$tomorrowMonth = date('m', time());
					$tomorrowYear = date('Y', time());
				
					$tomorrow = $tomorrowYear."-".$tomorrowMonth."-".$tomorrowDay;

					$articles = new Articles();
					$lastArticles = $articles->GetLastArticles($tomorrow);

					$calificationDoctors = new CalificationDoctors();
					$lastCalifications = $calificationDoctors->GetLastCalifications();

					$galleryDoctors = new GalleryDoctors();
				?>
				
				<div class="side-bar-block">

					<!-- reseñas -->
					<div class="title-divider">
						<h1>Últimas Reseñas</h1>
					</div>
					<!-- fin de reseñas -->

					<?php
						while ($calification = $lastCalifications->fetch(PDO::FETCH_ASSOC))
						{
							// Imagenes y Videos del comentario
							$listGalleryComment = $galleryDoctors->GetGalleryForComment($calification['CalificationDoctorId']);
							$galeria = $listGalleryComment->fetch(PDO::FETCH_ASSOC);
							
							if($galeria['Type'] == 'Image')
							{
								$first_image = "admin/files/images/".$galeria['Location'];
							}
							else
							{
								$first_image = "images/placeholder.jpg";
							}
					?>
							<ul class="collection">
								<a class="collection-item avatar truncate cirujanos" href="doctor/<?= $calification["DoctorId"] ?>_<?= slugify($calification['Name']) ?>">
									<div class="circle" style="background-image: url(<?= $first_image ?>)"></div>
									<span class="title">Dr. <?= $calification['Name'] ?></span>
									<p style="color:#626262;">
										<?php
											if (strlen($calification['Comment']) > 15)
											{
												echo substr($calification['Comment'], 0, 15)."...";
											}
											else
											{
												echo $calification['Comment'];
											}
										?>
									</p>

					<?php
									$totalStars = intval($calification['CountStars']);
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
					?>
									</div>
								</a>
							</ul>
					<?php
						}
					?>

				</div>

				<div class="side-bar-block">

					<div class="title-divider">
						<h1>Blog</h1>
					</div>

					<div class="collection">

						<?php
							while ($article = $lastArticles->fetch(PDO::FETCH_ASSOC))
							{
						?>
								<a href="noticia/<?= $article["ArticleId"] ?>_<?= $article["Slug"] ?>" class="collection-item avatar truncate valigncenter">
									<div class="circle" style="background-image:url('images/blog/<?= $article["Photo"] ?>'); background-size:cover; background-position:center;"></div>
									<span class="truncate"><?= $article["Title"] ?></span>
								</a>
						<?php
							}
						?>

					</div>
				</div>