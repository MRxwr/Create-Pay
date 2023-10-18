<?php
session_start ();
if ( !isset ($_SESSION["Almr3a"]) )
{
	require ("config.php");
	
	$name = $_POST["name"];
	$password = $_POST["password"];
	$password1 = $_POST["password1"];
	$email = $_POST["email"];
	$phone = $_POST["phone"];
	$passwordlen = strlen($password);
	
	if ( strstr($name,'"') )
	{
		header("Location: ../register.php?error=9");
		exit();
	}
	if ( strstr($email,'"') )
	{
		header("Location: ../register.php?error=9");
		exit();
	}
	if ( strstr($phone,'"') )
	{
		header("Location: ../register.php?error=9");
		exit();
	}
	
	if ( $password != $password1 )
	{
		header("Location: ../register.php?error=1");
		exit();
	}
	if ( !preg_match("/^[a-zA-Z0-9 ]*$/",$password) )
	{
		header("Location: ../register.php?error=10");
		exit();
	}
	if ( $passwordlen < 7 )
	{
		header("Location: ../register.php?error=8");
		exit();
	}
	elseif ( filter_var($email, FILTER_VALIDATE_EMAIL) === false )
	{
		header("Location: ../register.php?error=5");
		exit();
	}
	
	$sql = "SELECT email FROM adminstration WHERE email like '$email'";
	$result = $dbconnect->query($sql);
	if ( $result->num_rows > 0 )
	{
	header("Location: ../register.php?error=4");
	exit();
	}
	
	$sql = "SELECT id FROM adminstration ORDER BY id DESC LIMIT 1";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();
	$id = $row["id"]+1;
	
	$password = sha1($password);
	
	$sql = "INSERT INTO adminstration (id, date, fullName, email, password, phone) VALUES (NULL, NULL, '$name', '$email', '$password', '$phone')";
	if ( $dbconnect->query($sql) )
	{
		header("Location: ../login.php?msg=klasdfjs");
	}
	else
	{
		echo "Error: " . $sql . "<br>" . $dbconnect->error;
	}
}
else
{
	header("Location: ../index.php?error=5");
	exit();
}
?>