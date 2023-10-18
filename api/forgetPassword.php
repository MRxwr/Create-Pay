<?php
require('constants.php');

if(!isset($_POST["email"]) OR $_POST["email"] == ""){
	if ( $lang == 0 ){
		$response['msg']="please enter email.";
	}else{
		$response['msg']="الرجاء إدخال البريد الإلكتروني";
	}
	echo json_encode($response);die();
}

$email = $_POST["email"];
$randomPass = uniqid();
$password = sha1($randomPass);

$sql = "SELECT
		*
		FROM
		`clients`
		WHERE
		`email` LIKE '".$email."'
		";
$result = $dbconnect->query($sql);
if ( $result->num_rows == 0 ){
	if ( $lang == 0 ){
		$response['msg']="No client with this email.";
	}else{
		$response['msg']="لا يوجد عميل مسجل بهذا البريد الإلكتروني";
	}
	echo json_encode($response);die();
}

$sql = "UPDATE
		`clients`
		SET
		`password` = '".$password."'
		WHERE
		`email` LIKE '".$email."'
		";
$result = $dbconnect->query($sql);
if ( $result == 1 ){
	$response['ok'] = true;
	$response['status']= $succeed;
	if ( $lang == 0 ){
		$response['msg']="A new temprory password has been emailed to you.";
	}else{
		$response['msg']="تم ارسال كلمة مرور مؤقته على بريدكم الإلكتروني";
	}
	require('email.php');
}else{
	$response['ok'] = false;
	$response['status']= $error;
	if ( $lang == 0 ){
		$response['msg']="something went wrong please check your information.";
	}else{
		$response['msg']="حصل خطأ بالمعلومات المدخله ، الرجاء التأكد منها و المحاولة من جديد";
	}
}

echo json_encode($response);

?>