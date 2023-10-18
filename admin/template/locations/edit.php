<?php
require ('includes/config.php');
if ( isset($_GET["id"]) AND !empty($_GET["id"]) )
{
    $sql = "SELECT *
            FROM `locations`
            WHERE 
            `id` = '".$_GET["id"]."'
            ";
    $result = $dbconnect->query($sql);
    $row = $result->fetch_assoc();
}
else{
    header ("LOCATION: admin/locations");
}
?>
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
<form action="includes/locations/edit.php" method="POST">
<div class="form-body">
<h6 class="txt-dark capitalize-font">
<i class="zmdi zmdi-account mr-10"></i><?php echo $BranchInfo ?>
</h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Branch ?></label>
<input type="text" name="location" class="form-control" value='<?php echo $row["location"] ?>' required >
<input type="hidden" name="id" class="form-control" value='<?php echo $row["id"] ?>'>
</div>
</div>

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Percentage ?></label>
<input type="number" name="discount" class="form-control" max="100" min="0" step="1" value='<?php echo $row["discount"] ?>' required >
</div>
</div>

<!--/span-->
</div>
<!-- -->
<div class="row">
<div class="col-md-12">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Details ?></label><br>
<textarea name="details" rows="4" style="width:100%"><?php echo $row["details"] ?></textarea>
</div>
</div>
<!--/span-->
</div>
<!-- -->
<!-- /Row -->
</div>
<div class="form-actions mt-10">
<button type="submit" class="btn btn-success  mr-10"> <?php echo $save ?></button>
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