<?php
$servername = "localhost";
$username = "u671249433_linksUSER";
$password = "N@b$90949089";
$dbname = "u671249433_linksDB";

$dbconnect = new MySQLi($servername,$username,$password,$dbname);

if ( $dbconnect->connect_error )
{
	die("Connection Failed: " .$dbconnect->connect_error );
}

$sql = "SET CHARACTER SET utf8";
$dbconnect->query($sql);
?>
