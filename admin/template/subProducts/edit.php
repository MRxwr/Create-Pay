<?php
require ("includes/config.php");
$id = $_GET["id"];
$sql = "SELECT * FROM 
        `products` WHERE `id` = $id";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
$arTitle = $row["arTitle"];
$enTitle = $row["enTitle"];
$arDetails = $row["arDetails"];
$enDetails = $row["enDetails"];
$categoryId = $row["categoryId"];
$price = $row["price"];
$cost = $row["cost"];
$videoLink = $row["video"];
$storeQuantity = $row["storeQuantity"];
$onlineQuantity = $row["onlineQuantity"];
$discount = $row["discount"];
$weight = $row["weight"];
$width = $row["width"];
$height = $row["height"];
$depth = $row["depth"];

?>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="form-wrap">
<form action="includes/products/edit.php?id=<?php echo $id ?>" method="POST" enctype="multipart/form-data">
<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-info-outline mr-10"></i><?php echo $about_product ?></h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $English_Title ?></label>
<input type="text" name="enTitle" class="form-control" value="<?php echo $enTitle ?>">
</div>
</div>
<!--/span-->
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Arabic_Title ?></label>
<input type="text" name="arTitle" class="form-control" value="<?php echo $arTitle ?>">
</div>
</div>
<!--/span-->
</div>
<!-- Row -->
<!-- Row -->
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Category ?></label>
<select name="categoryId" class="form-control" data-placeholder="Choose a Category" tabindex="1">
<?php
$sql = "SELECT * FROM categories WHERE id LIKE $categoryId";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
?>
<option value="<?php echo $row["id"] ?>"><?php echo $row["enTitle"] ?></option>
<?php
$sql = "SELECT * FROM categories WHERE `hidden` = 0";
$result = $dbconnect->query($sql);
while ( $row = $result->fetch_assoc() )
{
?>
<option value="<?php echo $row["id"] ?>"><?php echo $row["enTitle"] ?></option>
<?php
}
?>
</select>
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Price ?></label>
<div class="input-group">
<div class="input-group-addon"><i class="ti-money"></i></div>
<input name="price" type="text" class="form-control" id="exampleInputuname" value="<?php echo $price ?>">
</div>
</div>
<!--/span-->

<!--/span-->
</div>
</div>

<!--/row-->
<!--<div class="row">
<div class="col-sm-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Discount ?> (%)</label>
<input name="discount" type="text" name="discount" class="form-control" max="100" min="0" step="1" value="<?php echo $discount ?>">
</div>
</div>
</div>
<!--/span
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Cost ?></label>
<div class="input-group">
<div class="input-group-addon"><i class="ti-money"></i></div>
<input name="cost" type="text" class="form-control" id="exampleInputuname_1" value="<?php echo $cost ?>">
</div>
</div>
</div>-->
<!--/span-->
<!--<div class="row">
<!--<div class="col-sm-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Store_Quantity ?></label>
<input name="storeQuantity" type="text" class="form-control" value="<?php echo $storeQuantity ?>">
</div>
</div>
<div class="col-sm-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $Online_Quantity ?></label>
<input name="onlineQuantity" type="text" class="form-control" value="<?php echo $onlineQuantity ?>">
</div>
</div>
</div>-->

<!--<div class="row">
<div class="col-sm-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $widthTxt ?></label>
<input name="width" type="text" class="form-control" value="<?php echo $width ?>">
</div>
</div>
<div class="col-sm-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $heightTxt ?></label>
<input name="height" type="text" class="form-control" value="<?php echo $height ?>">
</div>
</div>
</div>

<div class="row">
<div class="col-sm-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $depthTxt ?></label>
<input name="depth" type="text" class="form-control" value="<?php echo $depth ?>">
</div>
</div>
<div class="col-sm-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $weightTxt ?></label>
<input name="weight" type="text" class="form-control" value="<?php echo $weight ?>">
</div>
</div>
</div>-->
<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-comment-text mr-10"></i><?php echo $English_Description . " / " . $Arabic_Description ?></h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-md-6">
<div class="form-group">
<textarea name="enDetails" class="tinymce"><?php echo $enDetails ?></textarea>
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<textarea name="arDetails" class="tinymce"><?php echo $arDetails ?></textarea>
</div>
</div>
</div>
<!--/row-->
<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-collection-image mr-10"></i><?php echo $upload_image ?></h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-lg-12">
<?php 
$sql = "SELECT * FROM `images` WHERE `productId` = $id";
$result = $dbconnect->query($sql);
if ( $result->num_rows > 0 )
{
while ( $row = $result->fetch_assoc() )
{
?>
<div class="img-upload-wrap">
<table style="width:100%">
<tr>
<td style="width:300px">
<img class="img-responsive" style="width:300px;height:300px" src="../logos/<?php echo $row["imageurl"];?>" alt="upload_img">
</td>
</tr>
<tr>
<td class="btn btn-info btn-icon left-icon">
<a href="<?php echo "add-products.php?act=". $_GET["act"] ."&id=". $id ."&imgdel" . "=" .$row["id"] ?>" target="" style="text-decoration:none;color:white"><?php echo $Delete ?></a>
</td>
</tr>
</table>
</div>
<?php
}
}
else
{
?>
<div class="img-upload-wrap">
<img class="img-responsive" src="../img/slide1.jpg" alt="upload_img"> 
</div>
<?php
}
?>
<div style="padding-top:10px"></div>
<div class="fileupload btn btn-info btn-anim"><i class="fa fa-upload"></i><span class="btn-text"><?php echo $Upload_new_image ?></span>
<input type="file" name="logo[]" class="upload" multiple="multiple">
</div>
</div>
</div>
<hr class="light-grey-hr"/>

<div class="form-actions">
<button class="btn btn-success btn-icon left-icon mr-10 pull-left"> <i class="fa fa-check"></i> <span><?php echo $save ?></span></button>
<a href="product.php"><button type="button" class="btn btn-warning pull-left"><?php echo $Return ?></button></a>
<div class="clearfix"></div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>