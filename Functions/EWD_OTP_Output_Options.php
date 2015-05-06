<?php
/* Creates the admin page, and fills it in based on whether the user is looking at
*  the overview page or an individual item is being edited */
function EWD_OTP_Output_Options() {
	global $wpdb, $error, $EWD_OTP_Full_Version, $Sales_Rep_Only;
	global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name, $EWD_OTP_fields_table_name, $EWD_OTP_fields_meta_table_name, $EWD_OTP_sales_reps, $EWD_OTP_customers;
	
	if (isset($_GET['DisplayPage'])) {
		  $Display_Page = $_GET['DisplayPage'];
	}
	else { 
		$Display_Page = null;
	}
	if (!isset($_GET['Action'])) {
		$_GET['Action'] = null;
	}

	if (!isset($_GET['OrderBy'])) {
		$_GET['OrderBy'] = null;
	}

	include( plugin_dir_path( __FILE__ ) . '../html/AdminHeader.php');
	if ($_GET['Action'] == "EWD_OTP_Order_Details") {include( plugin_dir_path( __FILE__ ) . '../html/OrdersDetails.php');}
	elseif ($_GET['Action'] == "EWD_OTP_CustomerDetails") {include( plugin_dir_path( __FILE__ ) . '../html/CustomerDetails.php');}
	elseif ($_GET['Action'] == "EWD_OTP_RepDetails") {include( plugin_dir_path( __FILE__ ) . '../html/SalesRepDetails.php');}
	elseif ($_GET['Action'] == "EWD_OTP_FieldDetails") {include( plugin_dir_path( __FILE__ ) . '../html/CustomFieldDetails.php');}
	else {include( plugin_dir_path( __FILE__ ) . '../html/MainScreen.php');}
	include( plugin_dir_path( __FILE__ ) . '../html/AdminFooter.php');
}

function EWD_OTP_Output_Sales_Rep_Options() {
	global $wpdb, $error, $EWD_OTP_Full_Version, $Sales_Rep_Only;
	global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name, $EWD_OTP_fields_table_name, $EWD_OTP_fields_meta_table_name, $EWD_OTP_sales_reps, $EWD_OTP_customers;
	
	$Sales_Rep_Only = "Yes";

	if (isset($_GET['DisplayPage'])) {
		  $Display_Page = $_GET['DisplayPage'];
	}
	else { 
		$Display_Page = null;
	}
	if (!isset($_GET['Action'])) {
		$_GET['Action'] = null;
	}

	if (!isset($_GET['OrderBy'])) {
		$_GET['OrderBy'] = null;
	}

	include( plugin_dir_path( __FILE__ ) . '../html/AdminHeader.php');
	if ($_GET['Action'] == "EWD_OTP_Order_Details") {include( plugin_dir_path( __FILE__ ) . '../html/OrdersDetails.php');}
	else {include( plugin_dir_path( __FILE__ ) . '../html/MainScreen_Sales_Rep.php');}
	include( plugin_dir_path( __FILE__ ) . '../html/AdminFooter.php');
}
?>