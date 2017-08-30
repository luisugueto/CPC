<?php
	include("includes/header.php");
	require_once("admin/models/Categories.php");
	require_once("admin/models/ProceduresDoctor.php");
	require_once("admin/models/Doctors.php");
    require_once("admin/models/SubCategories.php");
    require_once("admin/models/CalificationDoctors.php");

	$doctor = new Doctors();
	$categories = new Categories();
	$procedures = new ProceduresDoctor();
    $subCategories = new SubCategories();
    $califications = new CalificationDoctors();
    
	$subCategories->setSubCategoryId($_GET["id"]);
	$subCategory = $subCategories->GetSubCategoryContent();

	$list_doctors = $doctor->ListDoctorsBySubCategory($_GET["id"]);

	$categoriesListt = $categories->ListCategories();

	$doctorss = $doctor->ListDoctorsName();
	$arrayDoctors = array();

	while($doctor_fetch = $doctorss->fetch(PDO::FETCH_ASSOC))
	{
		$arrayDoctors[$doctor_fetch['DoctorName']." - ".$doctor_fetch['SubTitle']. " [Doctor]"] = null;
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
?>

	<!-- Contenido -->
	<div class="container">
		<div class="row">

			<!-- columna izquierda -->
			<div class="col m9 s12">

				<section>
					<!-- Título -->
          			<div class="title-divider">
						<h1><?= $subCategory["Name"] ?></h1>
					</div>
					<!-- Fin título -->

                    <img src="images/procedimientos/<?= $subCategory["Photo"] ?>" width="100%">

                    <br>

                    <?= $subCategory["Content"] ?>

                    <!-- Listado doctores -->
                    <?php

                        $count_doctors = 0;

                        while ($Doctor = $list_doctors->fetch(PDO::FETCH_ASSOC))
                        {
                            $content = 'medicos';
                            $id = $Doctor["DoctorId"];
                            $name = '<strong>Médico No.'.$id.'</strong> ('.$Doctor['Name'].')';
                            $logo = ($Doctor['Logo'] != '') ? 'admin/img/doctors/'.$Doctor['Logo'] : 'images/placeholder.jpg';

                            if ($count_doctors == 0)
                            {
                                echo "<div class='row'>";
                                echo "<div class='col m6 s12'>";
                            }
                            elseif ($count_doctors == 1)
                            {
                                echo "<div class='col m6 s12'>";
                            }
                    ?>
                            <ul class="collection">
                                <a class="collection-item avatar truncate cirujanos" href="doctor/<?= $id ?>_<?= slugify($Doctor['Name']) ?>">
                                    <div class="circle" style="background-image: url(<?= $logo ?>)"></div>
                                    <span class="title">Dr. <?= $Doctor['Name'] ?></span>
                                    <p style="color:#626262;">
                                        <?php
                                            if (strlen($Doctor['Description']) > 50)
                                            {
                                                echo substr($Doctor['Description'], 0, 50)."...";
                                            }
                                            else
                                            {
                                                echo $Doctor['Description'];
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
                            elseif ($count_doctors == 1)
                            {
                                $count_doctors = 0;
                                echo "</div>";
                                echo "</div>";
                            }
                        }
                    ?>
                    <!-- Fin listado doctores -->

				</section>


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
