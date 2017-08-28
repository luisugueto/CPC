<?php
	require_once("models/Articles.php");
	include("includes/functions.php");

	$articles = new Articles();

	if(!isset($_POST['action']))
	{
		$_POST['action'] = '';
	}
	if(isset($_POST['id']))
	{
		$id = $_POST['id'];
	}
	elseif(isset($_POST['ArticleId']))
	{
		$id = $_POST['ArticleId'];
	}
	else
	{
		$id = '0';
	}

	if($id != '')
	{
		switch ($_POST['action'])
		{
			// Eliminar post
			case 'delete':
				if($id != '0')
				{
					$articles->setArticleId($id);
					echo json_encode($articles->DeleteArticle());
                    exit();
				}
			break;
		}
	}

?>