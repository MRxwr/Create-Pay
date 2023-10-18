<?php

require ("../config.php");

$artitle = $_POST["arTitle"];
$entitle = $_POST["enTitle"];
$arDetails = $_POST["arDetails"];
$enDetails = $_POST["enDetails"];
$categoryId = $_POST["categoryId"];
$price = $_POST["price"];
$cost = $_POST["cost"];
$videoLink = "";
$storeQuantity = 0;
$onlineQuantity = $_POST["onlineQuantity"];
$discount = $_POST["discount"];
$weight = 0;
$width = 0;
$height = 0;
$depth = 0;

$sql = "INSERT INTO 
		`products`
		(`categoryId`, `arTitle`, `enTitle`, `arDetails`, `enDetails`, `price`, `cost`, `video`, `storeQuantity`, `onlineQuantity`,`discount`, `weight`, `width`, `height`,`depth`) 
		VALUES
		('$categoryId','$artitle','$entitle','$arDetails','$enDetails', '$price', '$cost','$videoLink','$storeQuantity','$onlineQuantity', '$discount','$weight','$width','$height', '$depth')";
$result = $dbconnect->query($sql);

$sql = "SELECT * FROM `products` WHERE `enTitle` LIKE '$entitle' AND `arTitle` LIKE '$artitle'";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
$productID = $row["id"];

$i = 0;
while ( $i < sizeof($_FILES['logo']['tmp_name']) )
{
	if( is_uploaded_file($_FILES['logo']['tmp_name'][$i]) )
	{
		$directory = "../../../logos/";
		$originalfile = $directory . date("d-m-y") . time() . rand(111111,999999) . ".png";
		move_uploaded_file($_FILES["logo"]["tmp_name"][$i], $originalfile);
		$filenewname = str_replace("../../../logos/",'',$originalfile);
		$sql = "INSERT INTO `images`(`id`, `productId`, `imageurl`) VALUES (NULL,'$productID','$filenewname')";
		$result = $dbconnect->query($sql);
	}
	$i++;
}
header("LOCATION: ../../product.php");

//ALTER TABLE phrases AUTO_INCREMENT = 1

?>