<?php
function Update_EWD_OTP_Tables() {
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
		Order_Notes_Public text DEFAULT '' NOT NULL,
		Order_Notes_Private text DEFAULT '' NOT NULL,
		Order_Email text DEFAULT '' NOT NULL,
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
}
?>
