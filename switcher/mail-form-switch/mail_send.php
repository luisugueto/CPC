<?php 
require_once('phpMailer/class.phpmailer.php');
require_once('../functions.php');

function sendEmail($Subject,$FromEmail,$FromName,$ToEmail,$ToName,$CC,$BCC,$Reply,$Template,$formData){
	$result = "#0001";
	//Alt Content
	$altBodyContent = "";
	if(file_exists($Template)){
		$altBodyContent = file_get_contents($Template);
		$altBodyContent = strip_tags($altBodyContent, '<br>');
		$altBodyContent = str_replace("<br>", "/n", $altBodyContent);
	}
	$FromEmail = emailFormater($FromEmail);

	if($FromEmail != ""){
		$mail = new PHPMailer(); // defaults to using php "mail()"
		$mail->SetFrom($FromEmail,$FromName);
		$mail->AddAddress($FromEmail,$FromName);
		$mail->AltBody = $altBodyContent; // optional, comment out and test
		$mail->MsgHTML(include($Template));
		
		if($CC != ""){
			$CC = $CC.',';
			$CC = explode(",",$CC);
			if(is_array($CC)){
				foreach($CC as $item){
					$item = emailFormater($item);
					if($item != ""){$mail->AddAddress($item);}
				}	
			}else{
				$item = emailFormater($CC);
				if($item != ""){$mail->AddAddress($item);}
			}
		}
		if($BCC != ""){
			$BCC = $BCC.',';
			$BCC = explode(",",$BCC);
			if(is_array($BCC)){
				foreach($BCC as $item){
					$item = emailFormater($item);
					if($item != ""){$mail->AddBCC($item);}
				}	
			}else{
				$item = emailFormater($BCC);
				if($item != ""){$mail->AddBCC($item);}
			}
		}
		if($ToEmail != ""){
			$ToEmail = $ToEmail.',';
			$ToEmail = explode(",",$ToEmail);
			if(is_array($ToEmail)){
				foreach($ToEmail as $item){
					$item = emailFormater($item);
					if($item != ""){$mail->AddAddress($item);}
				}	
			}else{
				$item = emailFormater($BCC);
				if($item != ""){$mail->AddAddress($item);$mail->AddReplyTo($item);}
			}
		}else{
			$mail->AddBCC('errorlog@waloja.com');
		}
		
		if($Reply != ""){
			$Reply = $Reply.',';
			$Reply = explode(",",$Reply);
			$ReplyEmail = emailFormater($Reply[0]);
			if($ReplyEmail != ''){$mail->AddReplyTo($ReplyEmail);}
		}
		
		$mail->Subject = $Subject;
		$mail->CharSet = 'UTF-8';
		
		//Funcion enviar correo
		if(!$mail->Send()) {
			$result = "#34134";
		}else{
			$result = "ok";
		}
	}else{
	  $result = "#34103";
	}
	return $result;
}


//***************** OBTENEMOS DATOS **************//
//Generales
$FromEmail = "directorio@cirugiaplasticacolombia.com";
$FromName = 'CirugiaPlasticaColombia.com';

//Datos del switch
if(isset($_POST['site']["value"]) && $_POST['site']["value"] != ""){
	$site = unserialize(base64_decode($_POST['site']["value"]));
	$switchToName = $site['ToName'];
	$switchToEmail = $site['ToEmail'];
	
	$switchCCO = '';
	if(isset($site['CCO']) && $site['CCO'] != ''){
		$switchCCO = multiEmailFormater($site['CCO']);
	}
}

//Datos del formulario
$formData = array();
$formData['switchToName'] = $switchToName;
foreach($_POST as $key => $value){
	if($key != 'id' or $key != 'site'){
		if(isset($value['showtitle']) && $value['showtitle'] != ""){
			switch ($key) {
				case "email":
					$formData[$key]['value'] = emailFormater($value['value']);
					break;
				case "name":
				case "city":
					$formData[$key]['value'] = ucwords(strtolower($value['value']));
					break;
				case "comments":
					$formData[$key]['value'] = $value['value'];
					break;
				default:
					$formData[$key]['value'] = $value['value'];
					break;
			}
			$formData[$key]['showtitle'] = ucwords(strtolower($value['showtitle']));
			$formData['content'][] = $formData[$key];
		}else{
			$formData[$key]['value'] = $value['value'];
		}
	}
}
//Definimos Varibables del Form
$formDataToName = "";
$formDataToEmail = '';
if(isset($formData['name']['value']) && $formData['name']['value']  != ""){
	$formDataToName = $formData['name']['value'];
}
if(isset($formData['email']['value']) && $formData['email']['value']  != ""){
	$formDataToEmail = $formData['email']['value'];
	if($formDataToName == ""){
		$formDataToName = $formData['email']['value'];
	}
	
	//ENVIAR A REMITENTE
	$Subject = "Gracias por contactar a ".$switchToName;
	$ToEmail = $formDataToEmail;
	$ToName = $formDataToName;
	$CC = "";
	$BCC = "";
	$Reply = $FromEmail;
	$Template = "mail_template_remitente.php";
	$EnviarRemitente = sendEmail($Subject,$FromEmail,$FromName,$ToEmail,$ToName,$CC,$BCC,$Reply,$Template,$formData);
	// ------ 
}


//ENVIAR A DESTINATARIO
if(isset($formData) && $formData != ''){
	$Subject = $formDataToName." te ha contactado desde nuestro portal";
	$ToEmail = $switchToEmail;
	$ToName = $switchToName;
	$CC = '';
	$BCC = $switchCCO;
	$Reply = $formDataToEmail;
	$Template = "mail_template_destinatario.php";
	$EnviarDestinatario = sendEmail($Subject,$FromEmail,$FromName,$ToEmail,$ToName,$CC,$BCC,$Reply,$Template,$formData);
}else{
	$EnviarDestinatario = 'Error: #342423';
}
// ------ 


//Enviamos datos a API externo
if(isset($formData['content']) && $formData['content'] != ''){
	$varArray = array(
		'switch_id' => $site['switch_id'],
		'ip' => $_SERVER['REMOTE_ADDR'],
		'data_form' => base64_encode(serialize($formData['content']))
	);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://dooplamarketing.com/dooplatools/feed/api-save-form.php');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($varArray));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
}


if($EnviarDestinatario != ""){
	if($EnviarDestinatario == "ok") {
	  $alertMessage= "<strong>¡Felicitaciones!</strong><br>Tu mensaje ha sido enviado correctamente al correo de:<h4><strong>".$switchToName."</strong></h4>";
	  $alertClass = "alert-success";
	}else{
	  $alertMessage = "<strong>Error</strong><br>No se pudo enviar tu mensaje, por favor intenta de nuevo.<br>Error:".$EnviarDestinatario."";
	  $alertClass = "alert-danger";
	}
}else{
	$alertMessage = "";
	$alertClass = "";
}
?>


<?php if($alertMessage != "" && $alertClass != ""){?>
<div class="alert <?php echo $alertClass; ?> text-center">
  <?php echo $alertMessage; ?>
</div>
<?php }?>
<a href="http://doopla.co" target="_blank">
<img src="switcher/banner-doopla-728-90.jpg" class="img-responsive" alt="Doopla Marketing">
</a>