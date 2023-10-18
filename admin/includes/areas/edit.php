<?php
require("../config.php");

$id = $_POST["id"];
$arTitle = $_POST["arTitle"];
$enTitle = $_POST["enTitle"];
$charges = $_POST["charges"];

$sql = "UPDATE 
		`areas` 
		SET
		`arTitle`='$arTitle',
		`enTitle`='$enTitle',
		`charges` = '$charges'
		WHERE `id` = '$id'";
$result = $dbconnect->query($sql);

header ("Location: ../../areas.php");

?>