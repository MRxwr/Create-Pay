<?php
if(isset($_POST['action']) && $_POST['action']=='select'){
    $sql = "SELECT * FROM `clients` WHERE `sRef` LIKE '".$_POST["sRef"]."'";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();
	//$sRef = $row["sRef"];
    
    $respn=array('status'=>'success','data'=>$row,'message'=>'client successfully fetched');
			echo json_encode($respn);
}

?>