<?php
require ("includes/config.php");

$id = $_GET["id"];

$sql = "SELECT *
		FROM `all_orders`
		WHERE `orderId` LIKE '$id'
		";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
$location = $row["location"];
$sql = "SELECT *
		FROM `locations`
		WHERE `id` LIKE '$location'
		";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
$location = $row["location"];

$sql = "SELECT *
		FROM `all_orders`
		WHERE `orderId` LIKE '$id'
		";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
$voucher = $row["voucher"];
$storeLocation = $row["location"];
$notes = $row["notes"];
$discount = $row["discount"];
$country = $row["country"];
$area = $row["area"];
$block = $row["block"];
$street = $row["street"];
$house = $row["house"];
$avenue = $row["avenue"];
$notes = $row["notes"];
$building = $row["building"];
$floor = $row["floor"];
$apartment = $row["apartment"];
$areaA = $row["areaA"];
$blockA = $row["blockA"];
$streetA = $row["streetA"];
$avenueA = $row["avenueA"];
$notesA = $row["notesA"];
$discount = $row["discount"];
$totalPrice = $row["totalPrice"];
$totalPriceMain = $row["totalPrice"];
$place = $row["place"];
$charges = $row["d_s_charges"];
?>
<div class="row">
<div class="col-md-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark">Invoice</h6>
</div>
<div class="pull-right">
<h6 class="txt-dark">Order # <?php echo $row["orderId"]; ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="row">
<div class="col-xs-4">
<span class="txt-dark head-font inline-block capitalize-font mb-5"><img src="../img/logo.jpg" style="width:100px; height:100px"></span>
<address class="mb-15">
<span class="address-head mb-5">
Snap: Soap-aljmela <br>
Inst: Soap_aljmela <br>
Whatsapp: 51541819
</span>
</address>
</div>
<?php
if ( isset($row["location"]) ) {
?>
<div class="col-xs-4">
<span class="txt-dark head-font inline-block capitalize-font mb-5">Billed to:</span>
<address class="mb-15">
<span class="address-head mb-5"><?php echo $row["email"] ?></span>
</address>
</div>
<div class="col-xs-4 text-right">
<span class="txt-dark head-font inline-block capitalize-font mb-5">shiped to:</span>
<address class="mb-15">
<?php
if ( $place == "1" )
{
	echo $country . ", " . $area . "<br> قطعة " . $block . ", شارع " . $street ;
	if ( !empty($avenue) )
	{
		echo ", جادة " . $avenue;
	}

	echo ", منزل " . $house;
}
else
{
	echo $country . ", " . $area . "<br> قطعة " . $blockA . ", شارع " . $streetA;
	
	if ( !empty($avenueA) )
	{
		echo ", جادة " . $avenueA;
	}

	echo ", مبنى " . $building . ", طابق " . $floor . ", شقة " . $apartment;
}
?>
</address>
</div>
</div>
<div class="row">
<div class="col-xs-4">
<address>
<span class="txt-dark head-font capitalize-font mb-5"></span>
<br>
</address>
</div>
<div class="col-xs-4">
<address>
<span class="txt-dark head-font capitalize-font mb-5">Contact info:</span>
<br>
Phone:<?php echo $row["mobile"] ?><br>
</address>
</div>
<div class="col-xs-4 text-right">
<address>
<span class="txt-dark head-font capitalize-font mb-5">order date:</span><br>
<?php $row["date"] = explode(" ",$row["date"]); echo $row["date"][0] ?><br><br>
</address>
</div>
</div>
<?php
}
?>
<div class="invoice-bill-table">
<div class="table-responsive">
<table class="table table-hover">
<thead>
<tr>
<th>Item</th>
<th>Price</th>
<th>Quantity</th>
<th>Totals</th>
</tr>
</thead>
<tbody>
<?php

$sql = "SELECT `productId`, `quantity` FROM `all_orders` WHERE `orderId` LIKE '$id'";
$result = $dbconnect->query($sql);
while ( $row = $result->fetch_assoc() )
{
	$products[] = $row["productId"];
	$quantities[] = $row["quantity"];
}
$totalPrice =0;
$i = 0;
while ( $i < sizeof($products) )
{
$sql = "SELECT * FROM `products` WHERE `id` LIKE '$products[$i]'";
$result = $dbconnect->query($sql);

while ( $row = $result->fetch_assoc() )
{
	if ( $row["discount"] != 0 )
	{
		$checkPrice = $row["price"] - ( $row["price"] * $row["discount"] / 100);
	}
	else
	{
		$checkPrice = $row["price"];
	}
	$pricePerItem = $checkPrice*$quantities[$i];
	$totalPrice = $totalPrice + $pricePerItem;
	$productPrice = $checkPrice;

	?>
<tr>
<td><?php echo $row["enTitle"] ?></td>
<td><?php echo $productPrice ?> KD</td>
<td><?php echo $quantities[$i] ?></td>
<td><?php echo $pricePerItem ?> KD</td>
</tr>
<?php
}
$i++;
}
?>
	<?php
	if ( isset($discount) )
	{
		?>
	<tr>
	<td></td>
	<td></td>
	<td>
	Discount
	</td>
	<td>
	<?php echo $discount ?>%
	</td>
	</tr>
	<?php
	}
	?>
	<tr class="txt-dark">
	<td></td>
	<td></td>
	<td>Subtotal</td>
	<td><?php if ( isset($discount) ) { echo ($totalPrice - ( $totalPrice * $discount / 100)); } else {echo $totalPrice; } ?> KD</td>
	</tr>
	<?php
	$sql = "SELECT * FROM `vouchers` WHERE `id` LIKE '$voucher'";
	$result = $dbconnect->query($sql);
	$row = $result->fetch_assoc();
	?>
<tr class="txt-dark">
<td></td>
<td></td>
<td>Voucher</td>
<td><?php echo $row["voucher"]; ?></td>
</tr>
<tr class="txt-dark">
<td></td>
<td></td>
<td>Delivery</td>
<td><?php echo $charges; ?>KD</td>
</tr>
<tr class="txt-dark">
<td></td>
<td></td>
<td>Total:</td>
<td><?php echo $totalPriceMain ?>KD</td>
</tr>
	<?php
?>
</tbody>
</table>
</div>
<div class="row">
<div class="col-xs-12">
<address>
<span class="txt-dark head-font capitalize-font mb-5">Special Instructions:</span>
<br>
<?php 
if ( $place == "1")
{
	echo $notes;
}
else
{
	echo $notesA;
}
?>
<br>
</address>
</div>
</div>
<div class="button-list pull-right">
<!--<button type="submit" class="btn btn-success mr-10">
Proceed to payment 
</button>-->
<button type="button" class="btn btn-primary btn-outline btn-icon left-icon" onclick="javascript:window.print();"> 
<i class="fa fa-print"></i><span> Print</span> 
</button>
</div>
<div class="clearfix"></div>
</div>
</div>
</div>
</div>
</div>
</div>