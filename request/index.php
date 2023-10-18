
<?php 
require ("../admin/includes/config.php");
//require ("../admin/includes/checksouthead.php");

// $respn=array('status'=>'success','data'=>'ok', 'message'=>'CreatePay successfully added');
// 				echo json_encode($respn);
// 				exit;
		if(isset($_POST['page']) && !empty($_POST['page']))
		{
			$page = $_POST['page'];
			switch ($page) {
				case 'add_client':
					include('modules/'.$page.'.php');
					break;
				case 'edit_client':
					include('modules/'.$page.'.php');
					break;
				case 'get_client':
					include('modules/'.$page.'.php');
					break;
				case 'get_ref':
					include('modules/'.$page.'.php');
					break;
				default:
					include('moduls/'.$page.'.php');
				break;
			}
		}else{
		    echo 'endpoint not exist!!';
		}
?>