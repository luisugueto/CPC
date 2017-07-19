<?php
  include("includes/header.php");
	require_once("admin/models/Doctors.php");
	require_once("admin/models/DataDoctors.php");
	require_once("admin/models/CalificationDoctors.php");
	require_once("admin/models/GalleryDoctors.php");

	$id = $_GET['id'];
	$doctors = new Doctors();
	$doctors->setDoctorId($id);
	$content = $doctors->GetDoctorContent();

	$data = new DataDoctors();
	$dataList = $data->GetDataforDoctor($id);

	$califications = new CalificationDoctors();
	$califications->setDoctorId($id);
	$calificationsList = $califications->GetCalificationDoctorContent();

	$gallery = new GalleryDoctors();
	$gallery->setDoctorId($id);
	$galleryList = $gallery->GetGalleryContent();
?>
    <div class="row">
        <div class="col m12">
            <div class="profile-doctor" style="background-image: url('http://cirugiaplasticacolombia.com/wp-content/uploads/2015/09/Dra-Maria-Mercedes-Valencia-cirujana-plastica-cirugia-plastica-colombia-plastic-surgery-Mauro-Rebolledo-Photography-274x199.jpg')">
			</div>
            <div class="profile-actions">
                <h6 style="margin:0;">Dr. <?= $content["Name"] ?></h6>
                <small>Cirujano plástico (<?php
                  $i = 0;
                  while ($Data = $dataList->fetch(PDO::FETCH_ASSOC))
                  {
                    if($Data['Name'] == 'Ciudad')
                    {
                      $ciudad = $Data['Description'];
                    }
                    elseif($Data['Name'] == 'País')
                    {
                      $pais = $Data['Description'];
                    }

                    if(isset($ciudad) || isset($pais))
                    {
                      if(isset($ciudad) && isset($pais))
                      {
                        echo $ciudad.', '.$pais;
                      }
                      elseif(isset($ciudad))
                        if($i>0)
                          echo ', '.$ciudad;
                        else
                          echo $ciudad;
                      else echo $pais.',';
                    }
                    $i++;
                  }
                ?>)</small>
                <br>
                <?php
                $califications->setDoctorId($id);
                $calificationsList = $califications->GetCalificationDoctorContent();
                  if(count($calificationsList == 0))
                    echo "<div class='stars-rate'>
                      <i class='material-icons inactive left'>star</i>
                      <i class='material-icons inactive left'>star</i>
                      <i class='material-icons inactive left'>star</i>
                      <i class='material-icons inactive left'>star</i>
                      <i class='material-icons inactive left'>star</i>
                      <span style='margin-left:10px; color: black'>0 Comentarios</span>
                    </div>";
                ?>
                <br>
                <a class="waves-effect waves-light btn profile-btn"><i class="material-icons left" style="margin-right:5px; font-size:12px">email</i> Contactar</a>
                <a class="waves-effect waves-light btn profile-btn" style="background-color:#ffa200"><i class="material-icons left" style="margin-right:5px; font-size:12px">star</i> Calificar</a>
            </div>
        </div>
    </div>

    <div class="row" style="margin-bottom:0">

        <ul class="tabs">
            <li class="tab col s4"><a class="active" href="#description">Información</a></li>
            <li class="tab col s4"><a href="#comments">Comentarios</a></li>
            <li class="tab col s4"><a href="#gallery">Galería</a></li>
        </ul>

        <div id="description" class="col s12 content-tab-profile">
            <h6>Descripción</h6>
            <p>
                <?= $content["Description"] ?>
            </p>
        </div>

        <div id="comments" class="col s12 content-tab-profile">
          <div class="center">
            <a href="javascript:void(0)" onclick="modalCall('comentario','form','<?= $id;?>')" class="btn btn-inverse btn-custom waves-effect waves-light btn-xs"><i class="fa fa-pencil"></i>Agregar Comentario</a>
          </div>
        </div>

        <div id="gallery" class="col s12 content-tab-profile">

        </div>

    </div>

	<?php include("includes/footer.php"); ?>
