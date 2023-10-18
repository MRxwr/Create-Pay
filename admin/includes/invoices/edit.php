<?php
require("../config.php");

$id = $_POST["id"];
$invoices = $_POST["invoices"];
$discount = $_POST["discount"];
$details = $_POST["details"];

$sql = "UPDATE 
		`invoices` 
		SET
		`voucher`='$invoices',
		`details`='$details',
		`percentage` = '$discount'
		WHERE `id` = '$id'";
$result = $dbconnect->query($sql);

header ("Location: ../../invoices.php");

?>