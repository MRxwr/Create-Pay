<?php

require ("../config.php");

$url = $_POST["url"];
$title = $_POST["title"];

if( is_uploaded_file($_FILES['logo']['tmp_name']) )
{
	$directory = "../../../logos/";
	$originalfile = $directory . date("d-m-y") . time() .  round(microtime(true)). ".png";
	move_uploaded_file($_FILES["logo"]["tmp_name"], $originalfile);
	$filenewname = str_replace("../../../logos/",'',$originalfile);
}
else
{
	$filenewname = "";
}

$sql = "INSERT 
		INTO `banner` 
		(`title`, `link`, `image`) 
		VALUES 
		('$title', '$url', '$filenewname')";
$result = $dbconnect->query($sql);

header("LOCATION: ../../banners.php?b=$bannerType");

//ALTER TABLE phrases AUTO_INCREMENT = 1

?>