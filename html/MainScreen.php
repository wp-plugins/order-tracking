		<div class="EWD_OTP_Menu">
				 <h2 class="nav-tab-wrapper">
				 		 <a id="Dashboard_Menu" class="MenuTab nav-tab <?php if ($Display_Page == '' or $Display_Page == 'Dashboard') {echo 'nav-tab-active';}?>" onclick="ShowTab('Dashboard');"><?php _e("Dashboard", "EWD_OTP"); ?></a>
						 <a id="Orders_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'Orders') {echo 'nav-tab-active';}?>" onclick="ShowTab('Orders');"><?php _e("Orders", "EWD_OTP"); ?></a>
						 <a id="Options_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'Options') {echo 'nav-tab-active';}?>" onclick="ShowTab('Options');"><?php _e("Options", "EWD_OTP"); ?></a>
						 <a id="Advanced_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'Advanced') {echo 'nav-tab-active';}?>" onclick="ShowTab('Advanced');"><?php _e("Advanced", "EWD_OTP"); ?></a>
				 </h2>
		</div>
		
		<div class="clear"></div>
		
		<!-- Add the individual pages to the admin area, and create the active tab based on the selected page -->
		<div class="OptionTab <?php if ($Display_Page == "" or $Display_Page == 'Dashboard') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Dashboard">
				<?php include( plugin_dir_path( __FILE__ ) . 'DashboardPage.php'); ?>
		</div>
		
		<div class="OptionTab <?php if ($Display_Page == 'Orders' or $Display_Page == 'Order') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Orders">
				<?php include( plugin_dir_path( __FILE__ ) . 'OrdersPage.php'); ?>
		</div>	

		<div class="OptionTab <?php if ($Display_Page == 'Options' or $Display_Page == 'Option') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Options">
				<?php include( plugin_dir_path( __FILE__ ) . 'OptionsPage.php'); ?>
		</div>	
		
		<div class="OptionTab <?php if ($Display_Page == 'Advanced') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Advanced">
				<?php include( plugin_dir_path( __FILE__ ) . 'AdvancedPage.php'); ?>
		</div>		