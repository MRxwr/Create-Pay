<?php
$sql = "SELECT * 
		FROM `adminstration` 
		WHERE `email` LIKE '".$email."'";
$result = $dbconnect->query($sql);
if ( $result->num_rows == 1 )
{
?>
<div class="fixed-sidebar-left">
	<ul class="nav navbar-nav side-nav nicescroll-bar">
		<li class="navigation-header">
			<span>Create-Pay</span> 
			<i class="zmdi zmdi-more"></i>
		</li>

		<li>
			<a href="index.php" ><div class="pull-left">
			<i class="fa fa-home mr-20"></i>
			<span class="right-nav-text"><?php echo $dashboard ?></span>
			</div>
			<div class="pull-right"></div><div class="clearfix"></div>
			</a>
			
			<a href="listOfClients.php" ><div class="pull-left">
			<i class="ti-user mr-20"></i>
			<span class="right-nav-text"><?php echo $listOfclients ?></span>
			</div>
			<div class="pull-right"></div><div class="clearfix"></div>
			</a>

			<a href="invoices.php" ><div class="pull-left">
			<i class="fa fa-credit-card mr-20"></i>
			<span class="right-nav-text"><?php echo $invoices ?></span>
			</div>
			<div class="pull-right"></div><div class="clearfix"></div>
			</a>
			
			<a href="reports.php" ><div class="pull-left">
			<i class="icon-chart mr-20"></i>
			<span class="right-nav-text"><?php echo $Reports ?></span>
			</div>
			<div class="pull-right"></div><div class="clearfix"></div>
			</a>
			
			<a href="notification.php" ><div class="pull-left">
			<i class="icon-pie-chart mr-20"></i>
			<span class="right-nav-text">Notification</span>
			</div>
			<div class="pull-right"></div><div class="clearfix"></div>
			</a>
			
			<a href="logs.php" ><div class="pull-left">
			<i class="icon-time mr-20"></i>
			<span class="right-nav-text">Logs</span>
			</div>
			<div class="pull-right"></div><div class="clearfix"></div>
			</a>
			
		</li>

	</ul>
</div>
<?php
}
else
{
	?>
<div class="fixed-sidebar-left">
	<ul class="nav navbar-nav side-nav nicescroll-bar">
		<li class="navigation-header">
			<span>Create-Pay</span> 
			<i class="zmdi zmdi-more"></i>
		</li>

		<li>
			<a href="index.php" ><div class="pull-left">
			<i class="fa fa-home mr-20"></i>
			<span class="right-nav-text"><?php echo $dashboard ?></span>
			</div>
			<div class="pull-right"></div><div class="clearfix"></div>
			</a>
		
			<a href="invoices.php" ><div class="pull-left">
			<i class="fa fa-credit-card mr-20"></i>
			<span class="right-nav-text"><?php echo $invoices ?></span>
			</div>
			<div class="pull-right"></div><div class="clearfix"></div>
			</a>
			
			<a href="editProfile.php" ><div class="pull-left">
			<i class="ti-user mr-20"></i>
			<span class="right-nav-text"><?php echo $settingsText ?></span>
			</div>
			<div class="pull-right"></div><div class="clearfix"></div>
			</a>
			
		</li>

	</ul>
</div>
	<?php
}
?>