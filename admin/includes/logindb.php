<?php
session_start ();
include_once ("config.php");

$email = $_POST["email"];
$password = $_POST["password"];
$password = sha1($password);

$userType = "0";
$sql = "SELECT * 
		FROM `adminstration` 
		WHERE 
		`email` LIKE '$email' 
		AND 
		`password` LIKE '$password'
		";
$result = $dbconnect->query($sql);
if ( $result->num_rows < 1 )
{
	$userType = "1";
	$sql = "SELECT * 
			FROM `clients` 
			WHERE 
			`email` LIKE '$email' 
			AND 
			`password` LIKE '$password'
			AND 
			`hidden` != 1
			AND
			`approved` = 1
			";
	$result = $dbconnect->query($sql);
	if ( $result->num_rows < 1 )
	{
		$userType = "2";
	}
}
$row = $result->fetch_assoc();

$coockiecode = $row["keepMeAlive"];
$coockiecode = explode(',',$coockiecode);
$GenerateNewCC = md5(rand());
if ( sizeof($coockiecode) <= 3 )
{
	$coockiecodenew = array();
	if ( !isset ($coockiecode[2]) ) { $coockiecodenew[1] = $GenerateNewCC ; } else { $coockiecodenew[0] = $coockiecode[1]; }
	if ( !isset ($coockiecode[1]) ) { $coockiecodenew[0] = $GenerateNewCC ; } else { $coockiecodenew[1] = $coockiecode[2]; }
	if ( !isset ($coockiecode[0]) ) { $coockiecodenew[2] = $GenerateNewCC ; } else { $coockiecodenew[2] = $GenerateNewCC; }
}

$coockiecode = $coockiecodenew[0] . "," . $coockiecodenew[1] . "," . $coockiecodenew[2] ;

if ( $userType == 0 )
{
	echo $sql = "UPDATE adminstration SET keepMeAlive = '$coockiecode' WHERE email like '$email' AND password like '$password'";
	$result = $dbconnect->query($sql);
	$_SESSION["CreateKWLinksAdmin"] = $email;
	setcookie("CreateKWLinksAdmin", $GenerateNewCC, time() + (86400*30 ), "/");
	header("Location: ../index.php");
	exit();
}
elseif ($userType == 1 )
{
	$sql = "UPDATE clients SET keepMeAlive = '$coockiecode' WHERE email like '$email' AND password like '$password'";
	$result = $dbconnect->query($sql);
	$_SESSION["CreateKWLinksAdmin"] = $email;
	header("Location: ../index.php");
	setcookie("CreateKWLinksAdmin", $GenerateNewCC, time() + (86400*30 ), "/");
	exit();
}
else
{
	echo "try again";
	header("Location: ../login.php?error=p");
	exit();
}

?>