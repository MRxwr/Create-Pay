<?php

require ("../config.php");

$artitle = $_POST["arTitle"];
$entitle = $_POST["enTitle"];
$ardesc = $_POST["arDesc"];
$endesc = $_POST["enDesc"];
$id = $_GET["id"];

if( is_uploaded_file($_FILES['logo']['tmp_name']) )
{
	$directory = "../../../logos/";
	$originalfile = $directory . date("d-m-y") . time() .  round(microtime(true)). ".png";
	move_uploaded_file($_FILES["logo"]["tmp_name"], $originalfile);
	$filenewname = str_replace("../../../logos/",'',$originalfile);
}
else
{
	$sql = "SELECT `imageurl` 
			FROM `brand` 
			WHERE `id` LIKE '".$id."'";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();
	$filenewname = $row["imageurl"];
}

$sql = "UPDATE brand SET `arTitle`='$artitle', `enTitle`='$entitle', `arDescription`='$ardesc', `erDescription`='$endesc', `imageurl`='$filenewname' WHERE `id`='$id'";
$result = $dbconnect->query($sql);

header("LOCATION: ../../brands.php");

//ALTER TABLE phrases AUTO_INCREMENT = 1

?>