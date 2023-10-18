<style>
[type="date"] {
  background:#fff url(https://cdn1.iconfinder.com/data/icons/cc_mono_icon_set/blacks/16x16/calendar_2.png)  97% 50% no-repeat ;
}
[type="date"]::-webkit-inner-spin-button {
  display: none;
}
[type="date"]::-webkit-calendar-picker-indicator {
  opacity: 0;
}
label {
  display: block;
}
input {
  border: 1px solid #c4c4c4;
  border-radius: 5px;
  background-color: #fff;
  padding: 3px 5px;
  box-shadow: inset 0 3px 6px rgba(0,0,0,0.1);
  width: 100%;
}
</style>
<div class="row">
<div class="col-md-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
</div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="form-wrap mt-10">
<form action="" method="POST">
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10 text-left">Start Date</label>
<input type="date" name="startDate" required >
</div>
</div>		
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10 text-left">End Date</label>
<input type="date" name="endDate" required >
</div>
</div>	
</div>
<div class="row">
<!--<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Select Location</label>
<select class="selectpicker" name="location" data-style="form-control btn-default btn-outline">
<option></option>
<option value="1">Online</option>
<?php
require("includes/config.php");
$sql = "SELECT * FROM `locations` WHERE `hidden` = 0";
$result = $dbconnect->query($sql);
while ( $row = $result->fetch_assoc() )
{
?>
<option value="<?php echo $row["id"] ?>"><?php echo $row["location"] ?></option>
<?php
}
?>
</select>
</div>	
</div>-->

<div class="col-md-12">
<div class="form-group">
<button class="btn  btn-success">Submit</button>
</div>
</div>
<?php
if ( isset($_POST["endDate"]) )
{
	if ( !empty($_POST["location"]) AND empty($_POST["voucher"]) )
	{
		if ( $_POST["location"] == "online" )
		{
			$_POST["location"] = "0";
		}
		$sql = "SELECT totalPrice, orderId, status
				FROM `orders` 
				WHERE 
				`location` = '" .$_POST["location"]. "'
				AND
				date BETWEEN '".$_POST['startDate']."' AND '".$_POST["endDate"]."'
				AND
				`status` != 0
				AND
				`status` != 2020
				AND
				`status` != 2
				GROUP BY `orderId`
				";
	}
	elseif ( !empty($_POST["voucher"]) AND empty($_POST["location"]) )
	{
		$sql = "SELECT totalPrice, orderId, status
				FROM `orders` 
				WHERE 
				`voucher` = '" .$_POST["voucher"]. "'
				AND
				date BETWEEN '".$_POST['startDate']."' AND '".$_POST["endDate"]."'
				AND
				`status` != 0
				AND
				`status` != 2020
				AND
				`status` != 2
				GROUP BY `orderId`
				";
	}
	elseif ( !empty($_POST["voucher"]) AND !empty($_POST["location"]) )
	{
		if ( $_POST["location"] == "online" )
		{
			$_POST["location"] = "0";
		}
		$sql = "SELECT totalPrice, orderId, status
				FROM `orders` 
				WHERE 
				`voucher` = '" .$_POST["voucher"]. "'
				AND
				`location` = '" .$_POST["location"]. "'
				AND
				date BETWEEN '".$_POST['startDate']."' AND '".$_POST["endDate"]."'
				AND
				`status` != 0
				AND
				`status` != 2020
				AND
				`status` != 2
				GROUP BY `orderId`
				";
	}
	else
	{
		$sql = "SELECT totalPrice, orderId, status
				FROM `orders` 
				WHERE date BETWEEN '".$_POST['startDate']."' AND '".$_POST["endDate"]."'
				AND
				`status` != 0
				AND
				`status` != 2020
				AND
				`status` != 2
				GROUP BY `orderId`
				";
	}
	$result = $dbconnect->query($sql);
	while ( $row = $result->fetch_assoc() )
	{
		if ( $row["status"] != "0" )
		{
			$orderIds[] = $row["orderId"];
			$totals[] = $row["totalPrice"];
		}
	}
	
	$i = 0;
	if ( !empty($orderIds[0]) )
	{
		while ( $i < sizeof($orderIds) )
		{
			$sql = "SELECT productId, quantity
					FROM `orders` 
					WHERE `orderId` = '".$orderIds[$i]."'";
			$result = $dbconnect->query($sql);
			while ( $row = $result->fetch_assoc() )
			{
				$productIds[] = $row["productId"];
				$quantities[] = $row["quantity"];
			}
			$i++;
		}
		
		$i = 0;
		while ( $i < sizeof($productIds) )
		{
			$sql = "SELECT cost
					FROM `products` 
					WHERE `id` = '".$productIds[$i]."'";
			$result = $dbconnect->query($sql);
			while ( $row = $result->fetch_assoc() )
			{
				$cost[] = $row["cost"] * $quantities[$i];
			}
			$i++;
		}
	}
	
?>
<div class="col-md-6">
<div class="form-group">
<table style="width:100%; text-align:center; font-size:20px">
<tr>
<td>Earned</td>
<td>Cost</td>
<td>Profit</td>
</tr>
<tr>
<td><?php if ( isset($totals) ) {echo array_sum($totals); } ?></td>
<td><?php if ( isset($cost) ) {echo array_sum($cost);} ?></td>
<td><?php if ( isset($cost) ) {echo array_sum($totals) - array_sum($cost); } ?></td>
</tr>
</table>
</div>
</div>
<?php
}
?>
</div>
</form>
</div>
</div>
</div>
</div>


<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="table-wrap">
<div class="table-responsive">
<table id="example" class="table table-hover display  pb-30" >
<thead>
<tr>
<th><?php echo $DateTime ?></th>
<th><?php echo $OrderID ?></th>
<th><?php echo $Mobile ?></th>
<th><?php echo $Voucher ?></th>
<th><?php echo $Discount ?></th>
<th><?php echo $deliveryText ?></th>
<th><?php echo $paymentMethodText ?></th>
<th><?php echo $Price ?></th>
</tr>
</thead>
<tbody>
<?php
$i = 0 ;
if ( isset($orderIds) )
{
while ( $i < sizeof($orderIds) )
{
	$sql = "SELECT *
			FROM `orders` 
			WHERE `orderId` = '".$orderIds[$i]."'
			GROUP BY `orderId`";
	$result = $dbconnect->query($sql);
	while ( $row = $result->fetch_assoc() )
	{
?>
<tr>
<td><?php echo $row["date"] ?></td>
<td class="txt-dark"><?php echo $row["orderId"] ?></td>
<td class="txt-dark"><?php echo $row["mobile"] ?></td>
<td><?php echo $row["voucher"] ?></td>
<td><?php echo $row["discount"] ?></td>
<td><?php echo $row["d_s_charges"] ?></td>
<td><?php if ( $row["pMethod"] == 1 ) { echo "K-NET"; } else { echo "Visa/Master";} ?></td>
<td><?php echo $row["totalPrice"] ?></td>
</tr>
<?php
	}
	$i++;
}
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
<!-- /Row -->
</div>