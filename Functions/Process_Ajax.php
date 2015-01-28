<?php
/* Processes the ajax requests being put out in the admin area and the front-end
*  of the OTP plugin */

// Updates the order of items in the catalogue after a user has dragged and dropped them
function EWD_OTP_function() {
		global $wpdb;
		
}
add_action('wp_ajax_function', 'EWD_OTP_function');

// Records the number of times a product has been viewed
function EWD_OTP_Update_Orders() {
	$Path = ABSPATH . 'wp-load.php';
	include_once($Path);

	$Fields = array();
	$Field_Names_Array = explode(",", $_POST['Field_Labels']);
	foreach ($Field_Names_Array as $Field_Name) {
		$Field_Name_Key = trim(substr($Field_Name, 0, strpos($Field_Name, "=")));
		$Field_Name_Value = trim(substr($Field_Name, strpos($Field_Name, "=")+5));
		$Fields[$Field_Name_Key] = $Field_Name_Value;
	}
		
	echo EWD_OTP_Return_Results($_POST['Tracking_Number'], $Fields, $_POST['Order_Email']);
}
add_action('wp_ajax_ewd_otp_update_orders', 'EWD_OTP_Update_Orders');
add_action( 'wp_ajax_nopriv_ewd_otp_update_orders', 'EWD_OTP_Update_Orders');
