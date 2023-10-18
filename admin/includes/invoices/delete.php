<?php
require("../config.php");

$id = $_GET["id"];

$sql = "UPDATE `invoices` 
		SET 
		`hidden` = '1',
		`voucher` = CONCAT('**',`voucher`,'**')
		WHERE `id`='$id'";
		
//$sql = "DELETE FROM `invoices` WHERE `id` = '$id'";
$result = $dbconnect->query($sql);

header ("Location: ../../invoices.php");

?>