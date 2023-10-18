<?php

require ("../config.php");

$id = $_GET["id"];

$sql = "UPDATE `categories` 
		SET 
		`hidden` = '1',
		`arTitle` = CONCAT('**',`arTitle`,'**'),
		`enTitle` = CONCAT('**',`enTitle`,'**')
		WHERE `id`='$id'";
		
//$sql = "DELETE FROM `categories` WHERE `id`='$id'";
$result = $dbconnect->query($sql);

header("LOCATION: ../../categories.php");

?>