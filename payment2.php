<?php
session_start();
header('Content-type: application/json');
require("admin/includes/config.php");

$check = ["'",'"',")","(",";","?",">","<","~","!","#","$","%","^","&","*","-","_","=","+","/","|",":"];

$paymentId = $_POST["paymentId"];
$paymentMethod = $_POST["paymentMethod"];

$sql = "SELECT *
		FROM `invoices`
		WHERE `linkCode` LIKE '".$paymentId."'";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
$name = $row["name"];
$email = $row["email"];
$mobile = str_replace($check, "", $row["mobile"]);
$price = $row["price"];
$supplierCode = $row["supplierCode"];

$sql = "SELECT *
		FROM `clients`
		WHERE `sCode` LIKE '".$supplierCode."'";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
$PaymentAPIKey = $row["payAPIToken"];

if ( $row["commission"] == 0 ){
	$commission = 0;
}else{
	$commission = $row["commission"] + 0.150;
}

if ( empty($email) ){
	$email = $row["email"];
}

if ( $paymentMethod == 2 ){
	$realCommission = $commission - 0.15;
	//$price = $price - $commission;
	$price = $price + ($price * 2.5 / 100);
	$price = $price + $commission;
}elseif( $paymentMethod == 1 ){
	$price = $price + $commission;
}

$postMethodLines = array(
"endpoint" 				=> "PaymentRequestExicuteForStore",
"apikey" 				=> "{$PaymentAPIKey}",
"PaymentMethodId" 		=> "{$paymentMethod}",
"CustomerName"			=> "{$name}",
"DisplayCurrencyIso"	=> "KWD", 
"MobileCountryCode"		=> "+965", 
"CustomerMobile"		=> substr($mobile,0,11),
"CustomerEmail"			=> $email,
"invoiceValue"			=> $price,
"SourceInfo"			=> '',
"CallBackUrl"			=> 'https://createpay.link/checkout.php',
"ErrorUrl"				=> 'https://createpay.link/checkout.php?status=fail'
);

####### Execute payment ###### 
for( $i =0; $i < 10; $i++){
	$curl = curl_init();
	$headers  = [
				'Content-Type:application/json'
			];
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://payapi.createkwservers.com/api/v2/index.php',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_POST => 1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => json_encode($postMethodLines),
	  CURLOPT_HTTPHEADER => $headers,
	));
	$response = curl_exec($curl);
	curl_close($curl);
	$resultMY = json_decode($response, true);
	//echo json_encode($resultMY);die();

	if(isset($resultMY["data"]["InvoiceId"])){
		$orderId = $resultMY["data"]["InvoiceId"];
		if ( !isset($orderId) || empty($orderId) ){
			$sql = "INSERT INTO `logs`
					(`response`, `linkCode`, `status`)
					VALUES
					('".json_encode($resultMY)."', '".$paymentId."', '1')
					";
			$result = $dbconnect->query($sql);
		}
		$sql = "INSERT INTO `logs`
				(`response`, `linkCode`, `status`)
				VALUES
				('".json_encode($resultMY)."', '".$paymentId."', '0')
				";
		$result = $dbconnect->query($sql);
		$sql = "UPDATE `invoices` 
				SET
				`orderId` = '".$orderId."'
				WHERE 
				`linkCode` LIKE '".$paymentId."'
				";
		$result = $dbconnect->query($sql);
		header("LOCATION: " . $resultMY["data"]["PaymentURL"]);
		break;
	}
}
if( !isset($resultMY["data"]["InvoiceId"]) ){
	header("LOCATION: checkout.php?LinkId=" . $paymentId);die();
}
?>