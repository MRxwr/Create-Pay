<?php
require("includes/config.php");
if ( !isset($_GET["status"]) AND !isset($_GET["LinkId"]) AND !isset($_GET["paymentId"]) ){
	header("LOCATION: index.php");die();
}

if ( isset($_GET["LinkId"]) ) {
	$id = $_GET["LinkId"];
	$sql = "SELECT *
			FROM `invoices`
			WHERE `linkCode` LIKE '".$id."'";
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
}

if ( isset($_GET["paymentId"]) ){
	
	$paymentId = $_GET["paymentId"];
	
	//updating invoice
	
	$token = "hE-2B3TuAQ-ea717-mLkkfajc240Eh4PmRFLRugNAw3aQMTfsNaL9_IsHPKEYQ7P7Ov7AyXRk_JRTOEOP9aNt6KbOx5bWU7P60vqFEHyMSqGXMyTyFzR7knj9eJukd-fr2VKK0Ti0Xic2z7dmYeZAQ8gZd_LOmDHy8kMqBaL6Sgom0HRGJxNXy8dIqcyVe2vgJ5fjE40NzrTKktY9E5_3ELgTi5qFgAZTDk76WmblxT36oCZqAs2BxhBVD2-3uQbrEN3FtdQ8sladuRF5CX4znVQ7eSXZ1UyzcDiW2FqyNVbU2JasG9MC2u8Cz5xLKO1dU8PDXaETqeDJ-8DLxQ-1fed7NqJKSPnGOMwSrSRDIzCqRtqeXVVaqgngy0GDM88NRusZmBq73zqao577UfZcGjNGo-hlbPYS_0gYm-fAla0OkZeZjAJCgrDNTu0L1As0P27crSu2LUl6MNZn5iHkd1lUiCnRPwE7Ppky1C_t-l6lCuQcv-hkV9fv-EbcsIdnhBZhzG7_QG9jEZVjpj_FxcSTlv0EraCdI9O4rd0-pYesfbEEAE6YseARJ4iRXXVOYzy_lMLqGfu1kw_bOjJp1VPCMJA78N6uIh9PFdozgfBq6-UkDTCOEnozsRsILfO96buzhRRF0Czkde4NvBzt7jAPoqbEFcOn4mwzkLa_qDPOoVMOsQc12Vgcsb7klV0ktRJBA"; 
	
	//$token = "rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL"; 
	//token value to be placed here;
	$basURL = "https://api.myfatoorah.com";

	$invoiceArray = 
	[
		"Key" => $_GET["paymentId"],
		"KeyType" => 'paymentId'
	];
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "$basURL/v2/GetPaymentStatus",
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => json_encode($invoiceArray),
	  CURLOPT_HTTPHEADER => array("Authorization: Bearer $token","Content-Type: application/json"),
	));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);
	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		$resultMY = json_decode($response, true);
		$orderId = $resultMY["Data"]["InvoiceId"];
		if ( $resultMY["Data"]["InvoiceStatus"] == "Paid" ){
			$sql = "UPDATE 
					`invoices`
					SET 
					`status` = '1'
					WHERE 
					`orderId` = '".$orderId."'
					";
			$result = $dbconnect->query($sql);
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
	}
	
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
	echo $supplierCode = $row["supplierCode"];
	$id = $row["linkCode"];
}

if ( isset($_GET["status"]) )
{
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
$image = $row["imageurl"];

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
			background-image: linear-gradient(135deg, #32c5f5,#4495da);
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
	
	<header class="header mt-auto py-2 fixed-top topNav">
		<div class="container-fluid d-flex ml-3">
			<div class="row w-100">
				<div class="col-6 text-left">
					<b>CREATE-PAY</b>
				</div>
				<div class="col-6" style="text-align: right;">
					<b>Learn More...</b>
				</div>
			</div>
		</div>
	</header> 
		<div class = "main mainMargin" style="max-width:1280px;margin: auto;">
		<div class = "wrapper">
		<div class="container-fluid d-felx p-3 m-0">
			<div class="row w-100 m-0 p-3 bg-white" style=";box-shadow: 0px 0px 10px 10px #00a9ec;border-radius: 0px 75px 0px 75px;min-height:400px">
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 m-0 p-0" style="background-color:#7bccec;border-radius: 0px 75px 75px 75px;box-shadow:0px 0px 10px 2px #7bccec;">
					<div class="row h-100">
						<div class="col-md-6 text-center p-3" style="align-self: center;">
							<img src="../logos/<?php echo $image ?>" style="width: 150px;" class="rounded">
						</div>
						<div class="col-md-6 p-3 text-center" style="align-self: center;">
							<b><?php echo $sName ?></b><br>
							Contact information<br>
							Instagram: <?php echo $sInsta ?><br>
							Phone: +<?php echo $sMobile ?>
						</div>
					</div>
				</div>
				
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-left m-0 p-3" style="align-self: center;">
					<?php 
						echo "Date: " . $date . "<br>";
						echo "Name: " . $name . "<br>";
						echo "Mobile: " . $mobile . "<br>";
						echo "Email: " . $email . "<br>";
						echo "Details: " . $details . "<br>";
						echo "<b>Price: " . $price . " KD</b><br>";
					?>
					<div class="row mt-3 text-center">
					<?php
					if ( $paymentStatus == 0 ){
					?>
						<!-- Pending -->
						<div class="col text-center">
							<form action="payment" method="POST">
							<input type="hidden" name="paymentMethod" value="1">
							<input type="hidden" name="paymentId" value="<?php echo $_GET["LinkId"] ?>">
							<button type="submit" class="btn btn-light" style="width:100%"><img src="https://i.imgur.com/4JLfx6S.png" style="width:50px;height:25px"></button>
							</form>
						</div>
						<div class="col text-center">
							<form action="payment" method="POST">
							<input type="hidden" name="paymentMethod" value="2">
							<input type="hidden" name="paymentId" value="<?php echo $_GET["LinkId"] ?>">
							<button type="submit" class="btn btn-light" style="width:100%"><img src="https://i.imgur.com/sxwa2ux.png" style="width:50px;height:25px"></button>
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
						<div class="col text-center">
							<form action="payment" method="POST">
							<input type="hidden" name="paymentMethod" value="1">
							<input type="hidden" name="paymentId" value="<?php echo $_GET["LinkId"] ?>">
							<button type="submit" class="btn btn-light" style="width:100%"><img src="https://i.imgur.com/4JLfx6S.png" style="width:50px;height:25px"></button>
							</form>
						</div>
						<div class="col text-center">
							<form action="payment" method="POST">
							<input type="hidden" name="paymentMethod" value="2">
							<input type="hidden" name="paymentId" value="<?php echo $_GET["LinkId"] ?>">
							<button type="submit" class="btn btn-light" style="width:100%"><img src="https://i.imgur.com/sxwa2ux.png" style="width:50px;height:25px"></button>
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
		
		</div>
		</div>

		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	</body>
</html>