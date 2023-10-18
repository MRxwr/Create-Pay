<?php
require ("includes/config.php");

if ( isset($_GET["status"]) )
{
	$id = $_GET["id"];
	if ( $_GET["status"] == "returned")
	{
		$sql = "UPDATE `orders` SET `status`='3' WHERE `orderId` LIKE '".$id."'";
		$result = $dbconnect->query($sql);
		
		$sql = "SELECT `productId`,`quantity` FROM `orders` WHERE `orderId` LIKE '".$id."'";
		$result = $dbconnect->query($sql);
		while ( $row = $result->fetch_assoc() )
		{
			$products[] = $row["productId"];
			$quantities[] = $row["quantity"];
		}
		
		$i = 0;
		while ( $i < sizeof($products) )
		{
			$sql = "SELECT `storeQuantity` 
					FROM `products` 
					WHERE `id` LIKE '".$products[$i]."'
					";
			$result = $dbconnect->query($sql);
			$row = $result->fetch_assoc();
			$ReturnQuantity = $row["storeQuantity"] + $quantities[$i] ;
			
			$sql = "UPDATE `products` 
					SET `storeQuantity`='".$ReturnQuantity."' 
					WHERE `id` LIKE '".$products[$i]."'
					";
			$result = $dbconnect->query($sql);
			
			$i++;
		}
		
	}
	elseif ( $_GET["status"] == "success")
	{
		$sql = "SELECT `productId`,`quantity`,`location`, `status`
				FROM `orders` 
				WHERE `orderId` LIKE '".$id."'
				";
		$result = $dbconnect->query($sql);
		while ( $row = $result->fetch_assoc() )
		{
			$products[] = $row["productId"];
			$quantities[] = $row["quantity"];
			$location[] = $row["location"];
		}
		
		if ( $row["status"] = 3 )
		{
			$i = 0;
			while ( $i < sizeof($products) )
			{
				$sql = "SELECT `storeQuantity`, `onlineQuantity`
						FROM `products` 
						WHERE `id` LIKE '".$products[$i]."'
						";
				$result = $dbconnect->query($sql);
				$row = $result->fetch_assoc();
				$ReturnQuantity = $row["storeQuantity"] - $quantities[$i];
				$sql = "UPDATE `products` 
						SET 
						`storeQuantity` = '".$ReturnQuantity."'
						WHERE `id` LIKE '".$products[$i]."'
						";
				$result = $dbconnect->query($sql);
				
				$i++;
			}
		}
		$sql = "UPDATE 
				`orders` 
				SET 
				`status`='1' 
				WHERE 
				`orderId` LIKE '".$id."'
				";
		$result = $dbconnect->query($sql);
	}
	elseif ( $_GET["status"] == "delivered")
	{
		$sql = "UPDATE `orders` 
				SET `status`='4' 
				WHERE `orderId` LIKE '".$id."'";
		$result = $dbconnect->query($sql);
		
		$sql = "SELECT `productId`,`quantity`,`location` 
				FROM `orders` 
				WHERE `orderId` LIKE '".$id."'
				";
		$result = $dbconnect->query($sql);
	}
	elseif ( $_GET["status"] == "onDelivery")
	{
		$sql = "UPDATE `orders` 
				SET `status`='5' 
				WHERE `orderId` LIKE '".$id."'";
		$result = $dbconnect->query($sql);
		
		$sql = "SELECT `productId`,`quantity`,`location` 
				FROM `orders` 
				WHERE `orderId` LIKE '".$id."'
				";
		$result = $dbconnect->query($sql);
	}
	
}

$sql = "SELECT o.*, l.location, v.voucher 
		FROM `orders` AS o 
		JOIN `locations` AS l 
		ON o.location = l.id 
		JOIN `vouchers` AS v 
		ON v.id = o.voucher 
		WHERE o.location != '0' 
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
<th><?php echo $Store ?></th>
<th><?php echo $Voucher ?></th>
<th><?php echo $Price ?></th>
<th><?php echo $Status ?></th>
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
<td class="txt-dark"><?php echo $row["location"] ?></td>
<td><?php echo $row["voucher"] ?></td>
<td><?php echo $row["totalPrice"] ?></td>
<td>
<?php 
if ( $row["status"] == 5 )
{
	echo "<span class='label label-warning font-weight-100'>$OnDelivery</span>";
}
if ( $row["status"] == 4 )
{
	echo "<span class='label label-success font-weight-100'>$Delivered</span>";
}
if ( $row["status"] == 3 )
{
	//echo "<span class='label label-danger font-weight-100'>$Returned</span>";
}
elseif ( $row["status"] == 2 )
{
	echo "<span class='label label-default font-weight-100'>$Failed</span>";
}
elseif ( $row["status"] == 1 )
{
	echo "<span class='label label-primary font-weight-100'>$Paid</span>";
}
elseif ( $row["status"] == 0 )
{
	echo "<span class='label label-default font-weight-100'>$Pending</span>";
	
}
?>
</td>
<td>
<a href="?info=view&id=<?php echo $orederID ?>">
<button class="btn btn-info btn-rounded"><?php echo $Details ?>
</button>
<?php
if ( $row["status"] != 1 AND $row["status"] != 4 AND $row["status"] != 5 )
{
	?>
<a href="?status=success&id=<?php echo $orederID ?>">
<button class="btn btn-primary btn-icon-anim btn-circle">
<i class="fa fa-money"></i>
</button>
</a>
<?php
}
if ( $row["status"] != 3 )
{
	?>
<!--<a href="?status=returned&id=<php echo $orederID ?>">
<button class="btn btn-danger btn-icon-anim btn-circle">
<i class="ti-reload"></i>
</button>
</a>-->
<?php
}
if ( $row["status"] != 5 AND $row["status"] != 4 AND $row["status"] != 3)
{
	?>
<a href="?status=onDelivery&id=<?php echo $orederID ?>">
<button class="btn btn-warning btn-icon-anim btn-circle">
<i class="fa fa-car"></i>
</button>
</a>
<?php
}
if ( $row["status"] != 4 AND $row["status"] != 3)
{
	?>
<a href="?status=delivered&id=<?php echo $orederID ?>">
<button class="btn btn-success btn-icon-anim btn-circle">
<i class="fa fa-car"></i>
</button>
</a>
<?php
}
?>
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