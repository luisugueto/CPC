<?php

require_once("../includes/functions.php");

$apiKey = "2rckmqh47vn40optfgon816ghf";

$merchantId = "504777";

$amount = $_GET['amount'];
$code = generarCodigo(9);
$referenceCode = "PCPC-".$code;

$currency = "COP";

$firma_digital = $apiKey."~".$merchantId."~".$referenceCode."~".$amount."~".$currency;

$signature = md5($firma_digital);

$obj = [];

$obj['amount'] = $amount;
$obj['referenceCode'] = $referenceCode;
$obj['signature'] = $signature;

echo json_encode($obj);

?>
