<?php
require("../config.php");

$id = $_POST["id"];
$location = $_POST["location"];
$discount = $_POST["discount"];
$details = $_POST["details"];

$sql = "UPDATE 
		`locations` 
		SET
		`location`='$location',
		`details`='$details',
		`discount` = '$discount'
		WHERE `id` = '$id'";
$result = $dbconnect->query($sql);

header ("Location: ../../locations.php");

?>