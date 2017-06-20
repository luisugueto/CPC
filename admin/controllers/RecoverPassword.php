<?php
	require_once("../models/Users.php");
	include("../includes/functions.php");
	require '../PHPMailer/class.phpmailer.php';

	$users = new Users();
	$users->setEmail($_POST['recovery_email']);
	$result = $users->VerifyMail();

	if ($result != "fallo")
	{
		//Crear nueva contraseña aleatoria y asignarla al usuario.
		$newPassword = substr(str_shuffle(str_repeat("0123456789aAbBcdDeEfghHijkKlmMnNopqrRstuUvwxyz", 5)), 0, 7);
		$user_password = encrypt_decrypt("encrypt", $newPassword);
		$users->setPassword($user_password);
		$users->ShuffleNewPassword();

		$mail = new PHPMailer;
		$mail->setFrom('info@menudeldia.com', 'Menú del día.');
		$mail->addReplyTo('info@menudeldia.com', 'Menú del día.');
		$mail->addAddress($_POST['recovery_email']);
		$mail->isHTML(true);
		$mail->CharSet = 'UTF-8';

		$mail->Subject = 'Tu nueva contraseña de acceso al CRM';
		$mail->Body = '
			<html>
				<head>
				</head>
				<body>
					<table width="100%" cellpadding="10" cellspacing="0" style="color:#333; background-color: #fcfcfc; max-width:728px; text-align:left;">
						<tr >
							<td align="left" style="font-family:Arial, Helvetica, sans-serif; text-align:left; font-size:13px; padding:20px;">
								<span style="font-size:20px;"><strong>Nueva contraseña</strong></span><br>
								<br>
								Hola,
								<br/>
								Estos son tus nuevos datos de acceso a tu cuenta en el CRM:
								<br/><br/>
								<br/>
								<b>Login:</b> <a href="http://www.menudeldia.co/acceso" target="_blank">www.menudeldia.co/acceso</a></strong>
								<br/>
								<b>Usuario:</b>'.$_POST['recovery_email'].'
								<br/>
								<b>Contraseña:</b>'.$newPassword.'
								<br/><br/>
							</td>
						</tr>
						<tr>
							<td style="background:#f4f4f4; font-family:Arial, Helvetica, sans-serif; font-size:13px;  text-align:left;  padding:20px;">
								<strong><a href="http://www.menudeldia.co/acceso" target="_blank">menudeldia.co/acceso</a></strong>
								<br>
								<span style="font-size:10px;">
								Este es un correo automático enviado a <a href="mailto:'.$_POST['recovery_email'].'" target="_blank">'.$_POST['recovery_email'].'</a>, por favor no responda este correo.</span>
							</td>
						</tr>
					</table>
				</body>
			</html>
		';
			if(!$mail->send())
			{
				//Si no envia el correo, avisar de error.
				echo $newPassword;
			}
			else
			{
				//Si envia el correo, notificar al usuario.
				echo "exito";
			}
	}
	else
	{
		//Si no devuelve resultado, no existe el correo.
		echo "error";
	}

?>