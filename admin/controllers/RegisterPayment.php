<?php
	require_once("../models/PlanClients.php");
  require_once("../models/Clients.php");
  require_once("../models/Users.php");

	//Obtener la información de la sección proveniente del formulario
  $plan = new PlanClients();
  $plan->setDoctorId($_GET["doctorID"]);
  $plan->setPlanId($_GET['planId']);
	$result = $plan->CreatePlanClient();

  if(isset($result))
	   echo"Exito";
  else
    echo "Fallo";
?>
