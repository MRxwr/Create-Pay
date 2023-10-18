<?php
require('constants.php');

if ( !isset($_POST["token"]) AND empty($_POST["token"]) ){
	$response['msg']="Please enter device firebase token.";
	echo json_encode($response);die();
}if( !isset($_POST["phone"]) AND empty($_POST["phone"]) ){
	$response['msg']="Please enter user phone number.";
	echo json_encode($response);die();
}else{
	$sql = "UPDATE `firebase`
			SET
			`phone` = '".$_POST["phone"]."'
			WHERE
			`token` LIKE '".$_POST["token"]."'
			";
	$result = $dbconnect->query($sql);
	
	$response['ok'] = true;
	$response['status'] = $succeed;
	$response['msg'] = "Phone number has been updated.";
}

echo json_encode($response);
?>