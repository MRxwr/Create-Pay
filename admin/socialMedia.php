<!DOCTYPE html>
<html lang="en">
<?php 
require ("template/header.php");
require ("includes/config.php");
require ("includes/checksouthead.php");

if ( isset($_GET["update"]) AND $_GET["update"] = 1 )
{
    $whatsapp = $_POST["whatsapp"];
    $snapchat = $_POST["snapchat"];
    $instagram = $_POST["instagram"];
    $location = $_POST["location"];
    echo $sql = "UPDATE `s_media` 
                SET 
                `whatsapp`= '".$whatsapp."',
                `snapchat`= '".$snapchat."',
                `instagram`= '".$instagram."',
                `location`= '".$location."'
                WHERE `id` = 1
                ";
    $result = $dbconnect->query($sql);
}

$sql = "SELECT * FROM `s_media`";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
$whatsapp = $row["whatsapp"];
$snapchat = $row["snapchat"];
$instagram = $row["instagram"];
$location = $row["location"];

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
<form action="?update=1" method="POST">
<div class="form-body">
<h6 class="txt-dark capitalize-font">
<i class="zmdi zmdi-account mr-10"></i><?php echo $sMediaText ?>
</h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Whatsapp</label>
<input type="text" name="whatsapp" class="form-control" value="<?php echo $whatsapp ?>" required >
</div>
</div>
<!--/span-->
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Snapchat</label>
<input type="text" name="snapchat" class="form-control" value="<?php echo $snapchat ?>" required >
</div>
</div>
<!--/span-->
</div>
<!-- -->
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Instagram</label><br>
<input type="text" name="instagram" class="form-control" value="<?php echo $instagram ?>" required >
</div>
</div>

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Location</label><br>
<input type="text" name="location" class="form-control" value="<?php echo $location ?>" required >
</div>
</div>

<!--/span-->
</div>
<!-- -->
<!-- /Row -->
</div>
<div class="form-actions mt-10">
<button type="submit" class="btn btn-success  mr-10"><?php echo $save ?></button>
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
</body>

</html>
