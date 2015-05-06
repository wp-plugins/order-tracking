<div class="EWD_OTP_Menu">
	<h2 class="nav-tab-wrapper">
		<a id="Orders_Menu" class="MenuTab nav-tab nav-tab-active" onclick="ShowTab('Orders');"><?php _e("Orders", "EWD_OTP"); ?></a>
	</h2>
</div>
		
<div class="clear"></div>
		
<!-- Add the individual pages to the admin area, and create the active tab based on the selected page -->

<div class="OptionTab ActiveTab" id="Orders">
		<?php include( plugin_dir_path( __FILE__ ) . 'OrdersPage.php'); ?>
</div>			