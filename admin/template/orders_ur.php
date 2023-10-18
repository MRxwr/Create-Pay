<?php
require ("includes/config.php");

if ( isset($_GET["status"]) )
{
	$orderId = $_GET["id"];
	date_default_timezone_set('Asia/Riyadh');
	if ( $_GET["status"] == "success")
	{
		$date = date("Y-m-d h:i:s");
		$sql = "UPDATE `orders`
				SET
				`status` = 1
				WHERE
				`orderId` LIKE '".$_GET["id"]."'
				";
		$result = $dbconnect->query($sql);
		$i++;
	}
		header("LOCATION: product-orders.php");
}

$sql = "SELECT * 
		FROM `orders`
		WHERE `status` = 0
		GROUP BY `orderId`
		";
$result = $dbconnect->query($sql);

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
<th><?php echo $DateTime ?></th>
<th><?php echo $OrderID ?></th>
<th><?php echo $Price ?></th>
<th><?php echo $Mobile ?></th>
<th><?php echo $Actions ?></th>
</tr>
</thead>
<tbody>
<?php 
while ( $row = $result->fetch_assoc() )
{
$orederID = $row["orderId"];
?>
<tr>
<td><?php echo $row["date"] ?></td>
<td class="txt-dark"><?php echo $row["orderId"] ?></td>
<td><?php echo $row["totalPrice"] ?></td>
<td><?php echo $row["mobile"] ?></td>
<td>
<a href="?info=view&id=<?php echo $orederID ?>">
<button class="btn btn-info btn-rounded"><?php echo $Details ?>
</button>

<a href="?status=success&id=<?php echo $orederID ?>">
<button class="btn btn-primary btn-icon-anim btn-circle">
<i class="fa fa-money"></i>
</button>
</a>

</td>
</tr>
<?php
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