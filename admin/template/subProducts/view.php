<?php
require ("includes/config.php");
?>
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
<!--<th><?php echo $colorArText ?></th>
<th><?php echo $colorEnText ?></th>-->
<th><?php echo $sizeText ?></th>
<th><?php echo $quantityText ?></th>
<th><?php echo $Actions ?></th>
</tr>
</thead>
<tbody>
<?php
$i = 1;
$sql = "SELECT *
		FROM `subproducts` 
		WHERE `hidden` LIKE '0'
		AND 
		`productId` LIKE '".$_GET["id"]."'	
		";
$result = $dbconnect->query($sql);
while ($row = $result->fetch_assoc() )
{
?>
<tr>
<td class="txt-dark">
<?php echo str_pad($i,3,"0",STR_PAD_LEFT) ?>
</td>
<!--<td>
<?php echo $row["color"]; ?>
</td>
<td>
<?php echo $row["colorEn"]; ?>
</td>-->
<td>
<?php echo $row["size"]; ?>
</td>
<td>
<?php echo $row["quantity"]; ?>
</td>
<td>

<a href="includes/subProducts/delete.php?id=<?php echo $row["id"] ?>&productId=<?php echo $_GET["id"] ?>" class="font-18 txt-grey pull-left" data-toggle="tooltip" data-placement="top" title="<?php echo $delete ?>"><i class="zmdi zmdi-close"></i></a>

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