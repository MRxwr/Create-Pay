<?php
if(isset($_POST['action']) && $_POST['action']=='select'){
    $sql = "SELECT `sRef` FROM `clients` order by sRef desc limit 1";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();
	//$sRef = intval($row["sRef"]);
    //preg_match_all('!\d+!', $row["sRef"], $sRefArr);
     $sRef = preg_replace('/[^0-9]/', '', $row["sRef"]);  
     $sRef = sprintf("%04d",($sRef+1)); 
     $respn=array('status'=>'success','data'=>$sRef,'message'=>'client successfully fetched');
			echo json_encode($respn);
}

?>