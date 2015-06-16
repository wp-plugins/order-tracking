<?php
function Update_EWD_OTP_Tables() {
	/* Add in the required globals to be able to create the tables */
  	global $wpdb;
   	global $EWD_OTP_db_version;
	global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name, $EWD_OTP_fields_table_name, $EWD_OTP_fields_meta_table_name, $EWD_OTP_sales_reps, $EWD_OTP_customers;
    
	/* Create the Orders data table */  
   	$sql = "CREATE TABLE $EWD_OTP_orders_table_name (
  		Order_ID mediumint(9) NOT NULL AUTO_INCREMENT,
		Order_Name text DEFAULT '' NOT NULL,
		Order_Number text DEFAULT '' NOT NULL,
		Order_Status text DEFAULT '' NOT NULL,
		Order_Location text DEFAULT '' NOT NULL,
		Order_Notes_Public text DEFAULT '' NOT NULL,
		Order_Notes_Private text DEFAULT '' NOT NULL,
		Order_Customer_Notes text DEFAULT '' NOT NULL,
		Order_Email text DEFAULT '' NOT NULL,
		Sales_Rep_ID mediumint(9) DEFAULT 0 NOT NULL,
		Customer_ID mediumint(9) DEFAULT 0 NOT NULL,
		WooCommerce_ID mediumint(9) DEFAULT 0 NOT NULL,
		Order_Status_Updated datetime DEFAULT '0000-00-00 00:00:00' NULL,
		Order_Display text DEFAULT '' NOT NULL,
  		UNIQUE KEY id (Order_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
		
	/* Create the Order Statuses data table */  
   	$sql = "CREATE TABLE $EWD_OTP_order_statuses_table_name (
  		Order_Status_ID mediumint(9) NOT NULL AUTO_INCREMENT,
		Order_ID mediumint(9) DEFAULT 0 NOT NULL,
		Order_Status text DEFAULT '' NOT NULL,
		Order_Location text DEFAULT '' NOT NULL,
		Order_Status_Created datetime DEFAULT '0000-00-00 00:00:00' NULL,
  		UNIQUE KEY id (Order_Status_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
		
	/* Create the Order Statuses data table */  
   	$sql = "CREATE TABLE $EWD_OTP_sales_reps (
  		Sales_Rep_ID mediumint(9) NOT NULL AUTO_INCREMENT,
		Sales_Rep_First_Name text DEFAULT '' NOT NULL,
		Sales_Rep_Last_Name text DEFAULT '' NOT NULL,
		Sales_Rep_WP_ID mediumint(9) DEFAULT 0 NOT NULL,
		Sales_Rep_Created datetime DEFAULT '0000-00-00 00:00:00' NULL,
  		UNIQUE KEY id (Sales_Rep_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
		
	/* Create the Order Statuses data table */  
   	$sql = "CREATE TABLE $EWD_OTP_customers (
  		Customer_ID mediumint(9) NOT NULL AUTO_INCREMENT,
		Customer_Name text DEFAULT '' NOT NULL,
		Sales_Rep_ID mediumint(9) DEFAULT 0 NOT NULL,
		Customer_Email text DEFAULT '' NOT NULL,
		Customer_Created datetime DEFAULT '0000-00-00 00:00:00' NULL,
  		UNIQUE KEY id (Customer_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
		
	/* Create the custom fields table */
	$sql = "CREATE TABLE $EWD_OTP_fields_table_name (
  		Field_ID mediumint(9) NOT NULL AUTO_INCREMENT,
  		Field_Name text DEFAULT '' NOT NULL,
		Field_Slug text DEFAULT '' NOT NULL,
		Field_Type text DEFAULT '' NOT NULL,
		Field_Description text DEFAULT '' NOT NULL,
		Field_Values text DEFAULT '' NOT NULL,
		Field_Front_End_Display text DEFAULT '' NOT NULL,
		Field_Date_Created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  		UNIQUE KEY id (Field_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
		
	/* Update the custom fields meta table */
	$sql = "CREATE TABLE $EWD_OTP_fields_meta_table_name (
  		Meta_ID mediumint(9) NOT NULL AUTO_INCREMENT,
  		Field_ID mediumint(9) DEFAULT '0',
		Order_ID mediumint(9) DEFAULT '0',
		Meta_Value text DEFAULT '' NOT NULL,
  		UNIQUE KEY id (Meta_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
		
	//Update status percentages if they haven't been created yet
	$PercentageString = get_option("EWD_OTP_Percentages");
	if ($PercentageString == "") {
		$StatusString = get_option("EWD_OTP_Statuses");
		$Statuses = explode(",", $StatusString);
		foreach ($Statuses as $key => $Status) {
				$Percent = round(($key+1)/sizeOf($Statuses)*100,0);
				$PercentageString .= $Percent . ",";
		}
		$PercentageString = substr($PercentageString, 0, -1);
		update_option("EWD_OTP_Percentages", $PercentageString);
	}
 		
   	update_option("EWD_OTP_db_version", $EWD_OTP_db_version);
	if (get_option("EWD_OTP_Form_Instructions") == "") {update_option("EWD_OTP_Form_Instructions", "Enter the order number you would like to track in the form below.");}
	if (get_option("EWD_OTP_Timezone") == "") {update_option("EWD_OTP_Timezone", "Europe/London");}
	if (get_option("EWD_OTP_Access_Role") == "") {update_option("EWD_OTP_Access_Role", "administrator");}
	if (get_option("EWD_OTP_WooCommerce_Integration") == "") {update_option("EWD_OTP_WooCommerce_Integration", "No");}
	if (get_option("EWD_OTP_Display_Graphic") == "") {update_option("EWD_OTP_Display_Graphic", "Default");}
	if (get_option("EWD_OTP_Mobile_Stylesheet") == "") {update_option("EWD_OTP_Mobile_Stylesheet", "No");}

	if (get_option("EWD_OTP_Customer_Confirmation") == "") {update_option("EWD_OTP_Customer_Confirmation", "None");}
	if (get_option("EWD_OTP_Sales_Rep_Confirmation") == "") {update_option("EWD_OTP_Sales_Rep_Confirmation", "None");}
	if (get_option("EWD_OTP_Cut_Off_Days") == "") {update_option("EWD_OTP_Cut_Off_Days", 60);}

	if (get_option("EWD_OTP_Use_SMTP") == "") {update_option("EWD_OTP_Use_SMTP", "Yes");}
	if (get_option("EWD_OTP_Port") == "") {update_option("EWD_OTP_Port", "25");}
	if (get_option("EWD_OTP_Encryption_Type") == "") {update_option("EWD_OTP_Encryption_Type", "ssl");}
	if (get_option("EWD_OTP_From_Name") == "") {update_option("EWD_OTP_From_Name", get_option("EWD_OTP_Admin_Email"));}
	if (get_option("EWD_OTP_Username") == "") {update_option("EWD_OTP_Port", get_option("EWD_OTP_Admin_Email"));}
}
?>
