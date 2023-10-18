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
<form action="includes/locations/add.php" method="POST">
<div class="form-body">
<h6 class="txt-dark capitalize-font">
<i class="zmdi zmdi-account mr-10"></i><?php echo $BranchInfo ?>
</h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Branch ?></label>
<input type="text" name="location" class="form-control" required >
</div>
</div>

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Percentage ?></label>
<input type="number" name="discount" class="form-control" max="100" min="0" step="1" value="0" required >
</div>
</div>

<!--/span-->
</div>
<!-- -->
<div class="row">
<div class="col-md-12">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Details ?></label><br>
<textarea name="details" rows="4" style="width:100%"></textarea>
</div>
</div>
<!--/span-->
</div>
<!-- -->
<!-- /Row -->
</div>
<div class="form-actions mt-10">
<button type="submit" class="btn btn-success  mr-10"> <?php echo $Add ?></button>
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
<div class="panel-wrapper collapse in">
<div class="panel-body row">
<div class="table-wrap">
<div class="table-responsive">
<table class="table display responsive product-overview mb-30" id="myTable">
<thead>
<tr>
<th><?php echo $Date_Added ?></th>
<th>#</th>
<th><?php echo $Branch ?></th>
<th><?php echo $Discount ?></th>
<th><?php echo $Details ?></th>
<th><?php echo $Actions ?></th>
</tr>
</thead>
<tbody>
<?php
require ("includes/config.php");
$i = 1;
$sql = "SELECT *
		FROM `locations`
		WHERE `hidden` = '0'
		";
$result = $dbconnect->query($sql);
while ($row = $result->fetch_assoc() )
{
?>
<tr>
<td class="txt-dark">
<?php $date = explode (" ", $row["date"]); echo $date[0]; ?>
</td>
<td class="txt-dark">
<?php echo $i ?>
</td>
<td>
<?php echo $row["location"]; ?>
</td>
<td>
<?php echo $row["discount"]; ?>%
</td>
<td>
<?php echo $row["details"]; ?>
</td>
<td>
<a href="?id=<?php echo $row["id"] ?>" class="text-inverse pr-10" title="Edit" data-toggle="tooltip">
<i class="zmdi zmdi-edit txt-warning"></i>
</a>
<a href="includes/locations/delete.php?id=<?php echo $row["id"] ?>" class="text-inverse" title="Delete" data-toggle="tooltip">
<i class="zmdi zmdi-delete txt-danger"></i>
</a>
</td>
</tr>
<?php
$i++;
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