<?php
	require_once("../models/Plans.php");

	//Obtener la información de la sección proveniente del formulario
  $plan = new Plans();
  $plan->setPlanId($_GET['planId']);
	$planList = $plann = $plan->GetPlanContent();

	echo json_encode($planList);
?>
