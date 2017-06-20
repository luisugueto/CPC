<?php

	function encrypt_decrypt($action, $string)
	{
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'jsjh84238d238hdwjegd834hd';
		$secret_iv = 'jsjh842iv38d238hdwjegd834hd';
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		if($action == 'encrypt')
		{
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		}
		else if($action == 'decrypt')
		{
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
		return $output;
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

	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
	{
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

		switch ($theType)
		{
			case "text":
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
			break;  

			case "long":

			case "int":
				$theValue = ($theValue != "") ? intval($theValue) : "NULL";
			break;

			case "double":
				$theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
			break;

			case "date":
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
			break;

			case "defined":
				$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
			break;
		}

		return $theValue;
	}

?>