<?php
SESSION_START();
require ('../admin/includes/translate.php');
require ('../admin/includes/config.php');

if( isset($_POST["client"]) ){
	$sql = "SELECT *
			FROM `clients`
			WHERE
			`id` LIKE '".$_POST["client"]."'
			";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();
	$output = $row["id"] . "^";
	$output .= $row["fullName"] . "^";
	$output .= $row["email"] . "^";
	$output .= $row["phone"] . "^";
	$output .= $row["instaA"] . "^";
	$output .= $row["sCode"] . "^";
	$output .= $row["sRef"] . "^";
	$output .= $row["commission"] . "^";
	$output .= $row["privacy"] . "^";
	$output .= $row["payAPIToken"] . "^";
	echo $output;
}

if ( isset($_POST["homeForm"]) )
{
	$homeFormA = '<p class="mb-2">'.$selectAreaText.'</p><div class="form-group">
			<select name="area" class="form-control" required>';
			$sql = "SELECT * FROM `areas`";
			$result = $dbconnect->query($sql);
			while ( $row = $result->fetch_assoc() )
			{
$homeFormA .= '<option value="'.$row["id"].'">'.$row["arTitle"].'</option>';
			}
$homeFormA .= '</select>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="block" placeholder="'.$blockText.'" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="street" placeholder="'.$streetText.'" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="avenue" placeholder="'.$avenueText.'" >
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="house" placeholder="'.$houseText.'" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="notes" placeholder="'.$specialInstructionText.'">
			</div>';
			echo $homeFormA;
}
if ( isset($_POST["pickUpform"]) )
{
	$homeFormA = '
			</div>
			<div class="form-group">
			<input type="hidden" class="form-control" name="area" placeholder="'.$selectAreaText.'">
				<input type="hidden" class="form-control" name="block" placeholder="'.$blockText.'">
			</div>
			<div class="form-group">
				<input type="hidden" class="form-control" name="street" placeholder="'.$streetText.'">
			</div>
			<div class="form-group">
				<input type="hidden" class="form-control" name="avenue" placeholder="'.$avenueText.'" >
			</div>
			<div class="form-group">
				<input type="hidden" class="form-control" name="house" placeholder="'.$houseText.'">
			</div>
			<div class="form-group">
				<input type="hidden" class="form-control" name="notes" placeholder="'.$specialInstructionText.'">
			</div>';
			echo $homeFormA;
}

if ( isset($_POST["apartmentForm"]))
{
	$apartmentFormA = '<p class="mb-2">'.$selectAreaText.'</p><div class="form-group">
				<select name="areaa" class="form-control" required>';
	$sql = "SELECT * FROM `areas`";
	$result = $dbconnect->query($sql);
	while ( $row = $result->fetch_assoc() )
	{
		$apartmentFormA .= '<option value="'.$row["id"].'">'.$row["arTitle"].'</option>';
	}
	$apartmentFormA .= '</select>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="blocka" placeholder="'.$blockText.'" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="streeta" placeholder="'.$streetText.'" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="avenuea" placeholder="'.$avenueText.'">
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="building" placeholder="'.$buildingText.'" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="floor" placeholder="'.$floorText.'" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="apartment" placeholder="'.$apartmentText.'" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="notesa" placeholder="'.$specialInstructionText.'">
			</div>';
			echo $apartmentFormA;
}

if ( isset($_POST["removeItemBoxId"]) )
{
	$id = $_POST["removeItemBoxId"];
	$size = $_POST["removeItemBoxSize"];
	
	for ( $i = 0; $i < sizeof ($_SESSION["cart"]["id"]) ; $i ++ )
	{
		if (
			($_SESSION["cart"]["id"][$i] == $id) AND
			($_SESSION["cart"]["size"][$i] == $size)
			)
		{
			unset($_SESSION["cart"]["id"][$i]);
			unset($_SESSION["cart"]["qorder"][$i]);
			unset($_SESSION["cart"]["size"][$i]);
			
			$_SESSION["cart"]["id"] = array_values($_SESSION["cart"]["id"]);
			$_SESSION["cart"]["qorder"] = array_values($_SESSION["cart"]["qorder"]);
			$_SESSION["cart"]["size"] = array_values($_SESSION["cart"]["size"]);
		}
	}
	$cartItemsNo = sizeof($_SESSION["cart"]["id"]);
	echo $cartItemsNo;
}

