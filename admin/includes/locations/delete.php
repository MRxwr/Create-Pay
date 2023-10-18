<?php
require("../config.php");

$id = $_GET["id"];

$sql = "UPDATE `locations` 
		SET 
		`hidden` = '1',
		`location` = CONCAT('**',`location`,'**')
		WHERE `id`='$id'";

$result = $dbconnect->query($sql);

header ("Location: ../../locations.php");

?>