<?php
	require_once("admin/models/Doctors.php");
	require_once("admin/models/Users.php");
	require_once("admin/models/DataDoctors.php");
	require_once("admin/models/CalificationDoctors.php");
	require_once("admin/models/ContestCalification.php");
	require_once("admin/models/ContestCalificationUser.php");
	require_once("admin/models/GalleryDoctors.php");
	require_once("admin/models/Categories.php");
	require_once("admin/models/SubCategories.php");
	require_once("admin/models/ProceduresDoctor.php");
	require_once("admin/models/UserDoctors.php");
	require_once("admin/models/Plans.php");

	$users = new Users();
	$doctors = new Doctors();
	$contest = new ContestCalification();
	$contestt = new ContestCalificationUser();
	$userDoctors = new UserDoctors();
	$subCategories = new SubCategories();
	$plans = new Plans();

	if(isset($_GET['id']))
	{
		$id = $_GET['id'];
		$doctors->setDoctorId($id);
		$userDoctors->setDoctorId($id);

		if($doctors->existsDoctor())
		{

		}
		else
		{
			echo "<script>window.location.href='directorio'</script>";
			exit();
		}
		$content = $doctors->GetDoctorContent();
	}
	elseif (isset($_POST['search']))
	{
		$explode = explode("[", $_POST['search']);
		$name = explode("-", $explode[0]);
		$doctors->setName(trim($name[0]));
		$content = $doctors->GetDoctorForName();

		if($content)
		{
			$id = $content['DoctorId'];
			$userDoctors->setDoctorId($id);
		}
		else
		{
			exit();
		}
	}

	$logo = ($content['Logo'] != '') ? 'admin/img/doctors/'.$content['Logo'] : 'images/placeholder.jpg';

	$data = new DataDoctors();
    $califications = new CalificationDoctors();
    $gallery = new GalleryDoctors();

	$dataList = $data->GetDataforDoctor($id);
	$data_list_responsive = $data->GetDataforDoctor($id);
	
	$califications->setDoctorId($id);
    $gallery->setDoctorId($id);

	$numCalificationsList = $califications->numCalificationsForDoctor();

	$totalOneStar = $califications->numCalificationsTotalForDoctor(1);
	$totalTwoStar = $califications->numCalificationsTotalForDoctor(2);
	$totalThreeStar = $califications->numCalificationsTotalForDoctor(3);
	$totalFourStar = $califications->numCalificationsTotalForDoctor(4);
	$totalFiveStar = $califications->numCalificationsTotalForDoctor(5);

	$calificationsList = $califications->GetCalificationDoctorContent();

	$calificationsListComments = $califications->GetCommentsForDoctor();
	$califications_list_comments_responsive = $califications->GetCommentsForDoctor();

    $gallery->setType('Image');
	$imageList = $gallery->GetGalleryDoctorContent();
	$image_list_responsive = $gallery->GetGalleryDoctorContent();

	$imageUserList = $gallery->GetGalleryUserContent();
	$image_user_list_responsive = $gallery->GetGalleryUserContent();

	$gallery->setType('Video');
	$videoList = $gallery->GetGalleryDoctorContent();
	$video_list_responsive = $gallery->GetGalleryDoctorContent();

	$videoUserList = $gallery->GetGalleryUserContent();
	$video_user_list_responsive = $gallery->GetGalleryUserContent();

    $categories = new Categories();
	$categoriesList = $categories->ListCategories();
    $categoriesListt = $categories->ListCategories();

	$procedures = new ProceduresDoctor();

	$doctorProcedures = $procedures->GetDoctorProcedures($id);
	$doctor_procedures_responsive = $procedures->GetDoctorProcedures($id);

    $doctorss = $doctors->ListDoctorsName();
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

	$meta_title = $content["Name"]." :: Especialistas - Cirugía Plástica Colombia";
	$meta_desc = "";

	$plans->setPlanId($content["PlanId"]);
	$plan = $plans->GetPlanContent();
	$plan_caracteristicas = unserialize($plan["Characteristic"]);
	
	include("includes/header.php");
