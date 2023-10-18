<?php 
include_once("includes/config.php");

$id = $_GET["id"];
$sql = "SELECT * FROM `banner` WHERE `id`='$id'";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();

?>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="form-wrap">
<form action="includes/banners/edit.php" method="POST" enctype="multipart/form-data">
<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-info-outline mr-10"></i><?php echo $Banners ?></h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Title ?></label>
<input type="text" name="title" class="form-control" value="<?php echo $row["title"] ?>" required="">
</div>
</div>
<!--/span-->
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $URL ?></label>
<input type="text" name="url" class="form-control" value="<?php echo $row["link"] ?>">
</div>
</div>
<!--/span-->
</div>
<!--/row-->
<div class="seprator-block"></div>
<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-collection-image mr-10"></i><?php echo $upload_image ?></h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-lg-12">
<div class="img-upload-wrap">
<img class="img-responsive" src="<?php
if ( !empty($row["image"]) )
{
echo "../logos/" . $row["image"];
}
else
{
echo "../img/slide1.jpg";
}
?>" alt="upload_img"> 
</div>
<div class="fileupload btn btn-info btn-anim"><i class="fa fa-upload"></i><span class="btn-text"><?php echo $Upload_new_image ?></span>
<input type="file" name="logo" class="upload">
<input type="hidden" name="id" value="<?php echo $_GET["id"] ?>">

</div>
</div>
</div>
<div class="seprator-block"></div>
<div class="form-actions">
<button class="btn btn-success btn-icon left-icon mr-10 pull-left"> <i class="fa fa-check"></i> <span><?php echo $save ?></span></button>
<a href="banners.php" ><button type="button" class="btn btn-warning pull-left"><?php echo $Return ?></button></a>
<div class="clearfix"></div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>