				<?php
					require_once("admin/models/CalificationDoctors.php");
					require_once("admin/models/GalleryDoctors.php");

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

					<!-- Instagram -->
					<div class="title-divider">
						<h1>Instagram</h1>
					</div>
					<!-- fin de Instagram -->

					<!-- LightWidget WIDGET -->
					<script src="http://lightwidget.com/widgets/lightwidget.js"></script>
					<iframe src="http://lightwidget.com/widgets/54c4fae719f658e4b3f64ed599628176.html" scrolling="no" allowtransparency="true" class="lightwidget-widget" style="width: 100%; border: 0; overflow: hidden;"></iframe>

				</div>