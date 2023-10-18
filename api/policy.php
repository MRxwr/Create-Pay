<?php
require('constants.php');

$sql = "SELECT `policy`, `policyAr`
		FROM `s_media`
		WHERE
		`id` = '3'
		";
$row = mysqli_fetch_row(mysqli_query($dbconnect, $sql));

$response['ok'] = true;
$response['status']= $succeed;
if ( $lang == 0 ){
	$response['details']= $row[0] ;
}else{
	$response['details']= $row[1] ;
}
echo json_encode($response);

?>