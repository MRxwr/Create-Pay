<?php
require('constants.php');

if( !isset($_GET["endpoint"]) ){
	if ( $lang == 0 ){
		$response['msg']="please enter old password.";
	}else{
		$response['msg']="الرجاء إدخال كلمة المرور القديمة";
	}
	echo json_encode($response);die();
}elseif( $_GET["endpoint"] == "edit" ){
	if( !isset($_GET["refference"]) || empty($_GET["refference"])){
		if ( $lang == 0 ){
			$response['msg']="Please enter reffrence code.";
		}else{
			$response['msg']="الرجاء إدخال رمز العميل";
		}
		echo json_encode($response);die();
	}else{
		$sql = "SELECT 
				`privacy`
				FROM 
				`clients` 
				WHERE 
				`sRef` LIKE '".$_GET['refference']."'
				";
		$result = $dbconnect->query($sql);
		if ( $result->num_rows > 0 ){
			$row = $result->fetch_assoc();
			$response['ok'] = $ok;
			$response['status'] = $succeed;
			$response['data']["privacy"]= $row["privacy"];
			echo json_encode($response);die();
		}
	}
}elseif( $_GET["endpoint"] == "submit" ){
	if( !isset($_GET["refference"]) || empty($_GET["refference"])){
		if ( $lang == 0 ){
			$response['msg']="Please enter reffrence code.";
		}else{
			$response['msg']="الرجاء إدخال رمز العميل";
		}
		echo json_encode($response);die();
	}else{
		$sql = "UPDATE `clients` SET
				`privacy` = '".$_POST['text']."'
				WHERE 
				`sRef` LIKE '".$_GET['refference']."'
				";
		$result = $dbconnect->query($sql);
		
		$sql = "SELECT 
				`privacy`
				FROM 
				`clients` 
				WHERE 
				`sRef` LIKE '".$_GET['refference']."'
				";
		$result = $dbconnect->query($sql);
		if ( $result->num_rows > 0 ){
			$row = $result->fetch_assoc();
			$response['ok'] = $ok;
			$response['status'] = $succeed;
			$response['data']["privacy"]= $row["privacy"];
			echo json_encode($response);die();
		}
	}
}else{
	if ( $lang == 0 ){
		$response['msg']="please set a correct endpoint.";
	}else{
		$response['msg']="الرجاء التوجيه بشكل صحيح";
	}
	echo json_encode($response);die();
}

echo json_encode($response);

?>