<?php
require("admin/includes/config.php");

if ( !isset($_GET["LinkId"]) || empty($_GET["LinkId"]) ){
	if ( !isset($_GET["paymentId"]) && !isset($_GET["OrderID"]) ){
		header("LOCATION: index.html");die();
	}
}

if ( isset($_GET["LinkId"]) ) {
	$LinkId = $_GET["LinkId"];
	$sql = "SELECT *
			FROM `invoices`
			WHERE `linkCode` LIKE '".$LinkId."'";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();
	$name = $row["name"];
	$mobile = $row["mobile"];
	$email = $row["email"];
	$price = $row["price"];
	$details = $row["details"];
	$date = $row["date"];
	$supplierCode = $row["supplierCode"];
	$paymentId = $row["status"];
	$paymentStatus = $row["status"];
}elseif( isset($_GET["paymentId"]) || isset($_GET["OrderID"]) ){
	if ( isset($_GET["paymentId"]) ){
		$paymentId = $_GET["paymentId"];
	}
	require('api/checkInvoiceAPI.php');
	if ( (isset($_GET["status"]) && strstr($_GET["status"],'fail') === false ) || (isset($_GET["Result"]) && $_GET["Result"] == "CAPTURED") ){
		//var_dump($_GET["status"]);
		$sql = "SELECT `status` FROM `invoices` WHERE `orderId` LIKE '".$orderId."'";
		$result = $dbconnect->query($sql);
		$row = $result->fetch_assoc();
		if ( $row["status"] != '1' ){
			$sql = "UPDATE 
					`invoices`
					SET 
					`status` = '1'
					WHERE 
					`orderId` = '".$orderId."'
					";
			$result = $dbconnect->query($sql);
			
			$sql = "SELECT `supplierCode`, `price` FROM `invoices` WHERE `orderId` LIKE '".$orderId."'";
			$result = $dbconnect->query($sql);
			$row = $result->fetch_assoc();
			$supplierCode = $row["supplierCode"];
			$price = $row["price"];
			
			$sql = "SELECT `sRef` FROM `clients` WHERE `sCode` LIKE '".$supplierCode."'";
			$result = $dbconnect->query($sql);
			$row = $result->fetch_assoc();
			$sRef = $row["sRef"]; 
			
			require('notifications/paid.php');
		}
		$paymentStatus = 1;
	}else{
		$sql = "UPDATE 
				`invoices`
				SET 
				`status` = '2'
				WHERE 
				`orderId` = '".$orderId."'
				";
		$result = $dbconnect->query($sql);
		$paymentStatus = 2;
	}
	//echo $orderId;
	$sql = "SELECT *
			FROM `invoices`
			WHERE `orderId` LIKE '".$orderId."'";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();
	$name = $row["name"];
	$mobile = $row["mobile"];
	$email = $row["email"];
	$price = $row["price"];
	$details = $row["details"];
	$date = $row["date"];
	$supplierCode = $row["supplierCode"];
	$LinkId = $row["linkCode"];
}else{
	header("LOCATION: index.html");die();
}

if ( isset($_GET["status"]) ){
	$paymentStatus = 2;
}

$sql = "SELECT *
		FROM
		`clients`
		WHERE
		`sCode` LIKE '".$supplierCode."'
		AND
		`hidden` = 0
		";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
$sName = $row["fullName"];
$sEmail = $row["email"];
$sInsta = $row["instaA"];
$sMobile = $row["phone"];
$privacy = $row["privacy"];
$image = $row["imageurl"];
if ( $row["commission"] == 0 ){
	$commission = 0;
}else{
	$commission = $row["commission"]+0.15;
}


