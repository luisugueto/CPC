<?php 
$customSiteUrl = "cirugiaplasticacolombia.com";

$siteDataEncrypted = '';
function getApiData($url){ 
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_HTTPGET, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json','Accept: application/json'));
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}

function encrypt_decrypt($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = '6655939';
    $secret_iv = '6655939iv';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

function emailFormater($email){
	$cleanEmail = strtolower($email);
	$cleanEmail = str_replace(" ", "",$cleanEmail);
	$cleanEmail = filter_var($cleanEmail, FILTER_SANITIZE_EMAIL);
	if(!filter_var($cleanEmail, FILTER_VALIDATE_EMAIL) === false) {
		$resultEmail = $cleanEmail;
	}else{
		$resultEmail = $cleanEmail;
	}
	return $resultEmail;
}

function emailFormater2($email){
	$result = "";
	$cleanEmail = $email;
	$cleanEmail = str_replace(" ", "",$cleanEmail);
	$cleanEmail = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $cleanEmail
    );

    $cleanEmail = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $cleanEmail
    );

    $cleanEmail = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $cleanEmail
    );

    $cleanEmail = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $cleanEmail
    );

    $cleanEmail = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $cleanEmail
    );

    $cleanEmail = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C'),
        $cleanEmail
    );
	$cleanEmail = strtolower($cleanEmail);
	
	$cleanEmail = filter_var($cleanEmail, FILTER_SANITIZE_EMAIL);
	if(!filter_var($cleanEmail, FILTER_VALIDATE_EMAIL) === false) {
		$result = $cleanEmail;
	}else{
		$result = '';
	}
	return $result;
}

function multiEmailFormater($string){
	$result = '';
	if($string != ''){
		$string .= ',';
		$string = str_replace(' ','',$string);
		$string = str_replace(';',',',$string);
		$stringArr = explode(',',$string.',');
		if(is_array($stringArr)){
			foreach($stringArr as $item){
				$item = emailFormater2($item);
				if($item != ""){
					$result .= $item.',';
				}
			}	
		}
	}
	return rtrim($result, ",");
}



function LpCustomField($Field,$CustomFields){
	$result="";
	foreach($CustomFields as $field){
		if($field['icon'] == $Field){
			$result = $field['value'];
		}
	}
	return $result;
}
?>