<?php
require('constants.php');
function newOrderNoti($orderInfo){
	GLOBAL $dbconnect;
	$sRef = $orderInfo["refference"];
	$details = $orderInfo["details"];
	$price = $orderInfo["price"];
	$sql = "SELECT * FROM `firebase` WHERE `sRef` LIKE '".$sRef."' ";
	$result = $dbconnect->query($sql);
	while($row = $result->fetch_assoc() ){
		$to = $row["token"];
		$title = "New Order";
		$body = "You have a new order #{$details} with total of " . $price . "KD";
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS =>'{
				"to" : "'.$to.'",
				"notification" : {
					"title": "'.$title.'",
					"body" : "'.$body.'",
					"sound": "default",
					"badge" : "1"
				},
				"data" : {
					"title": "'.$title.'",
					"body" : "'.$body.'",
					"content_available":"true",
					"priority":"high",
					"click_action":"FLUTTER_NOTIFICATION_CLICK",
					"sound": "default"
				}
			}',
			CURLOPT_HTTPHEADER => array(
					'Authorization: key=AAAAoNHb8QE:APA91bEhs2weltPu2RqIXKmMdHcUtdf7p7LUuYWwHRgYbSJUsaxfTnbpQdfDR-pQXyPDgI1fkHO0ifV8yfDYADQJ2Rl0sEw2Wvh7bYPiq5uynHlksfUxN-36JFvb0dP2cbQBU3zJaF-L',
					'Content-Type: application/json'
				),
			)
		);
		$response = curl_exec($curl);
		curl_close($curl);
	}
}
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
}elseif(!isset($_POST["price"]) OR $_POST["price"] == ""){
	if ( $lang == 0 ){
		$response['msg']="please enter price.";
	}else{
		$response['msg']="الرجاء ادخال المبلغ";
	}
	echo json_encode($response);die();
}

if ( isset($_POST["email"]) ){
	$email = $_POST["email"];
}else{
	$email = "";
}

if ( isset($_POST["details"]) ){
	$details = $_POST["details"];
}else{
	$details = "";
}

if ( isset($_POST['refference']) ){
	$sql = "SELECT 
			`sCode`,`commission`
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
		echo json_encode($response);
		die();
	}
	$row = $result->fetch_assoc();
	$supplierCode = $row["sCode"];
	$commission = $row["commission"];
}else
{
	if ( $lang == 0 ){
		$response['msg']="Please enter user refference code.";
	}else{
		$response['msg']="الرجاء ادخل رمز العميل";
	}
	
	echo json_encode($response);die();
}
$name = $_POST["name"];
$mobile = $_POST["mobile"];
$price = ((float)$_POST["price"]);
if( isset($_POST["noti"]) && $_POST["noti"] == 1 ){
	$status = "1";
}else{
	$status = "0";
}
$linkCode = md5(uniqid(rand().$supplierCode.date("y-m-d h:i:s"), true));
$orderId = $details;
$sql = "INSERT INTO 
		`invoices`
		(`date`,`name`, `email`, `mobile`,`price`, `status`, `linkCode`,`supplierCode`, `orderId`, `details`, `sRef`) 
		VALUES 
		('".$realDate."', '".$name."','".$email."','".$mobile."','".$price."','".$status."','".$linkCode."','".$supplierCode."','".$orderId."','".$details."', '".$_POST['refference']."')";
$result = $dbconnect->query($sql);
if( isset($_POST["noti"]) ){
	newOrderNoti($_POST);
}
if ( $result == 1 ){
	$response['ok'] = true;
	$response['status']= $succeed;
	if ( $lang == 0 ){
		$response['msg']="Invoice created successfully.";
	}else{
		$response['msg']="تم إنشاء الفاتورة بنجاح";
	}
	$response['details']['Link'] = $baseUrl . $linkCode;
}else{
	$response['ok'] = false;
	$response['status']= $error;
	if ( $lang == 0 ){
		$response['msg']="something went wrong please check your information.";
	}else{
		$response['msg']="حصل خطأ في ادخال المعلومات الرجاء التأكد و المحاولة من جديد";
	}
	
}

echo json_encode($response);

?>