if ( isset($_GET["itemIndexM"]) )
{
	$key = $_GET["itemIndexM"];
	if($_SESSION["cart"]["qorder"][$key] > 1){
	$_SESSION["cart"]["qorder"][$key] = $_SESSION["cart"]["qorder"][$_GET["itemIndexM"]] - 1;
	}
	$result = (string)$_SESSION["cart"]["qorder"][$key];
	echo  $result;
}

if ( isset($_GET["itemIndexP"]) )
{
	$key = $_GET["itemIndexP"];
	$_SESSION["cart"]["qorder"][$key] = $_SESSION["cart"]["qorder"][$_GET["itemIndexP"]] + 1;
	$result = (string)$_SESSION["cart"]["qorder"][$key];
	echo  $result;
}

if ( isset($_POST["checkVoucherVal"]) && isset($_POST["totals2"]) && isset($_POST["shippingChargesInput"])  ) 
{
	$sql = "SELECT `percentage` , `id`
			FROM `vouchers`
			WHERE `voucher` LIKE '".$_POST["checkVoucherVal"]."'
			AND `hidden` != '1'
			";
	$result = $dbconnect->query($sql);
	$totals2 = $_POST["totals2"];
	$totals4Location = $_POST["totals2"];
	if ( $result->num_rows == 0 )
	{
		$shoppingCharges = $_POST["shippingChargesInput"];
		$totals2 = $totals2 + $shoppingCharges ;
		$msg = $voucherInvalidText ;
		$voucherId = "";
		$discountPercentage = 0;
	}
	else
	{
		$shoppingCharges = $_POST["shippingChargesInput"];
		$row = $result->fetch_assoc();
		$_SESSION["createKW"]["orderVoucher"] = $row["id"];
		$voucherId = $row["id"];
		$msg = $validVoucherText ;
		if ( $row["percentage"] == 100 )
		{
			$pMethod = $_POST["paymentMethodInput"];
			$shoppingCharges = $_POST["shippingChargesInput"];
			$sql = "SELECT `location` , `id`
					FROM `locations`
					";
			$result = $dbconnect->query($sql);
			$msg .= "<br><br>";
			$msg .= "<form method='POST' action='details'><select name='location' onchange='this.form.submit()'>";
			$msg .= '<option>'.$selectStoreText.'</option>';
			while ( $row = $result->fetch_assoc() )
			{
				$msg .= '<option value="'.$row["id"].'">'.$row["location"].'</option>';
			}
			$msg .= "</select><input type='hidden' name='totalPrice' value='". ($totals4Location+(float)$shoppingCharges) ."'><input type='hidden' name='pMethod'  value='".$pMethod."'><input type='hidden' name='charges'  value='".$shoppingCharges."'></from>";
		}
		$totals2 = $totals2 - ( (float)$totals2 * (float)$row["percentage"] / 100 );
		$totals2 = $totals2 + $shoppingCharges;
		$discountPercentage = (float)$row["percentage"];
		
	}
 	echo $totals2.','.$msg.','.$voucherId.",".$shoppingCharges .",".$discountPercentage;
}

if ( isset($_POST["emailAj"]) AND !empty($_POST["emailAj"]) )
{
	$email = $_POST["emailAj"];
	$password1 = rand(00000000,99999999);
	$password = sha1($password1);
	$sql = "SELECT * FROM `users` WHERE `email` LIKE '".$email."' ";
	$result = $dbconnect->query($sql);
	if ( $result->num_rows == 1 )
	{
		$row = $result->fetch_assoc();
		$name = $row["fullName"];
		$sql = "UPDATE `users` SET `password` = '".$password."' WHERE `email` LIKE '".$email."'";
		$result = $dbconnect->query($sql);

		$to = $email;
		$subject = "Forget Password - Create-Kw";
		$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n" . 'From: 						    noreply@Create-Kw.com';
		$msg = '<html><body><center>
				<img src="https://i.imgur.com/m7XjQj2.png" style="width:200px;height:200px">
				<p>&nbsp;</p>
				<p>Dear '.$name.',</p>
				<p>Your new password at <br> <strong> <a href="https://Create-Kw.com/">Create-Kw.com</a></strong> is:<br>
				</p>
				<p style="font-size: 25px; color: red"><strong>'.$password1.'</strong></p>
				<p>Best regards,<br>
				<strong>Create-Kw.com</strong></p>
				</center></body></html>';
		$message = html_entity_decode($msg);
		mail($to, $subject, $msg, $headers);

		echo $passwordToEmailText ;
	}
	else
	{
		echo $emailInvalidText;
	}
}

