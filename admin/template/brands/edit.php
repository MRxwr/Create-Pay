<?php 
include_once("includes/config.php");
$id = $_GET["id"];
$sql = "SELECT * FROM brand WHERE `id`='$id'";
$result = $dbconnect->query($sql);
$row = $result->fetch_assoc();
?>
<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-default card-view">
								<div class="panel-wrapper collapse in">
									<div class="panel-body">
										<div class="form-wrap">
											<form action="includes/brands/edit.php?id=<?php echo $id ?>" method="POST" enctype="multipart/form-data">
												<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-info-outline mr-10"></i>about brand</h6>
												<hr class="light-grey-hr"/>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label mb-10">English Name</label>
															<input type="text" name="enTitle" class="form-control" value="<?php echo $row["enTitle"] ?>">
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label mb-10">Arabic Name</label>
															<input type="text" name="arTitle" class="form-control" value="<?php echo $row["arTitle"] ?>">
														</div>
													</div>
													<!--/span-->
												</div>
												<div class="seprator-block"></div>
												<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-comment-text mr-10"></i>English Description</h6>
												<hr class="light-grey-hr"/>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<textarea class="form-control" name="enDesc" rows="4"><?php echo $row["erDescription"] ?></textarea>
														</div>
													</div>
												</div>
												<div class="seprator-block"></div>
												<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-comment-text mr-10"></i>Arabic Description</h6>
												<hr class="light-grey-hr"/>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<textarea class="form-control" name="arDesc" rows="4"><?php echo $row["arDescription"] ?></textarea>
														</div>
													</div>
												</div>
												<!--/row-->
												<div class="seprator-block"></div>
												<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-collection-image mr-10"></i>upload image</h6>
												<hr class="light-grey-hr"/>
												<div class="row">
													<div class="col-lg-12">
														<div class="img-upload-wrap">
															<img class="img-responsive" src="<?php
															if ( !empty($row["imageurl"]) )
															{
																echo "../logos/" . $row["imageurl"];
															}
															else
															{
																echo "../img/chair.jpg";
															}
															?>" alt="upload_img"> 
														</div>
														<div class="fileupload btn btn-info btn-anim"><i class="fa fa-upload"></i><span class="btn-text">Upload new image</span>
															<input type="file" name="logo" class="upload">
														</div>
													</div>
												</div>
												<div class="seprator-block"></div>
												<div class="form-actions">
													<button class="btn btn-success btn-icon left-icon mr-10 pull-left"> <i class="fa fa-check"></i> <span>save</span></button>
													<a href="brands.php"><button type="button" class="btn btn-warning pull-left">Return</button></a>
													<div class="clearfix"></div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>