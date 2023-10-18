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
<form action="includes/subProducts/add.php" method="POST">
<input type="hidden" name="productId" value="<?php echo $_GET["id"] ?>" class="form-control" >
<div class="form-body">
<h6 class="txt-dark capitalize-font">
<i class="fa fa-qrcode mr-10"></i><?php echo $subProductText ?>
</h6>
<hr class="light-grey-hr"/>
<input type="hidden" name="colorEn" class="form-control" value="">
<input type="hidden" name="color" class="form-control" value="">

<div class="row">
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $sizeText ?></label>
<input type="text" name="size" class="form-control" required >
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10"><?php echo $quantityText ?></label>
<input type="text" name="quantity" class="form-control" required >
</div>
</div>
<!--/span-->
</div>
<div class="row">
<div class="col-sm-12 col-xs-12">
<div class="form-wrap">
<div class="col-md-1 text-center">
<button type="submit" class="btn btn-success"><?php echo $Add  ?></button>
</div>
</div>
</div>
</div>
<!--/span-->
</div>
<!-- -->
<!-- -->
<!-- /Row -->
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>		
</div>