<?php
	require_once("../models/Articles.php");

	//Obtener la información de la sección proveniente del formulario
	$article = new Articles();
	$article->setArticleId($_GET["articleId"]);
	$article->setStatusId($_GET["statusId"]);
	
	//Guardar Categoría en la BD
	$result = $article->UpdateArticleStatus();

	$array = array("result" => $result);

	echo json_encode($array);
?>