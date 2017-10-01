<?php
	require_once("../models/Articles.php");

	//Obtener la información de la sección proveniente del formulario
	$article = new Articles();
	$article->setArticleId($_POST["hdArticleId"]);
	$article->setTitle($_POST["txtTitle"]);
	$article->setContent(base64_decode($_POST["content"]));
	$article->setMetaDescription($_POST["txtMetaDescription"]);
	$article->setMetaTitle($_POST["txtMetaTitle"]);
	$article->setStatusId($_POST["status"]);
	$article->setPublishDate($_POST["txtPublishDate"]);
	$article->setAuthor($_POST["hdAuthor"]);
	$article->setSlug($_POST["slug-article"]);
	$article->setPhoto($_POST["hdActualImage"]);

	if ($_POST["txtAltPhotos"] == "")
	{
		$article->setAltPhotos($_POST["txtTitle"]);
	}
	else
	{
		$article->setAltPhotos($_POST["txtAltPhotos"]);
	}

	$article->setTags($_POST["txtTags"]);

	if ($_FILES['imgSlide']['name'] != NULL)
	{
		$alowedExt = array("jpg","png","gif");

		//Obtener la extensión del archivo
		$explode = explode(".",$_FILES['imgSlide']["name"]);
		$fileExt = end($explode);

		//Crear String aleatorio de 10 caracteres para asignarlo al nombre de la foto
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$charactersLength = strlen($characters);
		$randomString = '';

		for ($i = 0; $i < 3; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}

		$_FILES['imgSlide']['name'] = $randomString."_".slugify($_FILES['imgSlide']['name']);

		//Obtener el nombre del archivo
		$article->setPhoto($_FILES['imgSlide']["name"]);

		//Validar si la extensión del archivo esta permitido
		if (in_array($fileExt,$alowedExt))
		{
			$folder = "../../images/blog/";
			$ruta = $_FILES['croppedImage']["tmp_name"];
			$file = $article->getPhoto();
			$destino = $folder.$file;
			//Validar si el archivo ya existe en la carpeta
			if(!file_exists($destino))
			{

				$image = $_FILES['croppedImage']['tmp_name'];

				$original_info = getimagesize($image);

				if ($original_info['mime'] == 'image/jpeg')
				{
					$original_img = imagecreatefromjpeg($image);
				}
				elseif ($original_info['mime'] == 'image/gif')
				{
					$original_img = imagecreatefromgif($image);
				}
				elseif ($original_info['mime'] == 'image/png')
				{
					$original_img = imagecreatefrompng($image);
				}

				$width = imagesx($original_img);
				$height = imagesy($original_img);

				$default_width = 1024;

				if ($width > $default_width) {
					$percent = $default_width / $width;
					$new_width = $width * $percent;
					$new_height = $height * $percent;
				}

				$percent = $default_width / $width;
				$new_width = $width * $percent;
				$new_height = $height * $percent;

				$thumb = imagecreatetruecolor( $new_width, $new_height );
				imagecopyresampled($thumb, $original_img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				imagejpeg($thumb, $image, 80);
				move_uploaded_file($ruta, $destino);
			}
		}
	}

	$categories = json_decode($_POST["categories"]);

	//Editar Slide en la BD
	$result = $article->UpdateArticle();

	if($result == "exito")
	{

		$lastArticleId = $_POST["hdArticleId"];

		if ($categories != "")
		{
			$article->DeleteArticleCategories($lastArticleId);
			for ($i = 0; $i < count($categories); $i++)
			{
				$article->SaveCategoryByArticle($lastArticleId, $categories[$i]);
			}
		}

		//Mostrar alerta al guardar correctamente
		echo "exito";
	}
	else
	{
		//Mostrar alerta al no guardar
		echo "error";
	}

	function slugify($cadena)
	{
		// Convertimos la cadena a minusculas
		$cadena = strtolower($cadena);

		// Remplazo tildes y eñes
		$unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y');
		$cadena = strtr( $cadena, $unwanted_array );

		// Remplazo cuarquier caracter que no este entre A-Za-z0-9 por un espacio vacio
		$cadena = trim(preg_replace("#[^a-z\s-\.]#i", "", $cadena));

		// Eliminamos espacios en blanco y cambiamos por separador
		$cadena = str_replace(" ", "-", $cadena);

		return $cadena;
	}
?>
