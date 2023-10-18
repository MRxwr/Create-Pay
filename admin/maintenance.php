<?php
require ("includes/config.php");
require ("includes/checksouthead.php");
?>
<!DOCTYPE html>
<html lang="en">
<?php 
require ("template/header.php");

if ( isset($_POST["switch"]) )
{
	$sql = "UPDATE `maintenance` 
			SET 
			`status` = '".$_POST["switch"]."'
			WHERE `id` LIKE '1'
			";
	$result = $dbconnect->query($sql);
}
if ( isset($_POST["switchCash"]) )
{
	$sql = "UPDATE `s_media` 
			SET 
			`cash` = '".$_POST["switchCash"]."'
			WHERE `id` LIKE '3'
			";
	$result = $dbconnect->query($sql);
}
if ( isset($_POST["minPrice"]) )
{
	$sql = "UPDATE `s_media`
			SET 
			`minPrice` = '".$_POST["minPrice"]."'
			WHERE `id` LIKE '2'
			";
	$result = $dbconnect->query($sql);
}

$sql = "SELECT * 
		FROM `maintenance`
		WHERE 
		`id` LIKE '1'
		";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
$mainSwitch = $row["status"];

$sql = "SELECT cash 
		FROM `s_media`
		WHERE 
		`id` LIKE '3'
		";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
$cashSwitch = $row["cash"];
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
            <div class="container-fluid ">
				<!-- Row -->
				<div class="row" style="padding:16px">
				<div class="col-md-12">
					<div class="panel panel-default card-view">
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark"><?php echo $Maintenance ?></h6>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body">
								<form method="POST" action="">
								<div class="radio">
									<input type="radio" name="switch" id="radio11" value="1" <?php if ( $mainSwitch == 1 ) { echo 'checked=""'; } ?>>
									<label for="radio11"> <?php echo $On ?> </label>
								</div>
								<div class="radio">
									<input type="radio" name="switch" id="radio11" value="0" <?php if ( $mainSwitch == 0 ) { echo 'checked=""'; } ?>>
									<label for="radio11"> <?php echo $Off ?> </label>
								</div>
								<div class="radio">
									<input type="radio" name="switch" id="radio11" value="2" <?php if ( $mainSwitch == 2 ) { echo 'checked=""'; } ?>>
									<label for="radio11"> <?php echo $busyText ?> </label>
								</div>
								<input type="submit" value="submit">
								</form>
					</div>
					</div>
					</div>
					</div>
				</div>
				<!-- /Row -->

				<?php
			$sql = "SELECT * 
					FROM `adminstration` 
					WHERE `email` LIKE '".$email."'";
			$result = $dbconnect->query($sql);
			if ( $result->num_rows == 1 )
			{
				
				$sql = "SELECT minPrice FROM `s_media` WHERE `id` LIKE '2'";
				$result = $dbconnect->query($sql);
				$row = $result->fetch_assoc();
				
				?>
			<div class="row" style="padding:16px">
				<div class="col-md-12">
					<div class="panel panel-default card-view">
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark"><?php echo $minPriceText ?></h6>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body">
								<form method="POST" action="">
								<div class="text">
									<input type="float" name="minPrice"  value="<?php echo $row["minPrice"] ?>">
									<br><input type="submit" value="submit" class="mt-5">
								</div>
								</form>
					</div>
					</div>
					</div>
					</div>
				</div>
				<!-- /Row -->
				
				<div class="row" style="padding:16px">
				<div class="col-md-12">
					<div class="panel panel-default card-view">
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark"><?php echo $cashONOFFText ?></h6>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body">
								<form method="POST" action="">
								<div class="radio">
									<input type="radio" name="switchCash" id="radio12" value="1" <?php if ( $cashSwitch == 1 ) { echo 'checked=""'; } ?>>
									<label for="radio12"> <?php echo $On ?> </label>
								</div>
								<div class="radio">
									<input type="radio" name="switchCash" id="radio12" value="0" <?php if ( $cashSwitch == 0 ) { echo 'checked=""'; } ?>>
									<label for="radio12"> <?php echo $Off ?> </label>
								</div>
								<input type="submit" value="submit">
								</form>
					</div>
					</div>
					</div>
					</div>
				</div>
				<?php
			}
			?>
				<!--row -->
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