?>
<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

		<title>Create-Pay Checkout</title>
		
		<style>
		html, body {
			height: 100%;
		}
		.main {
			height: 100%;
			width: 100%;
			display: table;
		}
		.wrapper {
			display: table-cell;
			height: 100%;
			vertical-align: middle;
		}
		body{
			background-attachment: fixed;
			width: 100%;
             height: 100%;
			background-image: url("logos/createbg1.jpg");
		}
		.topNav{
			background-color: #4398dc;
			box-shadow: 0px 0px 3px 2px #0fa9eb;
			border-bottom: #7bccec 1px solid;
			color: white;
		}
		@media screen and (min-height: 300px)
			   and (max-height: 640px)		{
			.mainMargin{
				padding-top:40px;
			}
			
		}
		</style>
	</head>
	
	<body>
	
	<!-- <header class="header mt-auto py-2 fixed-top topNav">
		<div class="container-fluid d-flex ml-3">
			<div class="row w-100">
				<div class="col-6 text-left">
					<b>CREATE-PAY</b>
				</div>
				<div class="col-6" style="text-align: right;">
					
				</div>
			</div>
		</div>
	</header> -->
		<div class = "main mainMargin" style="max-width:550px;margin: auto;">
		<div class = "mt-3">
		<div class="container-fluid d-felx p-3 m-0">
			<div class="row w-100 m-0 p-3 bg-white" style="border-radius: 0px 75px 0px 75px;min-height:400px">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 m-0 p-0" style="background-color: rgb(247, 247, 247);border-radius: 0px 75px 75px 75px;border: 1px solid lightgrey;">
					<div class="row h-100">
						<div class="col-md-6 text-center p-3" style="align-self: center;">
							<img src="logos/<?php echo $image ?>" style="width: 150px;" class="rounded">
						</div>
						<div class="col-md-6 p-3 text-center" style="align-self: center;">
							<div><?php echo $sName ?></div><br>
<?php if ( isset($privacy) AND !empty($privacy) ){
?>
	
	<a data-toggle="modal" data-target="#exampleModal" class="p-3"><img src="https://i.imgur.com/aOImLoZ.png" style="width:25px;height:25px"></a>
<?php
}
?>						
<a href="https://www.instagram.com/<?php echo $sInsta ?>" target="_blank" >
<svg height="511pt" viewBox="0 0 511 511.9" width="511pt" xmlns="http://www.w3.org/2000/svg" style="height: 25px;width: 25px;
"><path d="m510.949219 150.5c-1.199219-27.199219-5.597657-45.898438-11.898438-62.101562-6.5-17.199219-16.5-32.597657-29.601562-45.398438-12.800781-13-28.300781-23.101562-45.300781-29.5-16.296876-6.300781-34.898438-10.699219-62.097657-11.898438-27.402343-1.300781-36.101562-1.601562-105.601562-1.601562s-78.199219.300781-105.5 1.5c-27.199219 1.199219-45.898438 5.601562-62.097657 11.898438-17.203124 6.5-32.601562 16.5-45.402343 29.601562-13 12.800781-23.097657 28.300781-29.5 45.300781-6.300781 16.300781-10.699219 34.898438-11.898438 62.097657-1.300781 27.402343-1.601562 36.101562-1.601562 105.601562s.300781 78.199219 1.5 105.5c1.199219 27.199219 5.601562 45.898438 11.902343 62.101562 6.5 17.199219 16.597657 32.597657 29.597657 45.398438 12.800781 13 28.300781 23.101562 45.300781 29.5 16.300781 6.300781 34.898438 10.699219 62.101562 11.898438 27.296876 1.203124 36 1.5 105.5 1.5s78.199219-.296876 105.5-1.5c27.199219-1.199219 45.898438-5.597657 62.097657-11.898438 34.402343-13.300781 61.601562-40.5 74.902343-74.898438 6.296876-16.300781 10.699219-34.902343 11.898438-62.101562 1.199219-27.300781 1.5-36 1.5-105.5s-.101562-78.199219-1.300781-105.5zm-46.097657 209c-1.101562 25-5.300781 38.5-8.800781 47.5-8.601562 22.300781-26.300781 40-48.601562 48.601562-9 3.5-22.597657 7.699219-47.5 8.796876-27 1.203124-35.097657 1.5-103.398438 1.5s-76.5-.296876-103.402343-1.5c-25-1.097657-38.5-5.296876-47.5-8.796876-11.097657-4.101562-21.199219-10.601562-29.398438-19.101562-8.5-8.300781-15-18.300781-19.101562-29.398438-3.5-9-7.699219-22.601562-8.796876-47.5-1.203124-27-1.5-35.101562-1.5-103.402343s.296876-76.5 1.5-103.398438c1.097657-25 5.296876-38.5 8.796876-47.5 4.101562-11.101562 10.601562-21.199219 19.203124-29.402343 8.296876-8.5 18.296876-15 29.398438-19.097657 9-3.5 22.601562-7.699219 47.5-8.800781 27-1.199219 35.101562-1.5 103.398438-1.5 68.402343 0 76.5.300781 103.402343 1.5 25 1.101562 38.5 5.300781 47.5 8.800781 11.097657 4.097657 21.199219 10.597657 29.398438 19.097657 8.5 8.300781 15 18.300781 19.101562 29.402343 3.5 9 7.699219 22.597657 8.800781 47.5 1.199219 27 1.5 35.097657 1.5 103.398438s-.300781 76.300781-1.5 103.300781zm0 0"></path><path d="m256.449219 124.5c-72.597657 0-131.5 58.898438-131.5 131.5s58.902343 131.5 131.5 131.5c72.601562 0 131.5-58.898438 131.5-131.5s-58.898438-131.5-131.5-131.5zm0 216.800781c-47.097657 0-85.300781-38.199219-85.300781-85.300781s38.203124-85.300781 85.300781-85.300781c47.101562 0 85.300781 38.199219 85.300781 85.300781s-38.199219 85.300781-85.300781 85.300781zm0 0"></path><path d="m423.851562 119.300781c0 16.953125-13.746093 30.699219-30.703124 30.699219-16.953126 0-30.699219-13.746094-30.699219-30.699219 0-16.957031 13.746093-30.699219 30.699219-30.699219 16.957031 0 30.703124 13.742188 30.703124 30.699219zm0 0"></path></svg></a>
							
