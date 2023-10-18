<?php
require ("../config.php");

$id = $_GET["id"];
$arTitle = $_POST["arTitle"];
$enTitle = $_POST["enTitle"];
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

$i = 0;
while ( $i < sizeof($_FILES['logo']['tmp_name']) )
{
	if( is_uploaded_file($_FILES['logo']['tmp_name'][$i]) )
	{
		$directory = "../../../logos/";
		$originalfile = $directory . date("d-m-y") . time() .  rand(111111,999999) . ".png";
		move_uploaded_file($_FILES["logo"]["tmp_name"][$i], $originalfile);
		$filenewname = str_replace("../../../logos/",'',$originalfile);
		$sql = "INSERT INTO 
		`images`
		(`id`, `productId`, `imageurl`) 
		VALUES 
		(NULL,'$id','$filenewname')";
		$result = $dbconnect->query($sql);
	}
	$i++;
}

$sql = "UPDATE 
		`products` 
		SET 
		`categoryId`='$categoryId',
		`arTitle`='$arTitle',
		`enTitle`='$enTitle',
		`arDetails`='$arDetails',
		`enDetails`='$enDetails',
		`price`='$price',
		`cost`='$cost',
		`discount`='$discount',
		`onlineQuantity`='$onlineQuantity',
		`storeQuantity`='$storeQuantity',
		`weight`='$weight',
		`width`='$width',
		`height`='$height',
		`depth`='$depth'
		WHERE 
		`id`= '$id'";
$result = $dbconnect->query($sql);

header("LOCATION: ../../product.php");

?>