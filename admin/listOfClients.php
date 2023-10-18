<!DOCTYPE html>
<html lang="en">
<?php 
require ("template/header.php");
require ("includes/config.php");
require ("includes/checksouthead.php");

if ( isset($_GET["approved"]) ){
	$sql = "UPDATE `clients` SET `approved` = '1' WHERE `id` LIKE '".$_GET["approved"]."'";
	$result = $dbconnect->query($sql);
	$sql = "SELECT `sRef` FROM `clients` WHERE `id` LIKE '".$_GET["approved"]."'";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();
	$sRef = $row["sRef"];
	require('../notifications/approved.php');
}elseif( isset($_GET["reject"]) ){
	$sql = "UPDATE `clients` SET `approved` = '0' WHERE `id` LIKE '".$_GET["reject"]."'";
	$result = $dbconnect->query($sql);
	$sql = "SELECT `sRef` FROM `clients` WHERE `id` LIKE '".$_GET["reject"]."'";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();
	$sRef = $row["sRef"];
	require('../notifications/disabled.php');
}
?>
<body>
<!-- Preloader -->
<div class="preloader-it">
<div class="la-anim-1"></div>
</div>
<!-- /Preloader -->
<div class="wrapper  theme-1-active pimary-color-green">
<!-- Top Menu Items -->
<?php require ("template/navbar.php") ?>
<!-- /Top Menu Items -->

<!-- Left Sidebar Menu -->
<?php require("template/leftSideBar.php") ?>
<!-- /Left Sidebar Menu -->

<!-- Right Sidebar Menu -->
<div class="fixed-sidebar-right">
</div>
<!-- /Right Sidebar Menu -->

<!-- Right Sidebar Backdrop -->
<div class="right-sidebar-backdrop"></div>
<!-- /Right Sidebar Backdrop -->

<!-- Main Content -->
<div class="page-wrapper">
<div class="container-fluid pt-25">
<!-- Row -->

<div class="row">
<div class="col-md-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="row">
<div class="col-sm-12 col-xs-12">
<div class="form-wrap">
<form action="includes/clients/add.php" method="POST" enctype="multipart/form-data" autocomplete='off'>
<div class="form-body">
<h6 class="txt-dark capitalize-font">
<i class="zmdi zmdi-account mr-10"></i><?php echo $employeeInfo ?>
</h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-md-3">
<div class="form-group">
<label class="control-label mb-10"><?php echo $fullnameText ?></label>
<input type="text" name="fullName" class="form-control" required >
<input type="hidden" name="id" class="form-control" >
</div>
</div>
<!--/span-->

<div class="col-md-3">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Mobile ?></label><br>
<input type="number" name="phone" class="form-control" required >
</div>
</div>
<!--/span-->

<div class="col-md-3">
<div class="form-group">
<label class="control-label mb-10"><?php echo $emailText ?></label><br>
<input type="email" name="email" class="form-control" required >
</div>
</div>

<div class="col-md-3">
<div class="form-group">
<label class="control-label mb-10"><?php echo $passwordText ?></label>
<input type="password" name="password" class="form-control" required >
</div>
</div>

<div class="col-md-3">
<div class="form-group">
<label class="control-label mb-10"><?php echo "PayApi Token" ?></label>
<input type="text" name="payAPIToken" class="form-control" required >
</div>
</div>

<!--/span-->
</div>
<!-- -->
<div class="row">
<div class="col-md-3">
<div class="form-group">
<label class="control-label mb-10"><?php echo $sCodeText ?></label><br>
<input type="float" name="sCode" class="form-control" required >
</div>
</div>

<div class="col-md-3">
<div class="form-group">
<label class="control-label mb-10"><?php echo $sRefText ?></label><br>
<input type="text" name="sRef" class="form-control" required >
</div>
</div>

<div class="col-md-3">
<div class="form-group">
<label class="control-label mb-10"><?php echo $commissionText ?></label><br>
<input type="float" name="commission" class="form-control" >
</div>
</div>

<div class="col-md-3">
<div class="form-group">
<label class="control-label mb-10"><?php echo $instaAText ?></label><br>
<input type="text" name="instagram" class="form-control" required >
</div>
</div>

<div class="col-md-12">
<div class="form-group">
<label class="control-label mb-10"><?php echo "Privacy Policy" ?></label><br>
<textarea type="text" name="privacy" class="form-control" ></textarea>
</div>
</div>

<!--/span-->
</div>
<!-- -->
<div class="row">

<div class="col-md-2">
<div class="form-group">
<label class="control-label mb-10"><?php echo $contractText ?></label><br>
<input type="file" name="contract" class="upload" required >
</div>
</div>

<div class="col-md-2">
<div class="form-group">
<label class="control-label mb-10"><?php echo $myfatoorahText ?></label><br>
<input type="file" name="myfatoorah" class="upload" required >
</div>
</div>

<div class="col-md-2">
<div class="form-group">
<label class="control-label mb-10"><?php echo $civilFText ?></label><br>
<input type="file" name="civilF" class="upload" required >
</div>
</div>

<div class="col-md-2">
<div class="form-group">
<label class="control-label mb-10"><?php echo $civilBText ?></label><br>
<input type="file" name="civilB" class="upload" required >
</div>
</div>

<div class="col-md-2">
<div class="form-group">
<label class="control-label mb-10"><?php echo $instraProfileText ?></label><br>
<input type="file" name="instraProfile" class="upload" required >
</div>
</div>

