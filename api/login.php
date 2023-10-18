<?php
require('constants.php');

if( !isset($_POST['email']) OR $_POST['email'] == ""){
	if ( $lang == 0 ){
		$response['msg']="Please enter customer name.";
	}else{
		$response['msg']="الرجاء إدخال اسم العميل";
	}
	echo json_encode($response);die();
}elseif( !isset($_POST['password']) OR $_POST['password'] == "" ){
	if ( $lang == 0 ){
		$response['msg']="please enter password.";
	}else{
		$response['msg']="الرجاء إدخال كلمة المرور";
	}
	echo json_encode($response);die();
}else{
	$response['ok'] = true;
	$email = $_POST["email"];
	$password = $_POST["password"];
	$password = sha1($password);
	if ( !isset($_POST["token"]) OR empty($_POST["token"]) ){
		$token = "";
	}else{
		$token = $_POST["token"];
	}
	$sql = "SELECT 
			* 
			FROM 
			`clients` 
			WHERE 
			`email` LIKE '$email' 
			AND 
			`password` LIKE '$password'
			";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();
	if ( $result->num_rows == 1 ){
		if ( $row["approved"] == '0' ){
			$response['ok'] = false;
			$response['status']= $error;
			if ( $lang == 0 ){
				$response['msg']="Your account is under proccessing.";
			}else{
				$response['msg']="جاري العمل على تفعيل حسابكم";
			}
			$response['loginStatus'] = 1;
			echo json_encode($response);die();
		}
		if($row["hidden"] == '1'){
			$response['ok'] = false;
			$response['status']= $error;
			if ( $lang == 0 ){
				$response['msg']="Your acccount has been disabled by Create-Pay Team.";
			}else{
				$response['msg']="تم إيقاف حسابكم من قبل الإدرات كريت-بي";
			}
			$response['loginStatus'] = 2;
			echo json_encode($response);die();
		}else{
			$response['ok'] = true;
			$response['status']= $succeed;
			if ( $lang == 0 ){
				$response['msg']="Login Successful.";
			}else{
				$response['msg']="عملية تسجيل دخول ناجحة";
			}
			$mobile = $row["phone"];
			$response['loginStatus'] = 3;
			$response['details']['UserId'] = $row["id"];
			$response['details']['name'] = $row["fullName"];
			$response['details']['email'] = $row["email"];
			$response['details']['Refference'] = $row["sRef"];
			
			$sql = "SELECT 
					* 
					FROM 
					`firebase` 
					WHERE 
					`userId` LIKE '".$response['details']['UserId']."' 
					";
			$result = $dbconnect->query($sql);
			if ( $result->num_rows > 0 ){
				$sql = "UPDATE `firebase`
						SET
						`token` = '".$token."',
						`sRef` = '".$response['details']['Refference']."',
						`lastLogin` = '".$realDate."'
						WHERE 
						`userId` LIKE '".$response['details']['UserId']."'
						";
				$result = $dbconnect->query($sql);
			}else{
				$sql = "INSERT INTO 
						`firebase`
						(`token`, `userId`, `phone`, `sRef`, `lastLogin`) 
						VALUES 
						('".$token."', '".$response['details']['UserId']."', '".$mobile."', '".$response['details']['Refference']."', '".$realDate."')
						";
				$result = $dbconnect->query($sql);
			}
			
			
		}
	}else{
		$response['ok'] = false;
		$response['status']= $error;
		$response['loginStatus'] = 0;
		if ( $lang == 0 ){
			$response['msg']= "Please enter your info correctly";
		}else{
			$response['msg']= "الرجاء التأكد من المعلومات المدخلة و المحاولة من جديد";
		}
	}
}

echo json_encode($response);

?>