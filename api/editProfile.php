<?php
require('constants.php');

if(!isset($_POST["password"]) OR $_POST["password"] == ""){
	if ( $lang == 0 ){
		$response['msg']="please enter old password.";
	}else{
		$response['msg']="الرجاء إدخال كلمة المرور القديمة";
	}
	echo json_encode($response);die();
}elseif(!isset($_POST["newPassword"]) OR $_POST["newPassword"] == ""){
	
	if ( $lang == 0 ){
		$response['msg']="please enter new password.";
	}else{
		$response['msg']="الرجاء إدخال كلمة المرور الجديدة";
	}
	echo json_encode($response);die();
}

if(!isset($_POST["refference"]) OR $_POST["refference"] == ""){
	if ( $lang == 0 ){
		$response['msg']="Please enter reffrence code.";
	}else{
		$response['msg']="الرجاء إدخال رمز العميل";
	}
	echo json_encode($response);die();
}else{
	$sql = "SELECT 
			`sCode`
			FROM 
			`clients` 
			WHERE 
			`sRef` LIKE '".$_POST['refference']."'
			";
	$result = $dbconnect->query($sql);
	if ( $result->num_rows == 0 ){
		if ( $lang == 0 ){
			$response['msg']="No user with this refference code.";
		}else{
			$response['msg']="لا يوجد مستخدم لرمز المرجع المدخل";
		}
		echo json_encode($response);die();
	}else{
		$sql = "SELECT 
				`sCode`
				FROM 
				`clients` 
				WHERE 
				`sRef` LIKE '".$_POST['refference']."'
				AND
				`password` LIKE '".sha1($_POST['password'])."'
				";
		$result = $dbconnect->query($sql);
		if ( $result->num_rows == 0 ){
			if ( $lang == 0 ){
				$response['msg']="Your old password is not matching this account password, Please type in the correct password.";
			}else{
				$response['msg']="كلمة المرور القديمة لا تتطابق مع المسجلة لدينا ، الرجاء إدخالها بشكل صحيح و المحاولة من جديد";
			}
			echo json_encode($response);die();
		}
	}
}

$password = sha1($_POST["newPassword"]);
$refCode = $_POST["refference"];
$sql = "UPDATE
		`clients`
		SET
		`password` = '".$password."'
		WHERE
		`sRef` LIKE '".$refCode."'
		";
$result = $dbconnect->query($sql);
if ( $result == 1 ){
	$response['ok'] = true;
	$response['status']= $succeed;
	if ( $lang == 0 ){
		$response['msg']="Your password has been updated successfully.";
	}else{
		$response['msg']="تم تغيير كلمة المرور بنجاح";
	}
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