<?php
header('Content-type: application/json');
date_default_timezone_set('Asia/Riyadh');
$realDate = date("Y-m-d H:i:s");
$onlyDate = date("Y-m-d");
include_once ("../../admin/includes/config.php");
$response = array();
$ok = true;
$succeed = 200;
$error = 404;
$baseUrl = "https://".$_SERVER["HTTP_HOST"]."/checkout.php?LinkId=";
$response['ok'] = false;
$response['status']= $error;

if ( isset(getallheaders()["APPKEY"]) ){
	$headerAPI =  getallheaders()["APPKEY"];
}else{
	$headerAPI = "";
}

if ( $headerAPI != "API123" ){
	$response['msg']="Please check your appkey";
}

if ( isset($_GET["languageId"]) AND $_GET["languageId"] == 1 ){
	$lang = 1;
}else{
	$lang = 0;
}

?>