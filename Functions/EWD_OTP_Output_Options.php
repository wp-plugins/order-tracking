<?php
/* Creates the admin page, and fills it in based on whether the user is looking at
*  the overview page or an individual item is being edited */
function EWD_OTP_Output_Options() {
		global $wpdb, $error, $Full_Version;
		global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;
		
		if (isset($_GET['DisplayPage'])) {
			  $Display_Page = $_GET['DisplayPage'];
		}
		include( plugin_dir_path( __FILE__ ) . '../html/AdminHeader.php');
		if ($_GET['Action'] == "Order_Details") {include( plugin_dir_path( __FILE__ ) . '../html/OrdersDetails.php');}
		else {include( plugin_dir_path( __FILE__ ) . '../html/MainScreen.php');}
		include( plugin_dir_path( __FILE__ ) . '../html/AdminFooter.php');
}
?>