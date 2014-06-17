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
		
		echo EWD_OTP_Return_Results($_POST['Tracking_Number']);
}
add_action('wp_ajax_ewd_otp_update_orders', 'EWD_OTP_Update_Orders');
add_action( 'wp_ajax_nopriv_ewd_otp_update_orders', 'EWD_OTP_Update_Orders');
