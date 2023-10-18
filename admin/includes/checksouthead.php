<?php
if ( isset ( $_COOKIE["CreateKWLinksAdmin"] ) ){
	session_start ();
	require ("config.php");
	
	$svdva = $_COOKIE["CreateKWLinksAdmin"];
	
	$sql = "SELECT * 
			FROM `adminstration` 
			WHERE `keepMeAlive` LIKE '%".$svdva."%'";
	$result = $dbconnect->query($sql);
	
	if ( $result->num_rows == 1 ){
		$row = $result->fetch_assoc();
		$userID = $row["id"];
		$email = $row["email"];
		$username = $row["fullName"];
		$_SESSION['CreateKWLinksAdmin'] = $email;
		$userType = "0";
	}else{
		$sql = "SELECT * 
				FROM `clients` 
				WHERE `keepMeAlive` LIKE '%".$svdva."%'";
		$result = $dbconnect->query($sql);
		$row = $result->fetch_assoc();
		$userID = $row["id"];
		$email = $row["email"];
		$username = $row["fullName"];
		$clientCode = $row["sCode"];
		$clientRef = $row["sRef"];
		$_SESSION['CreateKWLinksAdmin'] = $email;
		$userType = "1";
	}
}elseif ( !isset ( $_COOKIE["CreateKWLinksAdmin"] ) ){
	header("Location: login.php");
}
?>