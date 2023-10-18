<?php
require ("includes/config.php");
require ("includes/checksouthead.php");
?>
<!DOCTYPE html>
<html lang="en">
<?php require ("template/header.php"); ?>
<style>
.cardEff{
	color: white;
    text-align: center;
    font-size: 20px;
    padding: 10px;
    margin-bottom: 10px;
    box-shadow: 0px 0px 10px 0px #2065a0;
    border-radius: 20px;
	background-image: linear-gradient(135deg, #1c4756,#7ea5c7);
}
</style>
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
<?php 
$sql = "SELECT 
		COUNT(if(`status` = '3', `status`, NULL)) AS refunded,
		COUNT(if(`status` = '2', `status`, NULL)) AS paid,
		COUNT(if(`status` = '1', `status`, NULL)) AS failed,
		COUNT(if(`status` = '0', `status`, NULL)) AS pending,
		COUNT(*) AS total,
		SUM(if(`status` = '2', `price`, NULL)) AS earnings
		FROM 
		`invoices` 
		WHERE 
		`supplierCode` LIKE '".$clientCode."'
		";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
?>
        <!-- Main Content -->
		<div class="page-wrapper">
            <div class="container-fluid ">
				<!-- Row -->
				<div class="row" style="padding:16px">
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
				<div class = "main1" style="margin: auto;">
				<div class = "wrapper1">
					<div class="row" style="padding:16px">
					<div class="cardEff col" style="padding: 50px;">
				Total Earnings<br><?php if ( empty($row["earnings"]) ){echo "0";}else{ echo $row["earnings"];} ?>KD
					</div>
					</div>
				</div>
				</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
					<div class="row" style="padding:16px">
					<div class="cardEff col" style="padding: 50px;">
				Total Invoices<br><?php echo $row["total"] ?> Invoice
					</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
					<div class="row" style="padding:16px">
					<div class="cardEff col" style="padding: 50px;background-image: linear-gradient(135deg, #78cb44,#1c561e);">
				Total Paid<br><?php echo $row["paid"] ?> Invoice
					</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
					<div class="row" style="padding:16px">
					<div class="cardEff col" style="padding: 50px;    background-image: linear-gradient(135deg, #f6c56c,#aa7b12);">
				Total Pending<br><?php echo $row["pending"] ?> Invoice
					</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
					<div class="row" style="padding:16px">
					<div class="cardEff col" style="padding: 50px;background-image: linear-gradient(135deg, #ff1616,#5c0606);">
				Total Failed<br><?php echo $row["failed"] ?> Invoice
					</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
					<div class="row" style="padding:16px">
					<div class="cardEff col" style="padding: 50px;    background-image: linear-gradient(135deg, #e66db0,#511034);">
				Total Refuned<br><?php echo $row["refunded"] ?> Invoice
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
    <!-- /#wrapper -->
	
	<!-- JavaScript -->
	
    <!-- jQuery -->
    <script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	
	<!-- Slimscroll JavaScript -->
	<script src="dist/js/jquery.slimscroll.js"></script>
	
	<!-- Owl JavaScript -->
	<script src="../vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>
	
	<!-- Sweet-Alert  -->
	<script src="../vendors/bower_components/sweetalert/dist/sweetalert.min.js"></script>
	<script src="dist/js/sweetalert-data.js"></script>
		
	<!-- Switchery JavaScript -->
	<script src="../vendors/bower_components/switchery/dist/switchery.min.js"></script>
	
	<!-- Fancy Dropdown JS -->
	<script src="dist/js/dropdown-bootstrap-extended.js"></script>
		
	<!-- Init JavaScript -->
	<script src="dist/js/init.js"></script>
</body>

</html>
