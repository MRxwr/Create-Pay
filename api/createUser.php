<?php
require('constants.php');

if ( !isset($_POST["name"]) OR $_POST["name"] == ""){
	if ( $lang == 0 ){
		$response['msg']="Please enter customer name.";
	}else{
		$response['msg']="الرجاء إدخال اسم العميل";
	}
	echo json_encode($response);die();
}elseif(!isset($_POST["mobile"]) OR $_POST["mobile"] == ""){
	if ( $lang == 0 ){
		$response['msg']="please enter customer mobile number.";
	}else{
		$response['msg']="الرجاء إدخال هاتف العميل";
	}
	echo json_encode($response);die();
}elseif(!isset($_POST["email"]) OR $_POST["email"] == ""){
	if ( $lang == 0 ){
		$response['msg']="please enter email.";
	}else{
		$response['msg']="الرجاء إدخال البريد الإلكتروني";
	}
	echo json_encode($response);die();
}elseif(!isset($_POST["password"]) OR $_POST["password"] == ""){
	if ( $lang == 0 ){
		$response['msg']="please enter password.";
	}else{
		$response['msg']="الرجاء إدخال كلمة المرور";
	}
	echo json_encode($response);die();
}elseif(!isset($_POST["instagram"]) OR $_POST["instagram"] == ""){
	if ( $lang == 0 ){
		$response['msg']="please enter instagram account.";
	}else{
		$response['msg']="الرجاء إدخال حساب الإنستغرام";
	}
	echo json_encode($response);die();
}elseif(!isset($_FILES["civilIdF"]) OR $_FILES["civilIdF"] == ""){
	if ( $lang == 0 ){
		$response['msg']="please upload civil ID from front.";
	}else{
		$response['msg']="الرجاء إدخال صورة البطاقة المدنية من الأمام";
	}
	echo json_encode($response);die();
}elseif(!isset($_FILES["civilIdB"]) OR $_FILES["civilIdB"] == ""){
	if ( $lang == 0 ){
		$response['msg']="please upload civil ID from back.";
	}else{
		$response['msg']="الرجاء إدخال صورة البطاقة المدنية من الخلف";
	}
	echo json_encode($response);die();
}elseif(!isset($_FILES["profileImage"]) OR $_FILES["profileImage"] == ""){
	if ( $lang == 0 ){
		$response['msg']="please upload your logo.";
	}else{
		$response['msg']="الرجاء إدخال شعار الشركة";
	}
	echo json_encode($response);die();
}elseif(!isset($_FILES["instaProfile"]) OR $_FILES["instaProfile"] == ""){
	if ( $lang == 0 ){
		$response['msg']="please upload instagram profile screenshot.";
	}else{
		$response['msg']="الرجاء إدخال صورة من حساب الإنستغرام";
	}
	echo json_encode($response);die();
}

$name = $_POST["name"];
$mobile = $_POST["mobile"];
$email = $_POST["email"];
$password = sha1($_POST["password"]);
$instagram = $_POST["instagram"];
if ( !isset($_POST["token"]) OR empty($_POST["token"]) ){
	$token = "";
}else{
	$token = $_POST["token"];
}
if( is_uploaded_file($_FILES['profileImage']['tmp_name']) ){
	$directory = "../logos/";
	$originalfile = $directory . date("d-m-y") . time() . rand(111111,999999) . ".png";
	move_uploaded_file($_FILES["profileImage"]["tmp_name"], $originalfile);
	$profileImage = str_replace("../logos/",'',$originalfile);
}
if( is_uploaded_file($_FILES['civilIdB']['tmp_name']) ){
	$directory = "../logos/";
	$originalfile = $directory . date("d-m-y") . time() . rand(111111,999999) . ".png";
	move_uploaded_file($_FILES["civilIdB"]["tmp_name"], $originalfile);
	$civilIdB = str_replace("../logos/",'',$originalfile);
}
if( is_uploaded_file($_FILES['civilIdF']['tmp_name']) ){
	$directory = "../logos/";
	$originalfile = $directory . date("d-m-y") . time() . rand(111111,999999) . ".png";
	move_uploaded_file($_FILES["civilIdF"]["tmp_name"], $originalfile);
	$civilIdF = str_replace("../logos/",'',$originalfile);
}
if( is_uploaded_file($_FILES['instaProfile']['tmp_name']) ){
	$directory = "../logos/";
	$originalfile = $directory . date("d-m-y") . time() . rand(111111,999999) . ".png";
	move_uploaded_file($_FILES["instaProfile"]["tmp_name"], $originalfile);
	$instaProfile = str_replace("../logos/",'',$originalfile);
}

$sql = "SELECT 
		* 
		FROM 
		`clients` 
		WHERE 
		`email` LIKE '".$email."' 
		";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
if ( $result->num_rows == 1 ){
	if ( $lang == 0 ){
		$response['msg']="This user email already exist. please choose another.";
	}else{
		$response['msg']="هذا البريد الإلكتروني مسجل لدينا سابقا ، الرجاء التسجيل إختيار بريد إلكتوني آخر";
	}
	echo json_encode($response);die();
}
$sql = "INSERT INTO 
		`clients`
		(`date`, `fullName`, `email`, `password`, `civilIdF`, `civilIdB`, `instaA`, `phone`, `imageurl`, `instaProfile`, `token`) 
		VALUES 
		('".$realDate."', '".$name."', '".$email."', '".$password."', '".$civilIdF."', '".$civilIdB."', '".$instagram."', '".$mobile."', '".$profileImage."', '".$instaProfile."', '".$token."')
		";
$result = $dbconnect->query($sql);

$last_id = $dbconnect->insert_id;

$sql = "INSERT INTO 
		`firebase`
		(`token`, `userId`, `phone`) 
		VALUES 
		('".$token."', '".$last_id."', '".$mobile."')
		";
$result = $dbconnect->query($sql);

if ( $result == 1 ){
	$response['ok'] = true;
	$response['status']= $succeed;
	if ( $lang == 0 ){
		$response['msg']="Your account has been created successfully, and in need of approval. we will contact you soon.";
	}else{
		$response['msg']="تم إنشاء حسابكم بنحاج، و هو بإنتظار الموافقة عليه من الفريق الإداري ، سنتواصل معكم قريبا";
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