<?php
require('constants.php');

// 0 pending, 1 failur, 2 paid, 3 refunded

if( !isset($_GET['refference']) ){
	if ( $lang == 0 ){
		$response['msg']="please enter customer refference code.";
	}else{
		$response['msg']="الرجاء ادخال رمز العميل";
	}
	echo json_encode($response);die();
}else{
	$sql = "SELECT 
			`sCode`,`commission`
			FROM 
			`clients` 
			WHERE 
			`sRef` LIKE '".$_GET['refference']."'
			";
	$result = $dbconnect->query($sql);
	if ( $result->num_rows == 0 ){
		if ( $lang == 0 ){
			$response['msg']="No user with this refference code.";
		}else{
			$response['msg']="لا يوجد مستخدم لرمز المرجع المدخل";
		}
		echo json_encode($response);die();
	}
	$row = $result->fetch_assoc();
	$UserCode = $row["sCode"];
	$commission = $row["commission"];
	
	$sql = "SELECT 
			*
			FROM 
			`invoices` 
			WHERE 
			`supplierCode` LIKE '".$UserCode."'
			ORDER BY `id` DESC
			";
	$result = $dbconnect->query($sql);
	$response['ok'] = true;
	$response['status']= $succeed;
	if ( $lang == 0 ){
		$response['msg']="list of invoices is available";
	}else{
		$response['msg']="قائمة الفواتير متاحة";
	}
	if ( $result->num_rows > 0 ){
		$i = 0;
		while ( $row = $result->fetch_assoc() ){
			
			$realPrice = $row["price"];//-(float)$commission;
			
			if ( $row["status"] == 0 ){
				$statusText = "Pending";
				$refundStatus = 0;
			}elseif( $row["status"] == 1 ){
				$statusText = "Paid";
				$refundStatus = 0;
			}elseif( $row["status"] == 2 ){
				$statusText = "Failed";
				$refundStatus = 0;
			}elseif( $row["status"] == 3 ){
				$statusText = "Refunded";
				$refundStatus = 1;
			}elseif( $row["status"] == 4 ){
				$statusText = "Expired";
				$refundStatus = 0;
			}
			$response['details']['invoices'][$i]["orderId"] = $row["orderId"];
			$response['details']['invoices'][$i]["Date"] = $row["date"];
			$response['details']['invoices'][$i]["Link"] = $baseUrl . $row["linkCode"];
			$response['details']['invoices'][$i]["CustomerName"] = $row["name"];
			$response['details']['invoices'][$i]["CustomerMobile"] = $row["mobile"];
			$response['details']['invoices'][$i]["CustomerEmail"] = $row["email"];
			$response['details']['invoices'][$i]["InvoicePrice"] = (string)$realPrice ;
			$response['details']['invoices'][$i]["InvoiceDetails"] = $row["details"];
			$response['details']['invoices'][$i]["InvoiceStatus"] = $row["status"];
			$response['details']['invoices'][$i]["InvoiceStatusText"] = $statusText;
			$response['details']['invoices'][$i]["RefundStatus"] = $refundStatus;
			$i++;
		}
	}else{
		unset($response);
		$response['ok'] = false;
		$response['status']= $error;
		if ( $lang == 0 ){
			$response['msg']="We could not find any invoice for you.";
		}else{
			$response['msg']="لا توجد فواتير لديك";
		}
		$response['details']['invoices'] = array();
	}
}

echo json_encode($response);

?>