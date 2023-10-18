<?php

require ("../config.php");

if ( isset($_GET["b"]) )
{
	if ( $_GET["b"] == "new" )
	{
		$bannerType = "new";
	}
	elseif ( $_GET["b"] == "best" )
	{
		$bannerType = "best";
	}
	elseif ( $_GET["b"] == "build" )
	{
		$bannerType = "build";
	}
	else
	{
		$bannerType = "main";
	}
}

$id = $_GET["id"];

$sql = "DELETE FROM `banners` WHERE `id`='$id'";
$result = $dbconnect->query($sql);

header("LOCATION: ../../banners.php?b=$bannerType");

?>