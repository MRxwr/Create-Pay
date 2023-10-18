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
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo "Payment History" ?></h6>
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
<th style="white-space: nowrap;"><?php echo "Time" ?></th>
<th style="white-space: nowrap;"><?php echo $fullnameText ?></th>
<th><?php echo $Status ?></th>
<th><?php echo $Action ?></th>
</tr>
</thead>
<tbody>
<?php
$sql = "SELECT
		l.response, l.date as logDate, l.status as logStatus, i.*, c.fullName
		FROM `logs` as l
		JOIN `invoices` as i
		ON i.linkCode = l.linkCode
		JOIN `clients` as c
		ON c.sCode = i.supplierCode
		ORDER BY l.id DESC
		";
$result = $dbconnect->query($sql);
while ( $row = $result->fetch_assoc() )
{

?>
<tr>
<td style="white-space: nowrap;" ><?php echo $row["logDate"] ?></td>
<td style="white-space: nowrap;" ><?php echo $row["fullName"] ?></td>
<td><?php if ( $row["logStatus"] == '0' ){echo "Success";}else{echo "Error";} ?></td>
<td><?php echo $row["response"] ?></td>
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
			var output = result.split("^");
			$('input[name="id"]').val(output[0]);
			$('input[name="fullName"]').val(output[1]);
			$('input[name="email"]').val(output[2]);
			$('input[name="phone"]').val(output[3]);
			$('input[name="instagram"]').val(output[4]);
			$('input[name="sRef"]').val(output[6]);
			$('input[name="sCode"]').val(output[5]);
			$('input[name="commission"]').val(output[7]);
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
