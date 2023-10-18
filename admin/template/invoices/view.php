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
<form action="includes/invoices/add.php" method="POST">
<div class="form-body">
<h6 class="txt-dark capitalize-font">
<i class="zmdi zmdi-account mr-10"></i><?php echo $invoicesInfo ?>
</h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $fullnameText ?></label>
<input type="text" name="name" class="form-control" required >
</div>
</div>
<!--/span-->
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Mobile ?></label>
<input type="text" name="mobile" class="form-control" required placeholder="96512345678">
</div>
</div>
<!--/span-->
</div>
<!-- -->

<div class="row">
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $emailText ?></label>
<input type="email" name="email" class="form-control" placeholder="Optional">
</div>
</div>
<!--/span-->
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Price ?></label>
<input type="float" name="price" class="form-control" required >
</div>
</div>
<!--/span-->
</div>

<div class="row">
<div class="col-md-12">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Details ?></label><br>
<textarea name="details" rows="4" style="width:100%" class="form-control" placeholder="Optional" ></textarea>
</div>
</div>
<!--/span-->
</div>
<!-- -->
<!-- /Row -->
</div>
<div class="form-actions mt-10">
<button type="submit" class="btn btn-success  mr-10"> Add</button>
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
<table class="table display responsive product-overview mb-30" id="example">
<thead>
<tr>
<th><?php echo $Date_Added ?></th>
<th><?php echo "Refference" ?></th>
<th><?php echo $OrderID ?></th>
<th><?php echo $fullnameText ?></th>
<th><?php echo $Mobile ?></th>
<th><?php echo $Price ?></th>
<th><?php echo $Details ?></th>
<th><?php echo $Status ?></th>
<th><?php echo $paymentLinkText ?></th>
</tr>
</thead>
<tbody>
<?php
require ("includes/config.php");
$i = 1;
if ( $userType == "0" ){
	$sql = "SELECT *
			FROM
			`invoices`
			ORDER BY `id` DESC";
	$row["commission"] = 0;
}else{
	$sql = "SELECT i.*, c.commission
			FROM `invoices` as i
			JOIN `clients` as c
			ON c.sRef = i.sRef
			WHERE
			i.sRef LIKE '".$clientRef."'
			ORDER BY i.id DESC";
}
$result = $dbconnect->query($sql);
while ($row = $result->fetch_assoc() )
{
	if ( $userType == "0" ){
		$commission = 0;
	}else{
		$commission = $row["commission"];
	}
	
?>
<tr>
<td><?php echo $row["date"] ?></td>
<td><?php echo $row["sRef"] ?></td>
<td><?php echo $row["orderId"]; ?></td>
<td><?php echo $row["name"]; ?></td>
<td><?php echo $row["mobile"]; ?></td>
<td><?php echo $row["price"]-$commission; ?></td>
<td><?php echo $row["details"]; ?></td>
<td>
<?php 
if ( $row["status"] == 0 ){
	echo "<span class='label label-primary font-weight-100'>$Pending</span>";
}elseif ( $row["status"] == 1 ){
	echo "<span class='label label-success font-weight-100'>$Paid</span>";
}elseif ( $row["status"] == 2 ){
	echo "<span class='label label-danger font-weight-100'>$failed</span>";
}elseif ( $row["status"] == 3 ){
	echo "<span class='label label-info font-weight-100'>$refunded</span>";
}elseif ( $row["status"] == 4 ){
	echo "<span class='label label-warning font-weight-100'>$ExpiredText</span>";
}
 ?>
</td>
<td>
<input type="hidden" id="linkInvoice<?php echo $i ?>" value="https://createpay.link/checkout.php?LinkId=<?php echo $row["linkCode"]; ?>">
<a onclick="copyToClipboard('#linkInvoice<?php echo $i ?>')" class="linkInvoice<?php echo $i ?>" ><img style="width:25px;height:25px" src="https://i.imgur.com/sYwyolZ.png" /></a>
<a href="<?php echo urldecode('https://wa.me/'.$row["mobile"].'/?text=Invoice for '.$row["price"].'KD has been sent to you. Please follow below link to pay: https://createpay.link/checkout?LinkId='.$row["linkCode"]) ?>" target="_blank" class="ml-5"><img style="width:25px;height:25px" src="https://i.imgur.com/QUvER0F.png" /></a>
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