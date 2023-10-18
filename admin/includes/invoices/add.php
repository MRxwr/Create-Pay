<?php
require("../config.php");
require("../checksouthead.php");

$name = $_POST["name"];
$email = $_POST["email"];
$mobile = $_POST["mobile"];
$price = $_POST["price"];
$status = "0";
$details = $_POST["details"];

//getting supplier code
$sql = "SELECT * 
		FROM `clients` 
		WHERE `id` LIKE '%".$userID."%'";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
$supplierCode = $row["sCode"];
$sRef = $row["sRef"];
$commission = $row["commission"];

// generating payment link code
$linkCode = md5(uniqid(rand().$supplierCode.date("y-m-d h:i:s"), true));

$orderId = "";


$sql = "INSERT INTO `invoices`
		(`name`, `email`, `mobile`,`price`, `status`, `linkCode`,`supplierCode`, `orderId`, `details`,`sRef`) 
		VALUES 
		('".$name."','".$email."','".$mobile."','".($price+$commission)."','".$status."','".$linkCode."','".$supplierCode."','".$orderId."','".$details."','".$sRef."')";
$result = $dbconnect->query($sql);

header ("Location: ../../invoices.php?code=".$linkCode);

?>