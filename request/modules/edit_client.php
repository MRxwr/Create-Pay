<?php

if(isset($_POST['action']) && $_POST['action']=='update'){

    $sRef = $_POST["sRef"];
    $fullName = ($_POST["fullName"]?$_POST["fullName"]:"");
	$email = $_POST["email"];
	$password = $_POST["password"];
	$password = sha1($password);
	$phone = $_POST["phone"];
	$sCode = $_POST["sCode"];
	$instagram = $_POST["instagram"];
	$commission = $_POST["commission"];
	$privacy = $_POST["privacy"];
	$payAPIToken = $_POST["payAPIToken"];
	$approved = $_POST["approved"];
	$hidden = $_POST["hidden"];
	$contract ='';
	$civilB ='';
	$myfatoorah='';
	$civilF='';

	$profileLogo ='';
	if(isset($_FILES['profileLogo']['tmp_name'])){
	 if( is_uploaded_file($_FILES['profileLogo']['tmp_name']) )
        {
        	$directory = "../logos/";
        	$originalfile4 = $directory . date("d-m-y") . time() . rand(111111,999999) . ".png";
        	move_uploaded_file($_FILES["profileLogo"]["tmp_name"], $originalfile4);
        	$profileLogo = str_replace("../logos/",'',$originalfile4);
        }
	    
	}
   

    $sql = "UPDATE `clients` SET `fullName`= '".$fullName."', `email`= '".$email."'";
    
     if(isset($_POST["password"]) && $_POST["password"]!=''){
       $sql .=",`password`= '".$password."'";
     }

    $sql .=",`phone`= '".$phone."'";
    $sql .=",`sCode`= '".$sCode."'";
    $sql .=",`instaA`= '".$instagram."'";
    $sql .=",`commission`= '".$commission."'";
    $sql .=",`privacy`= '".$privacy."'";
    $sql .=",`approved`= '".$approved."'";
    $sql .=",`hidden`= '".$hidden."'";
    $sql .=",`imageurl`= '".$profileLogo."'";
    $sql .=",`payAPIToken`= '".$payAPIToken."'
            WHERE `sRef` LIKE '".$sRef."'
        ";
    $result = $dbconnect->query($sql);
    $data =array();
					 //$data['id'] = $row['id'];
					 $data['title'] =  $fullName;
					 $data['email'] =  $email;
					 $data['phone'] =  $phone;
					 $data['sCode'] =  $sCode;
					 $data['instaA'] =  $instagram;
					 $data['commission'] =  $commission;
					 $data['privacy'] =  $privacy;
					 $data['payAPIToken'] =  $payAPIToken;
					 $data['sRef'] =  $sRef;
				$respn=array('status'=>'success','data'=>$data, 'message'=>'CreatePay successfully update');
				echo json_encode($respn);
				exit;
}




?>