if ( isset($_POST["nameReg"]) AND !empty($_POST["nameReg"]) AND isset($_POST["phoneReg"]) AND !empty($_POST["phoneReg"]) AND isset($_POST["emailReg"]) AND !empty($_POST["emailReg"]) AND isset($_POST["passwordReg"]) AND !empty($_POST["passwordReg"]))
{
	$name = $_POST["nameReg"];
	$phone = $_POST["phoneReg"];
	$email = $_POST["emailReg"];
	$password1 = $_POST["passwordReg"];
	if ( !preg_match("/^[a-zA-Z0-9 ]*$/",$phone) AND !preg_match("/^[a-zA-Z0-9 ]*$/",$password1) AND !preg_match("/^[a-zA-Z0-9 ]*$/",$name) )
	{
		echo $fillCorrectlyText ;
		exit();
	}
	$password = sha1($password1);
	$sql = "SELECT * FROM `users` WHERE `email` LIKE '%".$email."%' LIMIT 1 ";
	$result = $dbconnect->query($sql);
	if ( $result->num_rows != 1 )
	{
		$sql = "INSERT INTO `users` (`fullName`, `email`, `password`, `phone`) VALUES ('".$name."', '".$email."', '".$password."', '".$phone."')";
		$result = $dbconnect->query($sql);

		echo $RegistrationSuccText;
	}
	else
	{
		echo $emailExistText ;
	}
}

if ( isset($_POST["editPassAj"]) AND !empty($_POST["editPassAj"]) AND isset($_POST["editEmailAj"]) AND !empty($_POST["editEmailAj"]) )
{
	$email = $_POST["editEmailAj"];
	$password1 = $_POST["editPassAj"];
	$password = sha1($password1);
    $sql = "UPDATE `users` SET `password` = '".$password."' WHERE `email` LIKE '".$email."'
            ";
	$result = $dbconnect->query($sql);
	echo $passwordChagnedText ;
}

if ( isset($_POST["loginEmailAj"]) AND !empty($_POST["loginEmailAj"]) AND isset($_POST["loginPassAj"]) AND !empty($_POST["loginPassAj"]) )
{
	$email = $_POST["loginEmailAj"];
	$password1 = $_POST["loginPassAj"];
	$password = sha1($password1);
    $sql = "SELECT * FROM `users` WHERE `email` LIKE '".$email."' AND `password` LIKE '".$password."'";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();

	$coockiecode = $row["keepMeAlive"];
	$coockiecode = explode(',',$coockiecode);
	$GenerateNewCC = md5(rand());
	if ( sizeof($coockiecode) <= 3 )
	{
		$coockiecodenew = array();
		if ( !isset ($coockiecode[2]) ) 
		{ 
			$coockiecodenew[1] = $GenerateNewCC ; 
		} 
		else 
		{ 
			$coockiecodenew[0] = $coockiecode[1]; 
		}

		if ( !isset ($coockiecode[1]) )
		{
			$coockiecodenew[0] = $GenerateNewCC ; 
		} 
		else 
		{ 
			$coockiecodenew[1] = $coockiecode[2]; 
		}
		
		if ( !isset ($coockiecode[0]) )
		{
			$coockiecodenew[2] = $GenerateNewCC ; 
		} 
		else 
		{ 
			$coockiecodenew[2] = $GenerateNewCC; 
		}
	}

	$coockiecode = $coockiecodenew[0] . "," . $coockiecodenew[1] . "," . $coockiecodenew[2] ;

	if ( $result->num_rows == 1 )
	{
		$sql = "UPDATE `users` 
				SET 
				`keepMeAlive` = '".$coockiecode."' 
				WHERE 
				`email` LIKE '".$email."' 
				AND 
				`password` LIKE '$password'";
		$result = $dbconnect->query($sql);
		$_SESSION["CreateKWUFAIRY"] = $email;
		echo "1," . $loggedInText;
		setcookie("CreateKWUFAIRY", $GenerateNewCC, time() + (86400*30 ), "/");
	}
	else
	{
		echo "0," . $wrongLoginText ;
	}
}
?>