<?php
require('constants.php');

if( !isset($_GET['refference']) ){
	$response['ok'] = false;
	$response['status']= $error;
	if ( $lang == 0 ){
		$response['msg']="Please enter reffrence code.";
	}else{
		$response['msg']="الرجاء إدخال رمز العميل";
	}
}else{
	$sql = "SELECT 
			`sCode`
			FROM 
			`clients` 
			WHERE 
			`sRef` LIKE '".$_GET['refference']."'
			";
	$result = $dbconnect->query($sql);
	if ( $result->num_rows == 0 ){
		$response['ok'] = false;
		$response['status']= $error;
		if ( $lang == 0 ){
			$response['msg']="No user with this refference code.";
		}else{
			$response['msg']="لا يوجد مستخدم لرمز المرجع المدخل";
		}
		echo json_encode($response);
		die();
	}
	$row = $result->fetch_assoc();
	$UserCode = $row["sCode"];
	
	$sql = "SELECT 
			COUNT(if(`status` = '3', `status`, NULL)) AS refunded,
			COUNT(if(`status` = '1', `status`, NULL)) AS paid,
			COUNT(if(`status` = '2', `status`, NULL)) AS failed,
			COUNT(if(`status` = '0', `status`, NULL)) AS pending,
			COUNT(if(`status` = '4', `status`, NULL)) AS expired,
			COUNT(*) AS total,
			SUM(if(`status` = '1', `price`, NULL)) AS earnings
			FROM 
			`invoices` 
			WHERE 
			`sRef` LIKE '".$_GET['refference']."'
			";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();
	
	$response['ok'] = true;
	$response['status'] = $succeed;
	if ( $lang == 0 ){
		$response['msg'] = "Success";
	}else{
		$response['msg'] = "عملية ناجحة";
	}
	if ( $lang == 0 ){
		$response['details']['TotalInvoicesTitle'] = "Invoices";
	}else{
		$response['details']['TotalInvoicesTitle'] = "الفواتير";
	}
	$response['details']['TotalInvoices'] = (string)round($row["total"],2);
	if ( $lang == 0 ){
		$response['details']['TotalPaidTitle'] = "Paid";
	}else{
		$response['details']['TotalPaidTitle'] = "المدفوعة";
	}
	$response['details']['TotalPaid'] = (string)round($row["paid"],2);
	if ( $lang == 0 ){
		$response['details']['TotalPendingTitle'] = "Pending";
	}else{
		$response['details']['TotalPendingTitle'] = "قيد الإنتظار";
	}
	$response['details']['TotalPending'] = (string)round($row["pending"],2);
	if ( $lang == 0 ){
		$response['details']['TotalFailedTitle'] = "Failed";
	}else{
		$response['details']['TotalFailedTitle'] = "الملغية";
	}
	$response['details']['TotalFailed'] = (string)round($row["failed"],2);
	if ( $lang == 0 ){
		$response['details']['TotalRefundedTitle'] = "Refunded";
	}else{
		$response['details']['TotalRefundedTitle'] = "المسترجعة";
	}
	$response['details']['TotalRefunded'] = (string)round($row["refunded"],2);
	if ( $lang == 0 ){
		$response['details']['TotalExpiredTitle'] = "Expired";
	}else{
		$response['details']['TotalExpiredTitle'] = "المنتهية";
	}
	$response['details']['TotalExpired'] = (string)round($row["expired"],2);
	if ( $lang == 0 ){
		$response['details']['EarningsTitle'] = "Earnings";
	}else{
		$response['details']['EarningsTitle'] = "الأرباح";
	}
	$response['details']['Earnings'] = (string)round($row["earnings"],2);
	if ( !isset($row["earnings"]) OR empty($row["earnings"]) ){
		$response['details']['Earnings'] = "0";
	}
	if ( !isset($row["total"]) OR empty($row["total"]) ){
		$response['details']['TotalInvoices'] = "0";
	}
	/*
	$i = 0;
	$sql = "SELECT 
			*
			FROM 
			`invoices` 
			WHERE 
			`supplierCode` LIKE '".$UserCode."'
			ORDER BY `id` DESC
			LIMIT 5";
	$result = $dbconnect->query($sql);
	if ( $result->num_rows > 0 ){
		while ( $row = $result->fetch_assoc() ){
			$response['details']['invoices'][$i]["Date"] = $row["date"];
			$response['details']['invoices'][$i]["Link"] = $baseUrl . $row["linkCode"];
			$response['details']['invoices'][$i]["CustomerName"] = $row["name"];
			$response['details']['invoices'][$i]["CustomerMobile"] = $row["mobile"];
			$response['details']['invoices'][$i]["CustomerEmail"] = $row["email"];
			$response['details']['invoices'][$i]["InvoicePrice"] = $row["price"];
			$response['details']['invoices'][$i]["InvoiceStatus"] = $row["status"];
			$i++;
		}
	}else{
		unset($response);
		$response['ok'] = false;
		$response['status']= $error;
		$response['msg']="No invoices found for this user.";
		$response['details']['invoices'][$i]["Date"] = "";
		$response['details']['invoices'][$i]["Link"] = "";
		$response['details']['invoices'][$i]["CustomerName"] = "";
		$response['details']['invoices'][$i]["CustomerMobile"] = "";
		$response['details']['invoices'][$i]["CustomerEmail"] = "";
		$response['details']['invoices'][$i]["InvoicePrice"] = "";
		$response['details']['invoices'][$i]["InvoiceStatus"] = "";
	}
	*/
}

echo json_encode($response);

?>