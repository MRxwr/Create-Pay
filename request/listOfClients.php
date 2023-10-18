<?php


if( $userType == '1' ){
	$phone = $_POST["phone"];
	$password = $_POST["password"];
	$privacy = $_POST["privacy"];
	$password = sha1($password);
}else{
	$fullName = $_POST["fullName"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$password = sha1($password);
	$phone = $_POST["phone"];
	$sCode = $_POST["sCode"];
	$sRef = $_POST["sRef"];
	$instagram = $_POST["instagram"];
	$commission = $_POST["commission"];
	$privacy = $_POST["privacy"];
	$payAPIToken = $_POST["payAPIToken"];
}

if( is_uploaded_file($_FILES['contract']['tmp_name']) )
{
	$directory = "../../../logos/";
	$originalfile1 = $directory . date("d-m-y") . time() . rand(111111,999999) . ".png";
	move_uploaded_file($_FILES["contract"]["tmp_name"], $originalfile1);
	$contract = str_replace("../../../logos/",'',$originalfile1);
}

if( is_uploaded_file($_FILES['civilB']['tmp_name']) )
{
	$directory = "../../../logos/";
	$originalfile2 = $directory . date("d-m-y") . time() . rand(111111,999999) . ".png";
	move_uploaded_file($_FILES["civilB"]["tmp_name"], $originalfile2);
	$civilB = str_replace("../../../logos/",'',$originalfile2);
}

if( is_uploaded_file($_FILES['myfatoorah']['tmp_name']) )
{
	$directory = "../../../logos/";
	$originalfile3 = $directory . date("d-m-y") . time() . rand(111111,999999) . ".png";
	move_uploaded_file($_FILES["myfatoorah"]["tmp_name"], $originalfile3);
	$myfatoorah = str_replace("../../../logos/",'',$originalfile3);
}

if( is_uploaded_file($_FILES['civilF']['tmp_name']) )
{
	$directory = "../../../logos/";
	$originalfile4 = $directory . date("d-m-y") . time() . rand(111111,999999) . ".png";
	move_uploaded_file($_FILES["civilF"]["tmp_name"], $originalfile4);
	$civilF = str_replace("../../../logos/",'',$originalfile4);
}

if( is_uploaded_file($_FILES['profileLogo']['tmp_name']) )
{
	$directory = "../../../logos/";
	$originalfile4 = $directory . date("d-m-y") . time() . rand(111111,999999) . ".png";
	move_uploaded_file($_FILES["profileLogo"]["tmp_name"], $originalfile4);
	$profileLogo = str_replace("../../../logos/",'',$originalfile4);
}

if( is_uploaded_file($_FILES['instraProfile']['tmp_name']) )
{
	$directory = "../../../logos/";
	$originalfile4 = $directory . date("d-m-y") . time() . rand(111111,999999) . ".png";
	move_uploaded_file($_FILES["instraProfile"]["tmp_name"], $originalfile4);
	$instraProfile = str_replace("../../../logos/",'',$originalfile4);
}

if( $userType == '1' ){
	$sql = "UPDATE `clients` 
			SET";
	if ( isset($profileLogo) ){
		$sql .= "`imageurl`= '".$profileLogo."',";
	}
	if ( !empty($_POST["password"]) ){
		$sql .= "`password`= '".$password."',";
	}
	$sql .= "`privacy`= '".$privacy."',";
	$sql .= "`phone`= '".$phone."'
			WHERE
			`id` LIKE '".$_POST["id"]."'
			";
}elseif ( !empty($_POST["id"]) AND $userType == '0' ){
	$sql = "UPDATE `clients` 
			SET 
			`fullName`= '".$fullName."',
			`commission` = '".$commission."',";
	if ( !empty($_POST["password"]) ){
		$sql .= "`password`= '".$password."',";
	}
	if ( isset($instraProfile) ){
		$sql .= "`instaProfile`= '".$instraProfile."',";
	}
	if ( isset($profileLogo) ){
		$sql .= "`imageurl`= '".$profileLogo."',";
	}
	if ( isset($civilF) ){
		$sql .= "`civilIdF`= '".$civilF."',";
	}
	if ( isset($civilB) ){
		$sql .= "`civilIdB`= '".$civilB."',";
	}
	if ( isset($myfatoorah) ){
		$sql .= "`myfatoorah`= '".$myfatoorah."',";
	}
	if ( isset($contract) ){
		$sql .= "`contract`= '".$contract."',";
	}
	$sql .= "`email`= '".$email."',
			`phone`= '".$phone."',
			`sCode`= '".$sCode."',
			`sRef`= '".$sRef."',
			`privacy`= '".$privacy."',
			`instaA`= '".$instagram."',
			`payAPIToken`= '".$payAPIToken."'
			WHERE
			`id` LIKE '".$_POST["id"]."'
			";
}else{
	$sql = "INSERT INTO `clients`
			(`fullName`, `email`, `password`, `phone`, `sCode`, `sRef`, `instaA`, `contract`, `civilIdB`, `myfatoorah`, `civilIdF`, `imageurl`, `instaProfile`,`commission`,`privacy`, `payAPIToken`) 
			VALUES 
			('".$fullName."', '".$email."', '".$password."', '".$phone."','".$sCode."','".$sRef."','".$instagram."','".$contract."','".$civilB."','".$myfatoorah."','".$civilF."','".$profileLogo."','".$instraProfile."', '".$commission."', '".$privacy."', '{$payAPIToken}')
			";
}
$result = $dbconnect->query($sql);

if( $userType == '1' ){
	header("LOCATION: ../../editProfile.php");
}else{
	header("LOCATION: ../../listOfClients.php");
}
//ALTER TABLE phrases AUTO_INCREMENT = 1

?>