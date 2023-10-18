<?php
require("../config.php");

$id = $_GET["id"];

$sql = "UPDATE `areas` 
		SET 
		`hidden` = '1',
		`voucher` = CONCAT('**',`voucher`,'**')
		WHERE `id`='$id'";
		
//$sql = "DELETE FROM `vouchers` WHERE `id` = '$id'";
$result = $dbconnect->query($sql);

header ("Location: ../../vouchers.php");

?>