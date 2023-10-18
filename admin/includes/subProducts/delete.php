<?php
require ("../config.php");

$id = $_GET["id"];
$productId = $_GET["productId"];

$sql = "UPDATE `subproducts` 
		SET 
		`hidden` = '1'
		WHERE 
		`id` LIKE '".$id."'
		";
$result = $dbconnect->query($sql);

header("LOCATION: ../../add-sub-products.php?id=" . $_GET["productId"]);

?>