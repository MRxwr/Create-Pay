<?php

require ("../config.php");

$id = $_GET["id"];

$sql = "DELETE FROM `brands` WHERE `id`='$id'";
$result = $dbconnect->query($sql);

header("LOCATION: ../../brands.php");

?>