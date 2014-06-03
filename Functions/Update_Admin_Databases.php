<?php
/* The file contains all of the functions which make changes to the OTP tables */

/* Adds a single new order to the OTP database */
function Add_EWD_OTP_Order($Order_Name, $Order_Number, $Order_Email, $Order_Status, $Order_Notes_Public, $Order_Notes_Private, $Order_Display, $Order_Status_Updated) {
		global $wpdb;
		global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;
		
		$wpdb->insert( $EWD_OTP_orders_table_name, 
						array( 'Order_Name' => $Order_Name,
									 'Order_Number' => $Order_Number,
									 'Order_Status' => $Order_Status,
									 'Order_Notes_Public' => $Order_Notes_Public,
									 'Order_Notes_Private' => $Order_Notes_Private,
									 'Order_Email' => $Order_Email,
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
function Edit_EWD_OTP_Order($Order_ID, $Order_Name, $Order_Number, $Order_Email, $Order_Status, $Order_Notes_Public, $Order_Notes_Private, $Order_Display, $Order_Status_Updated) {
		global $wpdb;
		global $EWD_OTP_orders_table_name, $EWD_OTP_order_statuses_table_name;
		
		$wpdb->update( $EWD_OTP_orders_table_name, 
						array( 'Order_Name' => $Order_Name,
									 'Order_Number' => $Order_Number,
									 'Order_Status' => $Order_Status,
									 'Order_Notes_Public' => $Order_Notes_Public,
									 'Order_Notes_Private' => $Order_Notes_Private,
									 'Order_Email' => $Order_Email,
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

function Update_EWD_OTP_Statuses() {
		foreach ($_POST['status'] as $stat) {if ($stat != "") {$StatusString .= $stat . ",";}}
		$StatusString = substr($StatusString, 0, -1);
		update_option("EWD_OTP_Statuses", $StatusString);
		
		$update = __("Options have been successfully updated.", 'EWD_OTP');
		return $update;
}

function Delete_EWD_OTP_Status($Status) {
		$OriginalStatusString = get_option("EWD_OTP_Statuses");
		$Statuses = explode(",", $OriginalStatusString);
		
		foreach ($Statuses as $stat) {if ($stat != $Status) {$StatusString .= $stat . ",";}}
		$StatusString = substr($StatusString, 0, -1);
		update_option("EWD_OTP_Statuses", $StatusString);
		
		$update = __("Option has been successfully deleted.", 'EWD_OTP');
		return $update;
}

function Update_EWD_OTP_Options() {
		$Custom_CSS = $_POST['custom_css'];
		$AJAX_Reload = $_POST['ajax_reload'];
		$New_Window = $_POST['new_window'];
		$Order_Information_Array = $_POST['order_information'];
		$Order_Information = implode(",", $Order_Information_Array);
		$Order_Email = $_POST['order_email'];
		
		$Custom_CSS = stripslashes_deep($Custom_CSS);
		$AJAX_Reload = stripslashes_deep($AJAX_Reload);
		$New_Window = stripslashes_deep($New_Window);
		$Order_Information = stripslashes_deep($Order_Information);
		$Order_Email = stripslashes_deep($Order_Email);
		
		update_option('EWD_OTP_Custom_CSS', $Custom_CSS);
		update_option('EWD_OTP_AJAX_Reload', $AJAX_Reload);
		update_option('EWD_OTP_New_Window', $New_Window);
		update_option('EWD_OTP_Order_Information', $Order_Information);
		update_option('EWD_OTP_Order_Email', $Order_Email);
}

function Update_EWD_OTP_Email_Settings() {
		$Admin_Email = $_POST['admin_email'];
		$Message_Body = $_POST['message_body'];
		$SMTP_Mail_Server = $_POST['smtp_mail_server'];
		$Admin_Password = $_POST['admin_password'];
		
		$Admin_Email = stripslashes_deep($Admin_Email);
		$Message_Body = stripslashes_deep($Message_Body);
		$SMTP_Mail_Server = stripslashes_deep($SMTP_Mail_Server);
		$Admin_Password = stripslashes_deep($Admin_Password);
		
		$key = 'EWD_OTP';
		$Encrypted_Admin_Password = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $Admin_Password, MCRYPT_MODE_CBC, md5(md5($key))));
		
		update_option('EWD_OTP_Admin_Email', $Admin_Email);
		update_option('EWD_OTP_Message_Body', $Message_Body);
		update_option('EWD_OTP_SMTP_Mail_Server', $SMTP_Mail_Server);
		update_option('EWD_OTP_Admin_Password', $Encrypted_Admin_Password);
}
?>