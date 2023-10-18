<!DOCTYPE html>
<html lang="en">
<?php require("template/header.php");require ("includes/checksouthead.php"); ?>

	<body>
		<!--Preloader-->
		<div class="preloader-it">
			<div class="la-anim-1"></div>
		</div>
		<!--/Preloader-->
		<div class="wrapper  theme-1-active pimary-color-green">
			
			<!-- Top Menu Items -->
		<?php require ("template/navbar.php") ?>
		<!-- /Top Menu Items -->
		
		<!-- Left Sidebar Menu -->
		<?php require("template/leftSideBar.php") ?>
		<!-- /Left Sidebar Menu -->
			
			<!-- Right Sidebar Backdrop -->
			<div class="right-sidebar-backdrop"></div>
			<!-- /Right Sidebar Backdrop -->
			
			<!-- Main Content -->
			<div class="page-wrapper">
				<div class="container-fluid">
					<!-- Title -->
					<div class="row heading-bg">
						<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						  <h5 class="txt-dark">Send Notifications</h5>
						</div>
					</div>
					<!-- /Title -->
					
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
<form action="../notifications/general.php" method="POST">
<div class="form-body">
<h6 class="txt-dark capitalize-font">
<i class="fa fa-qrcode mr-10"></i>General Notifications
</h6>
<hr class="light-grey-hr"/>

<div class="row">
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Title</label>
<input type="text" name="title" class="form-control" value="Ramadan Mubarak" required >
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Message</label>
<input type="text" name="msg" class="form-control" required >
</div>
</div>
<!--/span-->
</div>
<div class="row">
<div class="col-sm-12 col-xs-12">
<div class="form-wrap">
<div class="col-md-1 text-center">
<button type="submit" class="btn btn-success"><?php echo $Add  ?></button>
</div>
</div>
</div>
</div>
<!--/span-->
</div>
<!-- -->
<!-- -->
<!-- /Row -->
</div>
</form>
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
		<!-- /#wrapper -->
		
		<!-- JavaScript -->
		
		<!-- jQuery -->
		<script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>
		
		<!-- Bootstrap Core JavaScript -->
		<script src="../vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		
		<!-- Slimscroll JavaScript -->
		<script src="dist/js/jquery.slimscroll.js"></script>
	
		<!-- Fancy Dropdown JS -->
		<script src="dist/js/dropdown-bootstrap-extended.js"></script>
		
		<!-- Owl JavaScript -->
		<script src="../vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>
	
		<!-- Switchery JavaScript -->
		<script src="../vendors/bower_components/switchery/dist/switchery.min.js"></script>
	
		<!-- Init JavaScript -->
		<script src="dist/js/init.js"></script>
		
	</body>
</html>