<div class="col-md-2">
<div class="form-group">
<label class="control-label mb-10"><?php echo $profileLogoText ?></label><br>
<input type="file" name="profileLogo" class="upload" required >
</div>
</div>
<!--/span-->
</div>
<!-- -->
<!-- /Row -->
</div>
<div class="form-actions mt-10">
<button type="submit" class="btn btn-success mr-10"><?php echo $save ?></button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>		
</div>
</div>

<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo $listOfclients ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="table-wrap">
<div class="table-responsive">
<table id="myTable" class="table table-hover display pb-30" >
<thead>
<tr>
<th><?php echo $joingingDate ?></th>
<th><?php echo $fullnameText ?></th>
<th><?php echo "Token" ?></th>
<th><?php echo $emailText ?></th>
<th><?php echo $Mobile ?></th>
<th><?php echo $sCodeText ?></th>
<th><?php echo $sRefText ?></th>
<th><?php echo $commissionText ?></th>
<th><?php echo $profileLogoText ?></th>
<th><?php echo $instaAText ?></th>
<th><?php echo $contractText ?></th>
<th><?php echo $myfatoorahText ?></th>
<th><?php echo $civilFText ?></th>
<th><?php echo $civilBText ?></th>
<th><?php echo $Action ?></th>
</tr>
</thead>
<tbody>
<?php
$sql = "SELECT * 
		FROM `clients` 
		WHERE `hidden` = 0
		";
$result = $dbconnect->query($sql);
while ( $row = $result->fetch_assoc() )
{

?>
<tr>
<td><?php echo $row["date"] ?></td>
<td><?php echo $row["fullName"] ?></td>
<td><?php echo $row["payAPIToken"] ?></td>
<td><a href="mailto:<?php echo $row["email"] ?>" target="_blank">Email</a></td>
<td><?php echo $row["phone"] ?></td>
<td><?php echo $row["sCode"] ?></td>
<td><?php echo $row["sRef"] ?></td>
<td><?php echo $row["commission"] ?></td>
<td><a target="_blank" href="../logos/<?php echo $row["imageurl"] ?>">View</a></td>
<td><a target="_blank" href="https://www.instagram.com/<?php echo $row["instaA"] ?>">View</a></td>
<td><a target="_blank" href="../logos/<?php echo $row["contract"] ?>">View</a></td>
<td><a target="_blank" href="../logos/<?php echo $row["myfatoorah"] ?>">View</a></td>
<td><a target="_blank" href="../logos/<?php echo $row["civilIdF"] ?>">View</a></td>
<td><a target="_blank" href="../logos/<?php echo $row["civilIdB"] ?>">View</a></td>
<td>
<a class="editClient" id="<?php echo $row["id"]?>"><span class="ml-5 fa fa-edit" aria-hidden="true"></span></a>
<a href="includes/clients/delete.php?userid=<?php echo $row["id"]?>" data-toggle="tooltip" data-original-title="Delete"><span class="ml-5 fa fa-trash-o" aria-hidden="true"></span></a>
<?php 
if ( $row["approved"] == 0 ){
	?>
	<a href="?approved=<?php echo $row["id"]?>" data-toggle="tooltip" data-original-title="Approve"><span class="ml-5 fa fa-thumbs-up" aria-hidden="true"></span></a>
	<?php
}else{
	?>
	<a href="?reject=<?php echo $row["id"]?>" data-toggle="tooltip" data-original-title="Reject"><span class="ml-5 fa fa-thumbs-down" aria-hidden="true"></span></a>
	<?php
}
?>
</td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>	
</div>
</div>
<!-- /Row -->
</div>

<!-- Footer -->
<?php require("template/footer.php") ?>
<!-- /Footer -->

</div>
<!-- /Main Content -->

</div>
<!-- /#modals -->

<!-- JavaScript -->

<!-- jQuery -->
<script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Data table JavaScript -->
<script src="../vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="dist/js/dataTables-data.js"></script>

<!-- Slimscroll JavaScript -->
<script src="dist/js/jquery.slimscroll.js"></script>

<!-- Owl JavaScript -->
<script src="../vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>

<!-- Switchery JavaScript -->
<script src="../vendors/bower_components/switchery/dist/switchery.min.js"></script>

<!-- Fancy Dropdown JS -->
<script src="dist/js/dropdown-bootstrap-extended.js"></script>

<!-- Init JavaScript -->
<script src="dist/js/init.js"></script>

<script>
$( ".editClient" ).on("click",function() {
	var ClientId = $(this).attr("id");
	
	$.ajax({
		type:"POST",
		url: "../api/functions.php",
		data: {
		client: ClientId,
		},
		success:function(result){
			console.log(result);
			var output = result.split("^");
			$('input[name="id"]').val(output[0]);
			$('input[name="fullName"]').val(output[1]);
			$('input[name="email"]').val(output[2]);
			$('input[name="phone"]').val(output[3]);
			$('input[name="instagram"]').val(output[4]);
			$('input[name="sRef"]').val(output[6]);
			$('input[name="sCode"]').val(output[5]);
			$('input[name="commission"]').val(output[7]);
			$('textarea[name="privacy"]').val(output[8]);
			$('input[name="payAPIToken"]').val(output[9]);
			$('input[name="fullName"]').focus();
			$('input[name="password"]').val("");
			$('input[name="password"]').removeAttr("required");
			$('input[name="contract"]').removeAttr("required");
			$('input[name="myfatoorah"]').removeAttr("required");
			$('input[name="civilB"]').removeAttr("required");
			$('input[name="civilF"]').removeAttr("required");
			$('input[name="instraProfile"]').removeAttr("required");
			$('input[name="profileLogo"]').removeAttr("required");
			$('button[type="submit"]').html("Update");
		}
	});
});
</script>

</body>

</html>