<a href="https://wa.me/<?php echo $sMobile ?>" target="_blank" style="margin-left:20px"><svg height="682pt" viewBox="-23 -21 682 682.66669" width="682pt" xmlns="http://www.w3.org/2000/svg" style="
height: 25px;
width: 25px;
"><path d="m544.386719 93.007812c-59.875-59.945312-139.503907-92.9726558-224.335938-93.007812-174.804687 0-317.070312 142.261719-317.140625 317.113281-.023437 55.894531 14.578125 110.457031 42.332032 158.550781l-44.992188 164.335938 168.121094-44.101562c46.324218 25.269531 98.476562 38.585937 151.550781 38.601562h.132813c174.785156 0 317.066406-142.273438 317.132812-317.132812.035156-84.742188-32.921875-164.417969-92.800781-224.359376zm-224.335938 487.933594h-.109375c-47.296875-.019531-93.683594-12.730468-134.160156-36.742187l-9.621094-5.714844-99.765625 26.171875 26.628907-97.269531-6.269532-9.972657c-26.386718-41.96875-40.320312-90.476562-40.296875-140.28125.054688-145.332031 118.304688-263.570312 263.699219-263.570312 70.40625.023438 136.589844 27.476562 186.355469 77.300781s77.15625 116.050781 77.132812 186.484375c-.0625 145.34375-118.304687 263.59375-263.59375 263.59375zm144.585938-197.417968c-7.921875-3.96875-46.882813-23.132813-54.148438-25.78125-7.257812-2.644532-12.546875-3.960938-17.824219 3.96875-5.285156 7.929687-20.46875 25.78125-25.09375 31.066406-4.625 5.289062-9.242187 5.953125-17.167968 1.984375-7.925782-3.964844-33.457032-12.335938-63.726563-39.332031-23.554687-21.011719-39.457031-46.960938-44.082031-54.890626-4.617188-7.9375-.039062-11.8125 3.476562-16.171874 8.578126-10.652344 17.167969-21.820313 19.808594-27.105469 2.644532-5.289063 1.320313-9.917969-.664062-13.882813-1.976563-3.964844-17.824219-42.96875-24.425782-58.839844-6.4375-15.445312-12.964843-13.359374-17.832031-13.601562-4.617187-.230469-9.902343-.277344-15.1875-.277344-5.28125 0-13.867187 1.980469-21.132812 9.917969-7.261719 7.933594-27.730469 27.101563-27.730469 66.105469s28.394531 76.683594 32.355469 81.972656c3.960937 5.289062 55.878906 85.328125 135.367187 119.648438 18.90625 8.171874 33.664063 13.042968 45.175782 16.695312 18.984374 6.03125 36.253906 5.179688 49.910156 3.140625 15.226562-2.277344 46.878906-19.171875 53.488281-37.679687 6.601563-18.511719 6.601563-34.375 4.617187-37.683594-1.976562-3.304688-7.261718-5.285156-15.183593-9.253906zm0 0" fill-rule="evenodd"></path></svg></a>
							<br>
						</div>
					</div>
				</div>
				
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-left m-0 p-3" style="align-self: center;">
				<table style="width:100%">
					<?php 
						echo "<tr><td class='text-right'><b>Date:</b></td><td class='text-left'>" . $date . "</td></tr>";
						echo "<tr><td class='text-right'><b>Name:</b></td><td class='text-left'>" . $name . "</td></tr>";
						echo "<tr><td class='text-right'><b>Mobile:</b></td><td class='text-left'>" . $mobile . "</td></tr>";
						echo "<tr><td class='text-right'><b>Email:</b></td><td class='text-left'>" . $email . "</td></tr>";
						echo "<tr><td class='text-right'><b>Details:</b></td><td class='text-left'>" . $details . "</td></tr>";
						echo "<tr><td class='text-right'><b>Service Charges:</b></td><td class='text-left'>" . $commission . " KD</td></tr>";
						echo "<tr><td><b>Price:</b></td><td class='text-left'>" . $price . " KD</td></tr>";
						
					?>
					<?php if ( isset($privacy) AND !empty($privacy) ){
					?>
						<tr><td colspan="2" class="text-center" ><a data-toggle="modal" data-target="#exampleModal" class="p-3" style="text-decoration: none;color:darkblue">الشروط و الأحكام / Privacy Policy</a></td></tr>
					<?php
					}
					?>	
					</table>
					<div class="row mt-2 text-center">
					<?php
					if ( $paymentStatus == 0 ){
					?>
						<!-- Pending -->
						<div class="col-12 text-left mb-3">
							<form action="payment2" method="POST">
							<input type="hidden" name="paymentMethod" value="1">
							<input type="hidden" name="paymentId" value="<?php echo $LinkId ?>">
							<button type="submit" class="btn btn-light" style="width:100%; background-color: rgb(247, 247, 247);border: 1px solid lightgrey;">
							<div class="row m-0 p-0">
							<div class="col p-0">
							<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 13 15" enable-background="new 0 0 13 15" xml:space="preserve" style="
    height: 35px;
    width: 35px;
">
<g>
	<rect x="0.399" y="1.361" fill="#0B73B9" width="12.202" height="3.377"></rect>
	<polygon fill="#F9E715" points="5.352,7.377 5.352,9.291 2.625,9.291 2.625,5.709 5.352,5.709 5.352,7.251 7.319,5.709 
		10.963,5.709 8.914,7.305 11.12,9.291 7.199,9.291 	"></polygon>
	<path fill="#0B73B9" d="M12.601,5.157H0.399v4.895h12.202V5.157z M5.352,7.377v1.914H2.625V5.709h2.727v1.542l1.966-1.542h3.644
		L8.914,7.305l2.205,1.985h-3.92L5.352,7.377z"></path>
	<rect x="0.399" y="10.472" fill="#0B73B9" width="12.202" height="3.167"></rect>
</g>
</svg>
							</div>
							
							<div class="col text-left p-0" style="text-align: left;">
							K-NET
							</div>
							
							<div class="col text-right p-0" style="border: 1px solid #e9ecef;
    background-color: rgb(255 255 255);">
							<?php echo (round($price,2)+$commission) . "KD"; ?>
							</div>
							
							</button>
							</form>
						</div>
						<div class="col-12 text-center">
							<form action="payment2" method="POST">
							<input type="hidden" name="paymentMethod" value="2">
							<input type="hidden" name="paymentId" value="<?php echo $LinkId ?>">
							
							<button type="submit" class="btn btn-light" style="width:100%; background-color: rgb(247, 247, 247);border: 1px solid lightgrey;">
							<div class="row m-0 p-0">
							<div class="col p-0">
							<div class="col p-0">
							<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 19 15" enable-background="new 0 0 19 15" xml:space="preserve" style="
    height: 35px;
    width: 35px;
">
<path fill="#1A1F71" d="M7.398,4.779l-2.287,5.456H3.62L2.494,5.881C2.426,5.613,2.367,5.515,2.159,5.402
	c-0.339-0.184-0.9-0.357-1.392-0.464L0.8,4.779h2.402c0.306,0,0.581,0.204,0.651,0.556l0.594,3.157l1.468-3.713H7.398z
	 M13.244,8.454c0.006-1.44-1.99-1.52-1.977-2.163c0.004-0.195,0.191-0.404,0.598-0.457c0.202-0.026,0.76-0.047,1.392,0.244
	l0.247-1.157c-0.34-0.123-0.777-0.241-1.32-0.241c-1.395,0-2.377,0.741-2.385,1.803c-0.009,0.785,0.701,1.223,1.235,1.485
	c0.55,0.267,0.735,0.439,0.732,0.678c-0.004,0.366-0.439,0.528-0.844,0.534c-0.71,0.011-1.122-0.192-1.45-0.345l-0.256,1.196
	c0.33,0.151,0.939,0.283,1.569,0.29C12.269,10.32,13.239,9.588,13.244,8.454 M16.928,10.235h1.305l-1.14-5.456h-1.204
	c-0.271,0-0.5,0.157-0.601,0.4l-2.118,5.056h1.482l0.294-0.815h1.81L16.928,10.235z M15.353,8.302l0.743-2.049l0.427,2.049H15.353z
	 M9.415,4.779l-1.167,5.456H6.837l1.167-5.456H9.415z"></path>
</svg>
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16 15" enable-background="new 0 0 16 15" xml:space="preserve" style="
    height: 35px;
    width: 35px;
">
<g>
	<g>
		<rect x="5.904" y="3.733" fill="#EA611C" width="4.192" height="7.534"></rect>
		<path id="_Path__56_" fill="#E31221" d="M6.17,7.501C6.168,6.03,6.843,4.641,8,3.733C5.919,2.098,2.907,2.459,1.272,4.54
			c-1.635,2.08-1.274,5.093,0.807,6.728c1.737,1.365,4.184,1.365,5.921,0C6.843,10.36,6.169,8.971,6.17,7.501z"></path>
		<path fill="#F49D1E" d="M15.752,7.501c0,2.646-2.145,4.791-4.791,4.791c-1.074,0-2.117-0.361-2.961-1.025
			c2.08-1.635,2.442-4.647,0.807-6.728C8.571,4.24,8.3,3.969,8,3.733c2.08-1.635,5.092-1.275,6.728,0.805
			c0.664,0.844,1.025,1.887,1.025,2.961V7.501z"></path>
	</g>
</g>
</svg>
							</div>
							</div>
							
							<div class="col text-left p-0" style="text-align: left;">
							VISA
							</div>
							
							<div class="col text-right p-0" style="border: 1px solid #e9ecef;
    background-color: rgb(255 255 255);">
							<?php
							$realCommission = $commission - 0.15;
							$visaPrice = $price ;//- $commission;
							$visaPrice = $visaPrice + ($visaPrice * 2.5 / 100);
							$visaPrice = $visaPrice + $commission;
							echo round($visaPrice,2) . "KD";
							?>
							</div>
							
							</button>
							</form>
						</div>
						
					<?php
					}elseif( $paymentStatus == 1 ){
						?>
						<!-- Paid -->
						<div class="col text-center">
						<img src="https://i.imgur.com/rxA7Tzq.png" style="width:50px;height:50px"> <b>Successfull Payment.</b>
						</div>
						<?php
					}elseif( $paymentStatus == 2 ){
						?>
						<!-- failed -->
						<div class="row w-100 p-0 m-0">
						<div class="col text-center mb-3">
						<img src="https://i.imgur.com/4CogdVl.png" style="width:50px;height:50px"> <b>Failed attempt</b>, please retry.
						</div>
						</div>
						<div class="row w-100 p-0 m-0">
						<div class="col-12 text-left mb-3">
							<form action="payment2" method="POST">
							<input type="hidden" name="paymentMethod" value="1">
							<input type="hidden" name="paymentId" value="<?php echo $LinkId ?>">
							<button type="submit" class="btn btn-light" style="width:100%; background-color: rgb(247, 247, 247);border: 1px solid lightgrey;">
							<div class="row m-0 p-0">
							<div class="col p-0">
							<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 13 15" enable-background="new 0 0 13 15" xml:space="preserve" style="
    height: 35px;
    width: 35px;
">
<g>
	<rect x="0.399" y="1.361" fill="#0B73B9" width="12.202" height="3.377"></rect>
	<polygon fill="#F9E715" points="5.352,7.377 5.352,9.291 2.625,9.291 2.625,5.709 5.352,5.709 5.352,7.251 7.319,5.709 
		10.963,5.709 8.914,7.305 11.12,9.291 7.199,9.291 	"></polygon>
	<path fill="#0B73B9" d="M12.601,5.157H0.399v4.895h12.202V5.157z M5.352,7.377v1.914H2.625V5.709h2.727v1.542l1.966-1.542h3.644
		L8.914,7.305l2.205,1.985h-3.92L5.352,7.377z"></path>
	<rect x="0.399" y="10.472" fill="#0B73B9" width="12.202" height="3.167"></rect>
</g>
</svg>
							</div>
							
							<div class="col text-left p-0" style="text-align: left;">
							K-NET
							</div>
							
							<div class="col text-right p-0" style="border: 1px solid #e9ecef;
    background-color: rgb(255 255 255);">
							<?php echo (round($price,2)+$commission) . "KD"; ?>
							</div>
							
							</button>
							</form>
						</div>
						<div class="col-12 text-center">
							<form action="payment2" method="POST">
							<input type="hidden" name="paymentMethod" value="2">
							<input type="hidden" name="paymentId" value="<?php echo $LinkId ?>">
							
							<button type="submit" class="btn btn-light" style="width:100%; background-color: rgb(247, 247, 247);border: 1px solid lightgrey;">
							<div class="row m-0 p-0">
							<div class="col p-0">
							<div class="col p-0">
							<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 19 15" enable-background="new 0 0 19 15" xml:space="preserve" style="
    height: 35px;
    width: 35px;
">
<path fill="#1A1F71" d="M7.398,4.779l-2.287,5.456H3.62L2.494,5.881C2.426,5.613,2.367,5.515,2.159,5.402
	c-0.339-0.184-0.9-0.357-1.392-0.464L0.8,4.779h2.402c0.306,0,0.581,0.204,0.651,0.556l0.594,3.157l1.468-3.713H7.398z
	 M13.244,8.454c0.006-1.44-1.99-1.52-1.977-2.163c0.004-0.195,0.191-0.404,0.598-0.457c0.202-0.026,0.76-0.047,1.392,0.244
	l0.247-1.157c-0.34-0.123-0.777-0.241-1.32-0.241c-1.395,0-2.377,0.741-2.385,1.803c-0.009,0.785,0.701,1.223,1.235,1.485
	c0.55,0.267,0.735,0.439,0.732,0.678c-0.004,0.366-0.439,0.528-0.844,0.534c-0.71,0.011-1.122-0.192-1.45-0.345l-0.256,1.196
	c0.33,0.151,0.939,0.283,1.569,0.29C12.269,10.32,13.239,9.588,13.244,8.454 M16.928,10.235h1.305l-1.14-5.456h-1.204
	c-0.271,0-0.5,0.157-0.601,0.4l-2.118,5.056h1.482l0.294-0.815h1.81L16.928,10.235z M15.353,8.302l0.743-2.049l0.427,2.049H15.353z
	 M9.415,4.779l-1.167,5.456H6.837l1.167-5.456H9.415z"></path>
</svg>
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16 15" enable-background="new 0 0 16 15" xml:space="preserve" style="
    height: 35px;
    width: 35px;
">
<g>
	<g>
		<rect x="5.904" y="3.733" fill="#EA611C" width="4.192" height="7.534"></rect>
		<path id="_Path__56_" fill="#E31221" d="M6.17,7.501C6.168,6.03,6.843,4.641,8,3.733C5.919,2.098,2.907,2.459,1.272,4.54
			c-1.635,2.08-1.274,5.093,0.807,6.728c1.737,1.365,4.184,1.365,5.921,0C6.843,10.36,6.169,8.971,6.17,7.501z"></path>
		<path fill="#F49D1E" d="M15.752,7.501c0,2.646-2.145,4.791-4.791,4.791c-1.074,0-2.117-0.361-2.961-1.025
			c2.08-1.635,2.442-4.647,0.807-6.728C8.571,4.24,8.3,3.969,8,3.733c2.08-1.635,5.092-1.275,6.728,0.805
			c0.664,0.844,1.025,1.887,1.025,2.961V7.501z"></path>
	</g>
</g>
</svg>
							</div>
							</div>
							
							<div class="col text-left p-0" style="text-align: left;">
							VISA
							</div>
							
							<div class="col text-right p-0" style="border: 1px solid #e9ecef;
    background-color: rgb(255 255 255);">
							<?php
							$realCommission = $commission - 0.15;
							$visaPrice = $price ;//- $commission;
							$visaPrice = $visaPrice + ($visaPrice * 2.5 / 100);
							$visaPrice = $visaPrice + $commission;
							echo round($visaPrice,2) . "KD";
							?>
							</div>
							
							</button>
							</form>
						</div>
						</div>
						<?php
					}elseif( $paymentStatus == 3 ){
						?>
						<!-- Refunded -->
						<div class="col text-center">
						<img src="https://i.imgur.com/UcGoyWT.png" style="width:50px;height:50px"> <b>Refuned Successfully.</b>
						</div>
						<?php
					}elseif( $paymentStatus == 4 ){
						?>
						<!-- Expired -->
						<div class="col text-center">
						<img src="https://i.imgur.com/ItoEbKW.png" style="width:50px;height:50px"> <b>Expired Invoice.</b>
						</div>
						<?php
					}
					?>
					</div>
				</div>
			</div>
		</div>
		<div class="mb-3" style="
    text-align: center;
    color: white;
