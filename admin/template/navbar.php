<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="mobile-only-brand pull-left">
				<div class="nav-header pull-left">
					<div class="logo-wrap">
						<a href="index.php">
							<img class="brand-img" src="../img/logo.png" alt="brand"/>
							<span class="brand-text">CREATE-PAY</span>
						</a>
					</div>
				</div>	
				<a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block ml-20 pull-left" href="javascript:void(0);"><i class="zmdi zmdi-menu"></i></a>
				<a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-more"></i></a>
			</div>
			<div id="mobile_only_nav" class="mobile-only-nav pull-right">
				<ul class="nav navbar-right top-nav pull-right">
					<li class="dropdown auth-drp">
						<a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown"><img src="../img/user1.png" alt="user_auth" class="user-auth-img img-circle"/><span class="user-online-status"></span></a>
						<ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
							<li>
								<a><i class="fa fa-user"></i><span><?php echo $username ?></span><hr></a>
							</li>
						<?php
						if ( !isset($_COOKIE["CREATEkwLANG"]) OR $_COOKIE["CREATEkwLANG"] == "ENG" )
						{
						?>
							<li>
								<a href="?lang=AR"><i class="fa fa-language"></i><span>العربية</span></a>
							</li>
						<?php
						}
						else
						{
						?>
							<li>
								<a href="?lang=ENG"><i class="fa fa-language"></i><span>ENGLISH</span></a>
							</li>
						<?php
						}
						?>
							<li>
								<a href="logout.php"><i class="zmdi zmdi-power"></i><span>Log Out</span></a>
							</li>
						</ul>
					</li>

					<!--<li class="dropdown alert-drp">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
							<i class="zmdi zmdi-notifications top-nav-icon"></i>
							<?php 
								require('includes/config.php');
								$sql = "SELECT * FROM `orders` WHERE `status` LIKE '1' GROUP BY `orderId` ORDER BY `date`";
								$result = $dbconnect->query($sql);
								$numberOfRows = $result->num_rows;
							?>
							<span class="top-nav-icon-badge"><?php echo $numberOfRows ?></span>
						</a>
						<ul class="dropdown-menu alert-dropdown" data-dropdown-in="bounceIn" data-dropdown-out="bounceOut">
						<li>
							<div class="notification-box-head-wrap">
								<span class="notification-box-head pull-left inline-block">notifications</span>
								<div class="clearfix"></div>
								<hr class="light-grey-hr ma-0">
							</div>
						</li>
						<!-- start of notification
						<li>
							<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 229px;">
								<div class="streamline message-nicescroll-bar" style="overflow: hidden; width: auto; height: 229px;">
									<?php
									while ( $row = $result->fetch_assoc() )
									{
									?>
									<div class="sl-item">
										<a href="product-orders.php?info=view&id=<?php echo $row["orderId"] ?>">
											<div class="icon bg-blue">
												<i class="zmdi zmdi-info"></i>
											</div>
											<div class="sl-content">
												<span class="inline-block capitalize-font  pull-left truncate head-notifications txt-danger">Order Id:<?php echo $row["orderId"] ?>
												</span>
												<span class="inline-block font-11  pull-right notifications-time"><?php echo $row["date"] ?></span>
												<p class="truncate">Go to order</p>
											</div>
										</a>	
									</div>
									<hr class="light-grey-hr ma-0">
									<?php
									}
									?>
								</div>
								<div class="slimScrollBar" style="background: rgb(135, 135, 135); width: 4px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 0px; z-index: 99; right: 1px; height: 181.457px;">
								</div>
								<div class="slimScrollRail" style="width: 4px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;">
								</div>
							</div>
						</li>
						<!-- end of notification 
						<li>
							<div class="notification-box-bottom-wrap">
								<hr class="light-grey-hr ma-0">
								<a class="block text-center read-all" href="product-orders.php"> read all </a>
								<div class="clearfix"></div>
							</div>
						</li>
						</ul>
					</li>-->

				</ul>
			</div>	
		</nav>