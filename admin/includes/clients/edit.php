<?php

require ("../config.php");

$id = $_POST["userid"];
$fullName = $_POST["fullName"];
$email = $_POST["email"];
$password = $_POST["password"];
$phone = $_POST["phone"];

$sql = "UPDATE `users` 
        SET 
        `fullName`= '".$fullName."',
        `email`= '".$email."',
        `password`= '".$password."',
        `phone`= '".$phone."'
        WHERE `id` LIKE '".$id."'
        ";
$result = $dbconnect->query($sql);

header("LOCATION: ../../users.php");

?>