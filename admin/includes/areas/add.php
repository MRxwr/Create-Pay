<?php
require("../config.php");

$arTitle = $_POST["voucher"];
$enTitle = $_POST["percentage"];
$charges = $_POST["details"];

$sql = "INSERT INTO `areas`
		(`arTitle`, `enTitle`, `charges`) 
		VALUES 
		('$arTitle','$enTitle','$charges')";
$result = $dbconnect->query($sql);

header ("Location: ../../areas.php");

?>