<?php
	require_once("../models/SubCategories.php");

	//Obtener la información de la sección proveniente del formulario
  $subcategories = new SubCategories();
	$subcategoriesList = $subcategories->GetCategoryContent($_GET['id']);

	echo json_encode($subcategoriesList);
?>
