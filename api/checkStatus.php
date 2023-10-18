<?php
require('constants.php');

// 0 pending, 1 failur, 2 paid, 3 refunded

if( isset($_GET['code']) ){
	$sql = " SELECT *
			FROM `invoices`
			WHERE
			`linkCode` LIKE '{$_GET["code"]}'
			";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();
	$response["details"]["status"] = $row["status"] ;
}

echo json_encode($response);

?>