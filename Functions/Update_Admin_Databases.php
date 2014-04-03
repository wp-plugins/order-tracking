<?php
/* The file contains all of the functions which make changes to the OTP tables */

/* Adds a single new order to the OTP database */
function Add_EWD_OTP_Order($Order_Name, $Order_Number, $Order_Status, $Order_Display, $Order_Status_Updated) {
		global $wpdb;
		global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;
		
		$wpdb->insert( $EWD_OTP_orders_table_name, 
						array( 'Order_Name' => $Order_Name,
									 'Order_Number' => $Order_Number,
									 'Order_Status' => $Order_Status,
									 'Order_Display' => $Order_Display,
									 'Order_Status_Updated' => $Order_Status_Updated)
					 );
		$wpdb->insert( $EWD_OTP_order_statuses_table_name, 
						array( 'Order_ID' => $wpdb->insert_id,
									 'Order_Status' => $Order_Status,
									 'Order_Status_Created' => $Order_Status_Updated)
					 );
		$update = __("Order has been successfully created.", 'EWD_OTP');
		return $update;
}

/* Edits a single order with a given ID in the OTP database */
function Edit_EWD_OTP_Order($Order_ID, $Order_Name, $Order_Number, $Order_Status, $Order_Display, $Order_Status_Updated) {
		global $wpdb;
		global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;
		
		$wpdb->update( $EWD_OTP_orders_table_name, 
						array( 'Order_Name' => $Order_Name,
									 'Order_Number' => $Order_Number,
									 'Order_Status' => $Order_Status,
									 'Order_Display' => $Order_Display,
									 'Order_Status_Updated' => $Order_Status_Updated),
					 	array( 'Order_ID' => $Order_ID)
					 );
		$wpdb->insert( $EWD_OTP_order_statuses_table_name, 
						array( 'Order_ID' => $Order_ID,
									 'Order_Status' => $Order_Status,
									 'Order_Status_Created' => $Order_Status_Updated)
					 );
		$update = __("Order has been successfully edited.", 'EWD_OTP');
		return $update;
}

function Update_EWD_OTP_Order_Status($Order_ID, $Order_Status, $Order_Status_Updated) {
		global $wpdb;
		global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;
		
		$wpdb->update( $EWD_OTP_orders_table_name, 
						array( 'Order_Status' => $Order_Status,
									 'Order_Status_Updated' => $Order_Status_Updated),
					 	array( 'Order_ID' => $Order_ID)
					 );
		$wpdb->insert( $EWD_OTP_order_statuses_table_name, 
						array( 'Order_ID' => $Order_ID,
									 'Order_Status' => $Order_Status,
									 'Order_Status_Created' => $Order_Status_Updated)
					 );
		$update = __("Order status has been successfully edited.", 'EWD_OTP');
		return $update;
}

function Hide_EWD_OTP_Order($Order_ID) {
		global $wpdb;
		global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;
		
		$wpdb->update( $EWD_OTP_orders_table_name, 
						array( 'Order_Display' => "No"),
					 	array( 'Order_ID' => $Order_ID)
					 );

		$update = __("Order has been successfully hidden.", 'EWD_OTP');
		return $update;
}

/* Deletes a single prder with a given ID in the OTP database */
function Delete_EWD_OTP_Order($Order_ID) {
		global $wpdb;
		global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;
		
		$wpdb->delete(
						$EWD_OTP_orders_table_name,
						array('Order_ID' => $Order_ID)
					);
		$wpdb->delete(
						$EWD_OTP_order_statuses_table_name,
						array('Order_ID' => $Order_ID)
					);

		$update = __("Order has been successfully deleted.", 'EWD_OTP');
		$user_update = array("Message_Type" => "Update", "Message" => $update);
		return $update;
}

function Update_EWD_OTP_Options() {
		foreach ($_POST['status'] as $stat) {if ($stat != "") {$StatusString .= $stat . ",";}}
		$StatusString = substr($StatusString, 0, -1);
		update_option("EWD_OTP_Statuses", $StatusString);
		
		$update = __("Options have been successfully updated.", 'EWD_OTP');
		return $update;
}

function Delete_EWD_OTP_Option($Status) {
		$OriginalStatusString = get_option("EWD_OTP_Statuses");
		$Statuses = explode(",", $OriginalStatusString);
		
		foreach ($Statuses as $stat) {if ($stat != $Status) {$StatusString .= $stat . ",";}}
		$StatusString = substr($StatusString, 0, -1);
		update_option("EWD_OTP_Statuses", $StatusString);
		
		$update = __("Option has been successfully deleted.", 'EWD_OTP');
		return $update;
}

?>