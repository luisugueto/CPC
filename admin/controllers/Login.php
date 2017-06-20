<?php
	require_once("../models/Users.php");
	include("../includes/functions.php");

	$users = new Users();
	$users->setEmail($_POST["login_email"]);
	$user_password = encrypt_decrypt("encrypt", $_POST["login_password"]);
	$users->setPassword($user_password);

	// Si inicia sesión
	if ($users->Login())
	{
		//Crear cookies de sesión
		if ($_POST["remember"] == "1")
		{
			//Si marcó recordarme en el login, la cookie durará 1 año
			setcookie('UserId', $users->getUserId(), time()+60*60*24*365, "/");
			setcookie('UserName', $users->getName(), time()+60*60*24*365, "/");
		}
		else
		{
			//Si, no marcó recordarme en el login, la cookie durará 1 día
			setcookie('UserId', $users->getUserId(), 60*60*24+time(), "/");
			setcookie('UserName', $users->getName(), 60*60*24+time(), "/");
		}
		
		//Si inicia sesion, entrar al administrador.
		echo "exito";
	}
	else
	{
		//Si la contraseña no es valida, volver al Inicio de Sesion.
		echo "error";
	}
?>