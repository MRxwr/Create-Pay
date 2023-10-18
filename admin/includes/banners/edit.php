<?php

require ("../config.php");

$url = $_POST["url"];
$title = $_POST["title"];
$id = $_POST["id"];

if( is_uploaded_file($_FILES['logo']['tmp_name']) )
{
	$directory = "../../../logos/";
	$originalfile = $directory . date("d-m-y") . time() .  round(microtime(true)). ".png";
	move_uploaded_file($_FILES["logo"]["tmp_name"], $originalfile);
	$filenewname = str_replace("../../../logos/",'',$originalfile);
}
else
{
	$sql = "SELECT `image` 
			FROM `banner`
			WHERE `id` LIKE '".$id."'";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();
	$filenewname = $row["image"];
}

echo $sql = "UPDATE `banner` 
		SET 
		`link`='$url', 
		`image`='$filenewname', 
		`title`='$title' 
		WHERE `id`='$id'
		";
echo $result = $dbconnect->query($sql);

header("LOCATION: ../../banners.php");

//ALTER TABLE phrases AUTO_INCREMENT = 1

?>