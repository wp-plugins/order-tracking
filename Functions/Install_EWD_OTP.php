<?php
function Install_EWD_OTP() {
		/* Add in the required globals to be able to create the tables */
  	global $wpdb;
   	global $EWD_OTP_db_version;
		global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;
    
		/* Create the Orders data table */  
   	$sql = "CREATE TABLE $EWD_OTP_orders_table_name (
  	Order_ID mediumint(9) NOT NULL AUTO_INCREMENT,
		Order_Name text DEFAULT '' NOT NULL,
		Order_Number text DEFAULT '' NOT NULL,
		Order_Status text DEFAULT '' NOT NULL,
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
		Order_Status_Created datetime DEFAULT '0000-00-00 00:00:00' NULL,
  	UNIQUE KEY id (Order_Status_ID)
    )
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
 		
		update_option("EWD_OTP_Full_Version", "Yes");
   	add_option("EWD_OTP_db_version", $EWD_OTP_db_version);
		//add_option("EWD_OTP_Time_Frame", 60);
}
?>