?>

	<?php
		/* ===================================================== */
		/*             VERSIÓN PARA ESCRITORIO                   */
		/* ===================================================== */
	?>

	<div class="container hide-on-med-and-down">
		<div class="row">

			<div class="col m4 s12">
				<div class="center-align">
					<img src="<?= $logo ?>" width="60%">
					<h5><strong>Dr. <?= $content["Name"] ?></strong></h5>
					<?= $content["SubTitle"] ?>
					<br><br>
					<?php
						$countStars = 0;
						$i = 0;
						$totalStars = 0;
						$emptyStars = 0;

						if($califications->numCalificationsForDoctor() > 0)
						{
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
									echo "<i class='material-icons'>star</i>";
								}
								for ($x = 0; $x < $emptyStars; $x++)
								{
									echo "<i class='material-icons inactive'>star</i>";
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
								<div style='margin-left: 7px; color: black; position: relative; top: -4px; display: inline;'><?= $i ?> <?= $comment ?></div>
							</div>
					<?php
						}
						else
						{
							echo "<div class='stars-rate'><i class='material-icons inactive'>star</i><i class='material-icons inactive'>star</i><i class='material-icons inactive'>star</i><i class='material-icons inactive'>star</i><i class='material-icons inactive'>star</i><div style='margin-left: 7px; color: black; position: relative; top: -4px; display: inline;'>0 Reseñas</div></div>";
						}
                	?>

					<br><br>

					<?php
						if (array_key_exists("plan_datos", $plan_caracteristicas))
						{
					?>
							<a class="waves-effect waves-light btn profile-btn" onclick="modalCallSite('contacto','form','<?= $id;?>')" style="background-color:#c6055b"><i class="material-icons left" id="contactar-web" style="margin-right:5px; font-size:12px">email</i> Contactar</a>
					<?php
						}
					?>

					<a class="waves-effect waves-light btn profile-btn" id="calificar-web" onclick="modalCallSite('comentario','form','<?= $id;?>')" style="background-color:#ffa200"><i class="material-icons left" style="margin-right:5px; font-size:12px">star</i> Calificar</a>

					<br><br>

					<?php
						$enlacee = "http://cpc.cirugiaplasticacolombia.com/doctor/".$id."_".slugify($content['Name']);
						$enlace = 'http://www.facebook.com/sharer.php?s=100&p[url]='.$enlacee.'&p[title]=Conoce+a+'.$content['Name'].'&p[summary]=Ficha+Medica';
						$texto = 'Ver Ficha del Doctor en la ficha del doctor '.$content['Name'].' en el enlace: '.$enlacee.'';
					?>

					<a id="fb-share" href="javascript:var dir=window.document.URL;var tit=window.document.title;var tit2=encodeURIComponent(tit);var dir2= encodeURIComponent(dir);window.location.href=('<?= $enlace ?>');">
						<img src="images/fb.png" height="30" style="margin-right:10px;">
					</a>

                	<a id="tw-share" href="http://twitter.com/home?status=<?=$texto ?>'">
						<img src="images/tw.png" height="30">
					</a>
				</div>
			</div>

			<div class="col m8 s12">
				<div class="center-align">

					<div class="card">
						<div class="card-content">
							
							<div class="inner">

								<div class="rating">
									<span class="rating-num"><?= $totalStars ?></span>

									<div class="rating-stars">
										<?php
											if($califications->numCalificationsForDoctor() > 0)
											{	
												for ($x = 0; $x < $totalStars; $x++)
												{
													echo "<span><i class='material-icons active'>star</i></span>";
												}
												for ($x = 0; $x < $emptyStars; $x++)
												{
													echo "<span><i class='material-icons'>star</i></span>";
												}
											}
											else
											{
												echo "<span><i class='material-icons'>star</i></span><span><i class='material-icons'>star</i></span><span><i class='material-icons'>star</i></span><span><i class='material-icons'>star</i></span><span><i class='material-icons'>star</i></span>";
											}
										?>
									</div>
									<div class="rating-users">
										<i class="material-icons">person</i><div style='margin-left: 7px; color: black; position: relative; top: -4px; display: inline;'><?= $i ?> <?= $comment ?></div>
									</div>
								</div>

								<div class="histo">

									<div class="five histo-rate">
										<span class="histo-star">
											<i class="active material-icons">star</i> <div style='margin-left: 2px; color: black; position: relative; top: -7px; display: inline;'>5</div>
										</span>
										<span class="bar-block">
											<span id="bar-five" class="bar">
												<span><?= $totalFiveStar ?></span>&nbsp;
											</span>
										</span>
									</div>

									<div class="four histo-rate">
										<span class="histo-star">
											<i class="active material-icons">star</i> <div style='margin-left: 2px; color: black; position: relative; top: -7px; display: inline;'>4</div>
										</span>
										<span class="bar-block">
											<span id="bar-four" class="bar">
												<span><?= $totalFourStar ?></span>&nbsp;
											</span> 
										</span>
									</div> 

									<div class="three histo-rate">
										<span class="histo-star">
											<i class="active material-icons">star</i> <div style='margin-left: 2px; color: black; position: relative; top: -7px; display: inline;'>3</div>
										</span>
										<span class="bar-block">
											<span id="bar-three" class="bar">
												<span><?= $totalThreeStar ?></span>&nbsp;
											</span> 
										</span>
									</div>

									<div class="two histo-rate">
										<span class="histo-star">
											<i class="active material-icons">star</i> <div style='margin-left: 2px; color: black; position: relative; top: -7px; display: inline;'>2</div>
										</span>
										<span class="bar-block">
											<span id="bar-two" class="bar">
												<span><?= $totalTwoStar ?></span>&nbsp;
											</span> 
										</span>
									</div>

									<div class="one histo-rate">
										<span class="histo-star">
											<i class="active material-icons">star</i> <div style='margin-left: 2px; color: black; position: relative; top: -7px; display: inline;'>1</div>
										</span>
										<span class="bar-block">
											<span id="bar-one" class="bar">
												<span><?= $totalOneStar ?></span>&nbsp;
											</span> 
										</span>
									</div>

								</div>
							</div>

						</div>
					</div>

				</div>
			</div>

		</div>

		<div class="row" style="margin-bottom:0">
			<div class="col m4 s12">
				<ul class="tabs">
					<li class="tab col s4"><a class="active" href="#info">Información</a></li>
				</ul>

				<div id="info" class="col s12 content-tab-profile">
					<?php
						if ($dataList->rowCount() > 0)
						{
							echo '<h6><b>Contacto</b></h6>';
							while ($Data = $dataList->fetch(PDO::FETCH_ASSOC))
							{
								if ($Data['Name'] == "Teléfono")
								{
					?>
									<p id="phone-data"><b><?= $Data['Name'] ?>:</b> <?= substr($Data['Description'], 0, 5) ?>... <a href="javascript:void(0)" onclick="revealPhone('<?= $Data['Description'] ?>')">Ver teléfono</a></p>
					<?php
								}
								elseif ($Data['Name'] == "Página Web")
								{
									if (array_key_exists("plan_link", $plan_caracteristicas))
									{
					?>
										<p><b><?= $Data['Name'] ?>:</b> <?= $Data['Description'] ?> <a href="javascript:void(0)" onclick="visitPage('<?= $Data['Description'] ?>')">Visitar página web</a></p>
					<?php
									}
								}
								else
								{
									echo '<p><b>'.$Data['Name'].':</b> '.$Data['Description'].'</p>';
								}
							}
							echo '<br>';
						}
					?>

					<?php
						if ($doctorProcedures->rowCount() > 0)
						{
							while ($drProcedure = $doctorProcedures->fetch(PDO::FETCH_ASSOC))
							{
								echo "<h6><b>".$categories->GetCategoryName($drProcedure["CategoryId"])."</b></h6>";

								$doctorSubProcedures = $procedures->GetDoctorSubProcedures($id, $drProcedure["CategoryId"]);

								while ($drSubProcedure = $doctorSubProcedures->fetch(PDO::FETCH_ASSOC))
								{
									$subCatName = $subCategories->GetSubCategoryName($drSubProcedure["SubCategoryId"]);
									echo "<i class='material-icons' style='font-size: 18px;'>check</i> <div style='margin-left: 2px; color: black; position: relative; top: -4px; display: inline;'>".$subCatName."</div><br>";
								}
							}
							echo '<br>';
						}
					?>

					<?php
						if ($content["Description"] != "")
						{
					?>
							<h6><b>Descripción</b></h6>
							<p>
								<?= $content["Description"] ?>
							</p>
					<?php
						}
					?>

					<br>

					<?php
						$total_doctor_images = $imageList->rowCount();
						$total_user_images = $imageUserList->rowCount();

						$total_doctor_videos = $videoList->rowCount();
						$total_user_videos = $videoUserList->rowCount();

						if ($total_doctor_images != 0)
						{
							echo "<h6><b>Fotos</b></h6>";
	
							echo "<div class='row' style='margin-bottom:0'>";

							while ($Gallery = $imageList->fetch(PDO::FETCH_ASSOC))
							{
								echo "<div class='col m4'><a href='admin/img/doctors/galleries/".$Gallery['Location']."' data-lity><img src='admin/img/doctors/galleries/".$Gallery['Location']."' width='100%'></a></div>";
							}

							echo "</div>";

							echo "<div class='row' style='margin-bottom:0'>";
							
							if ($gallery->numGalleryForDoctorUser() != 0)
							{
								while ($GalleryUser = $imageUserList->fetch(PDO::FETCH_ASSOC))
								{
									echo "<div class='col m4'><a href='admin/files/images/".$Gallery['Location']."' data-lity><img src='admin/files/images/".$GalleryUser['Location']."' width='100%'></a></div>";
								}
							}

							echo "</div>";
							echo "<br>";
	
							echo "<h6><b>Videos</b></h6>";

							echo "<div class='row' style='margin-bottom:0'>";
	
							while ($Gallery = $videoList->fetch(PDO::FETCH_ASSOC))
							{
								echo "<div class='col m4'><a href='https://www.youtube.com/embed/".$Gallery['Location']."' data-lity><iframe width='100%' style='height='100px' src='https://www.youtube.com/embed/".$Gallery['Location']."' frameborder='0' allowfullscreen></iframe></a></div>";
							}

							echo "</div>";

							echo "<div class='row' style='margin-bottom:0'>";

							if ($total_user_images != 0)
							{
								while ($GalleryUser = $videoUserList->fetch(PDO::FETCH_ASSOC))
								{
									echo "<div class='col m4'><a href='https://www.youtube.com/embed/".$Gallery['Location']."' data-lity><iframe width='100%' style='height='100px' src='https://www.youtube.com/embed/".$GalleryUser['Location']."' frameborder='0' allowfullscreen></iframe></a></div>";
								}
							}

							echo "</div>";
							echo "<br>";
						}
						elseif ($total_user_images != 0)
						{
							echo "<h6><b>Fotos</b></h6>";

							echo "<div class='row' style='margin-bottom:0'>";
							
							while ($GalleryUser = $imageUserList->fetch(PDO::FETCH_ASSOC))
							{
								echo "<div class='col m4'><a href='admin/files/images/".$GalleryUser['Location']."' data-lity><img src='admin/files/images/".$GalleryUser['Location']."' width='100%'></a></div>";
							}

							echo "</div>";
	
							echo "<h6><b>Videos</b></h6>";

							echo "<div class='row' style='margin-bottom:0'>";

							while ($GalleryUser = $videoUserList->fetch(PDO::FETCH_ASSOC))
							{
								echo "<div class='col m4'><a href='https://www.youtube.com/embed/".$GalleryUser['Location']."' data-lity><iframe width='100%' style='height='100px' src='https://www.youtube.com/embed/".$GalleryUser['Location']."' frameborder='0' allowfullscreen></iframe></a></div>";
							}

							echo "</div>";
						}
					?>
				</div>
			</div>

			<div class="col m8 s12">				
				<div class="comments-container">
					<?php
						if($numCalificationsList == 0)
						{
							echo "<div class='center-align'>No posee Calificaciones</div>";
						}
						elseif ($numCalificationsList > 0)
						{
					?>
							<ul id="comments-list" class="comments-list">
					<?php
								$first_image = "";

								while($Comments = $calificationsListComments->fetch(PDO::FETCH_ASSOC))
								{
									$enlacee = "http://cpc.cirugiaplasticacolombia.com/detalle-calificacion.php?id=".$Comments['CalificationDoctorId'].""; 
									$enlace = 'http://www.facebook.com/sharer.php?s=100&p[url]='.$enlacee.'&p[title]=Conoce+a+'.$content['Name'].'&p[summary]=Ficha+Medica';
									$texto = 'Ver Calificacion del Doctor en la ficha del doctor '.$content['Name'].' en el enlace: '.$enlacee.'';

									// Imagenes y Videos del comentario
									$listGalleryComment = $gallery->GetGalleryForComment($Comments['CalificationDoctorId']);

									if ($listGalleryComment->rowCount() == 0)
									{
										$first_image = "";
									}
									else
									{
										while($Gallery = $listGalleryComment->fetch(PDO::FETCH_ASSOC))
										{
											if($Gallery['Type'] == 'Image')
											{
												$first_image = $Gallery['Location'];
											}
											elseif($Gallery['Type'] == 'Video')
											{
												
											}
										}	
									}
					?>
									<li>
										<div class="comment-main-level">
										
											<!-- Avatar -->
											<div class="comment-avatar">
												<?php
													if ($first_image != "")
													{
												?>
														<img src="admin/files/images/<?= $first_image ?>">
												<?php
													}
													else
													{
												?>
														<img src="images/placeholder.jpg">
												<?php
													}
												?>
											</div>

											<!-- Contenedor del Comentario -->
											<div class="comment-box">
												<div class="comment-head">
					<?php
													$d = date_parse($Comments["DateComment"]);
													$monthNum = $d["month"];
													$months = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
													$monthName = $months[$monthNum - 1];

													if($califications->GetStatusCalification($Comments['CalificationDoctorId']) == 'Active')
													{
					?>
														<h6 class="comment-name by-author"><?= $Comments['NameUser'] ?> <span><?= $d["day"] ?> de <?= $monthName ?> del <?= $d["year"] ?></span></h6> <span class="new badge">validado</span>
					<?php
													}
													else
													{
					?>
														<h6 class="comment-name by-author"><?= $Comments['NameUser'] ?> <span><?= $d["day"] ?> de <?= $monthName ?> del <?= $d["year"] ?></span></h6>
					<?php
													}
													if($califications->GetStatusDoctorCalification($Comments['CalificationDoctorId']) == 'Active')
													{
					?>
														<span class="new badge verified">verificado</span>
					<?php
													}
													
													$total_stars = intval($Comments['CountStars']);
													$empty_stars = 5 - $total_stars;

					?>
													<div class="stars-rate-comment">
					<?php
														for ($x = 0; $x < $total_stars; $x++)
														{
															echo "<i class='material-icons'>star</i>";
														}
														for ($x = 0; $x < $empty_stars; $x++)
														{
															echo "<i class='material-icons inactive'>star</i>";
														}
					?>
													</div>

													<a href="javascript:void(0)" onclick="modalCallSite('contestUser','form','<?= $Comments['CalificationDoctorId'];?>')">
														<i class="material-icons reply">comment</i>
													</a>

												</div>
												<div class="comment-content">
													<?= $Comments['Comment'] ?>
												</div>
											</div>
										</div>
									
					<?php
									
					?>
											<!-- Respuestas de los comentarios -->
											<ul class="comments-list reply-list">

					<?php

												$listCommentUser = $contest->GetUnionCommentsUserWithDoctor($Comments['CalificationDoctorId']);

												while($Commentss = $listCommentUser->fetch(PDO::FETCH_ASSOC))
												{
													$response_date = date_parse($Commentss["DateComment"]);
													$month_num = $response_date["month"];
													$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
													$month_name = $meses[$month_num - 1];
					?>
													<li>
														<!-- Avatar -->
					<?php
														if(!empty($Commentss['NameUser']))
														{
					?>
															<div class="comment-avatar"><img src="images/placeholder.jpg"></div>
					<?php
														}
														else
														{
					?>
															<div class="comment-avatar"><img src="<?= $logo ?>"></div>
					<?php
														}
					?>

														<!-- Contenedor del Comentario -->
														<div class="comment-box">
															<div class="comment-head">
					<?php
																if(!empty($Commentss['NameUser']))
																{
					?>
																	<h6 class="comment-name"><?= $Commentss['NameUser'] ?> <span><?= $response_date["day"] ?> de <?= $month_name ?> del <?= $response_date["year"] ?></span></h6>
					<?php
																}
																else
																{ 
					?>
																	<h6 class="comment-name tooltipped" data-position="bottom" data-delay="50" data-tooltip="Respondido por el Doctor <?= $content["Name"] ?>"><i class="material-icons" style="font-size: 10px; color: #0059a5;">verified_user</i> Dr. <?= $content["Name"] ?> <span><?= $response_date["day"] ?> de <?= $month_name ?> del <?= $response_date["year"] ?></span></h6>
					<?php 
																}
					?>
															</div>
															<div class="comment-content">
																<?= $Commentss['Comment'] ?>
															</div>
														</div>
													</li>
					<?php
												}
					?>
										</ul>
					<?php
										

									//echo '<a href="javascript:var dir=window.document.URL;var tit=window.document.title;var tit2=encodeURIComponent(tit);var dir2= encodeURIComponent(dir);window.location.href=('.$enlace.');"><img src="images/fb.png" style="width:20px; height: 20px"></img></a><a href="http://twitter.com/home?status='.$texto.'" class="btwitter" title="Compartelo en Twitter"><img src="images/tw.png" style="width:20px; height: 20px"></img></a>';
								}
					?>
							</ul>
					<?php
						}
					?>
				</div>
			</div>
		</div>
	</div>

	<?php
		/* ===================================================== */
		/*          FIN VERSIÓN PARA ESCRITORIO                  */
		/* ===================================================== */
	?>




	<?php
		/* ===================================================== */
		/*                 VERSIÓN PARA MÓVIL                    */
		/* ===================================================== */
	?>

    <div class="container responsive-w hide-on-med-and-up show-on-medium">

      	<div class="row" style="padding: 0 10px;">
        	<div class="col s12">
            	<div class="profile-doctor" style="background-image: url(<?= $logo ?>)"></div>

             	<div class="profile-actions">

                	<h6 style="margin:0;">Dr. <?= $content["Name"] ?></h6>
                	<small><?= $content["SubTitle"] ?></small>
                	<br>

                	<?php
						if($califications->numCalificationsForDoctor() > 0)
						{
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

					<br>

					<?php
						if (array_key_exists("plan_datos", $plan_caracteristicas))
						{
					?>

							<a class="waves-effect waves-light btn profile-btn" onclick="modalCallSite('contacto','form','<?= $id;?>')" style="background-color:#c6055b"><i class="material-icons left" id="contactar-mobile" style="margin-right:5px; font-size:12px">email</i> Contactar</a>

					<?php
						}
					?>

					<a class="waves-effect waves-light btn profile-btn" onclick="modalCallSite('comentario','form','<?= $id;?>')" id="calificar-mobile" style="background-color:#ffa200"><i class="material-icons left" style="margin-right:5px; font-size:12px">star</i> Calificar</a>

					<br>

                	<a id="fb-share-mobile" href="javascript:var dir=window.document.URL;var tit=window.document.title;var tit2=encodeURIComponent(tit);var dir2= encodeURIComponent(dir);window.location.href=('<?= $enlace ?>');" style="position: relative; top: 12px;">
						<img src="images/fb.png" height="25" style="margin:0 5px;">
					</a>

					<a id="tw-share-mobile" href="http://twitter.com/home?status=<?=$texto ?>'" style="position: relative; top: 12px;">
						<img src="images/tw.png" height="25">
					</a>

              	</div>
          	</div>
      	</div>

      	<div class="row" style="margin-bottom:0">

			<ul class="tabs">
				<li class="tab col s4"><a class="active" href="#description" id="information-tab">Información</a></li>
				<li class="tab col s4"><a href="#comments" id="comment-tab">Reseñas</a></li>
				<li class="tab col s4"><a href="#gallery" id="gal-tab">Galería</a></li>
			</ul>

			<div id="description" class="col s12 content-tab-profile">
				<?php
					if ($data_list_responsive->rowCount() > 0)
					{
						echo '<h6><b>Contacto</b></h6>';
						while ($Data = $data_list_responsive->fetch(PDO::FETCH_ASSOC))
						{
							if ($Data['Name'] == "Teléfono")
							{
				?>
								<p id="phone-data-mobile"><b><?= $Data['Name'] ?>:</b> <?= substr($Data['Description'], 0, 5) ?>... <a href="javascript:void(0)" onclick="revealPhone('<?= $Data['Description'] ?>')">Ver teléfono</a></p>
				<?php
							}
							elseif ($Data['Name'] == "Página Web")
							{
								if (array_key_exists("plan_link", $plan_caracteristicas))
								{
				?>
									<p><b><?= $Data['Name'] ?>:</b> <?= $Data['Description'] ?> <a href="javascript:void(0)" onclick="visitPage('<?= $Data['Description'] ?>')">Visitar página web</a></p>
				<?php
								}
							}
							else
							{
								echo '<p><b>'.$Data['Name'].':</b> '.$Data['Description'].'</p>';
							}
						}
						echo '<br>';
					}
				?>

				<?php
					if ($doctor_procedures_responsive->rowCount() > 0)
					{
						while ($drProcedure = $doctor_procedures_responsive->fetch(PDO::FETCH_ASSOC))
						{
							echo "<h6><b>".$categories->GetCategoryName($drProcedure["CategoryId"])."</b></h6>";

							$doctorSubProcedures = $procedures->GetDoctorSubProcedures($id, $drProcedure["CategoryId"]);

							while ($drSubProcedure = $doctorSubProcedures->fetch(PDO::FETCH_ASSOC))
							{
								$subCatName = $subCategories->GetSubCategoryName($drSubProcedure["SubCategoryId"]);
								echo "<i class='material-icons' style='font-size: 18px;'>check</i> <div style='margin-left: 2px; color: black; position: relative; top: -4px; display: inline;'>".$subCatName."</div><br>";
							}
						}
						echo '<br>';
					}
				?>

				<?php
					if ($content["Description"] != "")
					{
				?>
						<h6><b>Descripción</b></h6>
						<p>
							<?= $content["Description"] ?>
						</p>
				<?php
					}
				?>
			</div>

			<div id="comments" class="col s12 content-tab-profile">
				<div class="inner">

					<div class="rating">
						<span class="rating-num"><?= $totalStars ?></span>

						<div class="rating-stars">
							<?php
								if($califications->numCalificationsForDoctor() > 0)
								{	
									for ($x = 0; $x < $totalStars; $x++)
									{
										echo "<span><i class='material-icons active'>star</i></span>";
									}
									for ($x = 0; $x < $emptyStars; $x++)
									{
										echo "<span><i class='material-icons'>star</i></span>";
									}
								}
								else
								{
									echo "<span><i class='material-icons'>star</i></span><span><i class='material-icons'>star</i></span><span><i class='material-icons'>star</i></span><span><i class='material-icons'>star</i></span><span><i class='material-icons'>star</i></span>";
								}
							?>
						</div>
						<div class="rating-users">
							<i class="material-icons">person</i><div style='margin-left: 7px; color: black; position: relative; top: -4px; display: inline;'><?= $i ?> <?= $comment ?></div>
						</div>
					</div>

					<div class="histo">

						<div class="five histo-rate">
							<span class="histo-star">
								<i class="active material-icons">star</i> <div style='margin-left: 2px; color: black; position: relative; top: -4px; display: inline;'>5</div>
							</span>
							<span class="bar-block">
								<span id="bar-five" class="bar responsive">
									<span><?= $totalFiveStar ?></span>&nbsp;
								</span>
							</span>
						</div>

						<div class="four histo-rate">
							<span class="histo-star">
								<i class="active material-icons">star</i> <div style='margin-left: 2px; color: black; position: relative; top: -4px; display: inline;'>4</div>
							</span>
							<span class="bar-block">
								<span id="bar-four" class="bar responsive">
									<span><?= $totalFourStar ?></span>&nbsp;
								</span> 
							</span>
						</div> 

						<div class="three histo-rate">
							<span class="histo-star">
								<i class="active material-icons">star</i> <div style='margin-left: 2px; color: black; position: relative; top: -4px; display: inline;'>3</div>
							</span>
							<span class="bar-block">
								<span id="bar-three" class="bar responsive">
									<span><?= $totalThreeStar ?></span>&nbsp;
								</span> 
							</span>
						</div>

						<div class="two histo-rate">
							<span class="histo-star">
								<i class="active material-icons">star</i> <div style='margin-left: 2px; color: black; position: relative; top: -4px; display: inline;'>2</div>
							</span>
							<span class="bar-block">
								<span id="bar-two" class="bar responsive">
									<span><?= $totalTwoStar ?></span>&nbsp;
								</span> 
							</span>
						</div>

						<div class="one histo-rate">
							<span class="histo-star">
								<i class="active material-icons">star</i> <div style='margin-left: 2px; color: black; position: relative; top: -4px; display: inline;'>1</div>
							</span>
							<span class="bar-block">
								<span id="bar-one" class="bar responsive">
									<span><?= $totalOneStar ?></span>&nbsp;
								</span> 
							</span>
						</div>

					</div>
				</div>

				<div class="comments-container">
					<?php
						if($numCalificationsList == 0)
						{
							echo "<div class='center-align'>No posee Calificaciones</div>";
						}
						elseif ($numCalificationsList > 0)
						{
					?>
							<ul id="comments-list" class="comments-list">
					<?php
								$first_image = "";

								while($Comments = $califications_list_comments_responsive->fetch(PDO::FETCH_ASSOC))
								{
									$enlacee = "http://cpc.cirugiaplasticacolombia.com/detalle-calificacion.php?id=".$Comments['CalificationDoctorId'].""; 
									$enlace = 'http://www.facebook.com/sharer.php?s=100&p[url]='.$enlacee.'&p[title]=Conoce+a+'.$content['Name'].'&p[summary]=Ficha+Medica';
									$texto = 'Ver Calificacion del Doctor en la ficha del doctor '.$content['Name'].' en el enlace: '.$enlacee.'';

									// Imagenes y Videos del comentario
									$list_gallery_comment = $gallery->GetGalleryForComment($Comments['CalificationDoctorId']);

									if ($list_gallery_comment->rowCount() == 0)
									{
										$first_image = "";
									}
									else
									{
										while($Gallery = $list_gallery_comment->fetch(PDO::FETCH_ASSOC))
										{
											if($Gallery['Type'] == 'Image')
											{
												$first_image = $Gallery['Location'];
											}
											elseif($Gallery['Type'] == 'Video')
											{
												
											}
										}	
									}

					?>
									<li>
										<div class="comment-main-level">
										
											<!-- Avatar -->
											<div class="comment-avatar">
												<?php
													if ($first_image != "")
													{
												?>
														<img src="admin/files/images/<?= $first_image ?>">
												<?php
													}
													else
													{
												?>
														<img src="images/placeholder.jpg">
												<?php
													}
												?>
											</div>

											<!-- Contenedor del Comentario -->
											<div class="comment-box">
												<div class="comment-head">
					<?php
													$d = date_parse($Comments["DateComment"]);
													$monthNum = $d["month"];
													$months = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
													$monthName = $months[$monthNum - 1];

													if($califications->GetStatusCalification($Comments['CalificationDoctorId']) == 'Active')
													{
					?>
														<h6 class="comment-name by-author"><?= $Comments['NameUser'] ?> <span><?= $d["day"] ?> de <?= $monthName ?> del <?= $d["year"] ?></span></h6> <span class="new badge">validado</span>
					<?php
													}
													else
													{
					?>
														<h6 class="comment-name by-author"><?= $Comments['NameUser'] ?> <span><?= $d["day"] ?> de <?= $monthName ?> del <?= $d["year"] ?></span></h6>
					<?php
													}
													if($califications->GetStatusDoctorCalification($Comments['CalificationDoctorId']) == 'Active')
													{
					?>
														<span class="new badge verified">verificado</span>
					<?php
													}

													$total_stars = intval($Comments['CountStars']);
													$empty_stars = 5 - $total_stars;

					?>
													<div class="stars-rate-comment">
					<?php
														for ($x = 0; $x < $total_stars; $x++)
														{
															echo "<i class='material-icons'>star</i>";
														}
														for ($x = 0; $x < $empty_stars; $x++)
														{
															echo "<i class='material-icons inactive'>star</i>";
														}
					?>
													</div>

													<a href="javascript:void(0)" onclick="modalCallSite('contestUser','form','<?= $Comments['CalificationDoctorId'];?>')">
														<i class="material-icons reply">comment</i>
													</a>

												</div>
												<div class="comment-content">
													<?= $Comments['Comment'] ?>
												</div>
											</div>
										</div>
									
					<?php
									
					?>
											<!-- Respuestas de los comentarios -->
											<ul class="comments-list reply-list">

					<?php

												$list_comment_user = $contest->GetUnionCommentsUserWithDoctor($Comments['CalificationDoctorId']);

												while($Commentss = $list_comment_user->fetch(PDO::FETCH_ASSOC))
												{
													$response_date = date_parse($Commentss["DateComment"]);
													$month_num = $response_date["month"];
													$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
													$month_name = $meses[$month_num - 1];
					?>
													<li>
														<!-- Avatar -->
					<?php
														if(!empty($Commentss['NameUser']))
														{
					?>
															<div class="comment-avatar"><img src="images/placeholder.jpg"></div>
					<?php
														}
														else
														{
					?>
															<div class="comment-avatar"><img src="<?= $logo ?>"></div>
					<?php
														}
					?>

														<!-- Contenedor del Comentario -->
														<div class="comment-box">
															<div class="comment-head">
					<?php
																if(!empty($Commentss['NameUser']))
																{
					?>
																	<h6 class="comment-name"><?= $Commentss['NameUser'] ?> <span><?= $response_date["day"] ?> de <?= $month_name ?> del <?= $response_date["year"] ?></span></h6>
					<?php
																}
																else
																{ 
					?>
																	<h6 class="comment-name tooltipped" data-position="bottom" data-delay="50" data-tooltip="Respondido por el Doctor <?= $content["Name"] ?>"><i class="material-icons" style="font-size: 10px; color: #0059a5;">verified_user</i> Dr. <?= $content["Name"] ?> <span><?= $response_date["day"] ?> de <?= $month_name ?> del <?= $response_date["year"] ?></span></h6>
					<?php 
																}
					?>
															</div>
															<div class="comment-content">
																<?= $Commentss['Comment'] ?>
															</div>
														</div>
													</li>
					<?php
												}
					?>
										</ul>
					<?php
										

									//echo '<a href="javascript:var dir=window.document.URL;var tit=window.document.title;var tit2=encodeURIComponent(tit);var dir2= encodeURIComponent(dir);window.location.href=('.$enlace.');"><img src="images/fb.png" style="width:20px; height: 20px"></img></a><a href="http://twitter.com/home?status='.$texto.'" class="btwitter" title="Compartelo en Twitter"><img src="images/tw.png" style="width:20px; height: 20px"></img></a>';
								}
					?>
							</ul>
					<?php
						}
					?>
				</div>
			</div>

			<div id="gallery" class="col s12 content-tab-profile">
				<?php
					$total_doctor_images = $imageList->rowCount();
					$total_user_images = $imageUserList->rowCount();

					$total_doctor_videos = $videoList->rowCount();
					$total_user_videos = $videoUserList->rowCount();

					if ($gallery->numGalleryForDoctor() != 0)
					{
						echo "<h6><b>Fotos</b></h6>";

						echo "<div class='row' style='margin-bottom:0'>";

						while ($Gallery = $image_list_responsive->fetch(PDO::FETCH_ASSOC))
						{
							echo "<div class='col s6'><a href='admin/img/doctors/galleries/".$Gallery['Location']."' data-lity><img src='admin/img/doctors/galleries/".$Gallery['Location']."' width='100%'></a></div>";
						}

						echo "</div>";

						echo "<div class='row' style='margin-bottom:0'>";
						
						if ($gallery->numGalleryForDoctorUser() != 0)
						{
							while ($GalleryUser = $image_user_list_responsive->fetch(PDO::FETCH_ASSOC))
							{
								echo "<div class='col s6'><a href='admin/files/images/".$GalleryUser['Location']."' data-lity><img src='admin/files/images/".$GalleryUser['Location']."' width='100%'></a></div>";
							}
						}

						echo "</div>";
						echo "<br>";

						echo "<h6><b>Videos</b></h6>";

						echo "<div class='row' style='margin-bottom:0'>";

						while ($Gallery = $video_list_responsive->fetch(PDO::FETCH_ASSOC))
						{
							echo "<div class='col s6'><a href='https://www.youtube.com/embed/".$Gallery['Location']."' data-lity><iframe width='100%' style='height='100px' src='https://www.youtube.com/embed/".$Gallery['Location']."' frameborder='0' allowfullscreen></iframe></a></div>";
						}

						echo "</div>";

						echo "<div class='row' style='margin-bottom:0'>";

						if ($gallery->numGalleryForDoctorUser() != 0)
						{
							while ($GalleryUser = $video_user_list_responsive->fetch(PDO::FETCH_ASSOC))
							{
								echo "<div class='col s6'><a href='https://www.youtube.com/embed/".$GalleryUser['Location']."' data-lity><iframe width='100%' style='height='100px' src='https://www.youtube.com/embed/".$GalleryUser['Location']."' frameborder='0' allowfullscreen></iframe></a></div>";
							}
						}

						echo "</div>";
						echo "<br>";
					}
					elseif ($gallery->numGalleryForDoctorUser() != 0)
					{
						echo "<h6><b>Fotos</b></h6>";

						echo "<div class='row' style='margin-bottom:0'>";
						
						while ($GalleryUser = $image_user_list_responsive->fetch(PDO::FETCH_ASSOC))
						{
							echo "<div class='col s6'><a href='admin/files/images/".$GalleryUser['Location']."' data-lity><img src='admin/files/images/".$GalleryUser['Location']."'></a></div>";
						}

						echo "</div>";

						echo "<h6><b>Videos</b></h6>";

						echo "<div class='row' style='margin-bottom:0'>";

						while ($GalleryUser = $video_user_list_responsive->fetch(PDO::FETCH_ASSOC))
						{
							echo "<div class='col s6'><a href='https://www.youtube.com/embed/".$GalleryUser['Location']."' data-lity><iframe width='100%' style='height='100px' src='https://www.youtube.com/embed/".$GalleryUser['Location']."' frameborder='0' allowfullscreen></iframe></a></div>";
						}

						echo "</div>";
					}
				?>
			</div>

		</div>

    </div>

	<?php
		/* ===================================================== */
		/*                FIN VERSIÓN PARA MÓVIL                 */
		/* ===================================================== */
	?>

	<?php include("includes/footer.php"); ?>

	<?php
		$percentOne    =   ($totalOneStar    /   $califications->numCalificationsForDoctor()) * 100;
		$percentTwo    =   ($totalTwoStar    /   $califications->numCalificationsForDoctor()) * 100;
		$percentThree  =   ($totalThreeStar  /   $califications->numCalificationsForDoctor()) * 100;
		$percentFour   =   ($totalFourStar   /   $califications->numCalificationsForDoctor()) * 100;
		$percentFive   =   ($totalFiveStar   /   $califications->numCalificationsForDoctor()) * 100;
	?>

	<script type="text/javascript">

		$("#contactar-web").click(function() {
			ga('send', 'event', 'Contactar', 'click', 'D<?= $id ?>');
		});

		$("#contactar-mobile").click(function() {
			ga('send', 'event', 'Contactar', 'click', 'D<?= $id ?>');
		});

		$("#calificar-web").click(function() {
			ga('send', 'event', 'Calificar', 'click', 'D<?= $id ?>');
		});

		$("#calificar-mobile").click(function() {
			ga('send', 'event', 'Calificar', 'click', 'D<?= $id ?>');
		});

		$("#fb-share").click(function() {
			ga('send', 'event', 'Compartir en Facebook', 'click', 'D<?= $id ?>');
		});

		$("#fb-share-mobile").click(function() {
			ga('send', 'event', 'Compartir en Facebook', 'click', 'D<?= $id ?>');
		});

		$("#tw-share").click(function() {
			ga('send', 'event', 'Compartir en Twitter', 'click', 'D<?= $id ?>');
		});

		$("#tw-share-mobile").click(function() {
			ga('send', 'event', 'Compartir en Twitter', 'click', 'D<?= $id ?>');
		});

		$("#information-tab").click(function() {
			ga('send', 'event', 'Pestaña Información', 'click', 'D<?= $id ?>');
		});

		$("#comment-tab").click(function() {
			ga('send', 'event', 'Pestaña Reseñas', 'click', 'D<?= $id ?>');
		});

		$("#gal-tab").click(function() {
			ga('send', 'event', 'Pestaña Galería', 'click', 'D<?= $id ?>');
		});

		function revealPhone(phone) {
			$("#phone-data").html("<b>Teléfono:</b> " + phone);
			$("#phone-data-mobile").html("<b>Teléfono:</b> " + phone);
			ga('send', 'event', 'Teléfono', 'click', 'D<?= $id ?>');
		}

		function visitPage(url) {
			var res = url.split(":", 1);
			var web = "";

			if (res == "http") {
				web = url;
			} else {
				web = "http://" + url;
			}

			window.open(web);
			ga('send', 'event', 'Página Web', 'click', 'D<?= $id ?>');
		}

		$(function() {
			$('#bar-five').animate({ width: '<?= $percentFive ?>%'}, 1000);
			$('#bar-four').animate({ width: '<?= $percentFour ?>%'}, 1000);
			$('#bar-three').animate({ width: '<?= $percentThree ?>%'}, 1000);
			$('#bar-two').animate({ width: '<?= $percentTwo ?>%'}, 1000);
			$('#bar-one').animate({ width: '<?= $percentOne ?>%'}, 1000);

			$('#bar-five.responsive').animate({ width: '<?= $percentFive ?>%'}, 1000);
			$('#bar-four.responsive').animate({ width: '<?= $percentFour ?>%'}, 1000);
			$('#bar-three.responsive').animate({ width: '<?= $percentThree ?>%'}, 1000);
			$('#bar-two.responsive').animate({ width: '<?= $percentTwo ?>%'}, 1000);
			$('#bar-one.responsive').animate({ width: '<?= $percentOne ?>%'}, 1000);

			setTimeout(function() {
				$('.bar span').fadeIn('slow');
			}, 800);
		});
	</script>