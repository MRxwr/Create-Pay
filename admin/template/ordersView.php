<?php
header ("Refresh:180");
require ("includes/config.php");
$sql = "SELECT *
		FROM `orders`
		WHERE 
		`status` != 0
		AND
		`status` != 2020
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
<th><?php echo $Mobile ?></th>
<th><?php echo $Voucher ?></th>
<th><?php echo $Price ?></th>
<th><?php echo $methodOfPayment ?></th>
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
<td class="txt-dark"><?php echo $row["mobile"] ?></td>
<td><?php echo $row["voucher"] ?></td>
<td><?php echo $row["totalPrice"] ?></td>
<td><?php if ( $row["pMethod"] == 1 ) {echo "<b style='color:darkblue'>KNET</b>"; } elseif($row["pMethod"] == 3) { echo "<b style='color:darkgreen'>CASH</b>";; } else { echo "<b style='color:darkred'>VISA/MASTER</b>";} ?></td>
<td>
<?php 
if ( $row["status"] == 6 )
{
	echo "<span class='label label-default font-weight-100'>$preparingText</span>";
}
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
if ( $row["status"] == 2 )
{
	echo "<span class='label label-danger font-weight-100'>$Failed</span>";
}
if ( $row["status"] == 1 )
{
	echo "<span class='label label-primary font-weight-100'>$Paid</span>";
}
if ( $row["status"] == 0 )
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
if ( $row["status"] != 1 AND $row["status"] != 4 AND $row["status"] != 5 AND $row["status"] != 6 )
{
	?>
<a href="?status=success&id=<?php echo $orederID ?>">
<button class="btn btn-primary btn-icon-anim btn-circle" title="Paid" data-toggle="tooltip">
<i class="fa fa-money"></i>
</button>
</a>
<?php
}
if ( $row["status"] != 2 )
{
	?>
<a href="?status=failed&id=<?php echo $orederID ?>">
<button class="btn btn-danger btn-icon-anim btn-circle" title="Cancel" data-toggle="tooltip">
<i class="fa fa-times"></i>
</button>
</a>
<?php
}
if ( $row["status"] == 1 )
{
	?>
<a href="?status=preparing&id=<?php echo $orederID ?>">
<button class="btn btn-default btn-icon-anim btn-circle" title="Preparing" data-toggle="tooltip">
<i class="pe-7s-clock" style="font-size:25px"></i>
</button>
</a>
<?php
}
?>
<?php
if ( $row["status"] != 5 AND $row["status"] != 4 AND $row["status"] != 3)
{
	?>
<a href="?status=onDelivery&id=<?php echo $orederID ?>">
<button class="btn btn-warning btn-icon-anim btn-circle" title="On Delivery" data-toggle="tooltip">
<i class="fa fa-car"></i>
</button>
</a>
<?php
}
if ( $row["status"] != 4 AND $row["status"] != 3)
{
	?>
<a href="?status=delivered&id=<?php echo $orederID ?>">
<button class="btn btn-success btn-icon-anim btn-circle" title="Delivered" data-toggle="tooltip">
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
<audio id="my_audio">
    <source src="got-it-done.mp3" type="audio/mpeg">
</audio>
<?php
$sql = "SELECT * FROM `orders` 
        WHERE 
        date >= now() + interval 177 minute 
        AND 
        status = 1
        ";
$result = $dbconnect->query($sql);
if ( $result->num_rows > 0 )
{
    ?>
    <script>
        window.onload = function() {
    document.getElementById("my_audio").play();
    }
    </script>
    <?php
}