"><svg xmlns="http://www.w3.org/2000/svg" width="141.293" height="151.162" viewBox="0 0 141.293 151.162" style="
    height: 25px;
    width: 25px;
">
  <g id="Group_1" data-name="Group 1" transform="translate(-94.4 -69.85)">
    <path id="Path_1" data-name="Path 1" d="M204.949,86.407A10.622,10.622,0,0,0,197.8,72.255,75.667,75.667,0,0,0,106.044,125a76.26,76.26,0,0,1,26.13-27.16c18.151-11.206,41.768-11.861,57.543-5.815a20.726,20.726,0,0,0,2.041.668l.413.114a10.639,10.639,0,0,0,12.779-6.4Z" transform="translate(-9.635)" fill="#fff"></path>
    <path id="Path_2" data-name="Path 2" d="M120.86,274.926c-5.967-12.332-6.634-22.913-5.955-30.109a54.368,54.368,0,0,1,54.29-53.124q1.323,0,2.631.065c-17.729-1.7-41.447,2.206-57.871,17.291a73.66,73.66,0,0,0-7.252,7.66,55.413,55.413,0,0,0-9.861,51.2,75.657,75.657,0,0,0,87.418,52.161C147.991,315.53,130.719,295.3,120.86,274.926Z" transform="translate(0 -100.569)" fill="#fff"></path>
    <path id="Path_3" data-name="Path 3" d="M298.058,700.393a55.632,55.632,0,0,0,24.2,1.312,39.9,39.9,0,0,0,14.125-5.286,75.757,75.757,0,0,0,11.006-8.1,29.638,29.638,0,0,1-10.514-5.471,20.329,20.329,0,0,1-5.931-8.526c-9.6,7.594-21.849,12.667-35.056,11.68-25.03-1.871-37.365-13-46.655-28.465C259.018,678.5,280.1,695.366,298.058,700.393Z" transform="translate(-128.118 -486.285)" fill="#fff"></path>
    <path id="Path_4" data-name="Path 4" d="M769.963,581.979s-4.479,9.028-12.667,13.227-10.707,7.908-9.448,13.507,10.217,11.547,17.565,8.048,10.078-15.676,10.637-22.115-1.819-17.006-1.819-17.006-1.4,9.938-8.258,14.207C765.974,591.847,768,589.537,769.963,581.979Z" transform="translate(-540.443 -420.172)" fill="#fff"></path>
  </g>
</svg> Create Pay</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Privacy Policy</h5>
      </div>
      <div class="modal-body">
        <?php echo $privacy ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
		
		<script>
		<?php if ( isset($privacy) AND !empty($privacy) ){
			?>
		$('form').submit(function () { 
			if(confirm("Do you agree to the  terms and conditions? (هل توافق على الشروط  و الأحكام؟)")) {
                return true;
            }else{
                return false;
            }
		});
		<?php
		}
		?>
		</script>
		
	</body>
</html>