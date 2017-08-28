<?php
	require_once("admin/models/Sections.php");
	$section = new Sections();
	$section->setSectionId(6);
	$contentSection = $section->GetSectionContent();
	include("includes/header.php");
	require_once("admin/models/Categories.php");
	require_once("admin/models/Doctors.php");
	require_once("admin/models/ProceduresDoctor.php");
  	require_once("admin/PHPMailer/class.phpmailer.php");

	$categories = new Categories();
	$categoriesList = $categories->ListCategories();
	$categoriesListt = $categories->ListCategories();

	$doctor = new Doctors();
	$procedures = new ProceduresDoctor();

	$doctorss = $doctor->ListDoctorsName();
	$arrayDoctors = array();

	while($Doctor = $doctorss->fetch(PDO::FETCH_ASSOC)){
		$arrayDoctors[$Doctor['DoctorName']." - ".$Doctor['SubTitle']. " [Doctor]"] = null;
	}
	$jsonDoctors = json_encode($arrayDoctors);

	$proceduress = $procedures->ListProceduresName();
	$arrayProcedures = array();

	while($Procedures = $categoriesListt->fetch(PDO::FETCH_ASSOC)){
		$arrayProcedures[$Procedures['Name']." - ".$Procedures['CategoryId']." - [Procedimiento]"] = null;
	}
	$jsonProcedures = json_encode($arrayProcedures);
	$arrayMerge = array_merge($arrayDoctors, $arrayProcedures);

  if(isset($_POST)){
    $mail = new PHPMailer;
    $mail->setFrom('info@pixelgrafia.com', 'Información Pixelgrafía');
    $mail->addReplyTo('info@pixelgrafia.com', 'Información Pixelgrafía');
    $mail->addAddress($_POST['txtEmail']);

    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';

    $mail->Subject = $_POST['txtAsunto'];
    $mail->Body = "El usuario con el correo ".$_POST['txtEmail']." lo quiere contactar con el siguiente mensaje: ".$_POST['txtMessage']."";

    if(!$mail->send())
    {
      echo "<script>alert('Ha ocurrido un error')</script>";
    }
    else
    {
      echo "<script>alert('Mensaje Enviado con Exito')</script>";
    }
  }
?>

	<!-- Contenido -->
	<div class="container">
		<div class="row">

			<!-- columna izquierda -->
			<div class="col m9 s12">

				<section class="hide-on-small-only">

					<!-- Título -->
					<div class="title-divider">
						<h1>Contacto</h1>
					</div>
					<!-- Fin título -->

				</section>

				<!-- Listado procedimientos -->
				<div class="row">

					<div class="col m12">
                <form class="form-control" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                  <div class="form-group">
                      <label class="col-sm-3 control-label">Asunto</label>
                      <div class="col-sm-6">
                          <input name="txtAsunto" type="text" class="form-control" parsley-trigger="change" required placeholder=""/>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-3 control-label">Correo de Contacto</label>
                      <div class="col-sm-6">
                          <input name="txtEmail" type="email" class="form-control" parsley-trigger="change" required placeholder=""/>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-3 control-label">Mensaje</label>
                      <div class="col-sm-6">
                          <input name="txtMessage" type="text" class="form-control" parsley-trigger="change" required placeholder=""/>
                      </div>
                  </div>
                  <button  class="btn btn-primary waves-effect waves-light"> <i class="fa fa-check m-r-5"></i> <span>Enviar</span> </button>
                </form>
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
