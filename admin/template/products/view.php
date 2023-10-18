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
<th><?php echo $photo ?></th>
<th><?php echo $areaAr ?></th>
<th><?php echo $areaEn ?></th>
<th><?php echo $Actions ?></th>
</tr>
</thead>
<tbody>
<?php
$i = 1;
$sql = "SELECT DISTINCT  p.*, i.imageurl
		FROM products AS p 
		JOIN images AS i 
		ON p.id = i.productId
		WHERE p.hidden = '0'
		GROUP BY p.id	
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
<img src="../logos/<?php echo $row["imageurl"] ?>" style="width:50px;height:50px" alt="Product Image" />
</td>
<td>
<?php echo $row["arTitle"]; ?>
</td>
<td>
<?php echo $row["enTitle"]; ?>
</td>
<td>
<a href="add-sub-products.php?id=<?php echo $row["id"] ?>" class="font-18 txt-grey mr-10 pull-left" data-toggle="tooltip" data-placement="top" title="<?php echo $codesText ?>"><i class="fa fa-sitemap"></i></a>

<a href="add-products.php?act=edit&id=<?php echo $row["id"] ?>" class="font-18 txt-grey mr-10 pull-left" data-toggle="tooltip" data-placement="top" title="<?php echo $edit ?>"><i class="zmdi zmdi-edit"></i></a>

<a href="includes/products/delete.php?id=<?php echo $row["id"] ?>" class="font-18 txt-grey pull-left" data-toggle="tooltip" data-placement="top" title="<?php echo $delete ?>"><i class="zmdi zmdi-close"></i></a>

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