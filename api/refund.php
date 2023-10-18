<?php
require('constants.php');

if ( !isset($_POST["invoiceId"]) OR empty($_POST["invoiceId"]) ){
	if ( $lang == 0 ){
		$response["IsSuccess"] = false;
		$response["ValidationErrors"] = [];
		$response["Data"] = null;
		$response['Message']="Please enter invoice id.";
	}else{
		$response["IsSuccess"] = false;
		$response["ValidationErrors"] = [];
		$response["Data"] = null;
		$response['Message']="الرجاء إدخال رقم الفاتورة";
	}
	echo json_encode($response);die();
}elseif(!isset($_POST["refference"]) OR $_POST["refference"] == ""){
	if ( $lang == 0 ){
		$response["IsSuccess"] = false;
		$response["ValidationErrors"] = [];
		$response["Data"] = null;
		$response['Message']="please enter customer refference code.";
	}else{
		$response["IsSuccess"] = false;
		$response["ValidationErrors"] = [];
		$response["Data"] = null;
		$response['Message']="الرجاء ادخال رمز العميل";
	}
	echo json_encode($response);die();
}else{
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
			$response["IsSuccess"] = false;
			$response["ValidationErrors"] = [];
			$response["Data"] = null;
			$response['Message']="No user with this refference code.";
		}else{
			$response["IsSuccess"] = false;
			$response["ValidationErrors"] = [];
			$response["Data"] = null;
			$response['Message']="لا يوجد مستخدم لرمز المرجع المدخل";
		}
		echo json_encode($response);die();
	}
	$row = $result->fetch_assoc();
	$supplierCode = $row["sCode"];
	$commission = $row["commission"];
	
	$sql = "SELECT 
			*
			FROM 
			`invoices` 
			WHERE 
			`orderId` LIKE '".$_POST['invoiceId']."'
			";
	$result = $dbconnect->query($sql);
	if ( $result->num_rows == 0 ){
		if ( $lang == 0 ){
			$response["IsSuccess"] = false;
			$response["ValidationErrors"] = [];
			$response["Data"] = null;
			$response['Message']="No invoice with this id.";
		}else{
			$response["IsSuccess"] = false;
			$response["ValidationErrors"] = [];
			$response["Data"] = null;
			$response['Message']="لا يوجد فاتورة بهذا الرقم";
		}
		echo json_encode($response);die();
	}
	
	$sql = "SELECT 
			*
			FROM 
			`invoices` 
			WHERE 
			`orderId` LIKE '".$_POST['invoiceId']."'
			AND
			`supplierCode` LIKE '".$supplierCode."'
			";
	$result = $dbconnect->query($sql);
	if ( !isset($result->num_rows) OR $result->num_rows == 0 ){
		if ( $lang == 0 ){
			$response["IsSuccess"] = false;
			$response["ValidationErrors"] = [];
			$response["Data"] = null;
			$response['Message']="Invoice id and user refference is not a match.";
		}else{
			$response["IsSuccess"] = false;
			$response["ValidationErrors"] = [];
			$response["Data"] = null;
			$response['Message']="رقم الفاتورة لا يطابق رمز العميل";
		}
		echo json_encode($response);die();
	}
	$row = $result->fetch_assoc();
	$price = $row["price"];
	
	$postMethodLines = array(
		"KeyType" => "invoiceid",
		"Key"=>  $_POST["invoiceId"],
		"RefundChargeOnCustomer"=> false,
		"ServiceChargeOnCustomer"=> false,
		"Amount"=> $price,
		"Comment"=> "refunding...",
		"AmountDeductedFromSupplier"=> round(($price-($commission+0.150)),3),
		);
	//print_r($postMethodLines);die();
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "$MFbasURL/v2/MakeRefund",
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => json_encode($postMethodLines),
	  CURLOPT_HTTPHEADER => array("Authorization: Bearer $token","Content-Type: application/json"),
	));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$myResult = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	$myResult = json_decode($myResult, true);
	
	if($err){
		echo "cURL Error #:" . $err;
	}else{
		if ( $myResult["IsSuccess"] == "true" ){
			echo $sql = "UPDATE `invoices`
						SET 
						`status` = '3'
						WHERE
						`orderId` LIKE '".$_POST["invoiceId"]."'
						";
			$result = $dbconnect->query($sql);
			$myResult["ValidationErrors"] = [];
			echo json_encode($myResult);
		}else{
			if ( $lang == 0 ){
				$myResult["ValidationErrors"] = [];
				$myResult["Message"] = "You dont have enough money left in your wallet.";
			}else{
				$myResult["ValidationErrors"] = [];
				$myResult["Message"] = "لا يوجد مبلغ كافي في محفظتك، الرجاء التواصل مع الإدارة";
			}
			echo json_encode($myResult);
		}
		
	}
}

?>