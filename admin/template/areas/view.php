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
<th>#</th>
<th><?php echo $areaAr ?></th>
<th><?php echo $areaEn ?></th>
<th><?php echo $charges ?></th>
<th><?php echo $Actions ?></th>
</tr>
</thead>
<tbody>
<?php
require ("includes/config.php");
$i = 1;
$sql = "SELECT *
		FROM `areas`
		";
$result = $dbconnect->query($sql);
while ($row = $result->fetch_assoc() )
{
?>
<tr>
<td class="txt-dark">
<?php echo str_pad($i,2,"0",STR_PAD_LEFT) ?>
</td>
<td>
<?php echo $row["arTitle"]; ?>
</td>
<td>
<?php echo $row["enTitle"]; ?>
</td>
<td>
<?php echo $row["charges"]; ?>
</td>
<td>
<a href="?id=<?php echo $row["id"] ?>" class="text-inverse pr-10" title="Edit" data-toggle="tooltip">
<i class="zmdi zmdi-edit txt-warning"></i>
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