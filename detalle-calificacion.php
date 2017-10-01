<?php
  include("includes/header.php");
	require_once("admin/models/Doctors.php");
	require_once("admin/models/DataDoctors.php");
	require_once("admin/models/CalificationDoctors.php");
	require_once("admin/models/GalleryDoctors.php");

  $doctors = new Doctors();

	$data = new DataDoctors();
  $califications = new CalificationDoctors();
  if(isset($_GET['id']))
  {
    $califications->setCalificationDoctorId($_GET['id']);
    if($califications->GetCalificationDoctor())
    {
      $contentComment = $califications->GetCalificationDoctor();
      $califications->setDoctorId($contentComment['DoctorId']);
      $calificationsList = $califications->GetCalificationDoctorContent();

      $doctors->setDoctorId($contentComment['DoctorId']);
      $content = $doctors->GetDoctorContent();
    }
    else{
      exit();
    }
  }
?>
    <div class="row">
        <div class="col m12">
            <div class="profile-doctor" style="background-image: url(<?= $logo ?>)">
			</div>
            <div class="profile-actions">
                <h6 style="margin:0;"><?= $content["Name"] ?></h6>
                <small>Cirujano plástico</small>
                <br>
                <?php

                  if($califications->numCalificationsForDoctor() > 0){
                    $countStars = 0; $i = 0;
                    while($Calification = $calificationsList->fetch(PDO::FETCH_ASSOC)){
                      $countStars+=$Calification['CountStars'];
                      $i++;
                    }
                    switch (intval($countStars/$i)) {
                      case 1:
                        echo "<div class='stars-rate'>
                          <i class='material-icons left'>star</i>
                          <i class='material-icons inactive left'>star</i>
                          <i class='material-icons inactive left'>star</i>
                          <i class='material-icons inactive left'>star</i>
                          <i class='material-icons inactive left'>star</i>
                          <span style='margin-left:10px; color: black'>$i Reseñas</span>
                        </div>";
                        break;
                      case 2:
                        echo "<div class='stars-rate'>
                          <i class='material-icons left'>star</i>
                          <i class='material-icons left'>star</i>
                          <i class='material-icons inactive left'>star</i>
                          <i class='material-icons inactive left'>star</i>
                          <i class='material-icons inactive left'>star</i>
                          <span style='margin-left:10px; color: black'>$i Reseñas</span>
                        </div>";
                        break;
                      case 3:
                        echo "<div class='stars-rate'>
                          <i class='material-icons left'>star</i>
                          <i class='material-icons left'>star</i>
                          <i class='material-icons left'>star</i>
                          <i class='material-icons inactive left'>star</i>
                          <i class='material-icons inactive left'>star</i>
                          <span style='margin-left:10px; color: black'>$i Reseñas</span>
                        </div>";
                        break;
                      case 4:
                        echo "<div class='stars-rate'>
                          <i class='material-icons left'>star</i>
                          <i class='material-icons left'>star</i>
                          <i class='material-icons left'>star</i>
                          <i class='material-icons left'>star</i>
                          <i class='material-icons inactive left'>star</i>
                          <span style='margin-left:10px; color: black'>$i Reseñas</span>
                        </div>";
                        break;
                      case 5:
                        echo "<div class='stars-rate'>
                          <i class='material-icons left'>star</i>
                          <i class='material-icons left'>star</i>
                          <i class='material-icons left'>star</i>
                          <i class='material-icons left'>star</i>
                          <i class='material-icons left'>star</i>
                          <span style='margin-left:10px; color: black'>$i Reseñas</span>
                        </div>";
                        break;
                      default:
                        echo "<div class='stars-rate'>
                          <i class='material-icons inactive left'>star</i>
                          <i class='material-icons inactive left'>star</i>
                          <i class='material-icons inactive left'>star</i>
                          <i class='material-icons inactive left'>star</i>
                          <i class='material-icons inactive left'>star</i>
                          <span style='margin-left:10px; color: black'>$i Reseñas</span>
                        </div>";
                        break;
                    }
                  }
                  else{
                    echo "<div class='stars-rate'>
                      <i class='material-icons inactive left'>star</i>
                      <i class='material-icons inactive left'>star</i>
                      <i class='material-icons inactive left'>star</i>
                      <i class='material-icons inactive left'>star</i>
                      <i class='material-icons inactive left'>star</i>
                      <span style='margin-left:10px; color: black'>0 Reseñas</span>
                    </div>";
                  }
                ?>
            </div>
        </div>
    </div>

    <div class="row" style="margin-bottom:0">
      <h4>Detalle del Comentario</h4>
      <br>
      <p align="center">
        <b>Calificacion:</b> <?=$contentComment['CountStars'] ?> Estrellas<br>
        <b>Fecha de la Calificación:</b> <?= $contentComment['DateComment'] ?> <br>
        <b>Comentario:</b> <?= $contentComment['Comment'] ?> <br>
        <b>Usuario:</b> <?= $content['Name'] ?>
      </p>


    </div>

	<?php include("includes/footer.php"); ?>
