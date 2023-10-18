<?php
if(isset($_POST['action']) && $_POST['action']=='add'){
    //var_dump($_POST);
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
	$approved = $_POST["approved"];
	$hidden = $_POST["hidden"];
	$payAPIToken = $_POST["payAPIToken"];
	$contract ='';
	$civilB ='';
	$myfatoorah='';
	$civilF='';

    $profileLogo ='';
    if( is_uploaded_file($_FILES['profileLogo']['tmp_name']) )
    {
    	$directory = "../logos/";
    	$originalfile4 = $directory . date("d-m-y") . time() . rand(111111,999999) . ".png";
    	move_uploaded_file($_FILES["profileLogo"]["tmp_name"], $originalfile4);
    	$profileLogo = str_replace("../logos/",'',$originalfile4);
    }

	$sql = "INSERT INTO `clients`
			(`fullName`, `email`, `password`, `phone`, `sCode`, `sRef`, `instaA`, `contract`, `civilIdB`, `myfatoorah`, `civilIdF`, `imageurl`,`commission`,`privacy`,`approved`,`hidden`, `payAPIToken`) 
			VALUES 
			('".$fullName."', '".$email."', '".$password."', '".$phone."','".$sCode."','".$sRef."','".$instagram."','".$contract."','".$civilB."','".$myfatoorah."','".$civilF."','".$profileLogo."', '".$commission."', '".$privacy."', '".$approved."', '".$hidden."', '{$payAPIToken}')
			";
            $result = $dbconnect->query($sql);
            $data =array();
					 //$data['id'] = $row['id'];
					 $data['title'] =  $fullName;
					 $data['sRef'] =  $sRef;
				$respn=array('status'=>'success','data'=>$data, 'message'=>'CreatePay successfully added');
				echo json_encode($respn);
				exit;
}

//ALTER TABLE phrases AUTO_INCREMENT = 1

?>