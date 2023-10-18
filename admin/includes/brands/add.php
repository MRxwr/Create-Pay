<?php

require ("../config.php");

$artitle = $_POST["arTitle"];
$entitle = $_POST["enTitle"];
$ardesc = $_POST["arDesc"];
$endesc = $_POST["enDesc"];

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

$sql = "INSERT INTO `brand` (`id`, `arTitle`, `enTitle`, `arDescription`, `erDescription`, `imageurl`) VALUES (NULL, '$artitle', '$entitle', '$ardesc', '$endesc', '$filenewname')";
$result = $dbconnect->query($sql);

header("LOCATION: ../../brands.php");

//ALTER TABLE phrases AUTO_INCREMENT = 1

?>