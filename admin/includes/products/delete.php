<?php

require ("../config.php");

$id = $_GET["id"];

$sql = "UPDATE `products` 
		SET 
		`hidden` = '1',
		`arTitle` = CONCAT('**',`arTitle`,'**'),
		`enTitle` = CONCAT('**',`enTitle`,'**')
		WHERE `id`='$id'";

//$sql = "DELETE FROM `products` WHERE `id`='$id'";
$result = $dbconnect->query($sql);

header("LOCATION: ../../product.php");

?>