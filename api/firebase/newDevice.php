<?php
require('constants.php');

if ( !isset($_POST["token"]) AND empty($_POST["token"]) ){
	$response['msg']="Please enter device firebase token.";
	echo json_encode($response);die();
}else{
	
	$sql = "INSERT INTO `firebase`
			(`token`)
			VALUES
			('".$_POST["token"]."')
			";
	$result = $dbconnect->query($sql);
	
	$response['ok'] = true;
	$response['status'] = $succeed;
	$response['msg'] = "Device token has been added.";
}

echo json_encode($response);
?>