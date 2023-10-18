<?php
require("../config.php");

$location = $_POST["location"];
$details = $_POST["details"];
$discount = $_POST["discount"];

$sql = "INSERT INTO `locations`
		(`location`, `details` , `discount`) 
		VALUES 
		('$location','$details', '$discount')";
$result = $dbconnect->query($sql);

header ("Location: ../../locations.php");

?>